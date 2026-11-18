<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Support\RichText;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Kategori & artikel contoh (PRD Fase 2 · A-12). Aman dijalankan berulang:
 * data dicari berdasarkan slug sehingga tidak terduplikasi.
 *
 *   php artisan db:seed --class=ArticleSeeder
 */
class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'rekam-medis-elektronik' => 'Rekam Medis Elektronik',
            'regulasi-akreditasi' => 'Regulasi & Akreditasi',
            'integrasi-satusehat-bpjs' => 'Integrasi SATUSEHAT & BPJS',
        ];
        $cat = [];
        foreach ($categories as $slug => $name) {
            $cat[$slug] = ArticleCategory::firstOrCreate(['slug' => $slug], ['name' => $name]);
        }

        $adminId = Admin::query()->value('id');

        $articles = [
            [
                'slug' => 'langkah-memulai-rekam-medis-elektronik-di-klinik-pratama',
                'category' => 'rekam-medis-elektronik',
                'title' => 'Langkah Memulai Rekam Medis Elektronik di Klinik Pratama',
                'excerpt' => 'Panduan praktis transisi dari rekam medis kertas ke rekam medis elektronik: persiapan SDM, data, perangkat, hingga uji coba layanan.',
                'is_featured' => true,
                'days_ago' => 2,
                'content' => <<<'HTML'
<p>Peralihan dari rekam medis kertas ke <strong>rekam medis elektronik (RME)</strong> bukan sekadar mengganti map dengan komputer. Klinik perlu menyiapkan orang, proses, dan data agar pelayanan tetap berjalan lancar selama masa transisi.</p>
<h2>1. Petakan alur pelayanan yang berjalan</h2>
<p>Mulailah dengan mencatat alur pasien dari pendaftaran hingga kasir. Pemetaan ini membantu menentukan modul yang dibutuhkan lebih dulu, misalnya:</p>
<ul>
<li>Pendaftaran dan antrian pasien</li>
<li>Pemeriksaan (SOAP) serta diagnosa ICD-10</li>
<li>Farmasi dan kasir</li>
</ul>
<h2>2. Siapkan sumber daya manusia</h2>
<p>Tetapkan penanggung jawab RME di klinik, lalu jadwalkan pelatihan untuk setiap peran: petugas pendaftaran, dokter, perawat, apoteker, dan kasir. Pelatihan singkat namun berulang biasanya lebih efektif daripada satu sesi panjang.</p>
<h2>3. Migrasi data pasien secara bertahap</h2>
<p>Data identitas pasien aktif dapat dimasukkan lebih dulu. Riwayat kunjungan lama bisa didigitalkan bertahap sesuai prioritas kunjungan ulang.</p>
<blockquote>Tips: jalankan uji coba paralel selama 1–2 minggu, yaitu pencatatan kertas dan elektronik berjalan bersamaan, sebelum benar-benar beralih penuh.</blockquote>
<h2>4. Evaluasi dan sempurnakan</h2>
<ol>
<li>Kumpulkan masukan dari petugas setiap pekan.</li>
<li>Pantau waktu tunggu pasien sebelum dan sesudah RME.</li>
<li>Pastikan data terkirim ke SATUSEHAT tanpa kendala.</li>
</ol>
<p>Tim TeFa V-Kes Polije mendampingi setiap tahap tersebut, mulai dari pelatihan hingga simulasi bridging.</p>
HTML,
            ],
            [
                'slug' => 'memahami-kewajiban-rme-menurut-pmk-24-tahun-2022',
                'category' => 'regulasi-akreditasi',
                'title' => 'Memahami Kewajiban RME Menurut PMK Nomor 24 Tahun 2022',
                'excerpt' => 'Ringkasan poin penting Peraturan Menteri Kesehatan Nomor 24 Tahun 2022 tentang Rekam Medis yang perlu dipahami pengelola fasilitas pelayanan kesehatan.',
                'is_featured' => false,
                'days_ago' => 6,
                'content' => <<<'HTML'
<p>Peraturan Menteri Kesehatan (PMK) Nomor 24 Tahun 2022 tentang Rekam Medis mewajibkan setiap fasilitas pelayanan kesehatan menyelenggarakan <strong>rekam medis elektronik</strong>. Berikut poin-poin yang perlu dipahami pengelola faskes.</p>
<h2>Siapa yang wajib?</h2>
<p>Kewajiban berlaku bagi fasilitas pelayanan kesehatan, termasuk tempat praktik mandiri dokter, klinik, puskesmas, laboratorium, apotek, dan rumah sakit.</p>
<h2>Kegiatan penyelenggaraan RME</h2>
<table>
<thead><tr><th>Kegiatan</th><th>Contoh di klinik</th></tr></thead>
<tbody>
<tr><td>Registrasi pasien</td><td>Pencatatan identitas dan nomor rekam medis</td></tr>
<tr><td>Pendistribusian data</td><td>Data pemeriksaan diteruskan ke farmasi dan kasir</td></tr>
<tr><td>Pengisian informasi klinis</td><td>Anamnesis, pemeriksaan, diagnosis, dan tindakan</td></tr>
<tr><td>Penyimpanan & penjaminan mutu</td><td>Backup data dan audit kelengkapan</td></tr>
<tr><td>Transfer isi rekam medis</td><td>Pengiriman data ke platform SATUSEHAT</td></tr>
</tbody>
</table>
<h2>Keamanan dan kerahasiaan</h2>
<p>RME wajib menjamin <em>kerahasiaan, keutuhan, dan ketersediaan</em> data. Hak akses perlu dibatasi sesuai peran pengguna serta dilengkapi pencatatan aktivitas.</p>
<p>Dengan memilih sistem yang patuh regulasi sejak awal, faskes dapat terhindar dari sanksi administratif dan lebih siap menghadapi akreditasi.</p>
HTML,
            ],
            [
                'slug' => 'persiapan-bridging-satusehat-untuk-faskes',
                'category' => 'integrasi-satusehat-bpjs',
                'title' => 'Persiapan Bridging SATUSEHAT untuk Fasilitas Kesehatan',
                'excerpt' => 'Daftar persiapan administratif dan teknis sebelum faskes menghubungkan sistem RME ke platform SATUSEHAT Kementerian Kesehatan.',
                'is_featured' => false,
                'days_ago' => 12,
                'content' => <<<'HTML'
<p><strong>SATUSEHAT</strong> adalah platform integrasi data kesehatan nasional dari Kementerian Kesehatan RI. Agar data pelayanan dari sistem RME dapat terkirim, faskes perlu menyiapkan beberapa hal berikut.</p>
<h2>Persiapan administratif</h2>
<ul>
<li>Faskes telah terdaftar dan memiliki kode faskes yang valid.</li>
<li>Akun SATUSEHAT Platform untuk mendapatkan kredensial integrasi.</li>
<li>Data tenaga kesehatan lengkap dengan NIK yang sesuai.</li>
</ul>
<h2>Persiapan teknis</h2>
<ol>
<li>Pemetaan lokasi pelayanan (poli, ruang, dan unit).</li>
<li>Standarisasi kode diagnosa ICD-10 dan tindakan ICD-9-CM.</li>
<li>Uji coba pengiriman data di lingkungan <em>sandbox</em> sebelum produksi.</li>
</ol>
<h3>Bagaimana dengan BPJS Kesehatan?</h3>
<p>Untuk faskes yang melayani peserta JKN, integrasi dengan layanan BPJS Kesehatan dapat dilakukan berdampingan sehingga petugas tidak perlu menginput data dua kali.</p>
<p>SIP-Kes telah menyediakan modul <strong>Pengaturan Integrasi SatuSehat dan BPJS Kesehatan</strong> beserta pendampingan dari tim TeFa V-Kes Polije.</p>
HTML,
            ],
        ];

        foreach ($articles as $a) {
            Article::updateOrCreate(['slug' => $a['slug']], [
                'category_id' => $cat[$a['category']]->id,
                'admin_id' => $adminId,
                'title' => $a['title'],
                'excerpt' => $a['excerpt'],
                'content' => RichText::clean($a['content']),
                'author' => 'Tim TeFa V-Kes Polije',
                'status' => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDays($a['days_ago'])->setTime(9, 0),
                'is_featured' => $a['is_featured'],
                'meta_description' => Str::limit($a['excerpt'], 157),
            ]);
        }
    }
}
