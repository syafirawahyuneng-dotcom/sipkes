# PRD — Portal SIP-Kes (Sistem Informasi Pelayanan Kesehatan)

| Item | Keterangan |
|---|---|
| Produk | Portal informasi & pemasaran SIP-Kes |
| Pemilik | Teaching Factory Inovasi Kesehatan (TeFa V-Kes), Jurusan Kesehatan, Politeknik Negeri Jember |
| Versi dokumen | 1.1 (revisi: detail fitur, Galeri → Berita, penghapusan aplikasi RME & indikator LIVE) |
| Tanggal | 13 November 2026 |

---

## 1. Gambaran Umum

SIP-Kes adalah produk perangkat lunak rekam medis elektronik yang dikembangkan TeFa V-Kes Polije untuk fasilitas pelayanan kesehatan (praktik mandiri, klinik, puskesmas) dan terintegrasi dengan SATUSEHAT Kemenkes RI serta BPJS Kesehatan.

Website ini adalah **portal publik** produk tersebut: menjelaskan profil TeFa & SIP-Kes, katalog fitur/modul, keunggulan, paket harga, layanan pendukung, berita kegiatan, serta formulir konsultasi. Website **bukan** aplikasi rekam medis itu sendiri — portal tidak menyediakan aplikasi RME operasional (pendaftaran pasien, kasir, dsb.). Semua konten publik dikelola melalui panel admin.

### 1.1 Teknologi

| Lapisan | Teknologi |
|---|---|
| Backend | PHP 8.2+, Laravel 12 |
| Database | MySQL (`sipkes`), Eloquent ORM, migrasi & seeder Laravel |
| Frontend | Blade template, Tailwind CSS (CDN), Font Awesome 6.4, Google Fonts Inter |
| Autentikasi admin | Guard `admin` (model `Admin`), middleware alias `admin` (`RedirectIfNotAdmin`) |
| Penyimpanan file | Disk `public` (`storage/app/public`, diakses lewat `public/storage` setelah `php artisan storage:link`) |
| Server lokal | XAMPP (Apache + MySQL) |

### 1.2 Identitas Visual

- Warna utama: palet `primary` biru (`#eff6ff` – `#1e3a8a`), aksen `sky`, `teal`, `emerald`, `amber`; latar putih/`slate-50`; footer `slate-900`.
- Komponen khas: kartu `rounded-2xl/3xl` dengan border `slate-200`, banner judul halaman `bg-primary-900`, badge kategori `rounded-full uppercase`, tombol `rounded-xl`.
- Logo dari `SiteSetting('site_logo')` dengan cadangan `public/images/logo.png`.

---

## 2. Tujuan

1. Memperkenalkan SIP-Kes dan TeFa V-Kes kepada calon mitra faskes.
2. Menjelaskan setiap fitur/modul SIP-Kes secara rinci (fungsi, manfaat, pengguna, alur) agar calon mitra memahami nilai produk.
3. Menyajikan berita kegiatan (implementasi, pelatihan, fasilitas) sebagai bukti kredibilitas.
4. Mengonversi pengunjung menjadi prospek melalui formulir konsultasi dan WhatsApp.
5. Memudahkan admin TeFa memperbarui seluruh konten tanpa mengubah kode.

## 3. Pengguna & Kebutuhan

| Pengguna | Kebutuhan |
|---|---|
| Pengelola faskes (pemilik klinik, kepala puskesmas) | Memahami fitur, kepatuhan regulasi (PMK 24/2022), biaya, dan layanan pendampingan |
| Tenaga kesehatan (dokter, perawat, apoteker, petugas rekam medis) | Mengetahui modul yang relevan dengan pekerjaan mereka dan alur penggunaannya |
| Masyarakat / mahasiswa / mitra | Melihat profil, berita kegiatan TeFa, dan informasi kontak |
| Admin TeFa V-Kes | Mengelola konten beranda, profil, fitur, keunggulan, harga, layanan, berita, kontak, dan membaca pesan masuk |

---

## 4. Struktur Halaman

### 4.1 Portal Publik

| URL | Route name | Halaman | Sumber data |
|---|---|---|---|
| `/` | `home` | Beranda: hero, pengenalan, keunggulan, fitur unggulan, faskes sasaran, paket, layanan, cuplikan berita, kontak | `Banner`, `Profile`, `Advantage`, `Feature`, `TargetFacility`, `PricingPlan`, `SupportService`, `Gallery`, `ContactInfo` |
| `/profil` | `profile` | Profil TeFa V-Kes & SIP-Kes | `Profile` |
| `/fitur` | `features` | Katalog **Fitur & Modul Lengkap SIP-Kes** dengan filter kategori | `Feature` |
| `/fitur/{slug}` | `features.show` | **Detail fitur** (baru) | `Feature` |
| `/keunggulan` | `advantages` | Keunggulan sistem | `Advantage` |
| `/harga` | `pricing` | Paket harga | `PricingPlan` |
| `/layanan-pendukung` | `support.services` | Layanan pendukung (klaim BPJS, akreditasi) | `SupportService` |
| `/berita` | `news` | **Daftar berita** (pengganti Galeri) dengan filter kategori & paginasi | `Gallery` + `GalleryCategory` |
| `/berita/{slug}` | `news.show` | **Detail berita** (baru) | `Gallery` |
| `/galeri` | — | Redirect permanen (301) ke `/berita` agar tautan lama tetap berfungsi | — |
| `/kontak` | `contact` | Informasi kontak & formulir pesan | `ContactInfo` |
| `POST /kontak/kirim-pesan` | `contact.send` | Simpan pesan konsultasi | `ContactMessage` |

