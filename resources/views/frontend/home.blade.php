@extends('layouts.frontend')

@section('title', 'SIP-Kes - Sistem Informasi Pelayanan Kesehatan TeFa V-Kes Polije')

@section('content')

<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-b from-primary-50/70 via-white to-white py-16 lg:py-24 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left Hero Content -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                @if($banner && $banner->badge)
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-sky-100 text-primary-800 border border-sky-200 shadow-sm">
                    <span class="flex h-2 w-2 rounded-full bg-primary-600 animate-pulse"></span>
                    {{ $banner->badge }}
                </div>
                @else
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-sky-100 text-primary-800 border border-sky-200 shadow-sm">
                    <span class="flex h-2 w-2 rounded-full bg-primary-600 animate-pulse"></span>
                    🏥 Portal Resmi SIP-Kes • TeFa V-Kes Polije
                </div>
                @endif

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                    {{ $banner->title ?? 'Solusi Rekam Medis Elektronik & Bridging SATUSEHAT untuk Faskes Anda' }}
                </h1>

                <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    {{ $banner->subtitle ?? 'SIP-Kes menghadirkan integrasi SATUSEHAT Kemenkes & BPJS Kesehatan secara cepat, aman, dan mudah digunakan untuk Praktik Mandiri, Klinik, hingga Puskesmas.' }}
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-wrap justify-center lg:justify-start gap-4 pt-2">
                    <a href="{{ route('features') }}" class="px-6 py-3.5 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl shadow-lg shadow-primary-600/30 transition flex items-center gap-2">
                        <i class="fa-solid fa-list-check"></i> {{ $banner->primary_btn_text ?? 'Lihat Fitur Lengkap' }}
                    </a>
                    <a href="{{ route('contact') }}" class="px-6 py-3.5 bg-white hover:bg-slate-50 text-slate-800 font-bold rounded-xl border border-slate-200 shadow-sm transition flex items-center gap-2">
                        <i class="fa-solid fa-calendar-check text-primary-600"></i> {{ $banner->secondary_btn_text ?? 'Konsultasi & Demo' }}
                    </a>
                </div>

                <!-- Key Badges -->
                <div class="pt-6 border-t border-slate-100 grid grid-cols-3 gap-4 text-center sm:text-left">
                    <div>
                        <div class="text-2xl font-black text-primary-700">100%</div>
                        <div class="text-xs text-slate-500 font-medium">Patuh PMK 24/2022</div>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-primary-700">SATUSEHAT</div>
                        <div class="text-xs text-slate-500 font-medium">Bridging Resmi Kemenkes</div>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-primary-700">BPJS</div>
                        <div class="text-xs text-slate-500 font-medium">Koneksi PCare Siap Pakai</div>
                    </div>
                </div>
            </div>

            <!-- Right Hero Card / Visual Preview -->
            <div class="lg:col-span-5">
                <div class="relative mx-auto max-w-md lg:max-w-none">
                    <div class="relative bg-white rounded-2xl shadow-2xl border border-slate-100 p-6 sm:p-8 space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-primary-100 text-primary-700 flex items-center justify-center font-bold">
                                    <i class="fa-solid fa-shield-halved text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm">SIP-Kes Cloud Ecosystem</h4>
                                    <p class="text-[11px] text-slate-500">Teaching Factory Inovasi Kesehatan</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5 animate-ping"></span> Live Active
                            </span>
                        </div>

                        <!-- Micro Feature List in Hero -->
                        <div class="space-y-3.5">
                            <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                                <div class="w-8 h-8 rounded-lg bg-sky-500 text-white flex items-center justify-center text-sm shrink-0 mt-0.5">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-800">Bridging Otomatis SATUSEHAT</p>
                                    <p class="text-[11px] text-slate-500">Kirim data encounter, diagnosis ICD-10 & obat tanpa input ganda.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                                <div class="w-8 h-8 rounded-lg bg-indigo-500 text-white flex items-center justify-center text-sm shrink-0 mt-0.5">
                                    <i class="fa-solid fa-id-card-clip"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-800">Antrian Suara & Pendaftaran</p>
                                    <p class="text-[11px] text-slate-500">Panggilan audio nomor antrian loket & cetak kartu berobat QR.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                                <div class="w-8 h-8 rounded-lg bg-teal-500 text-white flex items-center justify-center text-sm shrink-0 mt-0.5">
                                    <i class="fa-solid fa-tooth"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-800">Modul Odontogram Gigi</p>
                                    <p class="text-[11px] text-slate-500">Diagram odontogram visual standar rekam medis klinik gigi.</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-primary-900 rounded-xl p-4 text-white flex items-center justify-between">
                            <div>
                                <p class="text-xs text-primary-200">Mulai Langganan Dari</p>
                                <p class="text-lg font-black text-white">Rp 150.000 <span class="text-xs font-normal text-primary-200">/ bulan</span></p>
                            </div>
                            <a href="{{ route('pricing') }}" class="px-3.5 py-1.5 bg-sky-500 hover:bg-sky-400 text-white rounded-lg text-xs font-bold transition">
                                Lihat Paket
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Section: Pengenalan SIP-Kes & TeFa V-Kes -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <div class="lg:col-span-6 space-y-6">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-primary-100 text-primary-800">
                    <i class="fa-solid fa-circle-info"></i> Tentang SIP-Kes & TeFa V-Kes
                </div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight leading-snug">
                    Dilahirkan dari Riset Terapan & Inovasi Akademik Politeknik Negeri Jember
                </h2>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed text-justify">
                    {{ $profile->about_tefa ?? 'Teaching Factory Inovasi Kesehatan (TeFa V-Kes) merupakan unit usaha dan inovasi akademik di bawah Jurusan Kesehatan Politeknik Negeri Jember yang berfokus pada digitalisasi rekam medis faskes.' }}
                </p>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed text-justify">
                    {{ $profile->about_sipkes ?? 'SIP-Kes (Sistem Informasi Pelayanan Kesehatan) hadir menjawab kendala faskes seperti mahalnya software RME komersial dan rumitnya proses bridging SATUSEHAT Kemenkes RI.' }}
                </p>

                <div class="pt-2">
                    <a href="{{ route('profile') }}" class="inline-flex items-center gap-2 text-sm font-bold text-primary-700 hover:text-primary-800 transition">
                        Pelajari Profil Selengkapnya <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:border-primary-200 transition">
                        <div class="w-12 h-12 rounded-xl bg-primary-100 text-primary-700 flex items-center justify-center text-xl mb-4">
                            <i class="fa-solid fa-award"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 mb-1">Berstandar Vokasi</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">Dikembangkan oleh dosen dan praktisi Manajemen Informasi Kesehatan Polije yang menguasai kaidah rekam medis.</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:border-primary-200 transition">
                        <div class="w-12 h-12 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center text-xl mb-4">
                            <i class="fa-solid fa-handshake-angle"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 mb-1">Pendampingan Penuh</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">Faskes Anda tidak dilepas sendirian. Kami dampingi pelatihan SDM, migrasi data, hingga simulasi bridging.</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:border-primary-200 transition">
                        <div class="w-12 h-12 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center text-xl mb-4">
                            <i class="fa-solid fa-laptop-code"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 mb-1">Web-Based Cloud</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">Tanpa instalasi server lokal yang mahal. Cukup buka browser di laptop/PC dan faskes langsung online.</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:border-primary-200 transition">
                        <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center text-xl mb-4">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 mb-1">Keamanan Data Pasien</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">Enkripsi database berstandar tinggi dan pembatasan hak akses berjenjang (Role-Based Access Control).</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Section: 6 Keunggulan SIP-Kes -->
