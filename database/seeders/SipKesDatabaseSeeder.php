<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
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
        Schema::disableForeignKeyConstraints();

        // 1. Akun Administrator
        Admin::updateOrCreate(
            ['email' => 'admin@sipkes.id'],
            [
                'name' => 'Administrator SIP-Kes',
                'password' => Hash::make('admin123'),
            ]
        );

        // 2. Profil Lembaga (TeFa V-Kes) & SIP-Kes (Sesuai Proposal Hal 1-4)
        Profile::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Teaching Factory Inovasi Kesehatan (TeFa V-Kes)',
                'institution' => 'Politeknik Negeri Jember',
                'tagline' => 'Sistem Informasi Pelayanan Kesehatan (SIP-Kes) - Rekam Medis Elektronik Terintegrasi SATUSEHAT & Bridging BPJS Kesehatan',
                'about_tefa' => "Teaching Factory Inovasi Kesehatan (TeFa V-Kes) merupakan unit usaha di bawah Politeknik Negeri Jember yang berfokus pada pengembangan produk kesehatan, pelatihan bidang kesehatan dan layanan kesehatan berbasis teknologi dan inovasi.\n\nDengan fokus utama pada transformasi digital pada sektor kesehatan, TeFa V-Kes menghadirkan solusi inovatif yang membantu fasilitas layanan kesehatan, tenaga medis, dan pasien untuk terhubung secara efektif melalui teknologi yang aman, andal, dan efisien.\n\nSebagai pelopor dalam pengelolaan data medis berbasis teknologi, TeFa V-Kes telah mengembangkan sistem pengelolaan rekam medis elektronik (RME) bernama SIP-Kes (Sistem Informasi Pelayanan Kesehatan) yang menerapkan interoperabilitas data kesehatan dengan SatuSehat dan dirancang dengan standar keamanan tinggi dan selaras dengan regulasi nasional maupun internasional terkait kerahasiaan data.",
                'about_sipkes' => "SIP-Kes (Sistem Informasi Pelayanan Kesehatan) adalah sebuah sistem Rekam Medis Elektronik (RME) untuk manajemen data kesehatan di Fasilitas Kesehatan Tingkat Pertama (FKTP) yang telah terintegrasi dengan platform SATUSEHAT dan bridging BPJS Kesehatan.\n\nSistem ini dibangun dengan desain modern, nyaman, dan menerapkan standar keamanan yang telah teruji, serta tentunya dapat memudahkan manajemen FKTP. Sistem ini cocok digunakan untuk puskesmas, klinik, praktik mandiri dokter, praktik perawat, dan praktik bidan.",
                'vision' => 'Menjadi pusat inovasi dan rujukan nasional dalam transformasi digital layanan kesehatan berbasis pendidikan vokasi yang aman, andal, efisien, serta terintegrasi penuh dengan standar Kementerian Kesehatan Republik Indonesia.',
                'mission' => "1. Mengembangkan produk dan sistem informasi pelayanan kesehatan (RME SIP-Kes) yang patuh regulasi Kemenkes RI, berstandar format HL7-FHIR, dan terintegrasi SATUSEHAT serta BPJS Kesehatan.\n2. Memberikan pelatihan profesional bidang kesehatan dan pendampingan implementasi RME secara gratis bagi fasilitas pelayanan kesehatan mitra.\n3. Menyediakan layanan pendampingan e-klaim BPJS dan akreditasi klinik faskes yang didampingi langsung oleh dosen ahli, praktisi kesehatan, dan tenaga terlatih.",
                'goals' => 'Membantu fasilitas pelayanan kesehatan tingkat pertama (FKTP), tenaga medis, dan pasien untuk terhubung secara efektif melalui teknologi digital yang aman, andal, dan efisien, serta mempermudah manajemen faskes menuju pelayanan paperless.',
                'background' => "Berdasarkan Peraturan Menteri Kesehatan No. 24 Tahun 2022, Fasilitas Pelayanan Kesehatan (Fasyankes) wajib menerapkan Rekam Medis Elektronik (RME) yang memenuhi standar Kementerian Kesehatan. RME harus terintegrasi dengan platform SATUSEHAT dan dapat diakses oleh Kementerian Kesehatan untuk keperluan pemantauan dan kebijakan. Hak pasien untuk mengetahui informasi kesehatannya tetap dilindungi, dengan tetap menjaga kerahasiaan dan keamanan data.\n\nOleh karena itu, TeFa V-Kes Politeknik Negeri Jember menawarkan solusi implementasi Rekam Medis Elektronik (RME) yang sesuai standar Kementerian Kesehatan Republik Indonesia. Sistem RME SIP-Kes ini telah mendukung integrasi penuh dengan platform SATUSEHAT, dapat melakukan pertukaran data kesehatan secara real-time dan aman serta memenuhi regulasi nasional yang berlaku. Selain itu, SIP-Kes ini juga dapat digunakan untuk bridging dengan BPJS Kesehatan.",
            ]
        );

        // 3. Hero Banner (Sesuai Proposal Hal 1 & 4)
        Banner::updateOrCreate(
            ['id' => 1],
            [
                'badge' => '🏥 Proposal SIP-Kes • TeFa V-Kes Politeknik Negeri Jember',
                'title' => 'Sistem Informasi Pelayanan Kesehatan (SIP-Kes)',
                'subtitle' => 'Sebuah sistem rekam medis elektronik untuk manajemen data kesehatan di fasilitas pelayanan kesehatan tingkat pertama yang telah terintegrasi dengan SATUSEHAT dan bridging BPJS Kesehatan.',
                'primary_btn_text' => 'Lihat 20 Fitur Lengkap',
                'primary_btn_url' => '#fitur',
                'secondary_btn_text' => 'Hubungi Call Center',
                'secondary_btn_url' => '#kontak',
                'is_active' => true,
                'order' => 1,
            ]
        );

        // 4. Keunggulan: Mengapa Memilih SIP-Kes? (Sesuai Proposal Hal 11)
        Advantage::truncate();
        $advantages = [
            [
                'title' => 'Terintegrasi BPJS Kesehatan',
                'icon' => 'fa-hospital-user',
                'description' => 'SIP-Kes dapat digunakan untuk bridging dengan BPJS Kesehatan guna mempermudah verifikasi keaktifan kartu kepesertaan, proses pendaftaran antrian, hingga administrasi klaim pelayanan faskes.',
                'order' => 1,
            ],
            [
                'title' => 'Terintegrasi SATUSEHAT',
                'icon' => 'fa-shield-halved',
                'description' => 'Mendukung integrasi penuh dengan platform SATUSEHAT Kemenkes RI, dapat melakukan pertukaran data kesehatan secara real-time dan aman serta memenuhi regulasi PMK No. 24 Tahun 2022.',
                'order' => 2,
            ],
            [
                'title' => 'Berbasis Website',
                'icon' => 'fa-globe',
                'description' => 'Dapat diakses dari manapun dan kapanpun secara fleksibel melalui peramban web modern tanpa memerlukan investasi server fisik lokal yang rumit dan mahal.',
                'order' => 3,
            ],
            [
                'title' => 'Free Training',
                'icon' => 'fa-chalkboard-user',
                'description' => 'Gratis pelatihan penggunaan untuk fasyankes yang berlangganan hingga seluruh tenaga medis (dokter, perawat, bidan) dan staf (loket, farmasi, kasir) mahir mengoperasikannya.',
                'order' => 4,
            ],
            [
                'title' => 'Free Custom RME',
                'icon' => 'fa-screwdriver-wrench',
                'description' => 'Bebas biaya custom RME untuk menyesuaikan kebutuhan spesifik fasyankes, mulai dari formulir asesmen, lembar tindakan, hingga tata kelola resep.',
                'order' => 5,
            ],
            [
                'title' => 'Data Tersentralisasi',
                'icon' => 'fa-database',
                'description' => 'Server terpusat, sehingga fasyankes tidak perlu memikirkan pemeliharaan sistem, manajemen backup mandiri, maupun risiko kerusakan server fisik.',
                'order' => 6,
            ],
        ];
        foreach ($advantages as $adv) {
            Advantage::create($adv);
        }

        // 5. Fasilitas Kesehatan yang Cocok (Sesuai Proposal Hal 4)
        TargetFacility::truncate();
        $facilities = [
            [
                'name' => 'Puskesmas',
                'icon' => 'fa-hospital',
                'description' => 'Puskesmas dengan layanan rawat jalan maupun rawat inap yang membutuhkan pencatatan RME terintegrasi SATUSEHAT dan pelaporan morbiditas 20 besar penyakit.',
                'order' => 1,
            ],
            [
                'name' => 'Klinik',
                'icon' => 'fa-clinic-medical',
                'description' => 'Klinik Pratama maupun Rawat Inap dengan alur loket pendaftaran, antrian suara, berbagai poli tujuan (KIA, Gigi, UGD), farmasi, kasir, dan bridging BPJS.',
                'order' => 2,
            ],
            [
                'name' => 'Praktik Mandiri Dokter',
                'icon' => 'fa-user-doctor',
                'description' => 'Praktik mandiri dokter umum dan spesialis untuk pencatatan rekam medis SOAP, riwayat alergi, kode diagnosa ICD-10, tindakan, dan e-resep praktis.',
                'order' => 3,
            ],
            [
                'name' => 'Praktik Perawat',
                'icon' => 'fa-user-nurse',
                'description' => 'Praktik mandiri perawat yang memerlukan dokumentasi asuhan keperawatan terstandar, catatan tindakan medis harian, dan pemantauan kondisi pasien.',
                'order' => 4,
            ],
            [
                'name' => 'Praktik Bidan',
                'icon' => 'fa-person-breastfeeding',
                'description' => 'Praktik mandiri bidan untuk pelayanan kesehatan ibu dan anak (KIA), program KB, imunisasi balita, serta dokumentasi asuhan kebidanan lengkap.',
                'order' => 5,
            ],
        ];
        foreach ($facilities as $fac) {
            TargetFacility::create($fac);
        }

        // 6. 20 Fitur Lengkap SIP-Kes (Sesuai Proposal Hal 6-10)
        Feature::truncate();
        $features = [
            [
                'name' => 'Pendaftaran',
                'category' => 'Pelayanan',
                'icon' => 'fa-id-card',
                'description' => 'Fitur ini berfungsi untuk melakukan proses pencatatan pasien baru maupun pasien lama. Petugas pendaftaran dapat menginput data identitas pasien, menentukan pilihan poli tujuan, serta dapat mengidentifikasi keaktifan kartu BPJS Kesehatan pasien.',
                'is_featured' => true,
                'order' => 1,
            ],
            [
                'name' => 'Antrian dan Panggilan Suara',
                'category' => 'Pelayanan',
                'icon' => 'fa-bullhorn',
                'description' => 'Fitur Antrian ini dapat digunakan untuk ditampilkan pada layar monitor. Fitur antrian ini memungkinkan melakukan panggilan otomatis melalui audio panggilan sesuai dengan nomor antrian dan tujuan kliniknya.',
                'is_featured' => true,
                'order' => 2,
            ],
            [
                'name' => 'Pemeriksaan (SO)',
                'category' => 'Rekam Medis',
                'icon' => 'fa-stethoscope',
                'description' => "Fitur ini untuk pengisian data pemeriksaan pada area:\n• S (Subject): untuk mengisi keluhan, anamnesis, riwayat penyakit keluarga, riwayat alergi, dan lain-lain.\n• O (Object): untuk mengisi pemeriksaan fisik seperti tinggi badan, berat badan, tensi darah, dan lain-lain.",
                'is_featured' => true,
                'order' => 3,
            ],
            [
                'name' => 'Diagnosa dan Tindakan (AP)',
                'category' => 'Rekam Medis',
                'icon' => 'fa-notes-medical',
                'description' => "Fitur ini untuk pengisian hasil diagnosis dan tindakan untuk pasien, yang disebut sebagai:\n• A (Assessment): untuk mengisi prognosis & diagnosis yang sudah terintegrasi dengan kode ICD-10.\n• P (Plan): untuk mengisi tindakan berupa obat yang terintegrasi dengan bagian farmasi, injeksi, atau berupa alat kesehatan.",
                'is_featured' => true,
                'order' => 4,
            ],
            [
                'name' => 'Farmasi',
                'category' => 'Farmasi',
                'icon' => 'fa-pills',
                'description' => 'Fitur ini untuk pencatatan data obat dari penerimaan obat, ketersediaan stok obat, stock opname obat, data obat yang kadaluarsa, pengeluaran obat, mutasi obat, hingga pengaturan harga obat. Fitur farmasi ini terintegrasi dengan proses tindakan pemberian obat yang dilakukan pada fitur AP.',
                'is_featured' => true,
                'order' => 5,
            ],
            [
                'name' => 'Kasir',
                'category' => 'Keuangan',
                'icon' => 'fa-cash-register',
                'description' => 'Fitur ini merupakan titik akhir dari pelayanan kesehatan, yaitu pembayaran. Fitur ini terintegrasi dengan isian diagnosis, tindakan, dan obat yang diberikan kepada pasien. Petugas kasir dapat menambahkan item-item biaya lain yang belum terakomodir pada proses pemeriksaan sampai tindakan.',
                'is_featured' => true,
                'order' => 6,
            ],
            [
                'name' => 'Rawat Inap',
                'category' => 'Pelayanan',
                'icon' => 'fa-bed-pulse',
                'description' => 'Fitur Rawat Inap membantu fasilitas kesehatan dalam mengelola pasien yang menjalani perawatan inap secara efisien. Sistem ini mencatat detail pasien masuk, penempatan kamar atau tempat tidur, SOAP, asuhan keperawatan, serta pemantauan tindakan medis harian selama pasien dirawat.',
                'is_featured' => true,
                'order' => 7,
            ],
            [
                'name' => 'Laporan',
                'category' => 'Laporan',
                'icon' => 'fa-chart-pie',
                'description' => 'Fitur Laporan menyajikan data pelayanan kesehatan dalam bentuk yang mudah dibaca dan diakses secara real-time. Laporan mencakup berbagai aspek operasional, mulai dari jumlah kunjungan pasien, layanan yang diberikan, pemakaian obat, 20 besar penyakit, hingga pendapatan dalam periode waktu yang dapat disesuaikan.',
                'is_featured' => true,
                'order' => 8,
            ],
            [
                'name' => 'Dashboard',
                'category' => 'Laporan',
                'icon' => 'fa-gauge-high',
                'description' => 'Menyajikan dashboard visual interaktif yang menampilkan grafik perbandingan kunjungan pasien harian/bulanan, tren pendapatan klinik, serta monitoring data antrian dan layanan faskes secara real-time.',
                'is_featured' => false,
                'order' => 9,
            ],
            [
                'name' => 'Cetak Kartu Berobat',
                'category' => 'Pelayanan',
                'icon' => 'fa-address-card',
                'description' => 'Fasilitas pencetakan kartu berobat fisik maupun digital bagi pasien baru dan lama yang memuat identitas lengkap dan barcode nomor rekam medis untuk mempercepat pendaftaran berulang.',
                'is_featured' => false,
                'order' => 10,
            ],
            [
                'name' => 'Verifikasi dengan SatuSehat Mobile',
                'category' => 'Integrasi',
                'icon' => 'fa-mobile-screen-button',
                'description' => 'Fitur verifikasi identitas dan keaktifan profil kesehatan pasien secara langsung yang terkoneksi dengan aplikasi SATUSEHAT Mobile Kementerian Kesehatan RI.',
                'is_featured' => false,
                'order' => 11,
            ],
            [
                'name' => 'Asuhan Keperawatan',
                'category' => 'Rekam Medis',
                'icon' => 'fa-user-nurse',
                'description' => 'Dokumentasi asuhan keperawatan lengkap mulai dari asesmen dan pengkajian awal, perumusan diagnosa keperawatan terstandar, perencanaan intervensi, tindakan klinis keperawatan, hingga lembar evaluasi harian.',
                'is_featured' => false,
                'order' => 12,
            ],
            [
                'name' => 'Pengaturan Integrasi SatuSehat dan BPJS Kesehatan',
                'category' => 'Integrasi',
                'icon' => 'fa-network-wired',
                'description' => 'Pusat konfigurasi mandiri untuk menghubungkan API bridging SATUSEHAT Kemenkes RI (Organization ID, Client ID, Secret Key) serta integrasi BPJS Kesehatan dengan pemantauan status koneksi secara langsung.',
                'is_featured' => false,
                'order' => 13,
            ],
            [
                'name' => 'Odontogram pada Klinik Gigi',
                'category' => 'Rekam Medis',
                'icon' => 'fa-tooth',
                'description' => 'Diagram odontogram gigi visual interaktif untuk dokter gigi dan perawat gigi dalam mencatat kondisi klinis gigi geligi, karies, restorasi/tambalan, pencabutan, dan rencana perawatan gigi.',
                'is_featured' => false,
                'order' => 14,
            ],
            [
                'name' => 'General Consent',
                'category' => 'Legalitas',
                'icon' => 'fa-file-signature',
                'description' => 'Persetujuan umum (General Consent) dari pasien atau penanggung jawab keluarga yang terdokumentasi dan diarsipkan secara elektronik sesuai standar rekam medis dan hukum kesehatan.',
                'is_featured' => false,
                'order' => 15,
            ],
            [
                'name' => 'Informed Consent',
                'category' => 'Legalitas',
                'icon' => 'fa-file-contract',
                'description' => 'Formulir persetujuan tindakan medis kedokteran khusus setelah penjelasan risiko dan indikasi, dilengkapi dokumentasi persetujuan digital pasien atau wali serta tanda tangan dokter penanggung jawab.',
                'is_featured' => false,
                'order' => 16,
            ],
            [
                'name' => 'Surat Sehat & Surat Sakit',
                'category' => 'Administrasi',
                'icon' => 'fa-file-medical',
                'description' => 'Modul penerbitan dan pencetakan surat keterangan sehat, surat keterangan sakit istirahat dokter, dan surat rujukan resmi dengan format terstandar dan barcode verifikasi.',
                'is_featured' => false,
                'order' => 17,
            ],
            [
                'name' => 'Laboratorium',
                'category' => 'Penunjang',
                'icon' => 'fa-flask-vial',
                'description' => 'Pencatatan permintaan pemeriksaan laboratorium klinik penunjang, input hasil pengujian parameter darah/urine dan spesimen medis lainnya, hingga pencetakan lembar hasil laboratorium.',
                'is_featured' => false,
                'order' => 18,
            ],
            [
                'name' => 'Sedasi',
                'category' => 'Rekam Medis',
                'icon' => 'fa-syringe',
                'description' => 'Pencatatan pemantauan status sedasi dan anestesi pra, intra, dan pasca tindakan prosedur bedah minor atau tindakan klinis sesuai pedoman keselamatan pasien.',
                'is_featured' => false,
                'order' => 19,
            ],
            [
                'name' => 'Dan lain-lain',
                'category' => 'Pelayanan',
                'icon' => 'fa-ellipsis',
                'description' => 'Berbagai fitur dan modul penunjang operasional fasilitas pelayanan kesehatan lainnya yang senantiasa diperbarui mengikuti kebutuhan operasional mitra faskes dan regulasi terkini.',
                'is_featured' => false,
                'order' => 20,
            ],
        ];
        $featureDetails = require database_path('data/feature_details.php');
        foreach ($features as $feat) {
            foreach (($featureDetails[$feat['name']] ?? []) as $key => $lines) {
                $feat[$key] = implode("\n", $lines);
            }
            Feature::create($feat);
        }

        // 7. Daftar Harga SIP-Kes: 3 Pilihan Paket (Sesuai Proposal Hal 12)
        PricingPlan::truncate();
        $plans = [
            [
                'name' => 'PRAKTIK DOKTER MANDIRI',
                'slug' => 'praktik-dokter-mandiri',
                'price' => 150000,
                'period' => 'bulan',
                'badge' => 'Praktik Dokter Mandiri',
                'description' => 'Ideal untuk praktik dokter perorangan (umum maupun spesialis), praktik perawat, dan praktik mandiri bidan.',
                'features_list' => [
                    'Minimal kontrak 1 tahun.',
                    'Full support untuk integrasi BPJS Kesehatan dan SatuSehat.',
                    'Akses ke fitur-fitur praktik dokter mandiri: pendaftaran pasien lama & pasien baru, antrian, pemeriksaan, farmasi, kasir.',
                    'Free biaya custom RME',
                ],
                'terms' => [
                    'Minimal kontrak 1 tahun',
                    'Full support untuk integrasi BPJS Kesehatan dan SatuSehat',
                    'Free biaya custom RME',
                ],
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'KLINIK PRATAMA (Non Rawat Inap)',
                'slug' => 'klinik-pratama-non-rawat-inap',
                'price' => 350000,
                'period' => 'bulan',
                'badge' => 'Klinik Pratama',
                'description' => 'Dirancang khusus untuk Klinik Pratama Rawat Jalan yang membutuhkan sistem operasional multi-poli, APM, dan antrian suara terpadu.',
                'features_list' => [
                    'Minimal kontrak 1 tahun.',
                    'Full support untuk integrasi BPJS Kesehatan dan SatuSehat.',
                    'Akses ke fitur-fitur klinik pratama, seperti: pendaftaran pasien lama & pasien baru, antrian, APM, pemeriksaan, manajemen poli (KIA, Gigi, Laboratorium, UGD, dan lain-lain kecuali rawat inap), farmasi, kasir, manajemen pegawai.',
                    'Free biaya custom RME',
                    'Free biaya update fitur',
                ],
                'terms' => [
                    'Minimal kontrak 1 tahun',
                    'Full support untuk integrasi BPJS Kesehatan dan SatuSehat',
                    'Free biaya custom RME',
                    'Free biaya update fitur',
                ],
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'KLINIK RAWAT INAP & PUSKESMAS',
                'slug' => 'klinik-rawat-inap-puskesmas',
                'price' => 500000,
                'period' => 'bulan',
                'badge' => 'Klinik Rawat Inap & Puskesmas',
                'description' => 'Paket terlengkap untuk Klinik Rawat Inap dan Puskesmas dengan jumlah pasien dan kunjungan tanpa batas (unlimited).',
                'features_list' => [
                    'Minimal kontrak 1 tahun.',
                    'Full support untuk integrasi BPJS Kesehatan dan SatuSehat.',
                    'Akses ke fitur-fitur klinik rawat inap, seperti: pendaftaran pasien lama & pasien baru, antrian, APM, pemeriksaan, manajemen poli (KIA, Gigi, Laboratorium, UGD, rawat inap, dan lain-lain), farmasi, kasir, manajemen pegawai, kartu berobat, dan lain-lain.',
                    'Unlimited jumlah pasien dan kunjungan.',
                    'Free biaya custom RME',
                    'Free biaya update fitur',
                ],
                'terms' => [
                    'Minimal kontrak 1 tahun',
                    'Full support untuk integrasi BPJS Kesehatan dan SatuSehat',
                    'Unlimited jumlah pasien dan kunjungan',
                    'Free biaya custom RME',
                    'Free biaya update fitur',
                ],
                'is_active' => true,
                'order' => 3,
            ],
        ];
        foreach ($plans as $plan) {
            PricingPlan::create($plan);
        }

        // 8. Layanan Pendukung Lainnya (Sesuai Proposal Hal 13)
        SupportService::truncate();
        $services = [
            [
                'title' => 'Pendampingan Klaim BPJS',
                'icon' => 'fa-file-invoice-dollar',
                'summary' => 'Pendampingan berupa bimbingan input data sesuai kebutuhan e-klaim BPJS, penyesuaian data SEP & INA-CBG, serta konsultasi kendala teknis selama proses klaim.',
                'description' => "Pendampingan ini berupa bimbingan input data sesuai kebutuhan e-klaim BPJS, penyesuaian data SEP & INA-CBG, konsultasi kendala teknis selama proses klaim.\n\nKeunggulan Layanan Pendukung SIP-Kes:\n• Didampingi oleh tim profesional dari TEFA V-Kes POLIJE.\n• Melibatkan dosen ahli, praktisi kesehatan, dan mahasiswa terlatih.\n• Berbasis problem-solving dan continuous improvement.",
                'benefits' => [
                    'Bimbingan input data sesuai kebutuhan e-klaim BPJS',
                    'Penyesuaian data SEP & INA-CBG',
                    'Konsultasi kendala teknis selama proses klaim',
                    'Didampingi oleh tim profesional dari TEFA V-Kes POLIJE',
                    'Melibatkan dosen ahli, praktisi kesehatan, dan mahasiswa terlatih',
                    'Berbasis problem-solving dan continuous improvement',
                ],
                'is_active' => true,
                'order' => 1,
            ],
            [
                'title' => 'Pendampingan Akreditasi Klinik',
                'icon' => 'fa-award',
                'summary' => 'Pendampingan berupa penyusunan dokumen elektronik sesuai standar akreditasi Kemenkes, penyediaan data rekam medis, laporan kegiatan, dan log pelayanan, simulasi audit digital dan pendampingan tim surveyor.',
                'description' => "Pendampingan ini berupa penyusunan dokumen elektronik sesuai standar akreditasi Kemenkes, penyediaan data rekam medis, laporan kegiatan, dan log pelayanan, simulasi audit digital dan pendampingan tim surveyor.\n\nKeunggulan Layanan Pendukung SIP-Kes:\n• Didampingi oleh tim profesional dari TEFA V-Kes POLIJE.\n• Melibatkan dosen ahli, praktisi kesehatan, dan mahasiswa terlatih.\n• Berbasis problem-solving dan continuous improvement.",
                'benefits' => [
                    'Penyusunan dokumen elektronik sesuai standar akreditasi Kemenkes',
                    'Penyediaan data rekam medis, laporan kegiatan, dan log pelayanan',
                    'Simulasi audit digital dan gladi akreditasi',
                    'Pendampingan langsung saat tim surveyor melakukan visitasi',
                    'Didampingi oleh tim profesional dari TEFA V-Kes POLIJE',
                    'Melibatkan dosen ahli, praktisi kesehatan, dan mahasiswa terlatih',
                    'Berbasis problem-solving dan continuous improvement',
                ],
                'is_active' => true,
                'order' => 2,
            ],
        ];
        foreach ($services as $srv) {
            SupportService::create($srv);
        }

        // 9. Berita Kegiatan & Fasilitas TeFa V-Kes (tabel galleries) (Sesuai Proposal Hal 2, 3, 10, 14)
        GalleryCategory::truncate();
        Gallery::truncate();

        $catKegiatan = GalleryCategory::create(['name' => 'Dokumentasi Pelayanan & Implementasi', 'slug' => 'pelayanan-implementasi']);
        $catFasilitas = GalleryCategory::create(['name' => 'Gedung & Fasilitas TeFa V-Kes', 'slug' => 'gedung-fasilitas']);
        $catPelatihan = GalleryCategory::create(['name' => 'Pelatihan & Pendampingan Faskes', 'slug' => 'pelatihan-pendampingan']);

        $galleries = [
            [
                'category_id' => $catKegiatan->id,
                'title' => 'Implementasi RME SIP-Kes di Loket Pendaftaran Fasyankes',
                'description' => 'Pelayanan pendaftaran pasien dan identifikasi keaktifan BPJS menggunakan SIP-Kes di fasilitas kesehatan mitra.',
                'image' => 'gallery/pendaftaran-pasien-rme.jpg',
                'date' => '2026-08-10',
                'order' => 1,
            ],
            [
                'category_id' => $catFasilitas->id,
                'title' => 'Gedung Teaching Factory Inovasi Kesehatan (TeFa V-Kes)',
                'description' => 'Gedung unit usaha dan pusat riset rekam medis terpadu Politeknik Negeri Jember, Jalan Mastrip 164 Jember.',
                'image' => 'gallery/gedung-tefa-vkes.jpg',
                'date' => '2026-07-15',
                'order' => 2,
            ],
            [
                'category_id' => $catKegiatan->id,
                'title' => 'Pelayanan Pemeriksaan Medis Terintegrasi RME',
                'description' => 'Tenaga medis mengisi pemeriksaan klinis SOAP dan asesmen diagnosis ICD-10 secara langsung melalui SIP-Kes.',
                'image' => 'gallery/pelayanan-medis-pasien.jpg',
                'date' => '2026-09-02',
                'order' => 3,
            ],
            [
                'category_id' => $catPelatihan->id,
                'title' => 'Bimbingan Teknis & Pelatihan Penggunaan RME SIP-Kes',
                'description' => 'Pelatihan gratis pengoperasian sistem bagi dokter, perawat, apoteker, dan petugas fasyankes.',
                'image' => 'gallery/pelatihan-fasyankes.jpg',
                'date' => '2026-10-18',
                'order' => 4,
            ],
        ];
        $newsContents = require database_path('data/news_contents.php');
        foreach ($galleries as $g) {
            Gallery::create(array_merge($g, $newsContents[$g['title']] ?? []));
        }

        // 10. Informasi Kontak Sekretariat (Sesuai Proposal Hal 1, 2, 14)
        ContactInfo::truncate();
        ContactInfo::create([
            'phone' => '0813-3551-2803',
            'whatsapp' => '6281335512803',
            'email' => 'vkes@polije.ac.id',
            'instagram' => '@sipkes.co.id',
            'instagram_url' => 'https://instagram.com/sipkes.co.id',
            'address' => 'Jurusan Kesehatan, Program Studi Manajemen Informasi Kesehatan, Politeknik Negeri Jember, Jalan Mastrip 164 Jember',
            'maps_embed' => 'https://maps.google.com/maps?q=Politeknik+Negeri+Jember&t=&z=15&ie=UTF8&iwloc=&output=embed',
        ]);

        // 11. Pengaturan Situs (Site Settings)
        $settings = [
            'site_name' => 'SIP-Kes',
            'site_tagline' => 'Sistem Informasi Pelayanan Kesehatan - TeFa V-Kes Politeknik Negeri Jember',
            'meta_description' => 'Sebuah sistem rekam medis elektronik untuk manajemen data kesehatan di fasilitas pelayanan kesehatan tingkat pertama yang telah terintegrasi dengan SATUSEHAT dan bridging BPJS Kesehatan.',
            'phone' => '0813-3551-2803',
            'email' => 'vkes@polije.ac.id',
            'website' => 'www.sipkes.co.id',
            'instagram' => '@sipkes.co.id',
            'address' => 'Jurusan Kesehatan, Program Studi Manajemen Informasi Kesehatan, Politeknik Negeri Jember, Jalan Mastrip 164 Jember',
            'cta_title' => 'Siap Menerapkan Rekam Medis Elektronik Terintegrasi SATUSEHAT & BPJS?',
            'cta_subtitle' => 'Demikian penawaran ini kami buat, kami sangat terbuka untuk mendiskusikan terkait penawaran ini. Silakan menghubungi kami melalui call center kami.',
            'cta_btn_text' => 'Hubungi Call Center Kami',
            'cta_btn_url' => '#kontak',
        ];
        foreach ($settings as $key => $val) {
            SiteSetting::set($key, $val);
        }

        Schema::enableForeignKeyConstraints();
    }
}
