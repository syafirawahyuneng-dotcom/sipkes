<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\AdvantageController;
use App\Http\Controllers\Admin\PricingPlanController;
use App\Http\Controllers\Admin\SupportServiceController;
use App\Http\Controllers\Admin\GalleryController;

/*
|--------------------------------------------------------------------------
| Web Routes - Portal SIP-Kes (TeFa V-Kes Polije)
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. FRONTEND PUBLIK (Dapat Diakses Pengunjung)
// ==========================================
Route::get('/', [PortalController::class, 'home'])->name('home');
Route::get('/profil', [PortalController::class, 'profile'])->name('profile');
Route::get('/fitur', [PortalController::class, 'features'])->name('features');
Route::get('/fitur/{feature:slug}', [PortalController::class, 'featureShow'])->name('features.show');
Route::get('/keunggulan', [PortalController::class, 'advantages'])->name('advantages');
Route::get('/harga', [PortalController::class, 'pricing'])->name('pricing');
Route::get('/layanan-pendukung', [PortalController::class, 'supportServices'])->name('support.services');
Route::get('/berita', [PortalController::class, 'news'])->name('news');
Route::get('/berita/{news:slug}', [PortalController::class, 'newsShow'])->name('news.show');
Route::permanentRedirect('/galeri', '/berita'); // tautan lama Galeri
// Cadangan penyaji gambar unggahan (disk public) bila link public/storage belum dibuat
Route::get('/media/{path}', [PortalController::class, 'media'])->where('path', '[A-Za-z0-9_\-\/]+\.(jpe?g|png|gif|webp)')->name('media');
Route::get('/kontak', [PortalController::class, 'contact'])->name('contact');
Route::post('/kontak/kirim-pesan', [PortalController::class, 'sendMessage'])->name('contact.send');

// ==========================================
// 2. BACKEND / ADMIN AUTH & DASHBOARD
// ==========================================
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Auth Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected Admin Routes (Perlu Login)
    Route::middleware('admin')->group(function () {
        // Dashboard Ringkasan
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Kelola Beranda (Hero Banner)
        Route::get('/home-content', [DashboardController::class, 'homeIndex'])->name('home.index');
        Route::post('/home-content', [DashboardController::class, 'homeUpdate'])->name('home.update');

        // Kelola Profil TeFa & SIP-Kes
        Route::get('/profile-content', [DashboardController::class, 'profileIndex'])->name('profile.index');
        Route::post('/profile-content', [DashboardController::class, 'profileUpdate'])->name('profile.update');

        // Kelola Kontak & Pesan Masuk
        Route::get('/contact-content', [DashboardController::class, 'contactIndex'])->name('contact.index');
        Route::post('/contact-content', [DashboardController::class, 'contactUpdate'])->name('contact.update');
        Route::post('/messages/{message}/read', [DashboardController::class, 'markMessageAsRead'])->name('messages.read');
        Route::delete('/messages/{message}', [DashboardController::class, 'deleteMessage'])->name('messages.destroy');

        // CRUD Fitur SIP-Kes
        Route::resource('features', FeatureController::class)->except(['show']);

        // CRUD Keunggulan
        Route::resource('advantages', AdvantageController::class)->except(['show']);

        // CRUD Paket Harga
        Route::resource('pricing', PricingPlanController::class)->except(['show']);

        // CRUD Layanan Pendukung
        Route::resource('support-services', SupportServiceController::class)->except(['show']);

        // CRUD Berita & Kategori Berita (tabel galleries)
        Route::resource('galleries', GalleryController::class)->except(['show']);
        Route::post('/galleries/categories', [GalleryController::class, 'storeCategory'])->name('galleries.category.store');
        Route::delete('/galleries/categories/{category}', [GalleryController::class, 'destroyCategory'])->name('galleries.category.destroy');
    });
});