<section class="py-16 bg-slate-50 border-y border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-14">
            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-primary-100 text-primary-800 mb-3">Nilai Tambah Terbaik</span>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Keunggulan Utama SIP-Kes</h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3">Mengapa ratusan tenaga medis dan fasilitas kesehatan mempercayakan digitalisasi rekam medis kepada SIP-Kes?</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($advantages as $adv)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition hover:-translate-y-1">
                <div class="w-12 h-12 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center text-xl mb-4">
                    <i class="fa-solid {{ $adv->icon ?? 'fa-check' }}"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">{{ $adv->title }}</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">{{ $adv->description }}</p>
            </div>
            @empty
            <div class="col-span-3 text-center py-6 text-slate-400">Data keunggulan sedang dimuat...</div>
            @endforelse
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('advantages') }}" class="inline-flex items-center gap-2 text-sm font-bold text-primary-700 hover:text-primary-800 transition">
                Lihat Rincian Seluruh Keunggulan <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- Section: Fitur Unggulan (Berdasarkan Proposal) -->
<section id="fitur" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div class="max-w-2xl">
                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-sky-100 text-sky-800 mb-3">Fitur Lengkap Sesuai Regulasi</span>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Modul & Fitur Terintegrasi SIP-Kes</h2>
                <p class="text-slate-600 text-sm sm:text-base mt-2">Mulai dari loket pendaftaran, ruang pemeriksaan medis, farmasi, kasir, hingga bridging SATUSEHAT Kemenkes RI.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('features') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary-50 text-primary-700 hover:bg-primary-100 text-sm font-bold transition">
                    Lihat Semua {{ count($allFeatures) }} Fitur <i class="fa-solid fa-chevron-right text-xs"></i>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($featuredFeatures as $feat)
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:border-primary-400 hover:shadow-md transition group flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-11 h-11 rounded-xl bg-slate-50 text-primary-700 group-hover:bg-primary-600 group-hover:text-white flex items-center justify-center text-lg transition duration-300">
                            <i class="fa-solid {{ $feat->icon ?? 'fa-circle-dot' }}"></i>
                        </div>
                        <span class="inline-flex items-center gap-1 text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Live</span>
                        </span>
                    </div>
                    <h3 class="font-bold text-slate-800 text-sm mb-2 group-hover:text-primary-700 transition">{{ $feat->name }}</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">{{ Str::limit($feat->description, 100) }}</p>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100">
                    <a href="{{ $feat->route_url }}" class="inline-flex items-center justify-between w-full text-xs font-bold text-primary-600 group-hover:text-primary-700">
                        <span>Gunakan Modul</span>
                        <i class="fa-solid fa-arrow-right text-[10px] transition-transform group-hover:translate-x-1"></i>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-4 text-center py-8 text-slate-400">Daftar fitur sedang disiapkan.</div>
            @endforelse
        </div>
    </div>
