# PRD Fase 2 — Portal SIP-Kes: Gambar, WYSIWYG Editor, Artikel & Visual Beranda

| Item | Keterangan |
|---|---|
| Produk | Portal informasi & pemasaran SIP-Kes |
| Pemilik | Teaching Factory Inovasi Kesehatan (TeFa V-Kes), Jurusan Kesehatan, Politeknik Negeri Jember |
| Versi dokumen | 2.0 (Fase 2) — melanjutkan `PRD-SIP-KES.md` v1.1 |
| Tanggal | 18 November 2026 |
| Status | Diimplementasikan 18 November 2026 (22 test lulus) |

---

## 1. Latar Belakang

Fase 1 (v1.1) menghasilkan portal yang seluruh kontennya dinamis, halaman detail fitur, dan modul Berita. Ada empat kekurangan yang masih tersisa:

1. **Upload gambar hanya ada di Berita.** Kolom `image` sudah ada di tabel `profiles`, `support_services`, dan `banners`, tetapi form admin belum menyediakan input unggah. Tabel `features` dan `advantages` belum punya kolom gambar sama sekali.
2. **Deskripsi berupa teks polos** (`<textarea>`). Admin tidak dapat membuat heading, teks tebal, daftar, atau perataan, sehingga konten panjang (isi berita, deskripsi layanan, profil) terlihat seperti satu blok teks.
3. **Belum ada konten edukatif.** Berita hanya memuat kegiatan TeFa. Portal belum punya tempat untuk tulisan seperti panduan RME, regulasi PMK 24/2022, atau integrasi SATUSEHAT/BPJS yang berguna untuk SEO dan untuk menunjukkan keahlian TeFa.
4. **Beranda minim gambar.** Hero memakai kartu ilustrasi statis. Satu-satunya gambar di beranda ada di cuplikan Berita.

## 2. Tujuan Fase 2

| # | Tujuan | Ukuran keberhasilan |
|---|---|---|
| T-1 | Admin dapat mengunggah, mengganti, dan menghapus gambar pada setiap konten yang membutuhkan visual | Semua modul di §4.1 punya input gambar lengkap dengan pratinjau |
| T-2 | Semua deskripsi panjang dapat diformat (heading, bold, italic, list, alignment, tautan) | Semua field di §4.2 memakai editor WYSIWYG dan tampil terformat di portal |
| T-3 | Portal memiliki menu **Artikel** yang dikelola penuh dari admin | Artikel dapat dibuat, diedit, dihapus, disimpan sebagai draf, dan dipublikasikan |
| T-4 | Beranda tampil lebih informatif dan profesional | Hero, Pengenalan, dan Artikel Terbaru di beranda menampilkan gambar dari admin |
| T-5 | Tidak ada regresi | Seluruh test lama (`PortalDetailPagesTest`, `ExampleTest`) tetap lulus |

## 3. Prinsip & Batasan Pengembangan

- **Pertahankan identitas visual** dari PRD v1.1 §1.2: palet `primary` biru, kartu `rounded-2xl/3xl` dengan border `slate-200`, banner judul `bg-primary-900`, badge `rounded-full uppercase`, tombol `rounded-xl`, font Inter, ikon Font Awesome 6.4. Komponen baru memakai kelas Tailwind yang sudah dipakai di view yang ada.
- **Semua bersifat opsional dan punya fallback.** Konten tanpa gambar tetap memakai tampilan sekarang (ikon/placeholder bergradasi). Tata letak tidak boleh rusak saat gambar kosong.
- **Kompatibel ke belakang.** Data teks polos yang sudah ada tetap tampil rapi tanpa perlu diedit ulang (lihat W-06).
- **Perubahan seminimal mungkin pada fitur yang berjalan.** Route, nama tabel/model (`galleries`/`Gallery`), slug, dan URL lama tidak diubah. Migrasi hanya menambah kolom/tabel (*additive*); tidak ada kolom yang dihapus atau di-rename.
- **Field berformat daftar tetap teks polos.** Field "satu poin per baris" (`users`, `functions`, `benefits`, `workflow` di Fitur; `features_text`/`terms_text` di Paket Harga; `benefits_text` di Layanan) **tidak** diubah ke WYSIWYG karena portal memecahnya per baris menjadi daftar.
- Tanpa build step baru: library frontend dimuat lewat CDN dengan versi yang dikunci, sama seperti Tailwind dan Font Awesome sekarang.

