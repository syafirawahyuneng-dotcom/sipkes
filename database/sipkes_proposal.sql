-- ========================================================
-- DATABASE DUMP: sip_kes
-- Target RDBMS: MySQL 5.7+ / MariaDB 10.3+
-- Generated for Portal SIP-Kes TeFa Inovasi Kesehatan Polije
-- ========================================================

CREATE DATABASE IF NOT EXISTS `sip_kes` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `sip_kes`;

SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES (1, 'Administrator SIP-Kes', 'admin@sipkes.id', '$2y$12$LtBR3s1D3SH6PRUyTCCgQuf9hNJn1Sj4jLGVllPavv.SdywfnPXG6', NOW(), NOW());

-- ----------------------------
-- Table structure for profiles
-- ----------------------------
DROP TABLE IF EXISTS `profiles`;
CREATE TABLE `profiles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `institution` varchar(255) NOT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `about_tefa` text DEFAULT NULL,
  `about_sipkes` text DEFAULT NULL,
  `vision` text DEFAULT NULL,
  `mission` text DEFAULT NULL,
  `goals` text DEFAULT NULL,
  `background` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `profiles` (`id`, `name`, `institution`, `tagline`, `about_tefa`, `about_sipkes`, `vision`, `mission`, `goals`, `background`, `created_at`, `updated_at`) VALUES (1, 'Teaching Factory Inovasi Kesehatan (TeFa V-Kes)', 'Politeknik Negeri Jember', 'Sistem Informasi Pelayanan Kesehatan (SIP-Kes) - Rekam Medis Elektronik Terintegrasi SATUSEHAT & Bridging BPJS Kesehatan', 'Teaching Factory Inovasi Kesehatan (TeFa V-Kes) merupakan unit usaha di bawah Politeknik Negeri Jember yang berfokus pada pengembangan produk kesehatan, pelatihan bidang kesehatan dan layanan kesehatan berbasis teknologi dan inovasi.\n\nDengan fokus utama pada transformasi digital pada sektor kesehatan, TeFa V-Kes menghadirkan solusi inovatif yang membantu fasilitas layanan kesehatan, tenaga medis, dan pasien untuk terhubung secara efektif melalui teknologi yang aman, andal, dan efisien.\n\nSebagai pelopor dalam pengelolaan data medis berbasis teknologi, TeFa V-Kes telah mengembangkan sistem pengelolaan rekam medis elektronik (RME) bernama SIP-Kes (Sistem Informasi Pelayanan Kesehatan) yang menerapkan interoperabilitas data kesehatan dengan SatuSehat dan dirancang dengan standar keamanan tinggi dan selaras dengan regulasi nasional maupun internasional terkait kerahasiaan data.', 'SIP-Kes (Sistem Informasi Pelayanan Kesehatan) adalah sebuah sistem Rekam Medis Elektronik (RME) untuk manajemen data kesehatan di Fasilitas Kesehatan Tingkat Pertama (FKTP) yang telah terintegrasi dengan platform SATUSEHAT dan bridging BPJS Kesehatan.\n\nSistem ini dibangun dengan desain modern, nyaman, dan menerapkan standar keamanan yang telah teruji, serta tentunya dapat memudahkan manajemen FKTP. Sistem ini cocok digunakan untuk puskesmas, klinik, praktik mandiri dokter, praktik perawat, dan praktik bidan.', 'Menjadi pusat inovasi dan rujukan nasional dalam transformasi digital layanan kesehatan berbasis pendidikan vokasi yang aman, andal, efisien, serta terintegrasi penuh dengan standar Kementerian Kesehatan Republik Indonesia.', '1. Mengembangkan produk dan sistem informasi pelayanan kesehatan (RME SIP-Kes) yang patuh regulasi Kemenkes RI, berstandar format HL7-FHIR, dan terintegrasi SATUSEHAT serta BPJS Kesehatan.\n2. Memberikan pelatihan profesional bidang kesehatan dan pendampingan implementasi RME secara gratis bagi fasilitas pelayanan kesehatan mitra.\n3. Menyediakan layanan pendampingan e-klaim BPJS dan akreditasi klinik faskes yang didampingi langsung oleh dosen ahli, praktisi kesehatan, dan tenaga terlatih.', 'Membantu fasilitas pelayanan kesehatan tingkat pertama (FKTP), tenaga medis, dan pasien untuk terhubung secara efektif melalui teknologi digital yang aman, andal, dan efisien, serta mempermudah manajemen faskes menuju pelayanan paperless.', 'Berdasarkan Peraturan Menteri Kesehatan No. 24 Tahun 2022, Fasilitas Pelayanan Kesehatan (Fasyankes) wajib menerapkan Rekam Medis Elektronik (RME) yang memenuhi standar Kementerian Kesehatan. RME harus terintegrasi dengan platform SATUSEHAT dan dapat diakses oleh Kementerian Kesehatan untuk keperluan pemantauan dan kebijakan. Hak pasien untuk mengetahui informasi kesehatannya tetap dilindungi, dengan tetap menjaga kerahasiaan dan keamanan data.\n\nOleh karena itu, TeFa V-Kes Politeknik Negeri Jember menawarkan solusi implementasi Rekam Medis Elektronik (RME) yang sesuai standar Kementerian Kesehatan Republik Indonesia. Sistem RME SIP-Kes ini telah mendukung integrasi penuh dengan platform SATUSEHAT, dapat melakukan pertukaran data kesehatan secara real-time dan aman serta memenuhi regulasi nasional yang berlaku. Selain itu, SIP-Kes ini juga dapat digunakan untuk bridging dengan BPJS Kesehatan.', NOW(), NOW());

-- ----------------------------
-- Table structure for features
-- ----------------------------
DROP TABLE IF EXISTS `features`;
CREATE TABLE `features` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `description` text NOT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `features` (`id`, `name`, `category`, `icon`, `description`, `is_featured`, `order`, `created_at`, `updated_at`) VALUES (1, 'Pendaftaran', 'Pelayanan', 'fa-id-card', 'Fitur ini berfungsi untuk melakukan proses pencatatan pasien baru maupun pasien lama. Petugas pendaftaran dapat menginput data identitas pasien, menentukan pilihan poli tujuan, serta dapat mengidentifikasi keaktifan kartu BPJS Kesehatan pasien.', 1, 1, NOW(), NOW());
INSERT INTO `features` (`id`, `name`, `category`, `icon`, `description`, `is_featured`, `order`, `created_at`, `updated_at`) VALUES (2, 'Antrian dan Panggilan Suara', 'Pelayanan', 'fa-bullhorn', 'Fitur Antrian ini dapat digunakan untuk ditampilkan pada layar monitor. Fitur antrian ini memungkinkan melakukan panggilan otomatis melalui audio panggilan sesuai dengan nomor antrian dan tujuan kliniknya.', 1, 2, NOW(), NOW());
INSERT INTO `features` (`id`, `name`, `category`, `icon`, `description`, `is_featured`, `order`, `created_at`, `updated_at`) VALUES (3, 'Pemeriksaan (SO)', 'Rekam Medis', 'fa-stethoscope', 'Fitur ini untuk pengisian data pemeriksaan pada area:\n• S (Subject): untuk mengisi keluhan, anamnesis, riwayat penyakit keluarga, riwayat alergi, dan lain-lain.\n• O (Object): untuk mengisi pemeriksaan fisik seperti tinggi badan, berat badan, tensi darah, dan lain-lain.', 1, 3, NOW(), NOW());
INSERT INTO `features` (`id`, `name`, `category`, `icon`, `description`, `is_featured`, `order`, `created_at`, `updated_at`) VALUES (4, 'Diagnosa dan Tindakan (AP)', 'Rekam Medis', 'fa-notes-medical', 'Fitur ini untuk pengisian hasil diagnosis dan tindakan untuk pasien, yang disebut sebagai:\n• A (Assessment): untuk mengisi prognosis & diagnosis yang sudah terintegrasi dengan kode ICD-10.\n• P (Plan): untuk mengisi tindakan berupa obat yang terintegrasi dengan bagian farmasi, injeksi, atau berupa alat kesehatan.', 1, 4, NOW(), NOW());
INSERT INTO `features` (`id`, `name`, `category`, `icon`, `description`, `is_featured`, `order`, `created_at`, `updated_at`) VALUES (5, 'Farmasi', 'Farmasi', 'fa-pills', 'Fitur ini untuk pencatatan data obat dari penerimaan obat, ketersediaan stok obat, stock opname obat, data obat yang kadaluarsa, pengeluaran obat, mutasi obat, hingga pengaturan harga obat. Fitur farmasi ini terintegrasi dengan proses tindakan pemberian obat yang dilakukan pada fitur AP.', 1, 5, NOW(), NOW());
INSERT INTO `features` (`id`, `name`, `category`, `icon`, `description`, `is_featured`, `order`, `created_at`, `updated_at`) VALUES (6, 'Kasir', 'Keuangan', 'fa-cash-register', 'Fitur ini merupakan titik akhir dari pelayanan kesehatan, yaitu pembayaran. Fitur ini terintegrasi dengan isian diagnosis, tindakan, dan obat yang diberikan kepada pasien. Petugas kasir dapat menambahkan item-item biaya lain yang belum terakomodir pada proses pemeriksaan sampai tindakan.', 1, 6, NOW(), NOW());
INSERT INTO `features` (`id`, `name`, `category`, `icon`, `description`, `is_featured`, `order`, `created_at`, `updated_at`) VALUES (7, 'Rawat Inap', 'Pelayanan', 'fa-bed-pulse', 'Fitur Rawat Inap membantu fasilitas kesehatan dalam mengelola pasien yang menjalani perawatan inap secara efisien. Sistem ini mencatat detail pasien masuk, penempatan kamar atau tempat tidur, SOAP, asuhan keperawatan, serta pemantauan tindakan medis harian selama pasien dirawat.', 1, 7, NOW(), NOW());
INSERT INTO `features` (`id`, `name`, `category`, `icon`, `description`, `is_featured`, `order`, `created_at`, `updated_at`) VALUES (8, 'Laporan', 'Laporan', 'fa-chart-pie', 'Fitur Laporan menyajikan data pelayanan kesehatan dalam bentuk yang mudah dibaca dan diakses secara real-time. Laporan mencakup berbagai aspek operasional, mulai dari jumlah kunjungan pasien, layanan yang diberikan, pemakaian obat, 20 besar penyakit, hingga pendapatan dalam periode waktu yang dapat disesuaikan.', 1, 8, NOW(), NOW());
INSERT INTO `features` (`id`, `name`, `category`, `icon`, `description`, `is_featured`, `order`, `created_at`, `updated_at`) VALUES (9, 'Dashboard', 'Laporan', 'fa-gauge-high', 'Menyajikan dashboard visual interaktif yang menampilkan grafik perbandingan kunjungan pasien harian/bulanan, tren pendapatan klinik, serta monitoring data antrian dan layanan faskes secara real-time.', 0, 9, NOW(), NOW());
INSERT INTO `features` (`id`, `name`, `category`, `icon`, `description`, `is_featured`, `order`, `created_at`, `updated_at`) VALUES (10, 'Cetak Kartu Berobat', 'Pelayanan', 'fa-address-card', 'Fasilitas pencetakan kartu berobat fisik maupun digital bagi pasien baru dan lama yang memuat identitas lengkap dan barcode nomor rekam medis untuk mempercepat pendaftaran berulang.', 0, 10, NOW(), NOW());
INSERT INTO `features` (`id`, `name`, `category`, `icon`, `description`, `is_featured`, `order`, `created_at`, `updated_at`) VALUES (11, 'Verifikasi dengan SatuSehat Mobile', 'Integrasi', 'fa-mobile-screen-button', 'Fitur verifikasi identitas dan keaktifan profil kesehatan pasien secara langsung yang terkoneksi dengan aplikasi SATUSEHAT Mobile Kementerian Kesehatan RI.', 0, 11, NOW(), NOW());
INSERT INTO `features` (`id`, `name`, `category`, `icon`, `description`, `is_featured`, `order`, `created_at`, `updated_at`) VALUES (12, 'Asuhan Keperawatan', 'Rekam Medis', 'fa-user-nurse', 'Dokumentasi asuhan keperawatan lengkap mulai dari asesmen dan pengkajian awal, perumusan diagnosa keperawatan terstandar, perencanaan intervensi, tindakan klinis keperawatan, hingga lembar evaluasi harian.', 0, 12, NOW(), NOW());
INSERT INTO `features` (`id`, `name`, `category`, `icon`, `description`, `is_featured`, `order`, `created_at`, `updated_at`) VALUES (13, 'Pengaturan Integrasi SatuSehat dan BPJS Kesehatan', 'Integrasi', 'fa-network-wired', 'Pusat konfigurasi mandiri untuk menghubungkan API bridging SATUSEHAT Kemenkes RI (Organization ID, Client ID, Secret Key) serta integrasi BPJS Kesehatan dengan pemantauan status koneksi secara langsung.', 0, 13, NOW(), NOW());
INSERT INTO `features` (`id`, `name`, `category`, `icon`, `description`, `is_featured`, `order`, `created_at`, `updated_at`) VALUES (14, 'Odontogram pada Klinik Gigi', 'Rekam Medis', 'fa-tooth', 'Diagram odontogram gigi visual interaktif untuk dokter gigi dan perawat gigi dalam mencatat kondisi klinis gigi geligi, karies, restorasi/tambalan, pencabutan, dan rencana perawatan gigi.', 0, 14, NOW(), NOW());
INSERT INTO `features` (`id`, `name`, `category`, `icon`, `description`, `is_featured`, `order`, `created_at`, `updated_at`) VALUES (15, 'General Consent', 'Legalitas', 'fa-file-signature', 'Persetujuan umum (General Consent) dari pasien atau penanggung jawab keluarga yang terdokumentasi dan diarsipkan secara elektronik sesuai standar rekam medis dan hukum kesehatan.', 0, 15, NOW(), NOW());
INSERT INTO `features` (`id`, `name`, `category`, `icon`, `description`, `is_featured`, `order`, `created_at`, `updated_at`) VALUES (16, 'Informed Consent', 'Legalitas', 'fa-file-contract', 'Formulir persetujuan tindakan medis kedokteran khusus setelah penjelasan risiko dan indikasi, dilengkapi dokumentasi persetujuan digital pasien atau wali serta tanda tangan dokter penanggung jawab.', 0, 16, NOW(), NOW());
INSERT INTO `features` (`id`, `name`, `category`, `icon`, `description`, `is_featured`, `order`, `created_at`, `updated_at`) VALUES (17, 'Surat Sehat & Surat Sakit', 'Administrasi', 'fa-file-medical', 'Modul penerbitan dan pencetakan surat keterangan sehat, surat keterangan sakit istirahat dokter, dan surat rujukan resmi dengan format terstandar dan barcode verifikasi.', 0, 17, NOW(), NOW());
INSERT INTO `features` (`id`, `name`, `category`, `icon`, `description`, `is_featured`, `order`, `created_at`, `updated_at`) VALUES (18, 'Laboratorium', 'Penunjang', 'fa-flask-vial', 'Pencatatan permintaan pemeriksaan laboratorium klinik penunjang, input hasil pengujian parameter darah/urine dan spesimen medis lainnya, hingga pencetakan lembar hasil laboratorium.', 0, 18, NOW(), NOW());
INSERT INTO `features` (`id`, `name`, `category`, `icon`, `description`, `is_featured`, `order`, `created_at`, `updated_at`) VALUES (19, 'Sedasi', 'Rekam Medis', 'fa-syringe', 'Pencatatan pemantauan status sedasi dan anestesi pra, intra, dan pasca tindakan prosedur bedah minor atau tindakan klinis sesuai pedoman keselamatan pasien.', 0, 19, NOW(), NOW());
INSERT INTO `features` (`id`, `name`, `category`, `icon`, `description`, `is_featured`, `order`, `created_at`, `updated_at`) VALUES (20, 'Dan lain-lain', 'Pelayanan', 'fa-ellipsis', 'Berbagai fitur dan modul penunjang operasional fasilitas pelayanan kesehatan lainnya yang senantiasa diperbarui mengikuti kebutuhan operasional mitra faskes dan regulasi terkini.', 0, 20, NOW(), NOW());

-- ----------------------------
-- Table structure for advantages
-- ----------------------------
DROP TABLE IF EXISTS `advantages`;
CREATE TABLE `advantages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `description` text NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `advantages` (`id`, `title`, `icon`, `description`, `order`, `created_at`, `updated_at`) VALUES (1, 'Terintegrasi BPJS Kesehatan', 'fa-hospital-user', 'SIP-Kes dapat digunakan untuk bridging dengan BPJS Kesehatan guna mempermudah verifikasi keaktifan kartu kepesertaan, proses pendaftaran antrian, hingga administrasi klaim pelayanan faskes.', 1, NOW(), NOW());
INSERT INTO `advantages` (`id`, `title`, `icon`, `description`, `order`, `created_at`, `updated_at`) VALUES (2, 'Terintegrasi SATUSEHAT', 'fa-shield-halved', 'Mendukung integrasi penuh dengan platform SATUSEHAT Kemenkes RI, dapat melakukan pertukaran data kesehatan secara real-time dan aman serta memenuhi regulasi PMK No. 24 Tahun 2022.', 2, NOW(), NOW());
INSERT INTO `advantages` (`id`, `title`, `icon`, `description`, `order`, `created_at`, `updated_at`) VALUES (3, 'Berbasis Website', 'fa-globe', 'Dapat diakses dari manapun dan kapanpun secara fleksibel melalui peramban web modern tanpa memerlukan investasi server fisik lokal yang rumit dan mahal.', 3, NOW(), NOW());
INSERT INTO `advantages` (`id`, `title`, `icon`, `description`, `order`, `created_at`, `updated_at`) VALUES (4, 'Free Training', 'fa-chalkboard-user', 'Gratis pelatihan penggunaan untuk fasyankes yang berlangganan hingga seluruh tenaga medis (dokter, perawat, bidan) dan staf (loket, farmasi, kasir) mahir mengoperasikannya.', 4, NOW(), NOW());
INSERT INTO `advantages` (`id`, `title`, `icon`, `description`, `order`, `created_at`, `updated_at`) VALUES (5, 'Free Custom RME', 'fa-screwdriver-wrench', 'Bebas biaya custom RME untuk menyesuaikan kebutuhan spesifik fasyankes, mulai dari formulir asesmen, lembar tindakan, hingga tata kelola resep.', 5, NOW(), NOW());
INSERT INTO `advantages` (`id`, `title`, `icon`, `description`, `order`, `created_at`, `updated_at`) VALUES (6, 'Data Tersentralisasi', 'fa-database', 'Server terpusat, sehingga fasyankes tidak perlu memikirkan pemeliharaan sistem, manajemen backup mandiri, maupun risiko kerusakan server fisik.', 6, NOW(), NOW());

