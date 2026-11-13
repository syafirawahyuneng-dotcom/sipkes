@extends('layouts.frontend')

@section('title', $feature->name . ' - Fitur & Modul SIP-Kes')

@php
    $functions = $feature->listOf('functions');
    $benefits  = $feature->listOf('benefits');
    $users     = $feature->listOf('users');
    $workflow  = $feature->listOf('workflow');
@endphp

@section('content')

<!-- Header Banner -->
<section class="bg-primary-900 text-white py-12 sm:py-16 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="flex flex-wrap items-center gap-2 text-xs text-primary-200 mb-6" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[9px] text-primary-400"></i>
            <a href="{{ route('features') }}" class="hover:text-white transition">Fitur & Modul</a>
            <i class="fa-solid fa-chevron-right text-[9px] text-primary-400"></i>
            <span class="text-white font-semibold">{{ $feature->name }}</span>
        </nav>

        <div class="flex flex-col sm:flex-row sm:items-center gap-5">
            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white/10 border border-white/20 text-sky-300 flex items-center justify-center text-3xl sm:text-4xl shrink-0">
                <i class="fa-solid {{ $feature->icon ?? 'fa-circle-check' }}"></i>
            </div>
            <div>
                <div class="flex flex-wrap items-center gap-2 mb-2">
                    @if($feature->category)
                    <a href="{{ route('features', ['category' => $feature->category]) }}" class="inline-block px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-primary-800 text-sky-300 hover:bg-primary-700 transition">
                        {{ $feature->category }}
                    </a>
                    @endif
                    @if($feature->is_featured)
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-400/15 text-amber-300">
                        <i class="fa-solid fa-star"></i> Modul Unggulan
                    </span>
                    @endif
                </div>
                <h1 class="text-3xl sm:text-4xl font-black tracking-tight">{{ $feature->name }}</h1>
            </div>
        </div>
    </div>
</section>