---

## 4. Kebutuhan Fungsional

### 4.1 Input Gambar pada Fitur Admin

#### Cakupan modul

| Modul admin | Tabel | Kolom | Status kolom | Tampil di portal |
|---|---|---|---|---|
| Halaman Beranda (Hero) | `banners` | `image` | Sudah ada, belum ada input | Hero beranda (§4.4) |
| Halaman Beranda (Pengenalan) | `site_settings` | key `home_intro_image` | Baru (key-value, tanpa migrasi skema) | Bagian Pengenalan beranda |
| Profil TeFa & SIP-Kes | `profiles` | `image` | Sudah ada, belum ada input | Halaman `/profil` dan bagian Pengenalan beranda |
| Fitur & Modul | `features` | `image` | **Baru** | Halaman `/fitur/{slug}` (gambar/tangkapan layar modul) |
| Keunggulan Sistem | `advantages` | `image` | **Baru** | Halaman `/keunggulan` |
| Layanan Pendukung | `support_services` | `image` | Sudah ada, belum ada input | Halaman `/layanan-pendukung` |
| Berita | `galleries` | `image` | Sudah ada dan berfungsi | Diseragamkan memakai komponen bersama |
| Artikel | `articles` | `cover_image` | **Baru** (§4.3) | `/artikel`, `/artikel/{slug}`, beranda |

Paket Harga, Kontak, dan Faskes Sasaran tidak mendapat gambar pada fase ini.

#### Kebutuhan

| ID | Kebutuhan |
|---|---|
| G-01 | Setiap form pada tabel di atas memiliki input gambar opsional dengan **pratinjau langsung** (sebelum disimpan) dan, saat edit, menampilkan gambar yang sedang dipakai. |
| G-02 | Admin dapat **mengganti** gambar (unggah file baru) dan **menghapus** gambar (centang "Hapus gambar") tanpa menghapus konten. |
| G-03 | Validasi server: `image`, format `jpeg/jpg/png/webp/gif`, ukuran maksimal **5 MB**, sama seperti aturan Berita yang ada. Pesan error dalam Bahasa Indonesia. |
| G-04 | File disimpan di disk `public` per folder modul (`features/`, `advantages/`, `services/`, `profile/`, `banners/`, `home/`, `articles/`). File lama dihapus dari storage saat diganti, dihapus, atau saat kontennya dihapus. |
| G-05 | URL gambar dibuat melalui satu accessor bersama (trait `HasImage` → `image_url`) yang memakai `public/storage`, dengan cadangan route `media` yang sudah ada bila symlink belum dibuat. Gambar kosong atau tidak valid → `null`, lalu view menampilkan fallback. |
| G-06 | Input gambar dibuat sebagai **satu komponen Blade bersama** (mis. `<x-admin.image-input>`) agar tampilan dan perilakunya sama di semua form. Form Berita dipindahkan ke komponen ini tanpa mengubah perilakunya. |
| G-07 | Setiap input gambar menampilkan petunjuk rasio/ukuran yang disarankan, mis. Hero 4:3 (≥ 1200 px), cover artikel/berita 16:9 (≥ 1200×675 px), fitur/keunggulan 16:10. |
| G-08 | Gambar di portal memakai `loading="lazy"` (kecuali hero), `object-cover` dalam wadah berasio tetap, dan atribut `alt` yang diambil dari judul/nama konten. |

