<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem RME Klinis') | SIP-Kes TeFa V-Kes Polije</title>
    
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
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                        clinical: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #0f172a; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; border-radius: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #475569; }
        @media print {
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            body { background: white !important; color: black !important; }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen flex flex-col lg:flex-row">

    <!-- Mobile Header -->
    <div class="lg:hidden bg-slate-900 text-white px-4 py-3 flex items-center justify-between no-print sticky top-0 z-50 shadow">
        <a href="{{ route('home') }}" title="Ke Beranda Portal">
            <img src="{{ asset('images/logo.png') }}" alt="SIP-Kes Logo" class="h-9 w-auto bg-white px-2 py-1 rounded-lg object-contain shadow-sm">
        </a>
        <button onclick="document.getElementById('rmeSidebar').classList.toggle('-translate-x-full')" class="p-2 text-slate-300 hover:text-white focus:outline-none">
            <i class="fa-solid fa-bars text-xl"></i>
        </button>
    </div>

    <!-- Sidebar Sistem RME (20 Modul Terurut 1 - 20 & Sticky Selalu Ada Saat Di-Scroll) -->
    <aside id="rmeSidebar" class="w-72 bg-slate-900 text-slate-300 flex-shrink-0 flex flex-col justify-between fixed lg:sticky top-0 left-0 z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-200 ease-in-out border-r border-slate-800 h-screen no-print shadow-xl">
        <div class="flex flex-col h-full overflow-hidden">
            <!-- Sidebar Brand Header (Hanya Logo Foto Saja, Tanpa Dobel Teks) -->
            <div class="h-20 flex items-center px-5 border-b border-slate-800 justify-between bg-slate-950/50 shrink-0">
                <a href="{{ route('home') }}" class="flex items-center" title="Ke Beranda Portal">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo SIP-Kes" class="h-11 w-auto max-h-12 bg-white px-3 py-1.5 rounded-xl shadow-md object-contain hover:scale-105 transition">
                </a>
                <button onclick="document.getElementById('rmeSidebar').classList.add('-translate-x-full')" class="lg:hidden text-slate-400 hover:text-white p-2">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Fast Status Bar -->
            <div class="px-4 py-2.5 bg-slate-800/40 border-b border-slate-800 flex items-center justify-between text-[11px] shrink-0">
                <div class="flex items-center gap-1.5 text-emerald-400 font-medium">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>SATUSEHAT Aktif</span>
                </div>
                <a href="{{ route('rme.pengaturan.integrasi') }}" class="text-sky-400 hover:text-sky-300 text-[10px] font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-link text-[9px]"></i> Bridging
                </a>
            </div>

            <!-- Navigation Links: Terurut Berdasarkan Nomor (Dari No. 1 Sampai Selesai No. 20) -->
            <div class="flex-1 overflow-y-auto custom-scrollbar px-3 py-4 space-y-1">
                <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">Daftar Modul RME (1 - 20)</p>

                <!-- 1. Pendaftaran -->
                <a href="{{ route('rme.pendaftaran') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium transition {{ request()->routeIs('rme.pendaftaran*') ? 'bg-primary-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-user-plus w-4 text-center text-blue-400 {{ request()->routeIs('rme.pendaftaran*') ? 'text-white' : '' }}"></i>
                    <span>1. Pendaftaran</span>
                </a>

                <!-- 2. Antrian dan Panggilan Suara -->
                <a href="{{ route('rme.antrian') }}" 
                   class="flex items-center justify-between px-3 py-2 rounded-lg text-xs font-medium transition {{ request()->routeIs('rme.antrian*') ? 'bg-primary-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-bullhorn w-4 text-center text-amber-400 {{ request()->routeIs('rme.antrian*') ? 'text-white' : '' }}"></i>
                        <span>2. Antrian & Panggilan Suara</span>
                    </div>
                    <span class="text-[9px] bg-amber-500/20 text-amber-300 px-1.5 py-0.5 rounded font-mono">TTS</span>
                </a>

                <!-- 3. Pemeriksaan (SO) -->
                <a href="{{ route('rme.pemeriksaan.so') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium transition {{ request()->routeIs('rme.pemeriksaan.so*') ? 'bg-primary-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-stethoscope w-4 text-center text-emerald-400 {{ request()->routeIs('rme.pemeriksaan.so*') ? 'text-white' : '' }}"></i>
                    <span>3. Pemeriksaan (SO)</span>
                </a>

                <!-- 4. Diagnosa dan Tindakan (AP) -->
                <a href="{{ route('rme.diagnosa.tindakan') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium transition {{ request()->routeIs('rme.diagnosa.tindakan*') ? 'bg-primary-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-notes-medical w-4 text-center text-purple-400 {{ request()->routeIs('rme.diagnosa.tindakan*') ? 'text-white' : '' }}"></i>
                    <span>4. Diagnosa & Tindakan (AP)</span>
                </a>

                <!-- 5. Farmasi -->
                <a href="{{ route('rme.farmasi') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium transition {{ request()->routeIs('rme.farmasi*') ? 'bg-primary-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-pills w-4 text-center text-teal-400 {{ request()->routeIs('rme.farmasi*') ? 'text-white' : '' }}"></i>
                    <span>5. Farmasi</span>
                </a>

                <!-- 6. Kasir -->
                <a href="{{ route('rme.kasir') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium transition {{ request()->routeIs('rme.kasir*') ? 'bg-primary-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-cash-register w-4 text-center text-amber-400 {{ request()->routeIs('rme.kasir*') ? 'text-white' : '' }}"></i>
                    <span>6. Kasir</span>
                </a>

                <!-- 7. Rawat Inap -->
                <a href="{{ route('rme.rawat.inap') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium transition {{ request()->routeIs('rme.rawat.inap*') ? 'bg-primary-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-bed w-4 text-center text-sky-400 {{ request()->routeIs('rme.rawat.inap*') ? 'text-white' : '' }}"></i>
                    <span>7. Rawat Inap</span>
                </a>

                <!-- 8. Laporan -->
                <a href="{{ route('rme.laporan') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium transition {{ request()->routeIs('rme.laporan*') ? 'bg-primary-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-chart-column w-4 text-center text-indigo-400 {{ request()->routeIs('rme.laporan*') ? 'text-white' : '' }}"></i>
                    <span>8. Laporan</span>
                </a>

                <!-- 9. Dashboard -->
                <a href="{{ route('rme.dashboard') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium transition {{ request()->routeIs('rme.dashboard') ? 'bg-primary-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-chart-pie w-4 text-center text-primary-400 {{ request()->routeIs('rme.dashboard') ? 'text-white' : '' }}"></i>
                    <span>9. Dashboard</span>
                </a>

                <!-- 10. Cetak Kartu Berobat -->
                <a href="{{ route('rme.kartu.berobat') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium transition {{ request()->routeIs('rme.kartu.berobat*') ? 'bg-primary-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-id-card w-4 text-center text-cyan-400 {{ request()->routeIs('rme.kartu.berobat*') ? 'text-white' : '' }}"></i>
                    <span>10. Cetak Kartu Berobat</span>
                </a>

                <!-- 11. Verifikasi dengan SatuSehat Mobile -->
                <a href="{{ route('rme.verifikasi.satusehat') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium transition {{ request()->routeIs('rme.verifikasi.satusehat*') ? 'bg-primary-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-mobile-screen-button w-4 text-center text-emerald-400 {{ request()->routeIs('rme.verifikasi.satusehat*') ? 'text-white' : '' }}"></i>
                    <span>11. Verifikasi dengan SatuSehat Mobile</span>
                </a>

                <!-- 12. Asuhan Keperawatan -->
                <a href="{{ route('rme.asuhan.keperawatan') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium transition {{ request()->routeIs('rme.asuhan.keperawatan*') ? 'bg-primary-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-user-nurse w-4 text-center text-rose-400 {{ request()->routeIs('rme.asuhan.keperawatan*') ? 'text-white' : '' }}"></i>
                    <span>12. Asuhan Keperawatan</span>
                </a>

                <!-- 13. Pengaturan Integrasi SatuSehat dan BPJS Kesehatan -->
                <a href="{{ route('rme.pengaturan.integrasi') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium transition {{ request()->routeIs('rme.pengaturan.integrasi*') ? 'bg-primary-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-sliders w-4 text-center text-slate-400 {{ request()->routeIs('rme.pengaturan.integrasi*') ? 'text-white' : '' }}"></i>
                    <span>13. Pengaturan Integrasi SatuSehat & BPJS</span>
                </a>

                <!-- 14. Odontogram pada Klinik Gigi -->
                <a href="{{ route('rme.odontogram') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium transition {{ request()->routeIs('rme.odontogram*') ? 'bg-primary-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-tooth w-4 text-center text-pink-400 {{ request()->routeIs('rme.odontogram*') ? 'text-white' : '' }}"></i>
                    <span>14. Odontogram pada Klinik Gigi</span>
                </a>

                <!-- 15. General Consent -->
                <a href="{{ route('rme.general.consent') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium transition {{ request()->routeIs('rme.general.consent*') ? 'bg-primary-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-file-signature w-4 text-center text-indigo-400 {{ request()->routeIs('rme.general.consent*') ? 'text-white' : '' }}"></i>
                    <span>15. General Consent</span>
                </a>

                <!-- 16. Informed Consent -->
                <a href="{{ route('rme.informed.consent') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium transition {{ request()->routeIs('rme.informed.consent*') ? 'bg-primary-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-file-shield w-4 text-center text-blue-400 {{ request()->routeIs('rme.informed.consent*') ? 'text-white' : '' }}"></i>
                    <span>16. Informed Consent</span>
                </a>

                <!-- 17. Surat Sehat & Surat Sakit -->
                <a href="{{ route('rme.surat.keterangan') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium transition {{ request()->routeIs('rme.surat.keterangan*') ? 'bg-primary-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-envelope-open-text w-4 text-center text-yellow-400 {{ request()->routeIs('rme.surat.keterangan*') ? 'text-white' : '' }}"></i>
                    <span>17. Surat Sehat & Surat Sakit</span>
                </a>

                <!-- 18. Laboratorium -->
                <a href="{{ route('rme.laboratorium') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium transition {{ request()->routeIs('rme.laboratorium*') ? 'bg-primary-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-vial-virus w-4 text-center text-teal-400 {{ request()->routeIs('rme.laboratorium*') ? 'text-white' : '' }}"></i>
                    <span>18. Laboratorium</span>
                </a>

                <!-- 19. Sedasi -->
                <a href="{{ route('rme.sedasi') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium transition {{ request()->routeIs('rme.sedasi*') ? 'bg-primary-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-bed-pulse w-4 text-center text-indigo-400 {{ request()->routeIs('rme.sedasi*') ? 'text-white' : '' }}"></i>
                    <span>19. Sedasi</span>
                </a>

                <!-- 20. Dan lain-lain -->
                <a href="{{ route('rme.master.data') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium transition {{ request()->routeIs('rme.master.data') ? 'bg-primary-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-hospital w-4 text-center text-slate-400 {{ request()->routeIs('rme.master.data') ? 'text-white' : '' }}"></i>
                    <span>20. Dan lain-lain</span>
                </a>
            </div>

            <!-- Sidebar Footer Navigation (Selalu Menempel di Bagian Bawah) -->
            <div class="p-3 border-t border-slate-800 bg-slate-950/60 flex flex-col gap-2 shrink-0">
                <a href="{{ route('features') }}" class="w-full flex items-center justify-center gap-2 py-2 px-3 text-xs font-semibold rounded-lg bg-slate-800 text-slate-300 hover:bg-slate-700 hover:text-white transition">
                    <i class="fa-solid fa-list-check text-primary-400"></i>
                    <span>Daftar 20 Fitur Portal</span>
                </a>
                <a href="{{ route('home') }}" class="w-full flex items-center justify-center gap-2 py-2 px-3 text-xs font-semibold rounded-lg bg-emerald-600/20 text-emerald-300 hover:bg-emerald-600/30 transition border border-emerald-500/30">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali ke Website Utama</span>
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden min-h-screen">
        
        <!-- Top App Bar -->
        <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6 no-print shadow-sm z-10">
            <div class="flex items-center gap-3 min-w-0">
                <h1 class="text-lg font-bold text-slate-800 truncate">
                    @yield('header_title', 'Sistem Rekam Medis Elektronik (RME)')
                </h1>
                <span class="hidden sm:inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                    <i class="fa-solid fa-circle-check mr-1 text-[10px]"></i> Operasional Siap Pakai
                </span>
            </div>

            <div class="flex items-center gap-3">
                <!-- Status Bridging SATUSEHAT -->
                <div class="hidden md:flex items-center gap-2 bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-lg text-xs font-medium text-emerald-700">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                    <span class="font-semibold">SATUSEHAT: Terhubung</span>
                </div>

                <!-- Status Bridging BPJS -->
                <div class="hidden lg:flex items-center gap-2 bg-sky-50 border border-sky-200 px-3 py-1.5 rounded-lg text-xs font-medium text-sky-700">
                    <i class="fa-solid fa-shield-halved text-sky-600"></i>
                    <span class="font-semibold">BPJS PCare: Ready</span>
                </div>

                <!-- Portal Link -->
                <a href="{{ route('features') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold transition border border-slate-300">
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    <span>Portal Fitur</span>
                </a>
            </div>
        </header>

        <!-- Flash Notifications -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
            <div class="max-w-7xl mx-auto space-y-6">

                @if(session('success'))
                    <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm flex items-start justify-between no-print animate-fade-in">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-xl"></i>
                            <div>
                                <h4 class="text-sm font-bold text-emerald-900">Operasi Berhasil</h4>
                                <p class="text-xs text-emerald-700 mt-0.5">{{ session('success') }}</p>
                            </div>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-sm">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-xl shadow-sm flex items-start justify-between no-print">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-triangle-exclamation text-rose-600 text-xl"></i>
                            <div>
                                <h4 class="text-sm font-bold text-rose-900">Peringatan / Error</h4>
                                <p class="text-xs text-rose-700 mt-0.5">{{ session('error') }}</p>
                            </div>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 text-sm">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-xl shadow-sm no-print">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-exclamation text-rose-600 text-xl"></i>
                            <div>
                                <h4 class="text-sm font-bold text-rose-900">Terdapat Kesalahan Input:</h4>
                                <ul class="list-disc list-inside text-xs text-rose-700 mt-1 space-y-0.5">
                                    @foreach($errors->all() as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Yield Content -->
                @yield('content')

            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-200 py-3 px-6 text-center text-xs text-slate-500 no-print flex flex-col sm:flex-row items-center justify-between gap-2">
            <div>
                &copy; {{ date('Y') }} <strong>SIP-Kes TeFa V-Kes Polije</strong>. Sistem Rekam Medis Elektronik Terintegrasi Kemenkes.
            </div>
            <div class="flex items-center gap-4 text-[11px] text-slate-400">
                <span>Versi 2.0.4 - Terstandar Permenkes 24/2022</span>
                <span>•</span>
                <span class="text-emerald-600 font-medium"><i class="fa-solid fa-shield-virus mr-1"></i>Keamanan HL7 FHIR</span>
            </div>
        </footer>

    </div>

    <!-- Web Speech API Audio Queue Helper (Dipanggil otomatis jika ada session call_audio) -->
    @if(session('call_audio'))
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                const audioData = @json(session('call_audio'));
                if ('speechSynthesis' in window) {
                    const text = `Nomor antrian, ${audioData.number}, silakan menuju ke ${audioData.poli}`;
                    const utterance = new SpeechSynthesisUtterance(text);
                    utterance.lang = 'id-ID';
                    utterance.rate = 0.9;
                    utterance.pitch = 1.0;
                    window.speechSynthesis.speak(utterance);
                }
            });
        </script>
    @endif

    @stack('scripts')
</body>
</html>

