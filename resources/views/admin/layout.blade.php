<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') | Panel SIP-Kes TeFa V-Kes</title>
    
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
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col lg:flex-row">

    @auth('admin')
    <!-- Admin Sidebar -->
    <aside class="w-full lg:w-64 bg-slate-900 text-slate-300 flex-shrink-0 flex flex-col justify-between border-r border-slate-800">
        <div>
            <!-- Sidebar Header -->
            <div class="h-20 flex items-center px-6 border-b border-slate-800 gap-3">
                @if($siteLogo)
                    <div class="bg-white p-2 rounded-xl flex items-center justify-center">
                        <img src="{{ $siteLogo }}" alt="SIP-Kes Logo" class="h-7 w-auto object-contain">
                    </div>
                @else
                    <div class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center text-white shadow-md">
                        <i class="fa-solid fa-heart-pulse text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-base font-bold text-white tracking-tight">Admin SIP-Kes</h1>
                        <p class="text-[11px] text-slate-400">TeFa V-Kes Polije</p>
                    </div>
                @endif
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1 text-xs font-semibold">
                <div class="px-3 py-2 text-[10px] uppercase font-bold text-slate-500 tracking-wider">Statistik & Utama</div>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-primary-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-gauge-high w-4 text-center"></i> Dashboard
                </a>

                <div class="pt-3 px-3 py-2 text-[10px] uppercase font-bold text-slate-500 tracking-wider">Kelola Konten Publik</div>

                <a href="{{ route('admin.home.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.home.*') ? 'bg-primary-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-house w-4 text-center"></i> Halaman Beranda
                </a>

                <a href="{{ route('admin.profile.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.profile.*') ? 'bg-primary-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-id-badge w-4 text-center"></i> Profil TeFa & SIP-Kes
                </a>

                <a href="{{ route('admin.features.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.features.*') ? 'bg-primary-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-list-check w-4 text-center"></i> Fitur & Modul RME
                </a>

                <a href="{{ route('admin.advantages.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.advantages.*') ? 'bg-primary-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-award w-4 text-center"></i> Keunggulan Sistem
                </a>

                <a href="{{ route('admin.pricing.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.pricing.*') ? 'bg-primary-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-tags w-4 text-center"></i> Paket Harga
                </a>

                <a href="{{ route('admin.support-services.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.support-services.*') ? 'bg-primary-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-handshake-angle w-4 text-center"></i> Layanan Pendukung
                </a>

                <a href="{{ route('admin.galleries.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.galleries.*') ? 'bg-primary-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-images w-4 text-center"></i> Galeri & Foto
                </a>

                <a href="{{ route('admin.contact.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.contact.*') ? 'bg-primary-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-envelope-open-text w-4 text-center"></i> Kontak & Pesan Masuk
                </a>
            </nav>
        </div>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-slate-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-white">{{ Auth::guard('admin')->user()->name ?? 'Administrator' }}</p>
                    <p class="text-[11px] text-slate-400">admin@sipkes.id</p>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" title="Logout" class="p-2 text-slate-400 hover:text-red-400 hover:bg-slate-800 rounded-lg transition">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </button>
                </form>
            </div>
            <div class="mt-3 text-center">
                <a href="{{ route('home') }}" target="_blank" class="block w-full py-1.5 px-3 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 text-[11px] font-semibold transition">
                    <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> Buka Website Publik
                </a>
            </div>
        </div>
    </aside>
    @endauth

    <!-- Main Content Panel -->
    <div class="flex-1 flex flex-col min-w-0">
        
        @auth('admin')
        <!-- Topbar -->
        <header class="h-20 bg-white border-b border-slate-200 px-6 sm:px-8 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <h2 class="text-lg font-bold text-slate-800">@yield('page_title', 'Dashboard')</h2>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" target="_blank" class="text-xs font-bold text-primary-600 hover:text-primary-700 flex items-center gap-1.5">
                    <i class="fa-solid fa-globe"></i> Lihat Frontend
                </a>
            </div>
        </header>
        @endauth

        <main class="p-6 sm:p-8 flex-1">
            <!-- Global Flash Alert Messages -->
            @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-800 text-xs sm:text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-green-600 text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs sm:text-sm flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-red-600 text-lg"></i>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>

