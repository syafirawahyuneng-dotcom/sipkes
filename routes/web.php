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
use App\Http\Controllers\RmeController;

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
Route::get('/keunggulan', [PortalController::class, 'advantages'])->name('advantages');
Route::get('/harga', [PortalController::class, 'pricing'])->name('pricing');
Route::get('/layanan-pendukung', [PortalController::class, 'supportServices'])->name('support.services');
Route::get('/galeri', [PortalController::class, 'gallery'])->name('gallery');
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

        // CRUD Galeri & Kategori
        Route::resource('galleries', GalleryController::class)->except(['show']);
        Route::post('/galleries/categories', [GalleryController::class, 'storeCategory'])->name('galleries.category.store');
        Route::delete('/galleries/categories/{category}', [GalleryController::class, 'destroyCategory'])->name('galleries.category.destroy');
    });
});

// ==========================================
// 3. SISTEM RME OPERASIONAL LENGKAP (20 FITUR PROPOSAL)
// ==========================================
Route::prefix('rme')->name('rme.')->group(function () {
    // 9. Dashboard
    Route::get('/', [RmeController::class, 'dashboard'])->name('home');
    Route::get('/dashboard', [RmeController::class, 'dashboard'])->name('dashboard');

    // 1. Pendaftaran
    Route::get('/pendaftaran', [RmeController::class, 'pendaftaran'])->name('pendaftaran');
    Route::post('/pendaftaran', [RmeController::class, 'storePendaftaran'])->name('pendaftaran.store');

    // 2. Antrian & Panggilan Suara
    Route::get('/antrian', [RmeController::class, 'antrian'])->name('antrian');
    Route::post('/antrian/store', [RmeController::class, 'storeQueue'])->name('antrian.store');
    Route::post('/antrian/{queue}/call', [RmeController::class, 'callQueue'])->name('antrian.call');
    Route::post('/antrian/{queue}/complete', [RmeController::class, 'completeQueue'])->name('antrian.complete');

    // 3. Pemeriksaan Keluhan Klinis (SO)
    Route::get('/pemeriksaan-so', [RmeController::class, 'pemeriksaanSo'])->name('pemeriksaan.so');
    Route::post('/pemeriksaan-so', [RmeController::class, 'storePemeriksaanSo'])->name('pemeriksaan.so.store');

    // 4. Diagnosa & Tindakan (AP)
    Route::get('/diagnosa-tindakan', [RmeController::class, 'diagnosaTindakan'])->name('diagnosa.tindakan');
    Route::post('/diagnosa-tindakan/{examination}', [RmeController::class, 'storeDiagnosaTindakan'])->name('diagnosa.tindakan.store');

    // 5. Farmasi
    Route::get('/farmasi', [RmeController::class, 'farmasi'])->name('farmasi');
    Route::post('/farmasi/obat', [RmeController::class, 'storeMedicine'])->name('farmasi.store');
    Route::post('/farmasi/{medicine}/dispense', [RmeController::class, 'dispenseMedicine'])->name('farmasi.dispense');

    // 6. Kasir
    Route::get('/kasir', [RmeController::class, 'kasir'])->name('kasir');
    Route::post('/kasir/{invoice}/bayar', [RmeController::class, 'payInvoice'])->name('kasir.pay');

    // 7. Rawat Inap
    Route::get('/rawat-inap', [RmeController::class, 'rawatInap'])->name('rawat.inap');
    Route::post('/rawat-inap/masuk', [RmeController::class, 'storeInpatientAdmission'])->name('rawat.inap.store');
    Route::post('/rawat-inap/{admission}/checkout', [RmeController::class, 'checkoutInpatient'])->name('rawat.inap.checkout');

    // 8. Laporan
    Route::get('/laporan', [RmeController::class, 'laporan'])->name('laporan');

    // 10. Cetak Kartu Berobat
    Route::get('/kartu-berobat', [RmeController::class, 'kartuBerobat'])->name('kartu.berobat');

    // 11. Verifikasi SATUSEHAT
    Route::get('/verifikasi-satusehat', [RmeController::class, 'verifikasiSatusehat'])->name('verifikasi.satusehat');

    // 12. Asuhan Keperawatan (SDKI SIKI SLKI)
    Route::get('/asuhan-keperawatan', [RmeController::class, 'asuhanKeperawatan'])->name('asuhan.keperawatan');
    Route::post('/asuhan-keperawatan', [RmeController::class, 'storeAskep'])->name('asuhan.keperawatan.store');

    // 13. Pengaturan Integrasi
    Route::get('/pengaturan-integrasi', [RmeController::class, 'pengaturanIntegrasi'])->name('pengaturan.integrasi');
    Route::post('/pengaturan-integrasi', [RmeController::class, 'saveIntegrasi'])->name('pengaturan.integrasi.save');
    Route::get('/pengaturan-integrasi/test', [RmeController::class, 'testKoneksi'])->name('pengaturan.integrasi.test');

    // 14. Odontogram Klinik Gigi
    Route::get('/odontogram', [RmeController::class, 'odontogram'])->name('odontogram');
    Route::post('/odontogram/save', [RmeController::class, 'saveTooth'])->name('odontogram.save');

    // 15. General Consent
    Route::get('/general-consent', [RmeController::class, 'generalConsent'])->name('general.consent');
    Route::post('/general-consent', [RmeController::class, 'storeGeneralConsent'])->name('general.consent.store');

    // 16. Informed Consent
    Route::get('/informed-consent', [RmeController::class, 'informedConsent'])->name('informed.consent');
    Route::post('/informed-consent', [RmeController::class, 'storeInformedConsent'])->name('informed.consent.store');

    // 17. Surat Keterangan Dokter (Sakit / Sehat)
    Route::get('/surat-keterangan', [RmeController::class, 'suratKeterangan'])->name('surat.keterangan');
    Route::post('/surat-keterangan', [RmeController::class, 'storeSurat'])->name('surat.keterangan.store');

    // 18. Laboratorium
    Route::get('/laboratorium', [RmeController::class, 'laboratorium'])->name('laboratorium');
    Route::post('/laboratorium', [RmeController::class, 'storeLab'])->name('laboratorium.store');

    // 19. Sedasi
    Route::get('/sedasi', [RmeController::class, 'sedasi'])->name('sedasi');
    Route::post('/sedasi', [RmeController::class, 'storeSedasi'])->name('sedasi.store');

    // 20. Master Data & Fasilitas
    Route::get('/master-data', [RmeController::class, 'masterData'])->name('master.data');
});