### 4.2 WYSIWYG Editor

#### Pilihan editor

**TinyMCE 7 self-hosted dari CDN jsDelivr** (`tinymce@7.x` dengan versi yang dikunci, `license_key: 'gpl'`).
Alasan: tidak memerlukan API key atau akun cloud; toolbar lengkap (heading, alignment, list, tabel, tautan, gambar); tersedia lokalisasi Bahasa Indonesia; dan bisa dipasang lewat satu tag `<script>` tanpa build step, sesuai pola CDN proyek ini.
Alternatif: CKEditor 5. Jika dipakai, cara inisialisasinya sama lewat partial yang sama.

#### Field yang memakai editor

| Modul | Field |
|---|---|
| Profil | `about_tefa`, `about_sipkes`, `background`, `vision`, `mission` |
| Fitur & Modul | `description` |
| Keunggulan Sistem | `description` |
| Layanan Pendukung | `description` |
| Berita | `content` (isi lengkap) |
| Artikel | `content` |

Field berikut **tetap teks polos** karena ditampilkan di kartu, meta, atau dipecah per baris: ringkasan berita (`galleries.description`), ringkasan artikel (`excerpt`), subjudul hero (`banners.subtitle`), alamat kontak, dan semua field daftar "satu poin per baris" (§3).

#### Kebutuhan

| ID | Kebutuhan |
|---|---|
| W-01 | Toolbar minimal: Undo/Redo · Heading (H2, H3, H4, Paragraf) · **Bold**, *Italic*, Underline, Strikethrough · Bullet list, Numbered list · Rata kiri/tengah/kanan/justify · Tautan · Kutipan (blockquote) · Tabel · Hapus format · Kode sumber · Layar penuh. Untuk Artikel & Berita ditambah **Sisipkan gambar** (W-05). |
| W-02 | Editor diinisialisasi oleh **satu partial** (`admin/partials/editor.blade.php`) yang dimuat di `admin/layout.blade.php`. Field cukup diberi kelas `.wysiwyg` agar editor aktif; preset `basic` untuk deskripsi singkat dan `full` untuk Artikel/Berita. |
| W-03 | Field wajib (`required`) tetap tervalidasi: isi editor disinkronkan ke `<textarea>` saat submit dan validasi server memeriksa teks setelah tag HTML dibuang (isi yang hanya `<p></p>` dianggap kosong). Nilai `old()` dipertahankan saat validasi gagal. |
| W-04 | **Keamanan (wajib):** HTML dari editor disanitasi di server sebelum disimpan memakai HTMLPurifier (`mews/purifier`) dengan whitelist tag: `p, br, h2–h4, strong, b, em, i, u, s, ul, ol, li, a[href,target,rel], blockquote, table/thead/tbody/tr/th/td, img[src,alt,width,height], span/p[style: text-align]`. `script`, `iframe`, `style`, atribut `on*`, dan `javascript:` dibuang. Hanya field hasil sanitasi yang boleh dirender dengan `{!! !!}`; semua field lain tetap memakai `{{ }}`. |
| W-05 | Unggah gambar dari dalam editor (Artikel & Berita) melalui endpoint admin `POST /admin/editor/upload` (route `admin.editor.upload`, middleware `admin`, CSRF). Validasinya sama dengan G-03, file disimpan di `editor/`, dan respons JSON `{ location: url }`. |
| W-06 | **Kompatibilitas data lama:** saat ditampilkan, konten yang tidak mengandung tag HTML dianggap teks polos lama dan diubah menjadi paragraf (`<p>` per baris kosong, `<br>` per baris), sehingga tampilannya sama dengan sekarang. Ini ditangani oleh satu helper/accessor (mis. `RichText::render()`). Data lama tidak perlu dimigrasi. |
| W-07 | Portal menampilkan konten terformat dengan gaya yang konsisten melalui satu kelas pembungkus (mis. `.rich-content`) untuk heading, list, tautan `primary-700`, blockquote, tabel responsif (`overflow-x-auto`), dan gambar `rounded-2xl max-w-full`. Gaya drop-cap pada paragraf pertama detail berita tetap dipertahankan. |
| W-08 | Ringkasan otomatis: bila ringkasan kartu kosong, sistem mengambil ±160 karakter pertama dari konten setelah tag HTML dibuang. Kartu tidak pernah menampilkan tag HTML mentah. |
| W-09 | Editor responsif dan tetap dapat dipakai di layar tablet; tinggi awal 300 px (basic) / 500 px (full) dan dapat diubah ukurannya. |