</section>

<!-- Section: Fasilitas Kesehatan yang Didukung -->
<section class="py-16 bg-slate-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-white/10 text-sky-300 mb-3">Fleksibel & Teruji</span>
            <h2 class="text-3xl font-extrabold text-white tracking-tight">Fasilitas Kesehatan yang Dapat Menggunakan SIP-Kes</h2>
            <p class="text-slate-400 text-sm sm:text-base mt-2">Didesain adaptif untuk berbagai skala fasyankes tingkat pertama maupun penunjang mandiri.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($facilities as $fac)
            <div class="bg-slate-800/80 rounded-2xl p-6 border border-slate-700 hover:border-sky-500/50 transition">
                <div class="w-12 h-12 rounded-xl bg-sky-500/20 text-sky-400 flex items-center justify-center text-2xl mb-4">
                    <i class="fa-solid {{ $fac->icon ?? 'fa-hospital' }}"></i>
                </div>
                <h3 class="text-base font-bold text-white mb-2">{{ $fac->name }}</h3>
                <p class="text-xs text-slate-400 leading-relaxed">{{ $fac->description }}</p>
            </div>
            @empty
            <!-- Static fallback if DB empty -->
            <div class="bg-slate-800/80 rounded-2xl p-6 border border-slate-700">
                <h3 class="font-bold text-white mb-1">Praktik Dokter Mandiri</h3>
                <p class="text-xs text-slate-400">Dokter Umum, Gigi, dan Spesialis.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Section: Pilihan Paket Harga (3 Paket Sesuai Proposal) -->