-- ----------------------------
-- Table structure for pricing_plans
-- ----------------------------
DROP TABLE IF EXISTS `pricing_plans`;
CREATE TABLE `pricing_plans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL UNIQUE,
  `price` decimal(12,2) NOT NULL,
  `period` varchar(50) NOT NULL DEFAULT 'bulan',
  `badge` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `features_list` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features_list`)),
  `terms` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`terms`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `pricing_plans` (`id`, `name`, `slug`, `price`, `period`, `badge`, `description`, `features_list`, `terms`, `is_active`, `order`, `created_at`, `updated_at`) VALUES (1, 'PRAKTIK DOKTER MANDIRI', 'praktik-dokter-mandiri', 150000.00, 'bulan', 'Praktik Dokter Mandiri', 'Ideal untuk praktik dokter perorangan (umum maupun spesialis), praktik perawat, dan praktik mandiri bidan.', '[\"Minimal kontrak 1 tahun.\",\"Full support untuk integrasi BPJS Kesehatan dan SatuSehat.\",\"Akses ke fitur-fitur praktik dokter mandiri: pendaftaran pasien lama & pasien baru, antrian, pemeriksaan, farmasi, kasir.\",\"Free biaya custom RME\"]', '[\"Minimal kontrak 1 tahun\",\"Full support untuk integrasi BPJS Kesehatan dan SatuSehat\",\"Free biaya custom RME\"]', 1, 1, NOW(), NOW());
