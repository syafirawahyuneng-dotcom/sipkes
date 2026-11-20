<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Feature;
use App\Models\Gallery;
use Database\Seeders\SipKesDatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Lightbox global (resources/views/partials/lightbox.blade.php) terpasang
 * di semua halaman publik & admin, satu kali per halaman, dan logo dikecualikan.
 */
class ImageLightboxTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(SipKesDatabaseSeeder::class);
    }

    private function assertLightboxOnce(string $html, string $page): void
    {
        $this->assertSame(1, substr_count($html, 'id="sk-lightbox"'), "Lightbox harus tepat satu di $page");
        $this->assertStringContainsString('window.SkLightbox', $html, "Script lightbox tidak ada di $page");
    }

    public function test_lightbox_is_present_on_every_public_page(): void
    {
        $pages = ['/', '/profil', '/fitur', '/keunggulan', '/harga', '/layanan-pendukung', '/berita', '/artikel', '/informasi', '/kontak',
            '/fitur/' . Feature::first()->slug, '/berita/' . Gallery::first()->slug];

        foreach ($pages as $page) {
            $html = $this->get($page)->assertOk()->getContent();
            $this->assertLightboxOnce($html, $page);
            // Logo situs tidak ikut dipreview
            $this->assertMatchesRegularExpression('/alt="Logo Resmi SIP-Kes" data-no-preview/', $html, "Logo tanpa data-no-preview di $page");
        }
    }

    public function test_lightbox_is_present_on_admin_pages(): void
    {
        $admin = Admin::first();
        foreach (['admin.dashboard', 'admin.galleries.index', 'admin.information.index', 'admin.features.index'] as $route) {
            $html = $this->actingAs($admin, 'admin')->get(route($route))->assertOk()->getContent();
            $this->assertLightboxOnce($html, $route);
        }
    }
}