### 4.3 Menu Artikel

Perbedaan dengan Berita: **Berita** memuat kabar kegiatan TeFa (implementasi, pelatihan, fasilitas). **Artikel** memuat tulisan edukatif/wawasan (panduan RME, regulasi, SATUSEHAT, BPJS, tips manajemen faskes) yang bertahan lama dan mendukung SEO. Keduanya dikelola terpisah.

#### Portal publik

| URL | Route name | Halaman |
|---|---|---|
| `/artikel` | `articles` | Daftar artikel terpublikasi: filter kategori, pencarian judul, paginasi 9 item |
| `/artikel/{slug}` | `articles.show` | Detail artikel |

| ID | Kebutuhan |
|---|---|
| A-01 | Menu **Artikel** ditambahkan di navbar desktop (setelah "Berita"), menu mobile, dan footer. Menu aktif disorot seperti menu lain. |
| A-02 | Kartu artikel menampilkan cover (atau placeholder bergradasi), kategori, tanggal publikasi, estimasi waktu baca, judul, ringkasan, dan "Baca Selengkapnya". Seluruh kartu dapat diklik. Desainnya mengikuti kartu Berita. |
| A-03 | Daftar diurutkan berdasarkan `published_at` terbaru. Hanya artikel berstatus *published* dengan `published_at ≤ sekarang` yang tampil. |
| A-04 | Halaman detail menampilkan breadcrumb, cover, kategori, judul, penulis, tanggal, estimasi waktu baca, isi terformat (`.rich-content`), tombol bagikan (WhatsApp, salin tautan), artikel terkait (kategori sama, maks. 3), CTA konsultasi/demo, dan tombol kembali ke daftar artikel. |
| A-05 | Slug unik dibuat otomatis dari judul (trait `HasUniqueSlug` yang sudah ada). Slug tidak dikenal, draf, atau artikel terjadwal → **404**. |
| A-06 | SEO: `<title>` = judul artikel, `<meta name="description">` = `meta_description` atau ringkasan, dan tag Open Graph (`og:title`, `og:description`, `og:image` = cover). Layout `frontend` menyediakan `@stack`/`@yield` untuk meta tanpa mengubah halaman lain. |
| A-07 | Jika belum ada artikel terpublikasi, halaman menampilkan *empty state* yang ramah, bukan halaman kosong atau error. |

#### Panel admin

| Menu | Route | Fungsi |
|---|---|---|
| Artikel | `admin.articles.*` (resource, kecuali `show`) | Daftar, tambah, edit, hapus artikel |
| Kategori Artikel | `admin.articles.categories.store` / `.destroy` | Tambah/hapus kategori (pola sama dengan kategori Berita) |
| Publikasi | `admin.articles.publish` (`PATCH`) | Ubah status draf ↔ terbit langsung dari daftar |
| Pratinjau | `admin.articles.preview` | Lihat artikel (termasuk draf) dengan tampilan portal |

