<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Information;
use Database\Seeders\SipKesDatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class InformationPageTest extends TestCase
{
    use RefreshDatabase;

    private array $created = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(SipKesDatabaseSeeder::class);
    }

    protected function tearDown(): void
    {
        foreach ($this->created as $path) {
            Storage::disk('public')->delete($path);
        }
        parent::tearDown();
    }

    private function png(string $name = 'info.png'): UploadedFile
    {
        // PNG 1x1 asli (tanpa ekstensi GD)
        $bytes = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');

        return UploadedFile::fake()->createWithContent($name, $bytes);
    }

    public function test_menu_link_and_empty_state(): void
    {
        $this->get('/fitur')->assertOk()->assertSee(route('information'), false);
        $this->get('/informasi')->assertOk()->assertSee('Belum ada informasi');
    }

    public function test_admin_crud_and_public_preview(): void
    {
        $admin = Admin::first();

        // Foto wajib saat membuat
        $this->actingAs($admin, 'admin')
            ->post(route('admin.information.store'), ['title' => 'Tanpa Foto', 'is_active' => 1])
            ->assertSessionHasErrors('image');

        $this->actingAs($admin, 'admin')
            ->post(route('admin.information.store'), [
                'title' => 'Jadwal Pelatihan SIP-Kes',
                'description' => 'Pelatihan pengguna untuk faskes mitra.',
                'date' => '2026-11-18',
                'is_active' => 1,
                'image' => $this->png(),
            ])
            ->assertRedirect(route('admin.information.index'))
            ->assertSessionHasNoErrors();

        $info = Information::where('title', 'Jadwal Pelatihan SIP-Kes')->firstOrFail();
        $this->created[] = $info->image;
        $this->assertTrue($info->hasValidImage());

        // Halaman publik: foto bisa diklik (data-src untuk preview) + lightbox tersedia
        $this->get('/informasi')
            ->assertOk()
            ->assertSee('Jadwal Pelatihan SIP-Kes')
            ->assertSee('data-src="' . $info->image_url . '"', false)
            ->assertSee('id="sk-lightbox"', false)
            ->assertSee('data-lightbox-group="informasi"', false);

        // Admin pages
        $this->actingAs($admin, 'admin')->get(route('admin.information.index'))->assertOk()->assertSee('Jadwal Pelatihan SIP-Kes');
        $this->actingAs($admin, 'admin')->get(route('admin.information.create'))->assertOk();
        $this->actingAs($admin, 'admin')->get(route('admin.information.edit', $info))->assertOk();

        // Sembunyikan → tidak tampil di publik; foto lama tetap
        $this->actingAs($admin, 'admin')
            ->put(route('admin.information.update', $info), ['title' => 'Jadwal Pelatihan SIP-Kes', 'is_active' => 0])
            ->assertSessionHasNoErrors();
        $this->assertFalse($info->fresh()->is_active);
        $this->assertSame($info->image, $info->fresh()->image);
        $this->get('/informasi')->assertOk()->assertDontSee('Jadwal Pelatihan SIP-Kes');

        // Hapus → data & file terhapus
        $path = $info->image;
        $this->actingAs($admin, 'admin')->delete(route('admin.information.destroy', $info))->assertRedirect();
        $this->assertNull(Information::find($info->id));
        $this->assertFalse(Storage::disk('public')->exists($path));
    }

    public function test_admin_pages_require_login(): void
    {
        $this->get(route('admin.information.index'))->assertRedirect(route('admin.login'));
    }
}