<!-- Content -->
<section class="py-12 sm:py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- Main Column -->
            <div class="lg:col-span-8 space-y-6">

                <!-- Deskripsi -->
                <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-sm">
                    <h2 class="flex items-center gap-2.5 text-lg font-bold text-slate-900 mb-4">
                        <span class="w-8 h-8 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center text-sm"><i class="fa-solid fa-circle-info"></i></span>
                        Deskripsi Fitur
                    </h2>
                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed">{!! nl2br(e($feature->description)) !!}</p>
                </div>

                <!-- Fungsi Utama -->
                @if(count($functions))
                <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-sm">
                    <h2 class="flex items-center gap-2.5 text-lg font-bold text-slate-900 mb-5">
                        <span class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center text-sm"><i class="fa-solid fa-gears"></i></span>
                        Fungsi Utama
                    </h2>
                    <ul class="space-y-3">
                        @foreach($functions as $item)
                        <li class="flex items-start gap-3 text-sm text-slate-700 leading-relaxed">
                            <i class="fa-solid fa-circle-check text-primary-600 mt-1 shrink-0"></i>
                            <span>{{ $item }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Alur Penggunaan -->
                @if(count($workflow))
                <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-sm">
                    <h2 class="flex items-center gap-2.5 text-lg font-bold text-slate-900 mb-5">
                        <span class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm"><i class="fa-solid fa-route"></i></span>
                        Alur Penggunaan
                    </h2>
                    <ol class="relative space-y-5">
                        @foreach($workflow as $i => $step)
                        <li class="flex items-start gap-4">
                            <span class="w-8 h-8 rounded-full bg-primary-600 text-white text-xs font-black flex items-center justify-center shrink-0">{{ $i + 1 }}</span>
                            <p class="text-sm text-slate-700 leading-relaxed pt-1.5">{{ $step }}</p>
                        </li>
                        @endforeach
                    </ol>
                </div>
                @endif

                <!-- Prev / Next -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @if($prev)
                    <a href="{{ route('features.show', $prev) }}" class="group bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:border-primary-400 hover:shadow-md transition">
                        <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1"><i class="fa-solid fa-arrow-left mr-1"></i> Fitur Sebelumnya</p>
                        <p class="text-sm font-bold text-slate-800 group-hover:text-primary-700 transition">{{ $prev->name }}</p>
                    </a>
                    @else
                    <div class="hidden sm:block"></div>
                    @endif
                    @if($next)
                    <a href="{{ route('features.show', $next) }}" class="group bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:border-primary-400 hover:shadow-md transition sm:text-right">
                        <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Fitur Berikutnya <i class="fa-solid fa-arrow-right ml-1"></i></p>
                        <p class="text-sm font-bold text-slate-800 group-hover:text-primary-700 transition">{{ $next->name }}</p>
                    </a>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="lg:col-span-4 space-y-6">

                @if(count($users))
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
                    <h3 class="flex items-center gap-2 text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">
                        <i class="fa-solid fa-user-doctor text-teal-600"></i> Pengguna Modul
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($users as $u)
                        <span class="px-3 py-1.5 rounded-xl bg-teal-50 text-teal-800 border border-teal-100 text-xs font-semibold">{{ $u }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(count($benefits))
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
                    <h3 class="flex items-center gap-2 text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">
                        <i class="fa-solid fa-thumbs-up text-amber-500"></i> Manfaat bagi Faskes
                    </h3>
                    <ul class="space-y-3">
                        @foreach($benefits as $b)
                        <li class="flex items-start gap-2.5 text-sm text-slate-700 leading-relaxed">
                            <i class="fa-solid fa-check text-emerald-600 mt-1 shrink-0"></i>
                            <span>{{ $b }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Informasi Pendukung -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
                    <h3 class="flex items-center gap-2 text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">
                        <i class="fa-solid fa-shield-halved text-primary-600"></i> Informasi Pendukung
                    </h3>
                    <ul class="space-y-2.5 text-xs text-slate-600">
                        <li class="flex items-center gap-2"><i class="fa-solid fa-file-shield text-primary-500 w-4 text-center"></i> Mengacu pada PMK No. 24 Tahun 2022 tentang Rekam Medis</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-cloud-arrow-up text-primary-500 w-4 text-center"></i> Mendukung integrasi SATUSEHAT Kemenkes RI</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-chalkboard-user text-primary-500 w-4 text-center"></i> Termasuk pelatihan & pendampingan tim TeFa V-Kes</li>
                    </ul>
                </div>

                <!-- CTA -->
                <div class="bg-gradient-to-br from-primary-800 to-sky-600 rounded-2xl p-6 text-white shadow-md">
                    <h3 class="text-base font-bold mb-2">Tertarik dengan modul ini?</h3>
                    <p class="text-xs text-primary-100 leading-relaxed mb-4">Konsultasikan kebutuhan faskes Anda dan jadwalkan demo bersama tim TeFa V-Kes Polije.</p>
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('contact') }}" class="w-full text-center px-4 py-2.5 rounded-xl bg-white text-primary-800 font-bold text-xs hover:bg-primary-50 transition">
                            <i class="fa-solid fa-calendar-check mr-1"></i> Konsultasi & Demo
                        </a>
                        <a href="{{ route('pricing') }}" class="w-full text-center px-4 py-2.5 rounded-xl bg-primary-900/50 border border-white/20 font-bold text-xs hover:bg-primary-900 transition">
                            <i class="fa-solid fa-tags mr-1"></i> Lihat Paket Harga
                        </a>
                    </div>
                </div>
            </aside>
        </div>

        <!-- Related Features -->
        @if($related->isNotEmpty())
        <div class="mt-14">
            <div class="flex items-end justify-between mb-6">
                <h2 class="text-xl font-extrabold text-slate-900">Fitur Terkait</h2>
                <a href="{{ route('features') }}" class="text-sm font-bold text-primary-600 hover:text-primary-700">
                    <i class="fa-solid fa-arrow-left text-xs mr-1"></i> Kembali ke Semua Fitur
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($related as $r)
                <a href="{{ $r->detail_url }}" class="group bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:border-primary-400 hover:shadow-md transition">
                    <div class="w-10 h-10 rounded-xl bg-slate-50 text-primary-700 group-hover:bg-primary-600 group-hover:text-white flex items-center justify-center mb-3 transition">
                        <i class="fa-solid {{ $r->icon ?? 'fa-circle-dot' }}"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-800 group-hover:text-primary-700 transition mb-1">{{ $r->name }}</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">{{ Str::limit(preg_replace('/\s+/', ' ', $r->description), 80) }}</p>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

@endsection