INSERT INTO `pricing_plans` (`id`, `name`, `slug`, `price`, `period`, `badge`, `description`, `features_list`, `terms`, `is_active`, `order`, `created_at`, `updated_at`) VALUES (2, 'KLINIK PRATAMA (Non Rawat Inap)', 'klinik-pratama-non-rawat-inap', 350000.00, 'bulan', 'Klinik Pratama', 'Dirancang khusus untuk Klinik Pratama Rawat Jalan yang membutuhkan sistem operasional multi-poli, APM, dan antrian suara terpadu.', '[\"Minimal kontrak 1 tahun.\",\"Full support untuk integrasi BPJS Kesehatan dan SatuSehat.\",\"Akses ke fitur-fitur klinik pratama, seperti: pendaftaran pasien lama & pasien baru, antrian, APM, pemeriksaan, manajemen poli (KIA, Gigi, Laboratorium, UGD, dan lain-lain kecuali rawat inap), farmasi, kasir, manajemen pegawai.\",\"Free biaya custom RME\",\"Free biaya update fitur\"]', '[\"Minimal kontrak 1 tahun\",\"Full support untuk integrasi BPJS Kesehatan dan SatuSehat\",\"Free biaya custom RME\",\"Free biaya update fitur\"]', 1, 2, NOW(), NOW());
INSERT INTO `pricing_plans` (`id`, `name`, `slug`, `price`, `period`, `badge`, `description`, `features_list`, `terms`, `is_active`, `order`, `created_at`, `updated_at`) VALUES (3, 'KLINIK RAWAT INAP & PUSKESMAS', 'klinik-rawat-inap-puskesmas', 500000.00, 'bulan', 'Klinik Rawat Inap & Puskesmas', 'Paket terlengkap untuk Klinik Rawat Inap dan Puskesmas dengan jumlah pasien dan kunjungan tanpa batas (unlimited).', '[\"Minimal kontrak 1 tahun.\",\"Full support untuk integrasi BPJS Kesehatan dan SatuSehat.\",\"Akses ke fitur-fitur klinik rawat inap, seperti: pendaftaran pasien lama & pasien baru, antrian, APM, pemeriksaan, manajemen poli (KIA, Gigi, Laboratorium, UGD, rawat inap, dan lain-lain), farmasi, kasir, manajemen pegawai, kartu berobat, dan lain-lain.\",\"Unlimited jumlah pasien dan kunjungan.\",\"Free biaya custom RME\",\"Free biaya update fitur\"]', '[\"Minimal kontrak 1 tahun\",\"Full support untuk integrasi BPJS Kesehatan dan SatuSehat\",\"Unlimited jumlah pasien dan kunjungan\",\"Free biaya custom RME\",\"Free biaya update fitur\"]', 1, 3, NOW(), NOW());