| ID | Kebutuhan |
|---|---|
| A-08 | Form artikel berisi: judul\*, kategori, gambar utama/cover (G-01–G-08), ringkasan (maks. 300 karakter, teks polos), isi\* (WYSIWYG preset `full`), penulis (default nama admin yang login), status (Draf/Terbit), tanggal publikasi (default sekarang saat diterbitkan; tanggal di masa depan = terjadwal), tandai sebagai unggulan, dan meta description (opsional, maks. 160 karakter). |
| A-09 | Daftar admin menampilkan thumbnail, judul, kategori, status (badge Draf/Terbit/Terjadwal), tanggal publikasi, serta aksi Edit, Pratinjau, Terbitkan/Batalkan, Hapus. Daftar mendukung filter status & kategori, pencarian judul, dan paginasi 15 item. |
| A-10 | Hapus artikel memerlukan konfirmasi dan ikut menghapus file cover. Gambar yang disisipkan di isi tetap tersimpan (dapat dipakai artikel lain). |
| A-11 | Menu "Artikel" ditambahkan di sidebar admin di bawah "Berita". Dashboard menampilkan jumlah artikel terbit dan draf. |
| A-12 | Seeder menyediakan 3 artikel contoh terbit dan 3 kategori: *Rekam Medis Elektronik*, *Regulasi & Akreditasi*, *Integrasi SATUSEHAT & BPJS*. |

### 4.4 Gambar pada Halaman Beranda

Struktur bagian beranda tetap sama (Hero → Pengenalan → Keunggulan → Fitur → Faskes Sasaran → Paket → Layanan → Berita → Kontak). Fase ini menambahkan gambar pada bagian yang ada dan menyisipkan satu bagian baru.

| ID | Bagian | Kebutuhan |
|---|---|---|
| H-01 | **Hero** | Bila `banners.image` diisi, kolom kanan hero menampilkan gambar (mis. foto tim/layar aplikasi SIP-Kes) dalam bingkai `rounded-3xl` dengan bayangan. Satu kartu kecil ringkasan ("Mulai dari Rp 150.000/bulan") ditumpuk melayang di pojok gambar. Bila kosong, kartu ilustrasi yang sekarang tetap ditampilkan tanpa perubahan. Gambar hero tidak memakai lazy-load (`fetchpriority="high"`). |
| H-02 | **Pengenalan (Tentang SIP-Kes)** | Ditambahkan gambar pendamping di samping teks (grid 2 kolom di desktop, gambar di atas teks di mobile). Sumbernya `site_settings.home_intro_image`, dengan cadangan `profiles.image`. Bila keduanya kosong, tata letak kembali ke tampilan sekarang. |
| H-03 | **Fitur Unggulan** | Kartu fitur tetap memakai ikon (tidak berubah). Gambar fitur (G-01) hanya tampil di halaman detail agar kartu beranda tetap ringkas. |
| H-04 | **Artikel Terbaru** (bagian baru) | Ditempatkan setelah bagian Berita: 3 artikel terbaru (artikel unggulan diprioritaskan) dalam kartu bercover dan tombol "Lihat Semua Artikel". Bagian ini disembunyikan bila belum ada artikel terbit. |
| H-05 | **Admin Halaman Beranda** | Halaman `admin.home.index` ditambah input gambar Hero dan gambar Pengenalan (komponen G-06), lengkap dengan pratinjau dan opsi hapus. |
| H-06 | **Halaman lain** | Halaman `/profil`, `/keunggulan`, `/layanan-pendukung`, dan `/fitur/{slug}` menampilkan gambar masing-masing bila tersedia: `/profil` di samping bagian Tentang; `/keunggulan` sebagai header kartu; `/layanan-pendukung` sebagai gambar layanan; `/fitur/{slug}` di bawah judul. Bila gambar kosong, tampilannya sama dengan sekarang. |

---

## 5. Model Data

Semua perubahan berupa migrasi baru yang bersifat *additive*.

| Migrasi | Perubahan |
|---|---|
| `2026_11_18_000012_add_image_to_features_and_advantages` | `features.image` string nullable (setelah `icon`); `advantages.image` string nullable |
| `2026_11_18_000013_create_articles_tables` | Tabel `article_categories` dan `articles` (di bawah) |

