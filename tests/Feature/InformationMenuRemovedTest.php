<?php

namespace Tests\Feature;

use App\Models\Admin;
use Database\Seeders\SipKesDatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * Menu "Informasi" sudah dihapus dari portal & admin dan tidak boleh muncul kembali.
 */
class InformationMenuRemovedTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(SipKesDatabaseSeeder::class);
    }

    public function test_routes_and_table_are_gone(): void
    {
        $this->assertFalse(Route::has('information'));
        $this->assertFalse(Route::has('admin.information.index'));
        $this->assertFalse(Schema::hasTable('information'));
        $this->get('/informasi')->assertNotFound();
        $this->get('/admin/information')->assertNotFound();
    }

    public function test_public_navigation_has_no_informasi_menu(): void
    {
        foreach (['/', '/fitur', '/berita', '/kontak'] as $page) {
            $html = $this->get($page)->assertOk()->getContent();
            $this->assertStringNotContainsString('/informasi', $html, "Tautan Informasi masih ada di $page");
            $this->assertDoesNotMatchRegularExpression('#<p class="font-bold">Informasi</p>#', $html);
            // Menu lain di dropdown Fitur & Layanan tetap ada
            $this->assertStringContainsString('Layanan Pendukung', $html);
        }
    }

    public function test_admin_sidebar_has_no_informasi_menu_after_login(): void
    {
        $html = $this->actingAs(Admin::first(), 'admin')->get(route('admin.dashboard'))->assertOk()->getContent();
        $this->assertStringNotContainsString('/admin/information', $html);
        $this->assertStringContainsString(route('admin.articles.index'), $html);
        $this->assertStringContainsString(route('admin.contact.index'), $html);
    }
}