-- ----------------------------
-- Table structure for support_services
-- ----------------------------
DROP TABLE IF EXISTS `support_services`;
CREATE TABLE `support_services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `description` longtext NOT NULL,
  `benefits` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`benefits`)),
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `support_services` (`id`, `title`, `icon`, `summary`, `description`, `benefits`, `is_active`, `order`, `created_at`, `updated_at`) VALUES (1, 'Pendampingan Klaim BPJS', 'fa-file-invoice-dollar', 'Pendampingan berupa bimbingan input data sesuai kebutuhan e-klaim BPJS, penyesuaian data SEP & INA-CBG, serta konsultasi kendala teknis selama proses klaim.', 'Pendampingan ini berupa bimbingan input data sesuai kebutuhan e-klaim BPJS, penyesuaian data SEP & INA-CBG, konsultasi kendala teknis selama proses klaim.\n\nKeunggulan Layanan Pendukung SIP-Kes:\n• Didampingi oleh tim profesional dari TEFA V-Kes POLIJE.\n• Melibatkan dosen ahli, praktisi kesehatan, dan mahasiswa terlatih.\n• Berbasis problem-solving dan continuous improvement.', '[\"Bimbingan input data sesuai kebutuhan e-klaim BPJS\",\"Penyesuaian data SEP & INA-CBG\",\"Konsultasi kendala teknis selama proses klaim\",\"Didampingi oleh tim profesional dari TEFA V-Kes POLIJE\",\"Melibatkan dosen ahli, praktisi kesehatan, dan mahasiswa terlatih\",\"Berbasis problem-solving dan continuous improvement\"]', 1, 1, NOW(), NOW());
INSERT INTO `support_services` (`id`, `title`, `icon`, `summary`, `description`, `benefits`, `is_active`, `order`, `created_at`, `updated_at`) VALUES (2, 'Pendampingan Akreditasi Klinik', 'fa-award', 'Pendampingan berupa penyusunan dokumen elektronik sesuai standar akreditasi Kemenkes, penyediaan data rekam medis, laporan kegiatan, dan log pelayanan, simulasi audit digital dan pendampingan tim surveyor.', 'Pendampingan ini berupa penyusunan dokumen elektronik sesuai standar akreditasi Kemenkes, penyediaan data rekam medis, laporan kegiatan, dan log pelayanan, simulasi audit digital dan pendampingan tim surveyor.\n\nKeunggulan Layanan Pendukung SIP-Kes:\n• Didampingi oleh tim profesional dari TEFA V-Kes POLIJE.\n• Melibatkan dosen ahli, praktisi kesehatan, dan mahasiswa terlatih.\n• Berbasis problem-solving dan continuous improvement.', '[\"Penyusunan dokumen elektronik sesuai standar akreditasi Kemenkes\",\"Penyediaan data rekam medis, laporan kegiatan, dan log pelayanan\",\"Simulasi audit digital dan gladi akreditasi\",\"Pendampingan langsung saat tim surveyor melakukan visitasi\",\"Didampingi oleh tim profesional dari TEFA V-Kes POLIJE\",\"Melibatkan dosen ahli, praktisi kesehatan, dan mahasiswa terlatih\",\"Berbasis problem-solving dan continuous improvement\"]', 1, 2, NOW(), NOW());

-- ----------------------------
-- Table structure for gallery_categories
-- ----------------------------
DROP TABLE IF EXISTS `gallery_categories`;
CREATE TABLE `gallery_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL UNIQUE,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `gallery_categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES (1, 'Dokumentasi Pelayanan & Implementasi', 'pelayanan-implementasi', NOW(), NOW());
INSERT INTO `gallery_categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES (2, 'Gedung & Fasilitas TeFa V-Kes', 'gedung-fasilitas', NOW(), NOW());
INSERT INTO `gallery_categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES (3, 'Pelatihan & Pendampingan Faskes', 'pelatihan-pendampingan', NOW(), NOW());

-- ----------------------------
-- Table structure for galleries
-- ----------------------------
DROP TABLE IF EXISTS `galleries`;
CREATE TABLE `galleries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `date` date DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `galleries_category_id_foreign` (`category_id`),
  CONSTRAINT `galleries_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `gallery_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `galleries` (`id`, `category_id`, `title`, `description`, `image`, `date`, `order`, `created_at`, `updated_at`) VALUES (1, 1, 'Implementasi RME SIP-Kes di Loket Pendaftaran Fasyankes', 'Pelayanan pendaftaran pasien dan identifikasi keaktifan BPJS menggunakan SIP-Kes di fasilitas kesehatan mitra.', 'gallery/pendaftaran-pasien-rme.jpg', '2026-08-10', 1, NOW(), NOW());
INSERT INTO `galleries` (`id`, `category_id`, `title`, `description`, `image`, `date`, `order`, `created_at`, `updated_at`) VALUES (2, 2, 'Gedung Teaching Factory Inovasi Kesehatan (TeFa V-Kes)', 'Gedung unit usaha dan pusat riset rekam medis terpadu Politeknik Negeri Jember, Jalan Mastrip 164 Jember.', 'gallery/gedung-tefa-vkes.jpg', '2026-07-15', 2, NOW(), NOW());
INSERT INTO `galleries` (`id`, `category_id`, `title`, `description`, `image`, `date`, `order`, `created_at`, `updated_at`) VALUES (3, 1, 'Pelayanan Pemeriksaan Medis Terintegrasi RME', 'Tenaga medis mengisi pemeriksaan klinis SOAP dan asesmen diagnosis ICD-10 secara langsung melalui SIP-Kes.', 'gallery/pelayanan-medis-pasien.jpg', '2026-09-02', 3, NOW(), NOW());
INSERT INTO `galleries` (`id`, `category_id`, `title`, `description`, `image`, `date`, `order`, `created_at`, `updated_at`) VALUES (4, 3, 'Bimbingan Teknis & Pelatihan Penggunaan RME SIP-Kes', 'Pelatihan gratis pengoperasian sistem bagi dokter, perawat, apoteker, dan petugas fasyankes.', 'gallery/pelatihan-fasyankes.jpg', '2026-10-18', 4, NOW(), NOW());

-- ----------------------------
-- Table structure for contact_info
-- ----------------------------
DROP TABLE IF EXISTS `contact_info`;
CREATE TABLE `contact_info` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(255) NOT NULL DEFAULT '0813-3551-2803',
  `whatsapp` varchar(255) NOT NULL DEFAULT '6281335512803',
  `email` varchar(255) NOT NULL DEFAULT 'vkes@polije.ac.id',
  `instagram` varchar(255) NOT NULL DEFAULT '@sipkes.co.id',
  `instagram_url` varchar(255) NOT NULL DEFAULT 'https://instagram.com/sipkes.co.id',
  `address` text NOT NULL,
  `maps_embed` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `contact_info` (`id`, `phone`, `whatsapp`, `email`, `instagram`, `instagram_url`, `address`, `created_at`, `updated_at`) VALUES (1, '0813-3551-2803', '6281335512803', 'vkes@polije.ac.id', '@sipkes.co.id', 'https://instagram.com/sipkes.co.id', 'Jurusan Kesehatan, Program Studi Manajemen Informasi Kesehatan, Politeknik Negeri Jember, Jalan Mastrip 164 Jember', NOW(), NOW());

-- ----------------------------
-- Table structure for contact_messages
-- ----------------------------
DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE `contact_messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `faskes_name` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for banners
-- ----------------------------
DROP TABLE IF EXISTS `banners`;
CREATE TABLE `banners` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `badge` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` text DEFAULT NULL,
  `primary_btn_text` varchar(255) NOT NULL DEFAULT 'Lihat Fitur & Demo',
  `primary_btn_url` varchar(255) NOT NULL DEFAULT '#fitur',
  `secondary_btn_text` varchar(255) NOT NULL DEFAULT 'Hubungi Kami',
  `secondary_btn_url` varchar(255) NOT NULL DEFAULT '#kontak',
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `banners` (`id`, `badge`, `title`, `subtitle`, `primary_btn_text`, `primary_btn_url`, `secondary_btn_text`, `secondary_btn_url`, `is_active`, `order`, `created_at`, `updated_at`) VALUES (1, '🏥 Proposal SIP-Kes • TeFa V-Kes Politeknik Negeri Jember', 'Sistem Informasi Pelayanan Kesehatan (SIP-Kes)', 'Sebuah sistem rekam medis elektronik untuk manajemen data kesehatan di fasilitas pelayanan kesehatan tingkat pertama yang telah terintegrasi dengan SATUSEHAT dan bridging BPJS Kesehatan.', 'Lihat 20 Fitur Lengkap', '#fitur', 'Hubungi Call Center', '#kontak', 1, 1, NOW(), NOW());

