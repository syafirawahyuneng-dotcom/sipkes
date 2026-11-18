<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Advantage;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Banner;
use App\Models\Feature;
use App\Models\Gallery;
use App\Models\Profile;
use App\Models\SiteSetting;
use App\Models\SupportService;
use Database\Seeders\SipKesDatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * PRD Fase 2: input gambar, WYSIWYG + sanitasi HTML, modul Artikel, gambar beranda.
 * Kriteria penerimaan 1, 3, 4, 5, 6, 7 (PRD-SIP-KES-FASE-2.md §9).
 */
class Phase2FeaturesTest extends TestCase
{
    use RefreshDatabase;

    private Admin $admin;

    /** File yang dibuat selama test, dihapus kembali di tearDown. */
    private array $files = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(SipKesDatabaseSeeder::class);
        $this->admin = Admin::firstOrFail();
    }

    protected function tearDown(): void
    {
        foreach (array_filter($this->files) as $path) {
            Storage::disk('public')->delete($path);
        }
        parent::tearDown();
    }

    private function png(string $name = 'foto.png'): UploadedFile
    {
        // PNG 1x1 asli (tanpa ekstensi GD)
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');

        return UploadedFile::fake()->createWithContent($name, $png);
    }

    private function track(?string $path): ?string
    {
        $this->files[] = $path;

        return $path;
    }

    private function admin()
    {
        return $this->actingAs($this->admin, 'admin');
    }

    // ---------------------------------------------------------------- Gambar (G-01–G-08)

    public function test_feature_image_can_be_uploaded_replaced_and_removed(): void
    {
        $feature = Feature::firstOrFail();
        $payload = [
            'name' => $feature->name,
            'description' => '<p>Deskripsi <strong>baru</strong>.</p>',
            'category' => $feature->category,
            'icon' => $feature->icon,
        ];

        // Upload
        $this->admin()->put(route('admin.features.update', $feature), $payload + ['image' => $this->png()])
            ->assertRedirect(route('admin.features.index'))->assertSessionHasNoErrors();
        $first = $this->track($feature->fresh()->image);
        $this->assertStringStartsWith('features/', $first);
        Storage::disk('public')->assertExists($first);
        $this->get('/fitur/' . $feature->slug)->assertOk()->assertSee($feature->fresh()->image_url, false);

        // Ganti → file lama terhapus
        $this->admin()->put(route('admin.features.update', $feature), $payload + ['image' => $this->png('baru.png')])
            ->assertSessionHasNoErrors();
        $second = $this->track($feature->fresh()->image);
        $this->assertNotSame($first, $second);
        Storage::disk('public')->assertMissing($first);
        Storage::disk('public')->assertExists($second);

        // Edit tanpa file → gambar tetap
        $this->admin()->put(route('admin.features.update', $feature), $payload)->assertSessionHasNoErrors();
        $this->assertSame($second, $feature->fresh()->image);

        // Hapus gambar
        $this->admin()->put(route('admin.features.update', $feature), $payload + ['remove_image' => '1'])
            ->assertSessionHasNoErrors();
        $this->assertNull($feature->fresh()->image);
        Storage::disk('public')->assertMissing($second);
        $this->get('/fitur/' . $feature->slug)->assertOk()->assertSee('Deskripsi Fitur');
    }

    public function test_invalid_or_oversized_images_are_rejected(): void
    {
        $feature = Feature::firstOrFail();

        $this->admin()->put(route('admin.features.update', $feature), [
            'name' => $feature->name, 'description' => 'Deskripsi',
            'image' => UploadedFile::fake()->createWithContent('x.txt', 'bukan gambar'),
        ])->assertSessionHasErrors(['image' => 'Gambar fitur harus berupa file gambar.']);

        $big = UploadedFile::fake()->createWithContent('besar.png', base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg=='))->size(6000);
        $this->admin()->post(route('admin.advantages.store'), [
            'title' => 'Besar', 'description' => 'Deskripsi', 'image' => $big,
        ])->assertSessionHasErrors(['image' => 'Ukuran Gambar keunggulan maksimal 5 MB.']);
    }

    public function test_advantage_service_and_profile_images_are_managed_and_shown(): void
    {
        // Keunggulan
        $this->admin()->post(route('admin.advantages.store'), [
            'title' => 'Keunggulan Bergambar', 'description' => '<p>Isi keunggulan.</p>', 'image' => $this->png(),
        ])->assertSessionHasNoErrors();
        $adv = Advantage::where('title', 'Keunggulan Bergambar')->firstOrFail();
        $this->track($adv->image);
        $this->get('/keunggulan')->assertOk()->assertSee($adv->image_url, false);

        $this->admin()->delete(route('admin.advantages.destroy', $adv));
        Storage::disk('public')->assertMissing($adv->image);

        // Layanan pendukung
        $srv = SupportService::firstOrFail();
        $this->admin()->put(route('admin.support-services.update', $srv), [
            'title' => $srv->title, 'icon' => $srv->icon, 'summary' => $srv->summary,
            'description' => '<p>Deskripsi layanan</p>', 'benefits_text' => "Satu\nDua",
            'is_active' => '1', 'image' => $this->png(),
        ])->assertSessionHasNoErrors();
        $srv->refresh();
        $this->track($srv->image);
        $this->assertSame(['Satu', 'Dua'], $srv->benefits);
        $this->get('/layanan-pendukung')->assertOk()->assertSee($srv->image_url, false);

        // Profil
        $profile = Profile::firstOrFail();
        $this->admin()->post(route('admin.profile.update'), [
            'name' => $profile->name, 'institution' => $profile->institution, 'tagline' => $profile->tagline,
            'about_tefa' => '<p>Tentang <em>TeFa</em></p>', 'about_sipkes' => '<p>Tentang SIP-Kes</p>',
            'background' => '<h2>Latar</h2><p>Belakang</p>', 'vision' => '<p>Visi</p>',
            'mission' => '<ol><li>Misi satu</li><li>Misi dua</li></ol>', 'image' => $this->png(),
        ])->assertSessionHasNoErrors();
        $profile->refresh();
        $this->track($profile->image);
        $this->get('/profil')->assertOk()
            ->assertSee($profile->image_url, false)
            ->assertSee('<ol><li>Misi satu</li><li>Misi dua</li></ol>', false)
            ->assertSee('<h2>Latar</h2>', false);
    }

    // ---------------------------------------------------------------- WYSIWYG & sanitasi (W-04, W-06)

    public function test_html_from_editor_is_sanitized_before_saving_and_rendering(): void
    {
        $feature = Feature::firstOrFail();
        $dirty = '<h2 style="text-align: center;">Judul</h2><p><strong>Tebal</strong> <em>miring</em></p>'
            . '<script>alert(1)</script><img src="x" onerror="alert(2)">'
            . '<a href="javascript:alert(3)">klik</a><ul><li>Poin</li></ul>';

        $this->admin()->put(route('admin.features.update', $feature), [
            'name' => $feature->name, 'description' => $dirty,
        ])->assertSessionHasNoErrors();

        $saved = $feature->fresh()->description;
        $this->assertStringNotContainsString('<script', $saved);
        $this->assertStringNotContainsString('onerror', $saved);
        $this->assertStringNotContainsString('javascript:', $saved);
        $this->assertStringContainsString('<h2 style="text-align:center;">Judul</h2>', $saved);
        $this->assertStringContainsString('<strong>Tebal</strong>', $saved);
        $this->assertStringContainsString('<ul><li>Poin</li></ul>', $saved);

        $html = $this->get('/fitur/' . $feature->slug)->assertOk()->getContent();
        $this->assertStringNotContainsString('alert(1)', $html);
        $this->assertStringNotContainsString('alert(2)', $html);   // onerror dibuang
        $this->assertStringNotContainsString('alert(3)', $html);   // javascript: dibuang
        $this->assertStringContainsString('<strong>Tebal</strong>', $html);

        // Kartu katalog tidak menampilkan tag HTML mentah
        $this->get('/fitur')->assertOk()->assertDontSee('&lt;strong&gt;', false)->assertSee('Judul Tebal miring');
    }

    public function test_required_rich_text_rejects_empty_markup(): void
    {
        $feature = Feature::firstOrFail();
        $this->admin()->put(route('admin.features.update', $feature), [
            'name' => $feature->name, 'description' => '<p>&nbsp;</p>',
        ])->assertSessionHasErrors(['description' => 'Deskripsi fitur wajib diisi.']);
    }

    public function test_legacy_plain_text_content_still_renders_as_paragraphs(): void
    {
        $news = Gallery::whereNotNull('content')->firstOrFail();
        $this->assertStringNotContainsString('<p>', $news->content); // data lama berupa teks polos

        $first = $news->paragraphs()[0];
        $this->get('/berita/' . $news->slug)->assertOk()->assertSee('<p>' . e($first), false);

        // Misi bawaan seeder (teks polos bernomor per baris) tetap dipisah baris
        $mission = Profile::first()->mission;
        $this->get('/profil')->assertOk()->assertSee(e(strtok($mission, "\n")), false);
    }

    public function test_news_content_from_editor_is_saved_sanitized_and_rendered(): void
    {
        $this->admin()->post(route('admin.galleries.store'), [
            'title' => 'Berita Berformat',
            'content' => '<h2>Sub Judul</h2><p>Isi <strong>tebal</strong></p><script>x()</script>',
        ])->assertSessionHasNoErrors();

        $news = Gallery::where('title', 'Berita Berformat')->firstOrFail();
        $this->assertStringNotContainsString('<script', $news->content);
        $this->get('/berita/' . $news->slug)->assertOk()
            ->assertSee('<h2>Sub Judul</h2>', false)
            ->assertSee('<strong>tebal</strong>', false)
            ->assertDontSee('x()', false);
        $this->get('/berita')->assertOk()->assertSee('Sub Judul Isi tebal');
    }

    public function test_editor_image_upload_endpoint(): void
    {
        $this->post(route('admin.editor.upload'), ['file' => $this->png()])->assertRedirect(route('admin.login'));

        $res = $this->admin()->postJson(route('admin.editor.upload'), ['file' => $this->png()])->assertOk();
        $location = $res->json('location');
        $this->assertNotEmpty($location);
        $this->track('editor/' . basename(parse_url($location, PHP_URL_PATH)));
        Storage::disk('public')->assertExists('editor/' . basename(parse_url($location, PHP_URL_PATH)));

        $this->admin()->postJson(route('admin.editor.upload'), [
            'file' => UploadedFile::fake()->createWithContent('a.txt', 'teks'),
        ])->assertStatus(422)->assertJsonValidationErrors('file');
    }

    // ---------------------------------------------------------------- Artikel (A-01–A-12)

    public function test_article_menu_list_and_detail_pages(): void
    {
        $this->assertSame(3, Article::published()->count()); // seeder contoh

        $home = $this->get('/')->assertOk();
        $home->assertSee(route('articles'), false)->assertSee('Artikel Terbaru');

        $this->get('/artikel')->assertOk()->assertSee('Artikel SIP-Kes')->assertSee('Baca Selengkapnya');

        foreach (Article::published()->get() as $article) {
            $this->get('/artikel/' . $article->slug)->assertOk()
                ->assertSee($article->title)
                ->assertSee('Kembali ke Daftar Artikel')
                ->assertSee('<meta property="og:title" content="' . e($article->title) . '">', false)
                ->assertSee('<meta name="description" content="' . e($article->meta_description_text) . '">', false);
        }

        $cat = ArticleCategory::where('slug', 'regulasi-akreditasi')->firstOrFail();
        $this->get('/artikel?category=' . $cat->slug)->assertOk()
            ->assertSee('Memahami Kewajiban RME')
            ->assertDontSee('Persiapan Bridging SATUSEHAT untuk Fasilitas Kesehatan');
        $this->get('/artikel?q=Bridging')->assertOk()->assertSee('Persiapan Bridging SATUSEHAT');
        $this->get('/artikel?q=tidak-ada-judul-ini')->assertOk()->assertSee('Artikel tidak ditemukan');
        $this->get('/artikel/tidak-ada')->assertNotFound();
    }

    public function test_draft_and_scheduled_articles_are_hidden(): void
    {
        $draft = Article::create(['title' => 'Artikel Draf Rahasia', 'content' => '<p>Draf</p>', 'status' => 'draft']);
        $scheduled = Article::create([
            'title' => 'Artikel Terjadwal Nanti', 'content' => '<p>Nanti</p>',
            'status' => 'published', 'published_at' => now()->addDays(3),
        ]);

        $this->get('/artikel/' . $draft->slug)->assertNotFound();
        $this->get('/artikel/' . $scheduled->slug)->assertNotFound();
        $this->get('/artikel')->assertDontSee('Artikel Draf Rahasia')->assertDontSee('Artikel Terjadwal Nanti');
        $this->get('/')->assertDontSee('Artikel Draf Rahasia');

        // Pratinjau admin tetap bisa melihat draf
        $this->admin()->get(route('admin.articles.preview', $draft))->assertOk()->assertSee('Mode pratinjau')->assertSee('Artikel Draf Rahasia');
    }

    public function test_article_preview_requires_admin_login(): void
    {
        $draft = Article::create(['title' => 'Draf Tertutup', 'content' => '<p>Draf</p>', 'status' => 'draft']);
        $this->get(route('admin.articles.preview', $draft))->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_crud_and_publish_articles(): void
    {
        $cat = ArticleCategory::firstOrFail();

        $this->admin()->get(route('admin.articles.index'))->assertOk()->assertSee('Tulis Artikel Baru');
        $this->admin()->get(route('admin.articles.create'))->assertOk()->assertSee('wysiwyg', false);

        // Validasi
        $this->admin()->post(route('admin.articles.store'), ['title' => '', 'content' => '<p></p>', 'status' => 'draft'])
            ->assertSessionHasErrors(['title', 'content']);

        // Simpan sebagai draf, dengan cover
        $this->admin()->post(route('admin.articles.store'), [
            'title' => 'Artikel Uji Admin',
            'category_id' => $cat->id,
            'excerpt' => 'Ringkasan uji.',
            'content' => '<h2>Bagian</h2><p>Isi <em>artikel</em> uji.</p><script>bad()</script>',
            'status' => 'draft',
            'cover_image' => $this->png('cover.png'),
        ])->assertRedirect(route('admin.articles.index'))->assertSessionHasNoErrors();

        $article = Article::where('title', 'Artikel Uji Admin')->firstOrFail();
        $cover = $this->track($article->cover_image);
        $this->assertSame('draft', $article->state);
        $this->assertSame($this->admin->name, $article->author);
        $this->assertSame($this->admin->id, $article->admin_id);
        $this->assertStringNotContainsString('<script', $article->content);
        $this->assertStringStartsWith('articles/', $cover);
        $this->get('/artikel/' . $article->slug)->assertNotFound();

        // Terbitkan dari daftar
        $this->admin()->patch(route('admin.articles.publish', $article))->assertSessionHas('success');
        $article->refresh();
        $this->assertSame('published', $article->state);
        $this->assertNotNull($article->published_at);
        $this->get('/artikel/' . $article->slug)->assertOk()
            ->assertSee('<h2>Bagian</h2>', false)
            ->assertSee($article->cover_url, false)
            ->assertDontSee('bad()', false);
        $this->get('/')->assertSee('Artikel Uji Admin');

        // Edit: ubah judul (slug tetap) & ganti cover
        $slug = $article->slug;
        $this->admin()->put(route('admin.articles.update', $article), [
            'title' => 'Artikel Uji Admin Revisi', 'content' => '<p>Isi revisi</p>', 'status' => 'published',
            'cover_image' => $this->png('cover2.png'),
        ])->assertSessionHasNoErrors();
        $article->refresh();
        $this->track($article->cover_image);
        $this->assertSame($slug, $article->slug);
        Storage::disk('public')->assertMissing($cover);
        $this->get('/artikel/' . $slug)->assertOk()->assertSee('Artikel Uji Admin Revisi')->assertSee('Isi revisi');

        // Batalkan terbit
        $this->admin()->patch(route('admin.articles.publish', $article));
        $this->assertSame('draft', $article->fresh()->state);
        $this->get('/artikel/' . $slug)->assertNotFound();

        // Filter daftar admin
        $this->admin()->get(route('admin.articles.index', ['status' => 'draft']))->assertOk()->assertSee('Artikel Uji Admin Revisi');
        $this->admin()->get(route('admin.articles.index', ['status' => 'published']))->assertOk()->assertDontSee('Artikel Uji Admin Revisi');

        // Hapus → cover ikut terhapus
        $currentCover = $article->cover_image;
        $this->admin()->delete(route('admin.articles.destroy', $article))->assertRedirect(route('admin.articles.index'));
        $this->assertNull(Article::find($article->id));
        Storage::disk('public')->assertMissing($currentCover);
    }

    public function test_admin_can_manage_article_categories(): void
    {
        $this->admin()->post(route('admin.articles.categories.store'), ['name' => 'Tips Manajemen Faskes'])->assertSessionHasNoErrors();
        $cat = ArticleCategory::where('name', 'Tips Manajemen Faskes')->firstOrFail();
        $this->assertSame('tips-manajemen-faskes', $cat->slug);

        $this->admin()->post(route('admin.articles.categories.store'), ['name' => 'Tips Manajemen Faskes'])->assertSessionHasErrors('name');

        $article = Article::published()->firstOrFail();
        $article->update(['category_id' => $cat->id]);
        $this->admin()->delete(route('admin.articles.categories.destroy', $cat));
        $this->assertNull($article->fresh()->category_id);
        $this->get('/artikel/' . $article->slug)->assertOk();
    }

    // ---------------------------------------------------------------- Beranda (H-01–H-05)

    public function test_home_images_are_managed_from_admin_with_fallback(): void
    {
        $this->get('/')->assertOk()->assertSee('SIP-Kes Cloud Ecosystem'); // kartu ilustrasi bawaan

        $this->admin()->get(route('admin.home.index'))->assertOk()->assertSee('Gambar Hero');

        $banner = Banner::firstOrFail();
        $this->admin()->post(route('admin.home.update'), [
            'badge' => $banner->badge, 'title' => $banner->title, 'subtitle' => $banner->subtitle,
            'primary_btn_text' => $banner->primary_btn_text, 'primary_btn_url' => $banner->primary_btn_url,
            'secondary_btn_text' => $banner->secondary_btn_text, 'secondary_btn_url' => $banner->secondary_btn_url,
            'image' => $this->png('hero.png'), 'intro_image' => $this->png('intro.png'),
        ])->assertSessionHasNoErrors();

        $banner->refresh();
        $hero = $this->track($banner->image);
        $intro = $this->track(SiteSetting::get('home_intro_image'));
        $this->assertStringStartsWith('banners/', $hero);
        $this->assertStringStartsWith('home/', $intro);

        $this->get('/')->assertOk()
            ->assertSee($banner->image_url, false)
            ->assertSee(\App\Support\ImageUpload::url($intro), false)
            ->assertDontSee('SIP-Kes Cloud Ecosystem');

        // Hapus kedua gambar → kembali ke tampilan bawaan
        $this->admin()->post(route('admin.home.update'), [
            'badge' => $banner->badge, 'title' => $banner->title, 'subtitle' => $banner->subtitle,
            'primary_btn_text' => $banner->primary_btn_text, 'primary_btn_url' => $banner->primary_btn_url,
            'secondary_btn_text' => $banner->secondary_btn_text, 'secondary_btn_url' => $banner->secondary_btn_url,
            'remove_image' => '1', 'remove_intro_image' => '1',
        ])->assertSessionHasNoErrors();
        $this->assertNull($banner->fresh()->image);
        $this->assertNull(SiteSetting::get('home_intro_image'));
        Storage::disk('public')->assertMissing($hero);
        Storage::disk('public')->assertMissing($intro);
        $this->get('/')->assertOk()->assertSee('SIP-Kes Cloud Ecosystem');
    }

    public function test_home_hides_article_section_without_published_articles(): void
    {
        Article::query()->update(['status' => 'draft']);
        $this->get('/')->assertOk()->assertDontSee('Artikel Terbaru');
        $this->get('/artikel')->assertOk()->assertSee('Artikel segera hadir');
    }

    // ---------------------------------------------------------------- Halaman admin

    public function test_all_admin_pages_render(): void
    {
        $pages = [
            route('admin.dashboard'), route('admin.home.index'), route('admin.profile.index'),
            route('admin.features.index'), route('admin.features.create'), route('admin.features.edit', Feature::first()),
            route('admin.advantages.index'), route('admin.advantages.create'), route('admin.advantages.edit', Advantage::first()),
            route('admin.support-services.index'), route('admin.support-services.create'), route('admin.support-services.edit', SupportService::first()),
            route('admin.galleries.index'), route('admin.galleries.create'), route('admin.galleries.edit', Gallery::first()),
            route('admin.articles.index'), route('admin.articles.create'), route('admin.articles.edit', Article::first()),
            route('admin.pricing.index'), route('admin.contact.index'),
        ];

        foreach ($pages as $url) {
            $this->admin()->get($url)->assertOk();
        }

        $this->admin()->get(route('admin.dashboard'))->assertSee('Artikel Terbit');
        $this->admin()->get(route('admin.profile.index'))->assertSee('class="wysiwyg', false)->assertSee('tinymce@7.6.1', false);
    }
}
