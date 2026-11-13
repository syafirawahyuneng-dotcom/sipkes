<?php

/*
|--------------------------------------------------------------------------
| Konten Detail Fitur & Modul SIP-Kes
|--------------------------------------------------------------------------
| Dipakai oleh migrasi 2026_11_13_000011 (mengisi data yang sudah ada) dan
| SipKesDatabaseSeeder (instalasi baru). Kunci = nama fitur pada tabel
| `features`. Setiap nilai disimpan sebagai teks satu poin per baris.
*/

return [
    'Pendaftaran' => [
        'users' => ['Petugas pendaftaran / loket', 'Petugas rekam medis'],
        'functions' => [
            'Mencatat identitas pasien baru (NIK, nama, tanggal lahir, alamat, kontak, penanggung jawab).',
            'Mencari dan memanggil data pasien lama berdasarkan nomor rekam medis, NIK, atau nama.',
            'Menentukan poli/klinik tujuan dan dokter yang dituju.',
            'Memeriksa keaktifan kartu BPJS Kesehatan pasien sebelum pelayanan.',
            'Menerbitkan nomor rekam medis unik secara otomatis.',
        ],
        'benefits' => [
            'Pendaftaran lebih cepat dan antrean loket berkurang.',
            'Mencegah duplikasi rekam medis untuk pasien yang sama.',
            'Status kepesertaan BPJS diketahui sejak awal sehingga mengurangi risiko klaim ditolak.',
        ],
        'workflow' => [
            'Petugas mencari pasien; jika belum terdaftar, isi formulir identitas pasien baru.',
            'Sistem memverifikasi keaktifan kartu BPJS (untuk pasien JKN).',
            'Petugas memilih poli dan dokter tujuan.',
            'Sistem membuat kunjungan dan nomor antrean yang diteruskan ke modul Antrian.',
        ],
    ],

    'Antrian dan Panggilan Suara' => [
        'users' => ['Petugas loket', 'Perawat / petugas poli', 'Pasien (melalui layar monitor)'],
        'functions' => [
            'Menampilkan nomor antrean aktif pada layar monitor ruang tunggu.',
            'Memanggil pasien otomatis melalui audio sesuai nomor antrean dan klinik tujuan.',
            'Mengatur antrean per loket dan per poli secara terpisah.',
            'Menandai status antrean: menunggu, dipanggil, dilayani, selesai.',
        ],
        'benefits' => [
            'Ruang tunggu lebih tertib dan pasien tidak perlu bertanya giliran.',
            'Petugas tidak perlu memanggil pasien secara manual.',
            'Waktu tunggu pasien dapat dipantau untuk evaluasi mutu pelayanan.',
        ],
        'workflow' => [
            'Pasien mendapat nomor antrean setelah pendaftaran.',
            'Petugas poli menekan tombol panggil pada antrean berikutnya.',
            'Layar monitor menampilkan nomor dan tujuan, disertai panggilan suara.',
            'Setelah pelayanan selesai, petugas menandai antrean sebagai selesai.',
        ],
    ],

    'Pemeriksaan (SO)' => [
        'users' => ['Dokter', 'Perawat', 'Bidan'],
        'functions' => [
            'Subject (S): mencatat keluhan utama, anamnesis, riwayat penyakit sekarang dan keluarga, serta riwayat alergi.',
            'Object (O): mencatat tanda vital dan pemeriksaan fisik seperti tinggi badan, berat badan, tekanan darah, nadi, suhu, dan laju napas.',
            'Menampilkan riwayat kunjungan dan pemeriksaan pasien sebelumnya.',
            'Menyimpan catatan pemeriksaan sebagai bagian rekam medis pasien.',
        ],
        'benefits' => [
            'Dokumentasi klinis terstruktur sesuai format SOAP.',
            'Riwayat pasien mudah ditelusuri pada kunjungan berikutnya.',
            'Data pemeriksaan siap dikirim ke SATUSEHAT tanpa input ulang.',
        ],
        'workflow' => [
            'Petugas memanggil pasien dari antrean poli.',
            'Perawat mengisi tanda vital (Object).',
            'Dokter mengisi keluhan dan anamnesis (Subject).',
            'Data diteruskan ke modul Diagnosa dan Tindakan (AP).',
        ],
    ],

    'Diagnosa dan Tindakan (AP)' => [
        'users' => ['Dokter', 'Dokter gigi'],
        'functions' => [
            'Assessment (A): mengisi diagnosis dan prognosis dengan pencarian kode ICD-10.',
            'Plan (P): mencatat tindakan medis (kode ICD-9-CM), injeksi, atau penggunaan alat kesehatan.',
            'Membuat resep obat yang langsung terhubung ke modul Farmasi.',
            'Mencatat rencana kontrol atau rujukan.',
        ],
        'benefits' => [
            'Kode diagnosis terstandar sehingga pelaporan dan klaim lebih akurat.',
            'Resep elektronik mengurangi salah baca tulisan tangan.',
            'Tindakan dan obat otomatis tercatat untuk perhitungan biaya di Kasir.',
        ],
        'workflow' => [
            'Dokter meninjau hasil pemeriksaan SO.',
            'Dokter memilih diagnosis ICD-10 dan mencatat prognosis.',
            'Dokter menginput tindakan dan resep obat.',
            'Resep diteruskan ke Farmasi; tindakan dan obat diteruskan ke Kasir.',
        ],
    ],

    'Farmasi' => [
        'users' => ['Apoteker', 'Tenaga teknis kefarmasian'],
        'functions' => [
            'Mencatat penerimaan obat dari pemasok.',
            'Memantau ketersediaan stok obat secara langsung.',
            'Melakukan stock opname dan mutasi obat antar gudang/unit.',
            'Menandai obat yang mendekati atau melewati tanggal kedaluwarsa.',
            'Mencatat pengeluaran obat sesuai resep dokter dan mengatur harga obat.',
        ],
        'benefits' => [
            'Stok obat terkendali sehingga mencegah kekosongan maupun penumpukan.',
            'Mengurangi kerugian akibat obat kedaluwarsa.',
            'Resep dari dokter diterima langsung tanpa salinan kertas.',
        ],
        'workflow' => [
            'Apoteker menerima resep elektronik dari modul AP.',
            'Sistem memeriksa ketersediaan stok.',
            'Obat disiapkan dan diserahkan; stok berkurang otomatis.',
            'Biaya obat tercatat di tagihan pasien pada modul Kasir.',
        ],
    ],

    'Kasir' => [
        'users' => ['Petugas kasir', 'Bagian keuangan'],
        'functions' => [
            'Menyusun tagihan otomatis dari diagnosis, tindakan, dan obat yang diberikan.',
            'Menambahkan item biaya lain yang belum tercatat pada proses pelayanan.',
            'Mencatat pembayaran tunai, non-tunai, maupun penjaminan BPJS.',
            'Mencetak kuitansi/nota pembayaran.',
        ],
        'benefits' => [
            'Perhitungan biaya cepat dan bebas salah hitung manual.',
            'Seluruh layanan yang diberikan tertagih dengan lengkap.',
            'Data pendapatan langsung masuk ke Laporan dan Dashboard.',
        ],
        'workflow' => [
            'Pasien selesai dilayani dokter dan farmasi.',
            'Kasir membuka tagihan pasien yang tersusun otomatis.',
            'Kasir menambahkan biaya lain bila ada, lalu memproses pembayaran.',
            'Sistem mencetak kuitansi dan menutup kunjungan.',
        ],
    ],

    'Rawat Inap' => [
        'users' => ['Perawat ruangan', 'Dokter penanggung jawab pasien (DPJP)', 'Petugas admisi'],
        'functions' => [
            'Mencatat pasien masuk rawat inap beserta asal rujukan.',
            'Mengatur penempatan kamar dan tempat tidur serta memantau ketersediaannya.',
            'Mencatat SOAP harian dan asuhan keperawatan selama perawatan.',
            'Memantau tindakan medis dan pemberian obat harian.',
            'Mencatat pasien pulang beserta ringkasan pulang.',
        ],
        'benefits' => [
            'Ketersediaan tempat tidur terlihat jelas.',
            'Catatan perkembangan pasien terintegrasi lintas profesi.',
            'Biaya perawatan terakumulasi otomatis hingga pasien pulang.',
        ],
        'workflow' => [
            'Pasien didaftarkan masuk rawat inap dan ditempatkan di tempat tidur kosong.',
            'Dokter dan perawat mengisi catatan SOAP dan asuhan keperawatan harian.',
            'Tindakan dan obat dicatat selama perawatan.',
            'Pasien dinyatakan pulang; tagihan diteruskan ke Kasir.',
        ],
    ],

    'Laporan' => [
        'users' => ['Pimpinan faskes', 'Petugas rekam medis', 'Bagian keuangan'],
        'functions' => [
            'Menyajikan jumlah kunjungan pasien per periode, poli, dan jenis penjamin.',
            'Menyajikan rekap layanan dan tindakan yang diberikan.',
            'Menyajikan pemakaian obat.',
            'Menyusun laporan 20 besar penyakit berdasarkan kode ICD-10.',
            'Menyajikan rekap pendapatan dengan rentang tanggal yang dapat diatur.',
        ],
        'benefits' => [
            'Laporan rutin tersedia tanpa rekap manual.',
            'Mendukung pelaporan ke dinas kesehatan dan kebutuhan akreditasi.',
            'Menjadi dasar pengambilan keputusan manajemen.',
        ],
        'workflow' => [
            'Pengguna memilih jenis laporan.',
            'Pengguna menentukan rentang tanggal dan filter.',
            'Sistem menampilkan laporan yang dapat dicetak atau diunduh.',
        ],
    ],

    'Dashboard' => [
        'users' => ['Pimpinan faskes', 'Manajer operasional'],
        'functions' => [
            'Menampilkan grafik kunjungan pasien harian dan bulanan.',
            'Menampilkan tren pendapatan klinik.',
            'Memantau jumlah antrean dan layanan yang sedang berjalan.',
            'Menampilkan ringkasan indikator utama dalam satu layar.',
        ],
        'benefits' => [
            'Kondisi operasional faskes terpantau sekilas.',
            'Tren kunjungan dan pendapatan mudah dibandingkan antarperiode.',
        ],
        'workflow' => [
            'Pengguna masuk ke sistem.',
            'Dashboard menampilkan ringkasan data terbaru.',
            'Pengguna memilih periode untuk melihat perbandingan.',
        ],
    ],

    'Cetak Kartu Berobat' => [
        'users' => ['Petugas pendaftaran', 'Pasien'],
        'functions' => [
            'Mencetak kartu berobat fisik bagi pasien baru maupun lama.',
            'Menyediakan kartu berobat digital.',
            'Memuat identitas pasien dan barcode nomor rekam medis.',
        ],
        'benefits' => [
            'Pendaftaran ulang cukup dengan memindai barcode.',
            'Mengurangi salah identifikasi pasien.',
        ],
        'workflow' => [
            'Pasien selesai didaftarkan.',
            'Petugas memilih menu cetak kartu.',
            'Kartu dicetak atau dikirim dalam bentuk digital kepada pasien.',
        ],
    ],

    'Verifikasi dengan SatuSehat Mobile' => [
        'users' => ['Petugas pendaftaran', 'Pasien'],
        'functions' => [
            'Memverifikasi identitas pasien yang terhubung dengan aplikasi SATUSEHAT Mobile Kemenkes RI.',
            'Mencocokkan data pasien dengan IHS Number (ID SATUSEHAT).',
            'Memastikan profil kesehatan pasien aktif sebelum data pelayanan dikirim.',
        ],
        'benefits' => [
            'Data yang dikirim ke SATUSEHAT terhubung ke pasien yang benar.',
            'Mengurangi kegagalan pengiriman data akibat identitas tidak cocok.',
        ],
        'workflow' => [
            'Pasien menunjukkan SATUSEHAT Mobile atau memberikan NIK.',
            'Petugas melakukan verifikasi melalui sistem.',
            'Sistem menyimpan IHS Number pasien pada rekam medis.',
        ],
    ],

    'Asuhan Keperawatan' => [
        'users' => ['Perawat', 'Kepala ruangan'],
        'functions' => [
            'Mencatat pengkajian awal keperawatan.',
            'Merumuskan diagnosis keperawatan terstandar (SDKI).',
            'Menyusun luaran (SLKI) dan intervensi keperawatan (SIKI).',
            'Mencatat implementasi tindakan keperawatan.',
            'Mengisi evaluasi harian perkembangan pasien.',
        ],
        'benefits' => [
            'Dokumentasi keperawatan lengkap dan sesuai standar PPNI.',
            'Mendukung penilaian akreditasi pada aspek pelayanan keperawatan.',
            'Kesinambungan asuhan antar-shift lebih terjaga.',
        ],
        'workflow' => [
            'Perawat melakukan pengkajian awal pasien.',
            'Perawat memilih diagnosis keperawatan serta luaran dan intervensi.',
            'Perawat mencatat tindakan yang dilakukan.',
            'Perawat mengisi evaluasi pada akhir shift atau hari perawatan.',
        ],
    ],

    'Pengaturan Integrasi SatuSehat dan BPJS Kesehatan' => [
        'users' => ['Administrator sistem faskes', 'Tim IT / pendamping TeFa V-Kes'],
        'functions' => [
            'Menyimpan kredensial SATUSEHAT: Organization ID, Client ID, dan Client Secret.',
            'Menyimpan kredensial bridging BPJS Kesehatan (PCare).',
            'Memilih lingkungan uji (sandbox) atau produksi.',
            'Menguji dan memantau status koneksi secara langsung.',
        ],
        'benefits' => [
            'Faskes dapat mengatur integrasi secara mandiri.',
            'Gangguan koneksi cepat terdeteksi.',
            'Data pelayanan terkirim otomatis tanpa input ganda ke aplikasi lain.',
        ],
        'workflow' => [
            'Administrator mengisi kredensial dari portal SATUSEHAT dan BPJS.',
            'Administrator menjalankan uji koneksi.',
            'Setelah berhasil, sistem mengirim data pelayanan secara otomatis.',
        ],
    ],

    'Odontogram pada Klinik Gigi' => [
        'users' => ['Dokter gigi', 'Perawat gigi / terapis gigi dan mulut'],
        'functions' => [
            'Menampilkan diagram odontogram visual untuk gigi permanen dan gigi sulung.',
            'Mencatat kondisi tiap gigi: karies, tambalan/restorasi, gigi hilang, pencabutan, dan lain-lain.',
            'Mencatat rencana perawatan per gigi.',
            'Menyimpan riwayat perubahan kondisi gigi antar kunjungan.',
        ],
        'benefits' => [
            'Pencatatan gigi sesuai standar rekam medis kedokteran gigi.',
            'Kondisi gigi pasien mudah dijelaskan secara visual.',
            'Perkembangan perawatan gigi dapat dibandingkan dari waktu ke waktu.',
        ],
        'workflow' => [
            'Dokter gigi membuka odontogram pasien.',
            'Dokter memilih gigi dan menandai kondisinya.',
            'Dokter mencatat tindakan dan rencana perawatan.',
            'Odontogram tersimpan sebagai bagian rekam medis.',
        ],
    ],

    'General Consent' => [
        'users' => ['Petugas pendaftaran', 'Pasien / keluarga penanggung jawab'],
        'functions' => [
            'Menyediakan formulir persetujuan umum pelayanan secara elektronik.',
            'Merekam tanda tangan digital pasien atau penanggung jawab.',
            'Mengarsipkan dokumen persetujuan pada rekam medis pasien.',
        ],
        'benefits' => [
            'Mengurangi penggunaan dan penyimpanan kertas.',
            'Dokumen persetujuan mudah ditemukan saat dibutuhkan.',
            'Memenuhi standar hak pasien dan aspek hukum pelayanan kesehatan.',
        ],
        'workflow' => [
            'Petugas menampilkan formulir general consent kepada pasien.',
            'Pasien atau keluarga membaca dan menandatangani secara digital.',
            'Dokumen tersimpan otomatis di rekam medis.',
        ],
    ],

    'Informed Consent' => [
        'users' => ['Dokter', 'Pasien / wali'],
        'functions' => [
            'Menyediakan formulir persetujuan tindakan kedokteran.',
            'Mencatat penjelasan tindakan: indikasi, tata cara, risiko, komplikasi, dan alternatif.',
            'Merekam persetujuan atau penolakan pasien/wali dengan tanda tangan digital.',
            'Merekam tanda tangan dokter penanggung jawab dan saksi.',
        ],
        'benefits' => [
            'Memberikan perlindungan hukum bagi pasien dan tenaga medis.',
            'Bukti bahwa penjelasan tindakan telah diberikan terdokumentasi dengan baik.',
        ],
        'workflow' => [
            'Dokter menjelaskan rencana tindakan kepada pasien.',
            'Dokter mengisi rincian penjelasan pada formulir.',
            'Pasien/wali menyatakan setuju atau menolak dan menandatangani.',
            'Dokumen tersimpan dan dapat dicetak.',
        ],
    ],

    'Surat Sehat & Surat Sakit' => [
        'users' => ['Dokter', 'Petugas administrasi'],
        'functions' => [
            'Menerbitkan surat keterangan sehat.',
            'Menerbitkan surat keterangan sakit beserta lama istirahat.',
            'Menerbitkan surat rujukan.',
            'Mencetak surat dengan format terstandar dan barcode verifikasi.',
        ],
        'benefits' => [
            'Surat diterbitkan cepat dengan data pasien yang terisi otomatis.',
            'Keaslian surat dapat diverifikasi melalui barcode.',
            'Arsip surat tersimpan rapi di rekam medis.',
        ],
        'workflow' => [
            'Dokter memilih jenis surat setelah pemeriksaan.',
            'Sistem mengisi data pasien dan hasil pemeriksaan.',
            'Dokter melengkapi keterangan lalu menyetujui surat.',
            'Surat dicetak atau diberikan dalam bentuk digital.',
        ],
    ],

    'Laboratorium' => [
        'users' => ['Analis / ahli teknologi laboratorium medik', 'Dokter'],
        'functions' => [
            'Menerima permintaan pemeriksaan laboratorium dari dokter.',
            'Mencatat hasil uji parameter darah, urine, dan spesimen lainnya.',
            'Menampilkan nilai rujukan (normal) dan menandai hasil di luar batas.',
            'Mencetak lembar hasil laboratorium.',
        ],
        'benefits' => [
            'Hasil pemeriksaan langsung dapat dilihat dokter di rekam medis.',
            'Mengurangi kesalahan penyalinan hasil.',
            'Biaya pemeriksaan otomatis masuk ke tagihan pasien.',
        ],
        'workflow' => [
            'Dokter membuat permintaan pemeriksaan laboratorium.',
            'Petugas laboratorium mengambil dan memeriksa spesimen.',
            'Petugas menginput hasil pemeriksaan.',
            'Dokter meninjau hasil; lembar hasil dicetak bila diperlukan.',
        ],
    ],

    'Sedasi' => [
        'users' => ['Dokter', 'Dokter anestesi / penata anestesi', 'Perawat'],
        'functions' => [
            'Mencatat asesmen pra-sedasi.',
            'Memantau tanda vital dan tingkat sedasi selama tindakan (intra-sedasi).',
            'Mencatat pemulihan pasca-sedasi menggunakan skor pemulihan (misalnya skor Aldrete).',
            'Mencatat obat sedasi beserta dosis dan waktu pemberian.',
        ],
        'benefits' => [
            'Mendukung keselamatan pasien selama prosedur.',
            'Dokumentasi tindakan sedasi lengkap untuk kebutuhan audit dan akreditasi.',
            'Kelayakan pasien untuk dipindahkan atau dipulangkan dinilai secara objektif.',
        ],
        'workflow' => [
            'Petugas mengisi asesmen pra-sedasi.',
            'Selama tindakan, tanda vital dicatat berkala.',
            'Setelah tindakan, skor pemulihan dicatat hingga memenuhi kriteria.',
            'Pasien dipindahkan atau dipulangkan sesuai hasil penilaian.',
        ],
    ],

    'Dan lain-lain' => [
        'users' => ['Seluruh unit fasilitas pelayanan kesehatan'],
        'functions' => [
            'Pengelolaan data master: poli, dokter, tenaga kesehatan, tarif, dan pengguna.',
            'Pengaturan hak akses pengguna sesuai peran.',
            'Pengembangan modul tambahan sesuai kebutuhan mitra faskes dan regulasi terbaru.',
        ],
        'benefits' => [
            'Sistem dapat disesuaikan dengan alur kerja setiap faskes.',
            'Mengikuti perkembangan regulasi Kemenkes tanpa perlu berganti aplikasi.',
        ],
        'workflow' => [
            'Faskes menyampaikan kebutuhan kepada tim TeFa V-Kes.',
            'Tim menganalisis dan mengembangkan modul.',
            'Modul diuji, diaktifkan, dan staf faskes mendapatkan pelatihan.',
        ],
    ],
];
