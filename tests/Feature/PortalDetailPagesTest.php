<?php

namespace Tests\Feature;

use App\Models\Feature;
use App\Models\Gallery;
use Database\Seeders\SipKesDatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortalDetailPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(SipKesDatabaseSeeder::class);
    }

    public function test_every_feature_has_a_detail_page(): void
    {
        $this->get('/fitur')->assertOk()->assertSee('Lihat Detail');

        foreach (Feature::all() as $feature) {
            $this->assertNotEmpty($feature->slug);
            $this->get('/fitur/' . $feature->slug)
                ->assertOk()
                ->assertSee($feature->name)
                ->assertSee('Fungsi Utama')
                ->assertSee('Manfaat bagi Faskes')
                ->assertSee('Kembali ke Semua Fitur');
        }

        $this->get('/fitur/tidak-ada')->assertNotFound();
    }

    public function test_news_list_and_detail_pages(): void
    {
        $this->get('/berita')->assertOk()->assertSee('Baca Selengkapnya')->assertDontSee('Galeri');

        foreach (Gallery::all() as $news) {
            $this->get('/berita/' . $news->slug)
                ->assertOk()
                ->assertSee($news->title)
                ->assertSee($news->paragraphs()[0])
                ->assertSee('Kembali ke Daftar Berita');
        }

        $this->get('/berita/tidak-ada')->assertNotFound();
        $this->get('/galeri')->assertRedirect('/berita');
    }

    public function test_admin_can_upload_news_image_and_it_is_displayed(): void
    {
        $admin = \App\Models\Admin::first();
        $this->assertNotNull($admin);

        // PNG 1x1 asli (tanpa ekstensi GD)
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');
        $file = \Illuminate\Http\UploadedFile::fake()->createWithContent('foto-berita.png', $png);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.galleries.store'), [
                'title' => 'Uji Upload Foto Berita',
                'description' => 'Ringkasan uji.',
                'content' => "Paragraf satu.\n\nParagraf dua.",
                'date' => '2026-11-13',
                'image' => $file,
            ])
            ->assertRedirect(route('admin.galleries.index'))
            ->assertSessionHasNoErrors();

        $news = Gallery::where('title', 'Uji Upload Foto Berita')->firstOrFail();

        try {
            $this->assertStringStartsWith('gallery/', $news->image);
            $this->assertTrue($news->hasValidImage());
            $this->assertNotSame('', $news->image_url);

            $this->get('/berita')->assertOk()->assertSee($news->image_url, false);
            $this->get('/berita/' . $news->slug)->assertOk()->assertSee($news->image_url, false);

            // Gambar dapat diakses lewat route media (berlaku dengan/tanpa storage:link)
            $this->get(route('media', ['path' => $news->image]))->assertOk();
            $this->get('/media/gallery/tidak-ada.png')->assertNotFound();

            // Selain gambar ditolak
            $this->actingAs($admin, 'admin')
                ->post(route('admin.galleries.store'), [
                    'title' => 'Bukan Gambar',
                    'image' => \Illuminate\Http\UploadedFile::fake()->createWithContent('x.txt', 'halo'),
                ])
                ->assertSessionHasErrors('image');

            // Berita tanpa gambar tetap bisa disimpan dan tampil dengan placeholder
            $this->actingAs($admin, 'admin')
                ->post(route('admin.galleries.store'), ['title' => 'Berita Tanpa Foto'])
                ->assertSessionHasNoErrors();
            $plain = Gallery::where('title', 'Berita Tanpa Foto')->firstOrFail();
            $this->assertFalse($plain->hasValidImage());
            $this->get('/berita/' . $plain->slug)->assertOk();
        } finally {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($news->image);
        }
    }

    public function test_home_has_no_live_badge_and_no_rme_app(): void
    {
        $html = strip_tags($this->get('/')->assertOk()->getContent());

        $this->assertDoesNotMatchRegularExpression('/\bLIVE\b/i', $html);
        $this->assertStringNotContainsString('Galeri', $html);
        $this->get('/rme')->assertNotFound();
    }
}