<section id="harga" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-14">
            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-primary-100 text-primary-800 mb-3">Investasi Terjangkau Faskes</span>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Pilihan Paket Berlangganan SIP-Kes</h2>
            <p class="text-slate-600 text-sm sm:text-base mt-2">Transparan, tanpa biaya lisensi server mahal, dan sudah termasuk update regulasi Kemenkes RI.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @forelse($pricingPlans as $plan)
            <div class="relative bg-white rounded-3xl p-8 border {{ str_contains($plan->slug, 'klinik-pratama') ? 'border-primary-500 shadow-xl ring-2 ring-primary-500/20' : 'border-slate-200 shadow-sm' }} flex flex-col justify-between">
                @if($plan->badge)
                <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full text-xs font-black uppercase tracking-wider {{ str_contains($plan->slug, 'klinik-pratama') ? 'bg-primary-600 text-white' : 'bg-slate-800 text-white' }} shadow-md">
                    {{ $plan->badge }}
                </div>
                @endif

                <div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $plan->name }}</h3>
                    <p class="text-xs text-slate-500 mb-6">{{ $plan->description }}</p>

                    <div class="mb-6 pb-6 border-b border-slate-100">
                        <span class="text-3xl sm:text-4xl font-black text-slate-900">Rp {{ number_format($plan->price, 0, ',', '.') }}</span>
                        <span class="text-xs text-slate-500 font-medium">/ {{ $plan->period }}</span>
                    </div>

                    <p class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">Fitur Termasuk:</p>
                    <ul class="space-y-2.5 text-xs text-slate-600 mb-8">
                        @if(is_array($plan->features_list))
                            @foreach($plan->features_list as $fItem)
                            <li class="flex items-start gap-2.5">
                                <i class="fa-solid fa-check text-green-500 mt-0.5"></i>
                                <span>{{ $fItem }}</span>
                            </li>
                            @endforeach
                        @endif
                    </ul>
                </div>

                <div>
                    <a href="https://wa.me/6281335512803?text=Halo%20TeFa%20V-Kes,%20saya%20tertarik%20dengan%20Paket%20{{ urlencode($plan->name) }}" target="_blank" class="w-full block text-center py-3 px-4 rounded-xl font-bold text-xs sm:text-sm {{ str_contains($plan->slug, 'klinik-pratama') ? 'bg-primary-600 hover:bg-primary-700 text-white shadow-md shadow-primary-600/30' : 'bg-slate-100 hover:bg-slate-200 text-slate-800' }} transition">
                        Pilih Paket Ini
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-8 text-slate-400">Paket harga sedang dimuat.</div>
            @endforelse
        </div>

        <div class="mt-12 bg-slate-50 rounded-2xl p-6 border border-slate-200 text-center text-xs text-slate-600 max-w-4xl mx-auto space-y-1">
            <p class="font-bold text-slate-800">Catatan Ketentuan Layanan:</p>
            <p>1. Biaya langganan mencakup pemeliharaan sistem, cloud database, dan pembaruan format data SATUSEHAT Kemenkes RI.</p>
            <p>2. Disediakan pelatihan tatap muka (onsite) maupun daring (online) hingga tenaga faskes dapat menggunakan sistem secara mandiri.</p>
        </div>
    </div>
</section>

<!-- Section: Layanan Pendukung (Pendampingan Klaim BPJS & Akreditasi) -->
<section class="py-16 bg-slate-50 border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-teal-100 text-teal-800 mb-3">Lebih Dari Sekadar Aplikasi</span>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Layanan Pendukung Faskes</h2>
            <p class="text-slate-600 text-sm sm:text-base mt-2">Dukungan komprehensif dari tim akademisi dan praktisi rekam medis Politeknik Negeri Jember.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($supportServices as $srv)
            <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-primary-50 text-primary-600 flex items-center justify-center text-2xl mb-6">
                        <i class="fa-solid {{ $srv->icon ?? 'fa-hands-holding-circle' }}"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">{{ $srv->title }}</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-6">{{ $srv->summary }}</p>

                    <div class="space-y-2 mb-6">
                        @if(is_array($srv->benefits))
                            @foreach($srv->benefits as $b)
                            <div class="flex items-start gap-2.5 text-xs text-slate-600">
                                <i class="fa-solid fa-circle-check text-teal-600 mt-0.5"></i>
                                <span>{{ $b }}</span>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <a href="{{ route('support.services') }}" class="text-xs font-bold text-primary-700 hover:text-primary-800 transition inline-flex items-center gap-1.5">
                        Pelajari Rincian Layanan <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-2 text-center text-slate-400 py-6">Layanan pendukung sedang dimuat...</div>
            @endforelse
        </div>
    </div>
</section>

