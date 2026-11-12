@extends('layouts.frontend')

@section('title', 'Profil TeFa Inovasi Kesehatan & SIP-Kes | Politeknik Negeri Jember')

@section('content')

<!-- Header Banner -->
<section class="bg-primary-900 text-white py-16 px-4">
    <div class="max-w-7xl mx-auto text-center">
        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-primary-800 text-sky-300 mb-3">Tentang Kami</span>
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight">Profil Teaching Factory & SIP-Kes</h1>
        <p class="text-primary-200 text-sm sm:text-base max-w-2xl mx-auto mt-2">
            Mengenal lebih dekat unit inovasi akademik rekam medis vokasional Jurusan Kesehatan Politeknik Negeri Jember.
        </p>
    </div>
</section>

<!-- Content Body -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
        
        <!-- Block 1: TeFa V-Kes Polije -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-7 space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-sky-100 text-sky-800">
                    <i class="fa-solid fa-building-columns"></i> Unit Usaha Akademik
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Teaching Factory Inovasi Kesehatan (TeFa V-Kes)</h2>
                <p class="text-slate-600 text-sm sm:text-base leading-relaxed text-justify">
                    {{ $profile->about_tefa ?? 'Teaching Factory Inovasi Kesehatan (TeFa V-Kes) merupakan wadah pembelajaran berbasis industri dan unit usaha riset terapan di bawah naungan Program Studi Manajemen Informasi Kesehatan, Jurusan Kesehatan, Politeknik Negeri Jember. TeFa V-Kes menjembatani kompetensi akademik mahasiswa dan dosen vokasi dengan kebutuhan riil transformasi digital fasilitas pelayanan kesehatan di Indonesia.' }}
                </p>
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-primary-100 text-primary-700 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-graduation-cap text-lg"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm">Politeknik Negeri Jember</h4>
                        <p class="text-xs text-slate-500">Perguruan tinggi vokasi terkemuka penghasil inovasi teknologi terapan dan sumber daya manusia kesehatan yang kompeten dan tersertifikasi.</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 bg-gradient-to-tr from-primary-800 to-sky-600 rounded-3xl p-8 text-white shadow-xl space-y-6">
                <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center text-3xl">
                    <i class="fa-solid fa-hospital-user"></i>
                </div>
                <h3 class="text-xl font-bold">Fokus Utama TeFa V-Kes</h3>
                <ul class="space-y-3 text-xs sm:text-sm text-primary-100">
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-check text-sky-300 mt-1"></i>
                        <span>Pengembangan Rekam Medis Elektronik (RME) patuh regulasi Kemenkes.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-check text-sky-300 mt-1"></i>
                        <span>Bridging integrasi API SATUSEHAT & PCare BPJS Kesehatan.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-check text-sky-300 mt-1"></i>
                        <span>Pelatihan & pendampingan SDM faskes menuju Paperless Clinic.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-check text-sky-300 mt-1"></i>
                        <span>Konsultasi tata kelola rekam medis & persiapan akreditasi faskes.</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Block 2: Latar Belakang & Tujuan SIP-Kes -->
        <div class="bg-slate-50 rounded-3xl p-8 sm:p-12 border border-slate-200">
            <div class="max-w-3xl mb-8">
                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-primary-100 text-primary-800 mb-3">Latar Belakang & Tujuan</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Mengapa SIP-Kes Dikembangkan?</h2>
                <p class="text-slate-600 text-sm sm:text-base mt-2 text-justify">
                    {{ $profile->background ?? 'Sejak diberlakukannya Peraturan Menteri Kesehatan (PMK) No. 24 Tahun 2022, setiap fasilitas pelayanan kesehatan wajib menyelenggarakan rekam medis secara elektronik dan terhubung dengan platform SATUSEHAT. Banyak klinik mandiri dan pratama mengalami kendala biaya lisensi yang sangat mahal serta kerumitan teknis bridging. TeFa V-Kes Polije merancang SIP-Kes sebagai solusi yang terjangkau, legal, dan didukung pendampingan penuh.' }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-lg mb-4">
                        <i class="fa-solid fa-scale-balanced"></i>
                    </div>
                    <h4 class="font-bold text-slate-800 text-base mb-2">Kepatuhan Regulasi</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Menjamin faskes Anda mematuhi standar interoperabilitas Kemenkes RI dan terhindar dari sanksi administratif keterlambatan RME.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-lg mb-4">
                        <i class="fa-solid fa-stopwatch"></i>
                    </div>
                    <h4 class="font-bold text-slate-800 text-base mb-2">Efisiensi Pelayanan</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Mengurangi waktu tunggu pasien, mempercepat pencarian riwayat medis pasien, dan menghapus tumpukan map rekam medis kertas.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg mb-4">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h4 class="font-bold text-slate-800 text-base mb-2">Akurasi & Transparansi</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Pencatatan kasir, persediaan obat apotek, dan pelaporan penyakit (morbiditas) tersaji akurat dan otomatis dalam satu klik.</p>
                </div>
            </div>
        </div>

        <!-- Block 3: Visi & Misi -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center text-xl mb-4">
                    <i class="fa-solid fa-eye"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Visi Kami</h3>
                <p class="text-slate-600 text-sm leading-relaxed text-justify">
                    {{ $profile->vision ?? 'Menjadi pusat inovasi dan rujukan nasional dalam pengembangan teknologi informasi kesehatan vokasional yang adaptif, terintegrasi, dan berdampak nyata bagi faskes di Indonesia.' }}
                </p>
            </div>

            <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-xl mb-4">
                    <i class="fa-solid fa-bullseye"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Misi Kami</h3>
                <div class="text-slate-600 text-sm leading-relaxed whitespace-pre-line text-justify">
                    {{ $profile->mission ?? "1. Mengembangkan sistem informasi pelayanan kesehatan yang patuh regulasi Kemenkes dan BPJS.\n2. Memberikan layanan pendampingan transisi digital, bridging SATUSEHAT, dan akreditasi klinik.\n3. Mewadahi kolaborasi riset terapan antara dosen, mahasiswa terampil vokasi, dan fasyankes mitra." }}
                </div>
            </div>
        </div>

    </div>
</section>

@endsection