**`article_categories`**: `id`, `name`, `slug` (unique), `timestamps`

**`articles`**

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint PK | |
| `category_id` | FK nullable → `article_categories`, `nullOnDelete` | |
| `title` | string | wajib |
| `slug` | string unique | otomatis (`HasUniqueSlug`) |
| `excerpt` | text nullable | ringkasan teks polos |
| `content` | longText | HTML hasil sanitasi |
| `cover_image` | string nullable | path disk `public` |
| `author` | string nullable | |
| `status` | enum `draft`/`published`, default `draft` | |
| `published_at` | timestamp nullable, index | |
| `is_featured` | boolean default false | |
| `meta_description` | string(160) nullable | |
| `admin_id` | FK nullable → `admins`, `nullOnDelete` | pembuat |
| `timestamps` | | |

Model `Article`: scope `published()` (`status = published` dan `published_at <= now()`), accessor `cover_url`, `reading_time` (±200 kata/menit), `excerpt_text` (W-08), dan `content_html` (W-06).

Kolom yang sudah ada dan akhirnya dipakai: `banners.image`, `profiles.image`, `support_services.image`. Key baru di `site_settings`: `home_intro_image` (group `home`).

Rollback (`down()`): drop tabel `articles` & `article_categories`, lalu drop kolom `image` di `features`/`advantages`. File gambar di storage tidak ikut dihapus.

---

## 6. Alur Penggunaan

**Admin menulis & menerbitkan artikel**
`/admin/login` → menu Artikel → "Tulis Artikel Baru" → isi judul, pilih kategori, unggah cover, tulis isi di editor (heading, list, sisip gambar) → status *Draf* → Simpan → Pratinjau → klik "Terbitkan" → artikel tampil di `/artikel`, beranda (Artikel Terbaru), dan artikel terkait.

**Admin memperbarui visual beranda**
Menu Halaman Beranda → unggah gambar Hero dan gambar Pengenalan (pratinjau langsung) → Simpan → beranda menampilkan gambar baru. Bila gambar dihapus, beranda kembali ke tampilan bawaan.

**Admin melengkapi gambar fitur/layanan**
Menu Fitur & Modul / Keunggulan / Layanan Pendukung → Edit → unggah gambar + format deskripsi di editor → Simpan → tampil di halaman detail/daftar terkait.

**Pengunjung membaca artikel**
Navbar "Artikel" atau bagian Artikel Terbaru di beranda → `/artikel` → filter kategori/cari → klik kartu → `/artikel/{slug}` → baca → artikel terkait atau CTA konsultasi.

---

## 7. Ruang Lingkup

**Termasuk**
- Komponen input gambar bersama, serta upload/ganti/hapus gambar untuk Hero, Pengenalan beranda, Profil, Fitur, Keunggulan, Layanan Pendukung, Berita, dan Artikel.
- WYSIWYG editor (TinyMCE) pada field deskripsi di §4.2, sanitasi HTML, upload gambar dalam editor, dan kompatibilitas teks lama.
- Modul Artikel lengkap (portal + admin + kategori + draf/terbit/terjadwal + seeder contoh).
- Gambar di Hero dan Pengenalan beranda, bagian Artikel Terbaru, serta tampilan gambar di halaman Profil/Keunggulan/Layanan/Detail Fitur.

**Tidak termasuk**
- Galeri/slider multi-gambar per konten, kompresi/resize otomatis, dan manajer media terpusat (kandidat fase berikutnya).
- Komentar, *like*, atau langganan newsletter artikel.
- Multi-penulis dengan peran berbeda (semua admin memiliki hak yang sama).
- Perubahan pada Paket Harga, Kontak, Faskes Sasaran, serta logika bisnis/route Fase 1.
- Aplikasi RME dalam bentuk apa pun (tetap mengikuti PRD v1.1 §8).

