<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIP-Kes - Sistem Informasi Pelayanan Kesehatan') | TeFa V-Kes Polije</title>
    
    <!-- Meta & SEO -->
    <meta name="description" content="Portal Resmi SIP-Kes (Sistem Informasi Pelayanan Kesehatan) - Rekam Medis Elektronik Terintegrasi SATUSEHAT Kemenkes RI & BPJS Kesehatan. Dikembangkan oleh Teaching Factory Inovasi Kesehatan Polije.">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                        health: {
                            blue: '#0284c7',
                            dark: '#0f172a',
                            light: '#f8fafc',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-white text-slate-800 antialiased flex flex-col min-h-screen">

    <!-- Top Info Bar -->
    <div class="bg-primary-900 text-white text-xs py-2 px-4 border-b border-primary-800">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-4">
                <span><i class="fa-solid fa-graduation-cap mr-1 text-primary-300"></i> Teaching Factory Inovasi Kesehatan (TeFa V-Kes) - Politeknik Negeri Jember</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="tel:081335512803" class="hover:text-primary-200 transition"><i class="fa-solid fa-phone mr-1"></i> 0813-3551-2803</a>
                <a href="mailto:vkes@polije.ac.id" class="hover:text-primary-200 transition"><i class="fa-solid fa-envelope mr-1"></i> vkes@polije.ac.id</a>
                <a href="{{ route('admin.login') }}" class="bg-primary-700 hover:bg-primary-600 text-white px-2.5 py-0.5 rounded text-[11px] font-medium transition"><i class="fa-solid fa-lock mr-1"></i> Login Admin</a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md shadow-sm border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Brand / Logo (Memakai Foto / Gambar) -->
                <a href="{{ route('home') }}" class="flex items-center group py-2">
                    <img src="{{ $siteLogo ?: asset('images/logo.png') }}" 
                         alt="Logo Resmi SIP-Kes" 
                         class="h-12 max-h-12 w-auto object-contain group-hover:scale-105 transition duration-300"
                         onerror="this.src='{{ asset('images/logo.png') }}'">
                </a>

                <!-- Desktop Menu (Dipersingkat & Rapi) -->
                <nav class="hidden lg:flex items-center gap-1 xl:gap-2">
                    <a href="{{ route('home') }}" class="px-3.5 py-2 text-sm font-semibold rounded-lg transition {{ request()->routeIs('home') ? 'text-primary-700 bg-primary-50' : 'text-slate-600 hover:text-primary-600 hover:bg-slate-50' }}">
                        Beranda
                    </a>
                    <a href="{{ route('profile') }}" class="px-3.5 py-2 text-sm font-semibold rounded-lg transition {{ request()->routeIs('profile') ? 'text-primary-700 bg-primary-50' : 'text-slate-600 hover:text-primary-600 hover:bg-slate-50' }}">
                        Profil
                    </a>

                    <!-- Dropdown Fitur & Layanan -->
                    <div class="relative group">
                        <button type="button" class="flex items-center gap-1.5 px-3.5 py-2 text-sm font-semibold rounded-lg transition {{ request()->routeIs('features', 'advantages', 'support.services') ? 'text-primary-700 bg-primary-50' : 'text-slate-600 hover:text-primary-600 hover:bg-slate-50' }}">
                            <span>Fitur & Layanan</span>
                            <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200 group-hover:rotate-180"></i>
                        </button>
                        <div class="absolute left-0 mt-1 w-64 rounded-2xl bg-white shadow-xl border border-slate-100 py-2 hidden group-hover:block transition duration-200 z-50">
                            <!-- Direct RME Application Entry -->
                            <a href="{{ route('rme.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 text-xs font-semibold text-emerald-800 bg-emerald-50/80 hover:bg-emerald-100 transition rounded-xl mx-2 mb-1.5 border border-emerald-200">
                                <div class="w-7 h-7 rounded-lg bg-emerald-600 text-white flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-hospital text-xs"></i>
                                </div>
                                <div>
                                    <p class="font-bold flex items-center gap-1.5 text-emerald-950">
                                        <span>Buka Aplikasi RME</span>
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    </p>
                                    <p class="text-[10px] text-emerald-700 font-normal">20 modul beroperasi live</p>
                                </div>
                            </a>

                            <a href="{{ route('features') }}" class="flex items-center gap-3 px-4 py-2.5 text-xs font-semibold {{ request()->routeIs('features') ? 'text-primary-700 bg-primary-50' : 'text-slate-700 hover:text-primary-600 hover:bg-slate-50' }} transition">
                                <div class="w-7 h-7 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-list-check text-xs"></i>
                                </div>
                                <div>
                                    <p class="font-bold">Katalog 20 Fitur RME</p>
                                    <p class="text-[10px] text-slate-400 font-normal">Daftar modul & operasional</p>
                                </div>
                            </a>
                            <a href="{{ route('advantages') }}" class="flex items-center gap-3 px-4 py-2.5 text-xs font-semibold {{ request()->routeIs('advantages') ? 'text-primary-700 bg-primary-50' : 'text-slate-700 hover:text-primary-600 hover:bg-slate-50' }} transition">
                                <div class="w-7 h-7 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-star text-xs"></i>
                                </div>
                                <div>
                                    <p class="font-bold">Keunggulan Sistem</p>
                                    <p class="text-[10px] text-slate-400 font-normal">Nilai tambah faskes</p>
                                </div>
                            </a>
                            <a href="{{ route('support.services') }}" class="flex items-center gap-3 px-4 py-2.5 text-xs font-semibold {{ request()->routeIs('support.services') ? 'text-primary-700 bg-primary-50' : 'text-slate-700 hover:text-primary-600 hover:bg-slate-50' }} transition">
                                <div class="w-7 h-7 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-handshake-angle text-xs"></i>
                                </div>
                                <div>
                                    <p class="font-bold">Layanan Pendukung</p>
                                    <p class="text-[10px] text-slate-400 font-normal">Klaim BPJS & Akreditasi</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('pricing') }}" class="px-3.5 py-2 text-sm font-semibold rounded-lg transition {{ request()->routeIs('pricing') ? 'text-primary-700 bg-primary-50' : 'text-slate-600 hover:text-primary-600 hover:bg-slate-50' }}">
                        Paket Harga
                    </a>
                    <a href="{{ route('gallery') }}" class="px-3.5 py-2 text-sm font-semibold rounded-lg transition {{ request()->routeIs('gallery') ? 'text-primary-700 bg-primary-50' : 'text-slate-600 hover:text-primary-600 hover:bg-slate-50' }}">
                        Galeri
                    </a>
                    <a href="{{ route('contact') }}" class="px-3.5 py-2 text-sm font-semibold rounded-lg transition {{ request()->routeIs('contact') ? 'text-primary-700 bg-primary-50' : 'text-slate-600 hover:text-primary-600 hover:bg-slate-50' }}">
                        Kontak
                    </a>
                </nav>

                <!-- Action Button -->
                <div class="hidden sm:flex items-center gap-2.5">
                    <a href="{{ route('rme.dashboard') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-sm transition hover:shadow-md">
                        <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></span>
                        <span>Aplikasi RME Live</span>
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-3.5 py-2 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition border border-slate-200">
                        <i class="fa-brands fa-whatsapp mr-1.5 text-sm text-emerald-600"></i> Demo
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex lg:hidden">
                    <button type="button" id="mobile-menu-btn" class="p-2 rounded-lg text-slate-600 hover:text-primary-600 hover:bg-slate-100">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="hidden lg:hidden border-t border-slate-100 bg-white px-4 pt-3 pb-6 space-y-1 shadow-lg">
            <a href="{{ route('rme.dashboard') }}" class="block px-3 py-2.5 text-base font-bold rounded-xl text-emerald-800 bg-emerald-50 border border-emerald-200 mb-2">
                <i class="fa-solid fa-hospital mr-2 text-emerald-600"></i> Buka Aplikasi RME (Live)
            </a>
            <a href="{{ route('home') }}" class="block px-3 py-2 text-base font-medium rounded-md {{ request()->routeIs('home') ? 'text-primary-700 bg-primary-50' : 'text-slate-700 hover:bg-slate-50' }}">Beranda</a>
            <a href="{{ route('profile') }}" class="block px-3 py-2 text-base font-medium rounded-md {{ request()->routeIs('profile') ? 'text-primary-700 bg-primary-50' : 'text-slate-700 hover:bg-slate-50' }}">Profil</a>
            <a href="{{ route('features') }}" class="block px-3 py-2 text-base font-medium rounded-md {{ request()->routeIs('features') ? 'text-primary-700 bg-primary-50' : 'text-slate-700 hover:bg-slate-50' }}">Fitur RME</a>
            <a href="{{ route('advantages') }}" class="block px-3 py-2 text-base font-medium rounded-md {{ request()->routeIs('advantages') ? 'text-primary-700 bg-primary-50' : 'text-slate-700 hover:bg-slate-50' }}">Keunggulan</a>
            <a href="{{ route('pricing') }}" class="block px-3 py-2 text-base font-medium rounded-md {{ request()->routeIs('pricing') ? 'text-primary-700 bg-primary-50' : 'text-slate-700 hover:bg-slate-50' }}">Paket Harga</a>
            <a href="{{ route('support.services') }}" class="block px-3 py-2 text-base font-medium rounded-md {{ request()->routeIs('support.services') ? 'text-primary-700 bg-primary-50' : 'text-slate-700 hover:bg-slate-50' }}">Layanan Pendukung</a>
            <a href="{{ route('gallery') }}" class="block px-3 py-2 text-base font-medium rounded-md {{ request()->routeIs('gallery') ? 'text-primary-700 bg-primary-50' : 'text-slate-700 hover:bg-slate-50' }}">Galeri</a>
            <a href="{{ route('contact') }}" class="block px-3 py-2 text-base font-medium rounded-md {{ request()->routeIs('contact') ? 'text-primary-700 bg-primary-50' : 'text-slate-700 hover:bg-slate-50' }}">Kontak</a>
            <div class="pt-4 border-t border-slate-100 flex flex-col gap-2">
                <a href="{{ route('contact') }}" class="w-full text-center py-2.5 px-4 text-sm font-semibold text-white bg-primary-600 rounded-lg">Konsultasi Gratis</a>
                <a href="{{ route('admin.login') }}" class="w-full text-center py-2.5 px-4 text-sm font-semibold text-slate-700 bg-slate-100 rounded-lg">Portal Admin</a>
            </div>
        </div>
    </header>

    <!-- Main Content Body -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Call to Action Banner (Global) -->
    <section class="bg-gradient-to-r from-primary-800 to-sky-600 text-white py-16 px-4">
        <div class="max-w-6xl mx-auto text-center">
            <span class="inline-block px-3.5 py-1 text-xs font-bold uppercase tracking-wider bg-white/20 rounded-full mb-4">Integrasi Mudah & Terstandar</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight mb-4">Siap Mentransformasi Rekam Medis Faskes Anda Menjadi Digital?</h2>
            <p class="text-primary-100 text-base sm:text-lg max-w-2xl mx-auto mb-8">
                Konsultasikan kebutuhan faskes Anda sekarang bersama tim pakar TeFa V-Kes Polije. Nikmati kemudahan bridging SATUSEHAT Kemenkes & BPJS Kesehatan.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="https://wa.me/6281335512803?text=Halo%20TeFa%20V-Kes%20Polije,%20saya%20ingin%20konsultasi%20layanan%20SIP-Kes" target="_blank" class="px-6 py-3.5 bg-white text-primary-800 font-bold rounded-xl shadow-lg hover:bg-primary-50 transition flex items-center gap-2">
                    <i class="fa-brands fa-whatsapp text-green-600 text-lg"></i> Hubungi via WhatsApp
                </a>
                <a href="{{ route('contact') }}" class="px-6 py-3.5 bg-primary-900/60 hover:bg-primary-900 text-white font-bold rounded-xl border border-white/20 transition flex items-center gap-2">
                    <i class="fa-solid fa-envelope"></i> Kirim Formulir Permintaan
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 text-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                <!-- Col 1: About & Logo (Memakai Foto / Gambar) -->
                <div class="space-y-4">
                    <div class="flex items-center">
                        <img src="{{ $siteLogo ?: asset('images/logo.png') }}" 
                             alt="Logo Resmi SIP-Kes" 
                             class="h-12 max-h-12 w-auto object-contain brightness-100"
                             onerror="this.src='{{ asset('images/logo.png') }}'">
                    </div>
                    <p class="text-xs leading-relaxed text-slate-400">
                        Platform Sistem Informasi Pelayanan Kesehatan (SIP-Kes) milik Teaching Factory Inovasi Kesehatan (TeFa V-Kes), Jurusan Kesehatan Politeknik Negeri Jember. Solusi RME terintegrasi SATUSEHAT & BPJS.
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <a href="https://instagram.com/sipkes.co.id" target="_blank" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-slate-300 hover:text-white hover:bg-pink-600 transition">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="mailto:vkes@polije.ac.id" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-slate-300 hover:text-white hover:bg-primary-600 transition">
                            <i class="fa-solid fa-envelope"></i>
                        </a>
                        <a href="tel:081335512803" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-slate-300 hover:text-white hover:bg-green-600 transition">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                    </div>
                </div>

                <!-- Col 2: Navigasi Cepat -->
                <div>
                    <h3 class="text-white font-semibold mb-4 text-base">Navigasi Halaman</h3>
                    <ul class="space-y-2.5 text-xs">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition"><i class="fa-solid fa-chevron-right text-[9px] mr-1.5 text-primary-500"></i> Beranda</a></li>
                        <li><a href="{{ route('profile') }}" class="hover:text-white transition"><i class="fa-solid fa-chevron-right text-[9px] mr-1.5 text-primary-500"></i> Profil TeFa & SIP-Kes</a></li>
                        <li><a href="{{ route('features') }}" class="hover:text-white transition"><i class="fa-solid fa-chevron-right text-[9px] mr-1.5 text-primary-500"></i> Modul & Fitur RME</a></li>
                        <li><a href="{{ route('advantages') }}" class="hover:text-white transition"><i class="fa-solid fa-chevron-right text-[9px] mr-1.5 text-primary-500"></i> Keunggulan Sistem</a></li>
                        <li><a href="{{ route('pricing') }}" class="hover:text-white transition"><i class="fa-solid fa-chevron-right text-[9px] mr-1.5 text-primary-500"></i> Pilihan Paket Harga</a></li>
                        <li><a href="{{ route('gallery') }}" class="hover:text-white transition"><i class="fa-solid fa-chevron-right text-[9px] mr-1.5 text-primary-500"></i> Galeri Kegiatan</a></li>
                    </ul>
                </div>

                <!-- Col 3: Layanan & Solusi -->
                <div>
                    <h3 class="text-white font-semibold mb-4 text-base">Layanan & Integrasi</h3>
                    <ul class="space-y-2.5 text-xs">
                        <li><a href="{{ route('features') }}" class="hover:text-white transition"><i class="fa-solid fa-check text-sky-400 mr-1.5"></i> Integrasi SATUSEHAT Kemenkes</a></li>
                        <li><a href="{{ route('features') }}" class="hover:text-white transition"><i class="fa-solid fa-check text-sky-400 mr-1.5"></i> Bridging BPJS Kesehatan (PCare)</a></li>
                        <li><a href="{{ route('support.services') }}" class="hover:text-white transition"><i class="fa-solid fa-check text-sky-400 mr-1.5"></i> Pendampingan Klaim BPJS</a></li>
                        <li><a href="{{ route('support.services') }}" class="hover:text-white transition"><i class="fa-solid fa-check text-sky-400 mr-1.5"></i> Pendampingan Akreditasi Klinik</a></li>
                        <li><a href="{{ route('features') }}" class="hover:text-white transition"><i class="fa-solid fa-check text-sky-400 mr-1.5"></i> Modul Odontogram Gigi</a></li>
                        <li><a href="{{ route('features') }}" class="hover:text-white transition"><i class="fa-solid fa-check text-sky-400 mr-1.5"></i> Rekam Medis Rawat Inap & Jalan</a></li>
                    </ul>
                </div>

                <!-- Col 4: Kontak Sekretariat -->
                <div>
                    <h3 class="text-white font-semibold mb-4 text-base">Sekretariat TeFa V-Kes</h3>
                    <ul class="space-y-3 text-xs leading-relaxed text-slate-300">
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-location-dot mt-1 text-primary-400"></i>
                            <span>Jurusan Kesehatan, Prodi Manajemen Informasi Kesehatan, Politeknik Negeri Jember, Jl. Mastrip 164, Jember, Jawa Timur.</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-phone text-primary-400"></i>
                            <span>0813-3551-2803</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-envelope text-primary-400"></i>
                            <span>vkes@polije.ac.id</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-brands fa-instagram text-primary-400"></i>
                            <span>@sipkes.co.id</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-12 pt-6 border-t border-slate-800 text-center text-xs text-slate-500 flex flex-col sm:flex-row justify-between items-center gap-3">
                <p>&copy; {{ date('Y') }} SIP-Kes. Hak Cipta Dilindungi Undang-Undang. TeFa Inovasi Kesehatan - Politeknik Negeri Jember.</p>
                <div class="flex items-center gap-4">
                    <span class="text-slate-400">PMK No. 24 Tahun 2022 Compliant</span>
                    <span>•</span>
                    <a href="{{ route('admin.login') }}" class="text-slate-400 hover:text-white transition">Admin Portal</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Simple Mobile Menu Toggle Script -->
    <script>
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        if(btn && menu) {
            btn.addEventListener('click', () => {
                menu.classList.toggle('hidden');
            });
        }
    </script>

    @stack('scripts')
</body>
</html>