Komponen global (`layouts/frontend.blade.php`): top bar kontak, navbar sticky (Beranda, Profil, dropdown Fitur & Layanan, Paket Harga, Berita, Kontak), tombol Demo, menu mobile, banner CTA, footer 4 kolom.

### 4.2 Panel Admin (`/admin`, wajib login kecuali halaman login)

| Menu | Route | Fungsi |
|---|---|---|
| Login / Logout | `admin.login`, `admin.logout` | Autentikasi guard `admin` |
| Dashboard | `admin.dashboard` | Ringkasan jumlah konten & pesan terbaru |
| Halaman Beranda | `admin.home.*` | Kelola hero banner & logo situs |
| Profil TeFa & SIP-Kes | `admin.profile.*` | Kelola visi, misi, deskripsi |
| Fitur & Modul | `admin.features.*` | CRUD fitur, termasuk konten detail (pengguna, fungsi, manfaat, alur) |
| Keunggulan Sistem | `admin.advantages.*` | CRUD keunggulan |
| Paket Harga | `admin.pricing.*` | CRUD paket |
| Layanan Pendukung | `admin.support-services.*` | CRUD layanan |
| Berita | `admin.galleries.*` | CRUD berita (gambar, judul, tanggal, ringkasan, isi lengkap, penulis) + kelola kategori berita |
| Kontak & Pesan Masuk | `admin.contact.*`, `admin.messages.*` | Ubah info kontak, tandai baca/hapus pesan |

---

## 5. Modul & Kebutuhan Fungsional

### 5.1 Fitur & Modul Lengkap SIP-Kes

Katalog 20 modul sesuai proposal: Pendaftaran; Antrian dan Panggilan Suara; Pemeriksaan (SO); Diagnosa dan Tindakan (AP); Farmasi; Kasir; Rawat Inap; Laporan; Dashboard; Cetak Kartu Berobat; Verifikasi dengan SatuSehat Mobile; Asuhan Keperawatan; Pengaturan Integrasi SatuSehat dan BPJS Kesehatan; Odontogram pada Klinik Gigi; General Consent; Informed Consent; Surat Sehat & Surat Sakit; Laboratorium; Sedasi; Dan lain-lain.

| ID | Kebutuhan |
|---|---|
| F-01 | Setiap kartu fitur di halaman `/fitur` dan di bagian fitur beranda dapat diklik seluruhnya dan membuka `/fitur/{slug}`. |
| F-02 | Halaman detail menampilkan: ikon, nama fitur, kategori, deskripsi, **fungsi utama** (daftar), **manfaat** (daftar), **pengguna** (peran yang memakai modul), **alur penggunaan** (langkah bernomor), dan status "Modul Unggulan" bila berlaku. |
| F-03 | Halaman detail menyediakan breadcrumb, tombol kembali ke katalog, navigasi fitur sebelumnya/berikutnya, daftar fitur lain dalam kategori yang sama, dan ajakan konsultasi/demo. |
| F-04 | Setiap fitur memiliki `slug` unik yang dibuat otomatis dari nama. Slug tidak dikenal → 404. |
| F-05 | Admin dapat mengisi/mengubah konten detail (pengguna, fungsi, manfaat, alur — satu poin per baris). Bagian yang kosong tidak ditampilkan. |
| F-06 | Tidak ada tombol "Gunakan Modul" atau tautan ke aplikasi RME; tidak ada badge/indikator **LIVE**. |

### 5.2 Berita (pengganti Galeri)

| ID | Kebutuhan |
|---|---|
| B-01 | Seluruh penyebutan "Galeri" di portal & admin diganti "Berita" (menu navbar, mobile, footer, judul beranda, judul halaman, label admin). |
| B-02 | Halaman `/berita` menampilkan kartu berita: gambar (atau placeholder bergradasi bila gambar tidak ada), kategori, tanggal publikasi, judul, ringkasan, tombol "Baca Selengkapnya". Seluruh kartu dapat diklik. |
| B-03 | Filter kategori berita & paginasi 9 item per halaman. Berita diurutkan dari tanggal terbaru. |
| B-04 | Halaman `/berita/{slug}` menampilkan gambar utama, kategori, judul, tanggal publikasi, penulis (opsional), ringkasan, isi lengkap (paragraf), tombol bagikan (WhatsApp, salin tautan), berita terkait/terbaru, dan tombol kembali ke daftar berita. |
| B-05 | Setiap berita memiliki `slug` unik otomatis; slug tidak dikenal → 404. |
| B-06 | Admin dapat membuat/mengubah berita: judul, kategori, tanggal, gambar, ringkasan, isi lengkap, penulis, urutan. |
| B-07 | Tautan lama `/galeri` dialihkan ke `/berita`. |

### 5.3 Modul lain (tidak berubah)

Profil, Keunggulan, Paket Harga, Layanan Pendukung, Kontak (validasi `name`, `email`, `subject`, `message` wajib), serta seluruh CRUD admin terkait tetap seperti sebelumnya.

---

## 6. Alur Penggunaan

**Calon mitra mempelajari fitur**
Beranda → klik kartu fitur unggulan (atau "Lihat Semua Fitur") → `/fitur` → filter kategori → klik kartu → `/fitur/{slug}` → baca fungsi/manfaat/alur → "Konsultasi & Demo" ke `/kontak` atau WhatsApp.

**Pengunjung membaca berita**
Beranda (bagian Berita) / navbar "Berita" → `/berita` → klik kartu → `/berita/{slug}` → baca isi → berita terkait atau "Kembali ke Daftar Berita".

**Admin menerbitkan berita**
`/admin/login` → menu Berita → "Tulis Berita Baru" → isi form → Simpan → berita tampil di `/berita` dan beranda.

**Admin melengkapi detail fitur**
Menu Fitur & Modul → Edit → isi Pengguna/Fungsi/Manfaat/Alur → Simpan → tampil di `/fitur/{slug}`.

---

## 7. Model Data (ringkas)

| Tabel | Kolom penting |
|---|---|
| `features` | `name`, `slug`*, `category`, `icon`, `description`, `users`*, `functions`*, `benefits`*, `workflow`*, `is_featured`, `order` |
| `galleries` (berita) | `category_id`, `title`, `slug`*, `description` (ringkasan), `content`* (isi lengkap), `author`*, `image`, `date` (tanggal publikasi), `order` |
| `gallery_categories` | `name`, `slug` |
| Lainnya | `admins`, `profiles`, `advantages`, `pricing_plans`, `support_services`, `target_facilities`, `contact_infos`, `contact_messages`, `banners`, `site_settings` |

\* Kolom baru dari migrasi `2026_11_13_000011_add_detail_columns_to_features_and_galleries`. Migrasi ini juga mengisi slug dan konten detail untuk data yang sudah ada tanpa menghapus data. Konten bawaan disimpan di `database/data/feature_details.php` dan `database/data/news_contents.php` dan dipakai bersama oleh migrasi dan seeder.

Nama tabel/model `galleries`/`Gallery` dipertahankan agar data, upload, dan CRUD admin yang sudah ada tetap berfungsi. Penamaan "Berita" diterapkan pada route publik dan antarmuka.

---

## 8. Ruang Lingkup Revisi Ini

**Termasuk**
- Halaman detail untuk setiap fitur, dan kartu fitur yang bisa diklik.
- Penghapusan indikator **LIVE** (badge pojok kanan kartu fitur beranda, badge "Live Active" di kartu hero, tombol "Aplikasi RME Live" di pojok kanan navbar) tanpa pengganti.
- Penghapusan aplikasi RME operasional (`/rme/*`, `RmeController`, view `rme/*`, model klinis, migrasi & seeder RME) beserta seluruh tautannya dari portal.
- Galeri → Berita: daftar kartu, detail berita, form admin.

**Tidak termasuk**
- Membuat atau menambahkan aplikasi RME dalam bentuk apa pun.
- Perubahan pada halaman Profil, Keunggulan, Harga, Layanan Pendukung, Kontak.
- Penghapusan tabel database RME yang sudah ada di server (data tidak dihapus; tabel tidak lagi dipakai aplikasi).

## 9. Kebutuhan Non-Fungsional

- Responsif (mobile, tablet, desktop) dengan grid Tailwind.
- Semua halaman merespons HTTP 200 tanpa error; slug tidak valid → 404.
- Output dirender lewat Blade `{{ }}` (escape otomatis) untuk mencegah XSS; konten multi-baris dipecah per baris/paragraf, bukan HTML mentah.
- Formulir admin menggunakan CSRF dan validasi server.
- Gambar tanpa file valid menampilkan placeholder agar tata letak tidak rusak.

## 10. Kriteria Penerimaan

1. Mengeklik setiap kartu fitur membuka detail yang sesuai dengan fungsi fitur tersebut.
2. Tidak ada route `/rme`, tautan, atau tombol menuju aplikasi RME.
3. Tidak ada teks/badge "LIVE" di portal.
4. Kata "Galeri" tidak muncul di portal dan menu admin; menu "Berita" berfungsi.
5. Setiap berita memiliki halaman detail dengan konten berbeda dan navigasi kembali ke daftar.
6. Semua halaman publik dan admin terkait dapat dibuka tanpa error.

Kriteria 1–5 diuji otomatis oleh `tests/Feature/PortalDetailPagesTest.php` (`php artisan test --filter=PortalDetailPagesTest`).