## 8. Kebutuhan Non-Fungsional

- **Responsif:** semua halaman dan form baru diuji pada 360 px (mobile), 768 px (tablet), dan ≥ 1280 px (desktop); tidak ada scroll horizontal. Tabel di konten artikel dibungkus `overflow-x-auto`.
- **Keamanan:** sanitasi HTML (W-04); upload hanya untuk admin terautentikasi dengan CSRF; validasi MIME tipe gambar di server; nama file acak dari Laravel (`store()`), bukan nama asli.
- **Performa:** gambar non-hero memakai lazy-load; TinyMCE hanya dimuat di halaman admin yang memiliki `.wysiwyg`; query daftar artikel memakai eager-load kategori (tanpa N+1).
- **Aksesibilitas:** semua gambar memiliki `alt`, kontras teks di atas gambar memenuhi WCAG AA, dan form memiliki label.
- **Ketahanan:** gambar hilang atau tidak valid → fallback (placeholder/ikon/tampilan lama), bukan gambar rusak.
- **Deploy:** jalankan `composer require mews/purifier`, `php artisan migrate`, `php artisan db:seed --class=ArticleSeeder`, lalu pastikan `php artisan storage:link` sudah dijalankan.

## 9. Kriteria Penerimaan

1. Admin dapat mengunggah, mengganti, dan menghapus gambar di setiap modul §4.1; file lama terhapus dari storage; file non-gambar atau > 5 MB ditolak dengan pesan jelas.
2. Field di §4.2 menampilkan editor dengan toolbar W-01; konten berformat (heading, bold, italic, list, alignment) tampil sama di portal.
3. Input `<script>alert(1)</script>`, atribut `onerror`, atau tautan `javascript:` di editor tidak tersimpan dan tidak tereksekusi di portal.
4. Konten teks polos lama (berita, fitur, profil) tetap tampil sebagai paragraf rapi tanpa diedit ulang.
5. Menu Artikel ada di navbar, mobile, dan footer; `/artikel` dan `/artikel/{slug}` berfungsi; draf/terjadwal/slug tidak dikenal → 404.
6. Admin dapat membuat, mengedit, menghapus, menyimpan draf, menerbitkan, dan membatalkan terbit artikel.
7. Beranda menampilkan gambar Hero, gambar Pengenalan, dan bagian Artikel Terbaru bila datanya ada; bila kosong, beranda tetap tampil seperti Fase 1 tanpa error.
8. Semua halaman publik dan admin merespons 200 di mobile, tablet, dan desktop tanpa scroll horizontal.
9. Test Fase 1 tetap lulus, dan test baru `tests/Feature/Phase2FeaturesTest.php` mencakup kriteria 1, 3, 4, 5, 6, dan 7 (`php artisan test`).

## 10. Rencana Implementasi (urutan disarankan)

| Tahap | Pekerjaan | Ketergantungan |
|---|---|---|
| 1 | Trait `HasImage`, komponen `<x-admin.image-input>`, helper simpan/hapus file; refactor form Berita ke komponen | — |
| 2 | Migrasi `image` di features/advantages; input gambar di Profil, Fitur, Keunggulan, Layanan, Beranda; tampilan di halaman portal terkait (H-06) | 1 |
| 3 | `mews/purifier` + konfigurasi whitelist, helper `RichText::render()`, partial editor TinyMCE, CSS `.rich-content`; terapkan ke field §4.2 | — |
| 4 | Endpoint upload gambar editor (W-05) | 1, 3 |
| 5 | Modul Artikel: migrasi, model, controller admin & portal, view, menu, seeder, meta SEO | 1, 3, 4 |
| 6 | Beranda: Hero image, gambar Pengenalan, bagian Artikel Terbaru (H-01–H-05) | 2, 5 |
| 7 | Test otomatis + uji manual responsif + perbarui `PRD-SIP-KES.md` §4 & §7 (tabel route/model) | semua |