-- ----------------------------
-- Table structure for target_facilities
-- ----------------------------
DROP TABLE IF EXISTS `target_facilities`;
CREATE TABLE `target_facilities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `target_facilities` (`id`, `name`, `icon`, `description`, `order`, `created_at`, `updated_at`) VALUES (1, 'Puskesmas', 'fa-hospital', 'Puskesmas dengan layanan rawat jalan maupun rawat inap yang membutuhkan pencatatan RME terintegrasi SATUSEHAT dan pelaporan morbiditas 20 besar penyakit.', 1, NOW(), NOW());
INSERT INTO `target_facilities` (`id`, `name`, `icon`, `description`, `order`, `created_at`, `updated_at`) VALUES (2, 'Klinik', 'fa-clinic-medical', 'Klinik Pratama maupun Rawat Inap dengan alur loket pendaftaran, antrian suara, berbagai poli tujuan (KIA, Gigi, UGD), farmasi, kasir, dan bridging BPJS.', 2, NOW(), NOW());
INSERT INTO `target_facilities` (`id`, `name`, `icon`, `description`, `order`, `created_at`, `updated_at`) VALUES (3, 'Praktik Mandiri Dokter', 'fa-user-doctor', 'Praktik mandiri dokter umum dan spesialis untuk pencatatan rekam medis SOAP, riwayat alergi, kode diagnosa ICD-10, tindakan, dan e-resep praktis.', 3, NOW(), NOW());
INSERT INTO `target_facilities` (`id`, `name`, `icon`, `description`, `order`, `created_at`, `updated_at`) VALUES (4, 'Praktik Perawat', 'fa-user-nurse', 'Praktik mandiri perawat yang memerlukan dokumentasi asuhan keperawatan terstandar, catatan tindakan medis harian, dan pemantauan kondisi pasien.', 4, NOW(), NOW());
INSERT INTO `target_facilities` (`id`, `name`, `icon`, `description`, `order`, `created_at`, `updated_at`) VALUES (5, 'Praktik Bidan', 'fa-person-breastfeeding', 'Praktik mandiri bidan untuk pelayanan kesehatan ibu dan anak (KIA), program KB, imunisasi balita, serta dokumentasi asuhan kebidanan lengkap.', 5, NOW(), NOW());

-- ----------------------------
-- Table structure for site_settings
-- ----------------------------
DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE `site_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL UNIQUE,
  `value` longtext DEFAULT NULL,
  `group` varchar(100) NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES (1, 'site_name', 'SIP-Kes', 'general', NOW(), NOW());
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES (2, 'site_tagline', 'Sistem Informasi Pelayanan Kesehatan - TeFa V-Kes Politeknik Negeri Jember', 'general', NOW(), NOW());
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES (3, 'meta_description', 'Sebuah sistem rekam medis elektronik untuk manajemen data kesehatan di fasilitas pelayanan kesehatan tingkat pertama yang telah terintegrasi dengan SATUSEHAT dan bridging BPJS Kesehatan.', 'general', NOW(), NOW());
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES (4, 'phone', '0813-3551-2803', 'general', NOW(), NOW());
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES (5, 'email', 'vkes@polije.ac.id', 'general', NOW(), NOW());
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES (6, 'website', 'www.sipkes.co.id', 'general', NOW(), NOW());
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES (7, 'instagram', '@sipkes.co.id', 'general', NOW(), NOW());
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES (8, 'address', 'Jurusan Kesehatan, Program Studi Manajemen Informasi Kesehatan, Politeknik Negeri Jember, Jalan Mastrip 164 Jember', 'general', NOW(), NOW());
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES (9, 'cta_title', 'Siap Menerapkan Rekam Medis Elektronik Terintegrasi SATUSEHAT & BPJS?', 'general', NOW(), NOW());
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES (10, 'cta_subtitle', 'Demikian penawaran ini kami buat, kami sangat terbuka untuk mendiskusikan terkait penawaran ini. Silakan menghubungi kami melalui call center kami.', 'general', NOW(), NOW());
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES (11, 'cta_btn_text', 'Hubungi Call Center Kami', 'general', NOW(), NOW());
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES (12, 'cta_btn_url', '#kontak', 'general', NOW(), NOW());

SET FOREIGN_KEY_CHECKS = 1;