<!-- Section: Cuplikan Galeri & Dokumentasi -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div>
                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-primary-100 text-primary-800 mb-3">Dokumentasi & Aktivitas</span>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Galeri Kegiatan TeFa V-Kes</h2>
                <p class="text-slate-600 text-sm sm:text-base mt-2">Dokumentasi sosialisasi, pelatihan faskes, serta fasilitas laboratorium rekam medis di Polije.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('gallery') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-sm font-bold transition">
                    Lihat Seluruh Foto <i class="fa-solid fa-images"></i>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($galleries as $g)
            <div class="group relative rounded-2xl overflow-hidden border border-slate-100 bg-slate-50 shadow-sm hover:shadow-md transition">
                <div class="h-44 bg-slate-100 overflow-hidden relative flex items-center justify-center">
                    @if($g->hasValidImage())
                        <img src="{{ $g->image_url }}" alt="{{ $g->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                        <div class="w-full h-full bg-gradient-to-tr from-primary-800 to-sky-600 flex items-center justify-center text-white">
                            <i class="fa-solid fa-camera text-4xl text-white/40 group-hover:scale-110 transition duration-300"></i>
                        </div>
                    @endif
                    <span class="absolute top-3 left-3 px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-black/60 text-white backdrop-blur-xs">
                        {{ $g->category->name ?? 'Kegiatan' }}
                    </span>
                </div>
                <div class="p-4">
                    <h4 class="font-bold text-slate-800 text-sm mb-1 line-clamp-1">{{ $g->title }}</h4>
                    <p class="text-xs text-slate-500 line-clamp-2">{{ $g->description }}</p>
                </div>
            </div>
            @empty
            <div class="col-span-4 text-center py-8 text-slate-400">Foto dokumentasi sedang diperbarui.</div>
            @endforelse
        </div>
    </div>
</section>

<!-- Section: Informasi Kontak Faskes -->
<section id="kontak" class="py-16 bg-slate-50 border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <!-- Left Info -->
            <div class="lg:col-span-5 space-y-6">
                <div>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-primary-100 text-primary-800 mb-3">Hubungi Tim Kami</span>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Konsultasikan Kebutuhan RME Faskes Anda</h2>
                    <p class="text-slate-600 text-sm sm:text-base mt-2">Tim Teaching Factory Inovasi Kesehatan siap membantu faskes Anda mulai dari tahap demo, bridging, hingga implementasi tuntas.</p>
                </div>

                <div class="space-y-4">
                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-white border border-slate-200">
                        <div class="w-10 h-10 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Telepon / WhatsApp Resmi</p>
                            <p class="text-sm font-bold text-slate-800">{{ $contact->phone ?? '0813-3551-2803' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-white border border-slate-200">
                        <div class="w-10 h-10 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Email Korespondensi</p>
                            <p class="text-sm font-bold text-slate-800">{{ $contact->email ?? 'vkes@polije.ac.id' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-white border border-slate-200">
                        <div class="w-10 h-10 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center shrink-0">
                            <i class="fa-brands fa-instagram"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Instagram Resmi</p>
                            <p class="text-sm font-bold text-slate-800">{{ $contact->instagram ?? '@sipkes.co.id' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-white border border-slate-200">
                        <div class="w-10 h-10 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Alamat Sekretariat</p>
                            <p class="text-xs sm:text-sm font-medium text-slate-700 leading-relaxed">{{ $contact->address ?? 'Jurusan Kesehatan, Program Studi Manajemen Informasi Kesehatan, Politeknik Negeri Jember, Jalan Mastrip 164, Jember.' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Form -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Formulir Permintaan Demo & Penawaran</h3>
                    <p class="text-xs text-slate-500 mb-6">Kirimkan data faskes Anda, kami akan segera merespons dalam waktu 1x24 jam kerja.</p>

                    @if(session('success'))
                    <div class="p-4 mb-6 rounded-xl bg-green-50 border border-green-200 text-green-800 text-xs sm:text-sm flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-green-600 text-lg"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    @endif

                    <form action="{{ route('contact.send') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Penanggung Jawab *</label>
                                <input type="text" name="name" required class="w-full text-xs sm:text-sm px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="dr. / Bpk / Ibu...">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Email Aktif *</label>
                                <input type="email" name="email" required class="w-full text-xs sm:text-sm px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="nama@faskes.com">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">No. WhatsApp / HP *</label>
                                <input type="text" name="phone" class="w-full text-xs sm:text-sm px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="08xxxxxxxxxx">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Klinik / Praktik Mandiri</label>
                                <input type="text" name="faskes_name" class="w-full text-xs sm:text-sm px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Klinik Pratama Sehat...">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Kebutuhan / Subjek *</label>
                            <input type="text" name="subject" required class="w-full text-xs sm:text-sm px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Permintaan Demo Sistem / Konsultasi Bridging SATUSEHAT">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Pesan Tambahan *</label>
                            <textarea name="message" rows="4" required class="w-full text-xs sm:text-sm px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Jelaskan kebutuhan spesifik faskes Anda..."></textarea>
                        </div>

                        <button type="submit" class="w-full py-3.5 px-6 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-sm shadow-md shadow-primary-600/30 transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-paper-plane"></i> Kirim Pesan Konsultasi
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection

