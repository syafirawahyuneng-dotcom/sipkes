<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Profile;
use App\Models\Banner;
use App\Models\Feature;
use App\Models\Advantage;
use App\Models\PricingPlan;
use App\Models\SupportService;
use App\Models\GalleryCategory;
use App\Models\Gallery;
use App\Models\ContactInfo;
use App\Models\SiteSetting;
use App\Models\TargetFacility;

class SipKesDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin Account
        Admin::updateOrCreate(
            ['email' => 'admin@sipkes.id'],
            [
                'name' => 'Administrator SIP-Kes',
                'password' => Hash::make('admin123'),
            ]
        );

        // 2. Profile TeFa V-Kes & SIP-Kes
        Profile::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Teaching Factory Inovasi Kesehatan (TeFa V-Kes)',
                'institution' => 'Politeknik Negeri Jember',
                'tagline' => 'Transformasi Digital Rekam Medis Elektronik Terintegrasi Standar Kemenkes RI',
                'about_tefa' => 'Teaching Factory Inovasi Kesehatan (TeFa V-Kes) merupakan unit usaha dan inovasi akademik di bawah Jurusan Kesehatan Politeknik Negeri Jember. TeFa V-Kes berfokus pada pengembangan teknologi rekam medis elektronik (RME), riset terapan manajemen informasi kesehatan, serta pendampingan digitalisasi fasilitas pelayanan kesehatan di seluruh Indonesia.',
                'about_sipkes' => 'SIP-Kes (Sistem Informasi Pelayanan Kesehatan) adalah platform Rekam Medis Elektronik (RME) modern berbasis cloud website yang dirancang khusus untuk memfasilitasi tata kelola data rekam medis, operasional faskes, serta integrasi wajib platform SATUSEHAT Kementerian Kesehatan RI dan BPJS Kesehatan (PCare & VClaim).',
                'vision' => 'Menjadi pusat inovasi dan rujukan nasional dalam pengembangan teknologi informasi kesehatan vokasional yang adaptif, terintegrasi, dan berdampak nyata bagi faskes di Indonesia.',
                'mission' => "1. Mengembangkan sistem informasi pelayanan kesehatan yang patuh regulasi Kemenkes dan BPJS.\n2. Memberikan layanan pendampingan transisi digital, bridging SATUSEHAT, dan akreditasi klinik.\n3. Mewadahi kolaborasi riset terapan antara dosen, mahasiswa terampil vokasi, dan fasyankes mitra.",
                'goals' => 'Mewujudkan tata kelola faskes yang paperless, efisien, akuntabel, serta mempermudah dokter, perawat, apoteker, dan staf manajemen dalam memberikan pelayanan terbaik kepada masyarakat.',
                'background' => 'Latar belakang pengembangan SIP-Kes berakar dari Peraturan Menteri Kesehatan (PMK) No. 24 Tahun 2022 tentang kewajiban Rekam Medis Elektronik bagi seluruh fasilitas pelayanan kesehatan. Banyak klinik mandiri dan pratama menghadapi hambatan tingginya biaya investasi IT dan rumitnya proses bridging SATUSEHAT. TeFa V-Kes Polije hadir memberikan solusi sistem yang terjangkau, legal, handal, dan disertai pendampingan langsung.',
            ]
        );

        // 3. Hero Banners
        Banner::updateOrCreate(
            ['id' => 1],
            [
                'badge' => '🏥 Portal Resmi SIP-Kes • TeFa V-Kes Polije',
                'title' => 'Solusi Rekam Medis Elektronik & Bridging SATUSEHAT untuk Faskes Anda',
                'subtitle' => 'SIP-Kes menghadirkan integrasi SATUSEHAT Kemenkes & BPJS Kesehatan secara cepat, aman, dan mudah digunakan untuk Praktik Mandiri, Klinik, hingga Puskesmas.',
                'primary_btn_text' => 'Eksplorasi Fitur Lengkap',
                'primary_btn_url' => '#fitur',
                'secondary_btn_text' => 'Konsultasi & Penawaran',
                'secondary_btn_url' => '#kontak',
                'is_active' => true,
                'order' => 1,
            ]
        );

        // 4. Advantages
        $advantages = [
            [
                'title' => 'Terintegrasi SATUSEHAT Kemenkes',
                'icon' => 'fa-shield-halved',
                'description' => 'Sesuai regulasi PMK 24 Tahun 2022. Kirim data Encounter, Condition, Observation, Procedure, Medication ke SATUSEHAT secara otomatis.',
                'order' => 1,
            ],
            [
                'title' => 'Bridging BPJS Kesehatan (PCare)',
                'icon' => 'fa-hospital-user',
                'description' => 'Mendukung integrasi PCare BPJS Kesehatan untuk validasi kepesertaan, pendaftaran kunjungan, hingga pengiriman diagnosa dan obat.',
                'order' => 2,
            ],
            [
                'title' => 'Berbasis Web (Cloud Based)',
                'icon' => 'fa-cloud',
                'description' => 'Akses dari perangkat apa pun (Laptop, Tablet, PC) tanpa perlu instalasi server fisik di klinik Anda. Aman dengan enkripsi standar industri.',
                'order' => 3,
            ],
            [
                'title' => 'Free Training & Pendampingan',
                'icon' => 'fa-chalkboard-user',
                'description' => 'Pelatihan intensif bagi dokter, bidan, perawat, apoteker, dan kasir hingga seluruh SDM faskes mahir mengoperasikan sistem.',
                'order' => 4,
            ],
            [
                'title' => 'Free Custom RME Faskes',
                'icon' => 'fa-sliders',
                'description' => 'Formulir rekam medis, template asesmen dokter/perawat, dan format kartu resep dapat disesuaikan dengan alur spesifik klinik Anda.',
                'order' => 5,
            ],
            [
                'title' => 'Data Tersentralisasi & Real-time',
                'icon' => 'fa-database',
                'description' => 'Manajemen riwayat medis pasien, stok obat multi-depo, dan laporan keuangan klinik terkontrol secara transparan dalam satu dashboard.',
                'order' => 6,
            ],
        ];
        foreach ($advantages as $adv) {
            Advantage::updateOrCreate(['title' => $adv['title']], $adv);
        }

        // 5. Target Facilities
        $facilities = [
            ['name' => 'Praktik Dokter Mandiri', 'icon' => 'fa-user-doctor', 'description' => 'Praktik Dokter Umum & Spesialis yang membutuhkan pencatatan RME simpel dan koneksi SATUSEHAT.', 'order' => 1],
            ['name' => 'Klinik Pratama (Rawat Jalan)', 'icon' => 'fa-clinic-medical', 'description' => 'Klinik Pratama dengan alur registrasi, poli umum, poli gigi, farmasi, dan kasir terintegrasi.', 'order' => 2],
            ['name' => 'Klinik Rawat Inap & Bersalin', 'icon' => 'fa-bed-pulse', 'description' => 'Mendukung pengelolaan bangsal rawat inap, asuhan keperawatan, visite, serta gizi medis.', 'order' => 3],
            ['name' => 'Puskesmas', 'icon' => 'fa-building-columns', 'description' => 'Fasilitas kesehatan tingkat pertama pemerintah dengan pelaporan berstandar kementerian.', 'order' => 4],
            ['name' => 'Klinik Gigi & Estetika', 'icon' => 'fa-tooth', 'description' => 'Dilengkapi diagram Odontogram interaktif untuk riwayat kondisi gigi geligi dan tindakan.', 'order' => 5],
            ['name' => 'Laboratorium Medis Mandiri', 'icon' => 'fa-flask-vial', 'description' => 'Manajemen order spesimen, hasil uji laboratorium, dan pencetakan lembar hasil resmi.', 'order' => 6],
        ];
        foreach ($facilities as $fac) {
            TargetFacility::updateOrCreate(['name' => $fac['name']], $fac);
        }

        // 6. Features (Sesuai Proposal)
        $features = [
            ['name' => 'Pendaftaran Pasien & Cetak Kartu', 'category' => 'Pelayanan', 'icon' => 'fa-id-card', 'description' => 'Registrasi pasien baru & lama, auto-generate No. Rekam Medis, pencarian data NIK/BPJS, serta pencetakan kartu berobat fisik & barcode.', 'is_featured' => true, 'order' => 1],
            ['name' => 'Antrian & Panggilan Suara (Audio Queuing)', 'category' => 'Pelayanan', 'icon' => 'fa-bullhorn', 'description' => 'Sistem antrian loket dan poli otomatis dengan teknologi Text-to-Speech pemanggil nama dan nomor loket ke layar display pasien.', 'is_featured' => true, 'order' => 2],
            ['name' => 'Pemeriksaan Klinis (SO)', 'category' => 'Rekam Medis', 'icon' => 'fa-stethoscope', 'description' => 'Pencatatan data Subjektif (keluhan, riwayat penyakit, alergi) dan Objektif (tanda-tanda vital, tinggi/berat badan, status lokalis).', 'is_featured' => true, 'order' => 3],
            ['name' => 'Diagnosa ICD-10 & Tindakan ICD-9-CM (AP)', 'category' => 'Rekam Medis', 'icon' => 'fa-notes-medical', 'description' => 'Pencarian cerdas kode diagnosis ICD-10 resmi dan kode prosedur tindakan ICD-9-CM untuk standarisasi asesmen dokter (A) dan rencana terapi (P).', 'is_featured' => true, 'order' => 4],
            ['name' => 'Farmasi & E-Resep', 'category' => 'Farmasi', 'icon' => 'fa-pills', 'description' => 'Resep elektronik langsung dari poli ke apotek faskes, peracikan obat racikan/non-racikan, otomatis potong stok obat, dan cetak etiket aturan minum.', 'is_featured' => true, 'order' => 5],
            ['name' => 'Kasir & Billing Terpadu', 'category' => 'Keuangan', 'icon' => 'fa-cash-register', 'description' => 'Integrasi tagihan otomatis dari tindakan dokter, obat apotek, kamar rawat inap, dan laboratorium dengan invoice resmi serta multi-metode pembayaran.', 'is_featured' => true, 'order' => 6],
            ['name' => 'Rawat Inap & Manajemen Bed', 'category' => 'Pelayanan', 'icon' => 'fa-bed', 'description' => 'Monitoring ketersediaan kamar dan ranjang (bed status), catatan perkembangan pasien terintegrasi (CPPT), visite dokter harian, dan billing harian.', 'is_featured' => true, 'order' => 7],
            ['name' => 'Verifikasi SATUSEHAT Mobile', 'category' => 'Integrasi', 'icon' => 'fa-mobile-screen-button', 'description' => 'Validasi profil pasien dan scan QR SATUSEHAT Mobile langsung di loket faskes untuk mengonfirmasi identitas terverifikasi Kemenkes.', 'is_featured' => true, 'order' => 8],
            ['name' => 'Pengaturan Integrasi SATUSEHAT & BPJS', 'category' => 'Integrasi', 'icon' => 'fa-network-wired', 'description' => 'Konfigurasi Organization ID, Client ID, Secret Key SATUSEHAT, serta ConsID dan SecretKey BPJS Kesehatan dengan status koneksi live monitoring.', 'is_featured' => true, 'order' => 9],
            ['name' => 'Odontogram Klinik Gigi', 'category' => 'Rekam Medis', 'icon' => 'fa-tooth', 'description' => 'Diagram visual gigi interaktif untuk dokter gigi menandai kondisi karies, tambalan, pencabutan, dan riwayat tindakan restorasi gigi.', 'is_featured' => false, 'order' => 10],
            ['name' => 'General Consent & Informed Consent Digital', 'category' => 'Legalitas', 'icon' => 'fa-file-signature', 'description' => 'Formulir persetujuan umum dan persetujuan tindakan medis digital dengan tanda tangan elektronik dokter, pasien, atau wali sah.', 'is_featured' => false, 'order' => 11],
            ['name' => 'Surat Sehat & Surat Keterangan Sakit', 'category' => 'Administrasi', 'icon' => 'fa-file-medical', 'description' => 'Pembuatan dan pencetakan surat keterangan sakit istirahat, surat sehat bebas narkoba/buta warna, dengan format barcode verifikasi resmi.', 'is_featured' => false, 'order' => 12],
            ['name' => 'Asuhan Keperawatan (Askep)', 'category' => 'Rekam Medis', 'icon' => 'fa-user-nurse', 'description' => 'Dokumentasi asuhan keperawatan dan kebidanan mencakup diagnosa keperawatan (SDKI), intervensi (SIKI), dan evaluasi (SLKI).', 'is_featured' => false, 'order' => 13],
            ['name' => 'Laboratorium & Pemeriksaan Penunjang', 'category' => 'Penunjang', 'icon' => 'fa-vials', 'description' => 'Pencatatan rujukan internal spesimen laboratorium, input parameter uji (Darah Rutin, Gula, Kolesterol, dll.), dan pencetakan hasil uji.', 'is_featured' => false, 'order' => 14],
            ['name' => 'Sedasi & Catatan Bedah Minor', 'category' => 'Rekam Medis', 'icon' => 'fa-syringe', 'description' => 'Dokumentasi tindakan bedah minor, monitoring premedikasi, sedasi, evaluasi pra dan pasca tindakan klinis.', 'is_featured' => false, 'order' => 15],
            ['name' => 'Laporan Eksekutif & Statistik', 'category' => 'Laporan', 'icon' => 'fa-chart-pie', 'description' => 'Laporan kunjungan 10 besar penyakit (Morbiditas), tren pendapatan harian/bulanan, rasio rujukan, dan ekspor spreadsheet otomatis.', 'is_featured' => false, 'order' => 16],
            ['name' => 'Dashboard Manajemen Faskes', 'category' => 'Laporan', 'icon' => 'fa-gauge-high', 'description' => 'Tampilan statistik performa realtime: jumlah antrian aktif, tingkat hunian tempat tidur (BOR), stok obat kritis, dan status sinkronisasi SATUSEHAT.', 'is_featured' => false, 'order' => 17],
            ['name' => 'Multi-User & Hak Akses Berjenjang', 'category' => 'Keamanan', 'icon' => 'fa-users-gear', 'description' => 'Pembatasan hak akses berbasis peran (Role-Based Access Control) untuk Dokter, Bidan, Perawat, Petugas Loket, Apoteker, Kasir, dan Manajer.', 'is_featured' => false, 'order' => 18],
        ];
        foreach ($features as $feat) {
            Feature::updateOrCreate(['name' => $feat['name']], $feat);
        }

        // 7. Pricing Plans (Sesuai Proposal)
        $plans = [
            [
                'name' => 'Praktik Dokter Mandiri',
                'slug' => 'praktik-mandiri',
                'price' => 150000,
                'period' => 'bulan',
                'badge' => 'Pilihan Dokter',
                'description' => 'Ideal untuk Dokter Umum, Dokter Gigi, Dokter Spesialis, dan Bidan yang membuka praktik mandiri perorangan.',
                'features_list' => [
                    'Akses Sistem Rekam Medis Elektronik (RME)',
                    'Bridging SATUSEHAT Kemenkes RI Lengkap',
                    'Modul Rekam Medis SOAP & ICD-10 / ICD-9-CM',
                    'E-Resep & Cetak Surat Sakit / Sehat',
                    '1 Akun Dokter & 1 Akun Asisten/Perawat',
                    'Pencetakan Kartu Berobat & Antrian Standar',
                    'Free Backup Data Cloud Mingguan',
                    'Pendampingan Setup & Video Tutorial',
                ],
                'terms' => [
                    'Biaya berlangganan per bulan',
                    'Termasuk pembaruan regulasi SATUSEHAT',
                    'Koneksi internet disediakan oleh faskes',
                ],
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Klinik Pratama (Non Rawat Inap)',
                'slug' => 'klinik-pratama',
                'price' => 350000,
                'period' => 'bulan',
                'badge' => 'Paling Populer',
                'description' => 'Dirancang untuk Klinik Pratama Rawat Jalan yang membutuhkan sistem operasional terpadu multi-ruang poli dan farmasi.',
                'features_list' => [
                    'Seluruh Fitur Paket Praktik Dokter Mandiri',
                    'Bridging BPJS Kesehatan PCare & SATUSEHAT',
                    'Multi-Poli (Poli Umum, Poli Gigi, KIA/KB)',
                    'Modul Odontogram Gigi & Kartu Pasien',
                    'Manajemen Antrian dengan Panggilan Suara',
                    'Modul Apotek & Multi-Depo Stok Obat Terpadu',
                    'Modul Kasir & Billing Pembayaran Otomatis',
                    'Unlimited Akun Dokter, Perawat, dan Staf Loket',
                    'Pendampingan Teknis Langsung oleh Tim TeFa V-Kes',
                ],
                'terms' => [
                    'Biaya berlangganan bulanan terjangkau',
                    'Free training onsite/daring untuk staf klinik',
                    'Termasuk pemeliharaan sistem rutin',
                ],
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Klinik Rawat Inap & Puskesmas',
                'slug' => 'klinik-rawat-inap-puskesmas',
                'price' => 500000,
                'period' => 'bulan',
                'badge' => 'Solusi Terlengkap',
                'description' => 'Solusi enterprise lengkap untuk Klinik Rawat Inap, Klinik Utama, dan Fasilitas Puskesmas.',
                'features_list' => [
                    'Seluruh Fitur Paket Klinik Pratama',
                    'Manajemen Rawat Inap & Monitoring Kamar Bed',
                    'Catatan Perkembangan Pasien Terintegrasi (CPPT)',
                    'Asuhan Keperawatan (SDKI, SIKI, SLKI)',
                    'Modul Laboratorium & Pemeriksaan Penunjang Medis',
                    'General Consent & Informed Consent Digital TTD',
                    'Dokumentasi Tindakan Sedasi & Bedah Minor',
                    'Laporan Eksekutif, BOR, dan Morbiditas 10 Besar',
                    'Prioritas Bantuan Teknis Khusus 24/7',
                ],
                'terms' => [
                    'SLA support prioritas tinggi',
                    'Free Custom format formulir rekam medis faskes',
                    'Pendampingan akreditasi klinik dan audit data RME',
                ],
                'is_active' => true,
                'order' => 3,
            ],
        ];
        foreach ($plans as $plan) {
            PricingPlan::updateOrCreate(['slug' => $plan['slug']], $plan);
        }

        // 8. Support Services (Sesuai Proposal)
        $services = [
            [
                'title' => 'Pendampingan Klaim BPJS Kesehatan',
                'icon' => 'fa-file-invoice-dollar',
                'summary' => 'Solusi mengatasi kendala verifikasi data dan percepatan proses klaim BPJS Kesehatan faskes Anda.',
                'description' => 'Layanan pendampingan komprehensif bagi fasilitas kesehatan untuk menata alur pencatatan medis, kodifikasi diagnosa ICD-10 dan tindakan ICD-9-CM yang tepat, serta rekonsiliasi data pada aplikasi PCare BPJS. Didampingi langsung oleh pakar Manajemen Informasi Kesehatan dari TeFa V-Kes Polije agar angka pending klaim terminimalisasi.',
                'benefits' => [
                    'Audit kelengkapan resume medis dan berkas pendukung klaim',
                    'Pelatihan kodifikasi klinis sesuai standar tarif BPJS Kesehatan',
                    'Simulasi pencegahan fraud dan ketidaklengkapan berkas verifikasi',
                    'Konsultasi intensif dengan pakar rekam medis Polije',
                ],
                'is_active' => true,
                'order' => 1,
            ],
            [
                'title' => 'Pendampingan Akreditasi Klinik',
                'icon' => 'fa-award',
                'summary' => 'Persiapan instrumen Rekam Medis Elektronik dan tata kelola informasi untuk meraih akreditasi Paripurna.',
                'description' => 'TeFa V-Kes Polije membantu klinik dalam pemenuhan standar akreditasi klinik pada bab Tata Kelola Pelayanan Klinis (TKPK), Peningkatan Mutu dan Keselamatan Pasien (PMKP), serta Penyelenggaraan Rekam Medis Elektronik. Kami memfasilitasi pembuatan SOP rekam medis, tata kelola informed consent digital, keamanan data, dan pemenuhan indikator nasional mutu.',
                'benefits' => [
                    'Review dokumen regulasi internal dan SOP rekam medis faskes',
                    'Pemenuhan instrumen elemen penilaian akreditasi berbasis digital',
                    'Penerapan standar hak akses, kerahasiaan, dan keamanan data pasien',
                    'Pendampingan pra-survei dan gladi bersih akreditasi klinik',
                ],
                'is_active' => true,
                'order' => 2,
            ],
        ];
        foreach ($services as $srv) {
            SupportService::updateOrCreate(['title' => $srv['title']], $srv);
        }

        // 9. Gallery Categories & Dummy Items
        $catKegiatan = GalleryCategory::updateOrCreate(['slug' => 'dokumentasi-kegiatan'], ['name' => 'Dokumentasi Kegiatan']);
        $catFasilitas = GalleryCategory::updateOrCreate(['slug' => 'fasilitas-ruangan'], ['name' => 'Fasilitas & Ruangan']);
        $catPelatihan = GalleryCategory::updateOrCreate(['slug' => 'pelatihan-faskes'], ['name' => 'Pelatihan Faskes']);
        $catAktivitas = GalleryCategory::updateOrCreate(['slug' => 'aktivitas-tefa'], ['name' => 'Aktivitas TeFa V-Kes']);

        $galleries = [
            [
                'category_id' => $catKegiatan->id,
                'title' => 'Sosialisasi Integrasi SATUSEHAT Kemenkes',
                'description' => 'Kegiatan sosialisasi dan bimbingan teknis koneksi RME klinik ke platform SATUSEHAT.',
                'image' => 'gallery/sosialisasi-satusehat.jpg',
                'date' => '2026-08-15',
                'order' => 1,
            ],
            [
                'category_id' => $catPelatihan->id,
                'title' => 'Workshop Implementasi Rekam Medis Elektronik',
                'description' => 'Pelatihan langsung operasional RME SIP-Kes bersama dokter dan tenaga kesehatan mitra faskes.',
                'image' => 'gallery/workshop-rme.jpg',
                'date' => '2026-09-10',
                'order' => 2,
            ],
            [
                'category_id' => $catFasilitas->id,
                'title' => 'Laboratorium Smart Health TeFa V-Kes Polije',
                'description' => 'Ruang riset dan pusat data simulasi pelayanan kesehatan digital Politeknik Negeri Jember.',
                'image' => 'gallery/lab-tefa-polije.jpg',
                'date' => '2026-07-20',
                'order' => 3,
            ],
            [
                'category_id' => $catAktivitas->id,
                'title' => 'Pengujian Bridging API PCare BPJS & SATUSEHAT',
                'description' => 'Tim teknis TeFa V-Kes melakukan validasi pengiriman data encounter faskes secara realtime.',
                'image' => 'gallery/testing-api.jpg',
                'date' => '2026-10-05',
                'order' => 4,
            ],
        ];
        foreach ($galleries as $g) {
            Gallery::updateOrCreate(['title' => $g['title']], $g);
        }

        // 10. Contact Info (Sesuai Proposal)
        ContactInfo::updateOrCreate(
            ['id' => 1],
            [
                'phone' => '0813-3551-2803',
                'whatsapp' => '6281335512803',
                'email' => 'vkes@polije.ac.id',
                'instagram' => '@sipkes.co.id',
                'instagram_url' => 'https://instagram.com/sipkes.co.id',
                'address' => 'Jurusan Kesehatan, Program Studi Manajemen Informasi Kesehatan, Politeknik Negeri Jember, Jalan Mastrip 164, Jember, Jawa Timur.',
                'maps_embed' => 'https://maps.google.com/maps?q=Politeknik+Negeri+Jember&t=&z=15&ie=UTF8&iwloc=&output=embed',
            ]
        );

        // 11. Site Settings
        $settings = [
            'site_name' => 'SIP-Kes Portal',
            'site_tagline' => 'Sistem Informasi Pelayanan Kesehatan TeFa V-Kes Polije',
            'meta_description' => 'Website portal resmi SIP-Kes (Sistem Informasi Pelayanan Kesehatan), platform rekam medis elektronik (RME) terintegrasi SATUSEHAT & BPJS Kesehatan milik TeFa V-Kes Politeknik Negeri Jember.',
            'cta_title' => 'Siap Mentransformasi Tata Kelola Rekam Medis Faskes Anda?',
            'cta_subtitle' => 'Bergabunglah bersama puluhan fasilitas kesehatan yang telah terintegrasi resmi SATUSEHAT Kemenkes RI dengan pendampingan langsung dari TeFa V-Kes Polije.',
            'cta_btn_text' => 'Jadwalkan Demo & Konsultasi Gratis',
            'cta_btn_url' => '#kontak',
        ];
        foreach ($settings as $key => $val) {
            SiteSetting::set($key, $val);
        }
    }
}

