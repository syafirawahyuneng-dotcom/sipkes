@extends('layouts.frontend')

@section('title', $news->title . ' - Berita SIP-Kes')

@php
    $paragraphs  = $news->paragraphs();
    $wordCount   = str_word_count(strip_tags(implode(' ', $paragraphs) . ' ' . $news->description));
    $readMinutes = max(1, (int) ceil($wordCount / 200));
    $pubDate     = $news->date?->locale('id');
    $shareUrl    = url()->current();
    $shareText   = $news->title . ' - ' . $shareUrl;
@endphp

@section('content')

<!-- Reading progress -->
<div class="fixed top-0 left-0 right-0 h-1 z-[60] pointer-events-none" aria-hidden="true">
    <div id="read-progress" class="h-full w-0 bg-gradient-to-r from-sky-400 to-primary-500 transition-[width] duration-150"></div>
</div>

<!-- ============ HERO ============ -->
<section class="relative overflow-hidden bg-gradient-to-br from-primary-900 via-primary-800 to-sky-800 text-white">
    <!-- Decorative accents -->
    <div class="absolute inset-0 opacity-[0.07]" aria-hidden="true"
         style="background-image: radial-gradient(circle at 1px 1px, #fff 1px, transparent 0); background-size: 22px 22px;"></div>
    <div class="absolute -top-24 -right-24 w-80 h-80 rounded-full bg-sky-400/20 blur-3xl" aria-hidden="true"></div>
    <div class="absolute -bottom-32 -left-20 w-96 h-96 rounded-full bg-primary-500/20 blur-3xl" aria-hidden="true"></div>

    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 pt-10 sm:pt-14 pb-36 sm:pb-44">
        <!-- Breadcrumb -->
        <nav class="flex flex-wrap items-center gap-2 text-xs text-primary-200 mb-8" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 hover:text-white transition">
                <i class="fa-solid fa-house text-[10px]"></i> Beranda
            </a>
            <i class="fa-solid fa-chevron-right text-[9px] text-primary-400"></i>
            <a href="{{ route('news') }}" class="hover:text-white transition">Berita</a>
            <i class="fa-solid fa-chevron-right text-[9px] text-primary-400"></i>
            <span class="text-white/90 font-semibold line-clamp-1 max-w-[60vw] sm:max-w-md">{{ $news->title }}</span>
        </nav>

        <div class="max-w-4xl">
            <!-- Category -->
            <div class="flex flex-wrap items-center gap-2 mb-5">
                @if($news->category)
                <a href="{{ route('news', ['category' => $news->category->slug]) }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] sm:text-[11px] font-bold uppercase tracking-wider bg-white/10 border border-white/20 text-sky-200 hover:bg-white/20 transition backdrop-blur">
                    <i class="fa-solid fa-tag text-[9px]"></i> {{ $news->category->name }}
                </a>
                @endif
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] sm:text-[11px] font-bold uppercase tracking-wider bg-sky-400/15 text-sky-200">
                    <i class="fa-regular fa-newspaper text-[10px]"></i> Berita SIP-Kes
                </span>
            </div>

            <!-- Title -->
            <h1 class="text-[1.75rem] leading-[1.2] sm:text-4xl lg:text-5xl sm:leading-[1.15] font-black tracking-tight text-white">
                {{ $news->title }}
            </h1>
            <div class="mt-6 flex items-center gap-2" aria-hidden="true">
                <span class="h-1 w-14 rounded-full bg-sky-400"></span>
                <span class="h-1 w-4 rounded-full bg-sky-400/60"></span>
                <span class="h-1 w-2 rounded-full bg-sky-400/30"></span>
            </div>

            <!-- Meta -->
            <div class="mt-6 flex flex-wrap items-center gap-x-6 gap-y-3 text-xs sm:text-sm text-primary-100">
                @if($news->author)
                <div class="flex items-center gap-2.5">
                    <span class="w-9 h-9 rounded-full bg-white/15 border border-white/20 flex items-center justify-center text-sm font-black text-white">
                        {{ Str::upper(Str::substr($news->author, 0, 1)) }}
                    </span>
                    <div class="leading-tight">
                        <p class="text-[10px] uppercase tracking-wider text-primary-300">Ditulis oleh</p>
                        <p class="font-semibold text-white">{{ $news->author }}</p>
                    </div>
                </div>
                @endif
                @if($pubDate)
                <span class="inline-flex items-center gap-2"><i class="fa-regular fa-calendar text-sky-300"></i> {{ $pubDate->isoFormat('dddd, D MMMM Y') }}</span>
                @endif
                <span class="inline-flex items-center gap-2"><i class="fa-regular fa-clock text-sky-300"></i> {{ $readMinutes }} menit baca</span>
            </div>
        </div>
    </div>
</section>

<!-- ============ FEATURED IMAGE ============ -->
<section class="relative px-4 sm:px-6 -mt-28 sm:-mt-36">
    <figure class="max-w-5xl mx-auto">
        <div class="relative rounded-2xl sm:rounded-[2rem] overflow-hidden shadow-2xl shadow-primary-900/20 ring-1 ring-black/5 bg-slate-100 aspect-[16/10] sm:aspect-[16/8]">
            @if($news->hasValidImage())
                <img src="{{ $news->image_url }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-tr from-primary-800 via-primary-700 to-sky-500 flex items-center justify-center relative">
                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 1px 1px, #fff 1px, transparent 0); background-size: 18px 18px;"></div>
                    <div class="relative text-center text-white/70">
                        <i class="fa-solid fa-newspaper text-6xl sm:text-7xl mb-3"></i>
                        <p class="text-xs font-semibold tracking-wider uppercase">SIP-Kes · TeFa V-Kes Polije</p>
                    </div>
                </div>
            @endif
        </div>
        @if($news->category || $pubDate)
        <figcaption class="mt-3 text-center text-[11px] text-slate-400">
            <i class="fa-solid fa-camera mr-1"></i>
            Dokumentasi{{ $news->category ? ' ' . $news->category->name : '' }}{{ $pubDate ? ' · ' . $pubDate->isoFormat('D MMMM Y') : '' }}
        </figcaption>
        @endif
    </figure>
</section>

<!-- ============ BODY ============ -->
<section class="bg-white pt-10 sm:pt-14 pb-16 px-4 sm:px-6">
    <div class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12">

        <!-- Article -->
        <article id="article-body" class="lg:col-span-8 min-w-0">

            @if($news->description && $news->content)
            <!-- Lead / Summary -->
            <div class="relative rounded-2xl bg-gradient-to-br from-primary-50 to-sky-50 border border-primary-100 p-6 sm:p-7 mb-10">
                <i class="fa-solid fa-quote-left absolute -top-3 left-6 w-8 h-8 rounded-full bg-primary-600 text-white text-xs flex items-center justify-center shadow-md"></i>
                <p class="text-[11px] font-bold uppercase tracking-wider text-primary-600 mb-2">Ringkasan</p>
                <p class="text-base sm:text-lg font-semibold text-slate-800 leading-relaxed">{{ $news->description }}</p>
            </div>
            @endif

            <!-- Content -->
            <div class="space-y-6 text-[15px] sm:text-[17px] leading-[1.85] text-slate-700">
                @foreach($paragraphs as $i => $p)
                <p class="{{ $i === 0 ? 'first-letter:float-left first-letter:text-6xl first-letter:leading-[0.85] first-letter:font-black first-letter:text-primary-700 first-letter:mr-3 first-letter:mt-1.5' : '' }}">{!! nl2br(e($p)) !!}</p>
                @endforeach
            </div>

            <!-- End ornament -->
            <div class="flex items-center gap-4 my-12" aria-hidden="true">
                <span class="flex-1 h-px bg-gradient-to-r from-transparent to-slate-200"></span>
                <span class="w-9 h-9 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center"><i class="fa-solid fa-heart-pulse text-sm"></i></span>
                <span class="flex-1 h-px bg-gradient-to-l from-transparent to-slate-200"></span>
            </div>

            <!-- Author / source card -->
            <div class="flex flex-col sm:flex-row sm:items-center gap-4 rounded-2xl border border-slate-200 p-5 sm:p-6">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-600 to-sky-500 text-white flex items-center justify-center text-xl font-black shrink-0">
                    @if($news->author)
                        {{ Str::upper(Str::substr($news->author, 0, 1)) }}
                    @else
                        <i class="fa-solid fa-hospital"></i>
                    @endif
                </div>
                <div class="flex-1">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">{{ $news->author ? 'Penulis' : 'Sumber' }}</p>
                    <p class="text-base font-bold text-slate-900">{{ $news->author ?: 'TeFa V-Kes Politeknik Negeri Jember' }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">Teaching Factory Inovasi Kesehatan · Pengembang SIP-Kes</p>
                </div>
                <a href="{{ route('news') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold transition shrink-0">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Berita
                </a>
            </div>
        </article>

        <!-- Sidebar -->
        <aside class="lg:col-span-4">
            <div class="lg:sticky lg:top-28 space-y-5">

                <!-- Info -->
                <div class="rounded-2xl border border-slate-200 bg-slate-50/60 p-5">
                    <h2 class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-900 mb-4">
                        <span class="w-1 h-4 rounded-full bg-primary-600"></span> Informasi Berita
                    </h2>
                    <dl class="space-y-3.5 text-sm">
                        @if($pubDate)
                        <div class="flex items-start gap-3">
                            <dt class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-primary-600 flex items-center justify-center shrink-0"><i class="fa-regular fa-calendar text-xs"></i><span class="sr-only">Tanggal</span></dt>
                            <dd><p class="text-[11px] text-slate-400">Tanggal Publikasi</p><p class="font-semibold text-slate-800">{{ $pubDate->isoFormat('D MMMM Y') }}</p></dd>
                        </div>
                        @endif
                        @if($news->category)
                        <div class="flex items-start gap-3">
                            <dt class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-sky-600 flex items-center justify-center shrink-0"><i class="fa-solid fa-tag text-xs"></i><span class="sr-only">Kategori</span></dt>
                            <dd><p class="text-[11px] text-slate-400">Kategori</p>
                                <a href="{{ route('news', ['category' => $news->category->slug]) }}" class="font-semibold text-slate-800 hover:text-primary-700 transition">{{ $news->category->name }}</a></dd>
                        </div>
                        @endif
                        @if($news->author)
                        <div class="flex items-start gap-3">
                            <dt class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-teal-600 flex items-center justify-center shrink-0"><i class="fa-regular fa-user text-xs"></i><span class="sr-only">Penulis</span></dt>
                            <dd><p class="text-[11px] text-slate-400">Penulis</p><p class="font-semibold text-slate-800">{{ $news->author }}</p></dd>
                        </div>
                        @endif
                        <div class="flex items-start gap-3">
                            <dt class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-amber-500 flex items-center justify-center shrink-0"><i class="fa-regular fa-clock text-xs"></i><span class="sr-only">Waktu baca</span></dt>
                            <dd><p class="text-[11px] text-slate-400">Waktu Baca</p><p class="font-semibold text-slate-800">± {{ $readMinutes }} menit</p></dd>
                        </div>
                    </dl>
                </div>

                <!-- Share -->
                <div class="rounded-2xl border border-slate-200 p-5">
                    <h2 class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-900 mb-4">
                        <span class="w-1 h-4 rounded-full bg-emerald-500"></span> Bagikan Berita
                    </h2>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="https://wa.me/?text={{ urlencode($shareText) }}" target="_blank" rel="noopener"
                           class="inline-flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white text-xs font-bold transition" title="Bagikan ke WhatsApp">
                            <i class="fa-brands fa-whatsapp text-sm"></i> WhatsApp
                        </a>
                        <button type="button" id="copy-link" data-url="{{ $shareUrl }}"
                                class="inline-flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl bg-primary-50 text-primary-700 hover:bg-primary-600 hover:text-white text-xs font-bold transition" title="Salin tautan">
                            <i class="fa-solid fa-link text-sm"></i> <span id="copy-label">Salin Tautan</span>
                        </button>
                    </div>
                    <p id="copy-status" class="hidden mt-3 text-xs font-semibold text-emerald-600"><i class="fa-solid fa-circle-check mr-1"></i> Tautan berhasil disalin</p>
                </div>

                <!-- CTA -->
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-primary-800 to-sky-600 p-5 text-white">
                    <i class="fa-solid fa-stethoscope absolute -right-3 -bottom-3 text-7xl text-white/10" aria-hidden="true"></i>
                    <p class="relative text-sm font-bold mb-1">Ingin menerapkan SIP-Kes?</p>
                    <p class="relative text-xs text-primary-100 leading-relaxed mb-4">Konsultasikan kebutuhan faskes Anda bersama tim TeFa V-Kes Polije.</p>
                    <a href="{{ route('contact') }}" class="relative inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white text-primary-800 text-xs font-bold hover:bg-primary-50 transition">
                        Hubungi Kami <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        </aside>
    </div>
</section>

<!-- ============ RELATED ============ -->
@if($related->isNotEmpty())
<section class="bg-slate-50 border-t border-slate-100 py-14 sm:py-16 px-4 sm:px-6">
    <div class="max-w-5xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
            <div>
                <span class="inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-wider text-primary-600 mb-2">
                    <span class="w-6 h-0.5 bg-primary-600 rounded-full"></span> Baca Juga
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Berita Lainnya</h2>
            </div>
            <a href="{{ route('news') }}" class="inline-flex items-center gap-2 text-sm font-bold text-primary-600 hover:text-primary-700 group">
                Lihat Semua Berita <i class="fa-solid fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($related as $r)
            <a href="{{ $r->detail_url }}" class="group bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 flex flex-col focus:outline-none focus:ring-2 focus:ring-primary-500">
                <div class="relative h-44 bg-slate-100 overflow-hidden flex items-center justify-center shrink-0">
                    @if($r->hasValidImage())
                        <img src="{{ $r->image_url }}" alt="{{ $r->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                        <div class="w-full h-full bg-gradient-to-tr from-primary-800 to-sky-600 flex items-center justify-center">
                            <i class="fa-solid fa-newspaper text-4xl text-white/40 group-hover:scale-110 transition duration-300"></i>
                        </div>
                    @endif
                    @if($r->category)
                    <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-black/60 text-white">{{ $r->category->name }}</span>
                    @endif
                </div>
                <div class="p-5 flex flex-col flex-grow">
                    @if($r->date)
                    <p class="text-[11px] font-semibold text-primary-600 mb-2"><i class="fa-regular fa-calendar mr-1"></i> {{ $r->date->locale('id')->isoFormat('D MMMM Y') }}</p>
                    @endif
                    <h3 class="text-sm sm:text-base font-bold text-slate-800 leading-snug line-clamp-2 group-hover:text-primary-700 transition mb-3">{{ $r->title }}</h3>
                    <span class="mt-auto inline-flex items-center gap-1.5 text-xs font-bold text-primary-600">
                        Baca Selengkapnya <i class="fa-solid fa-arrow-right text-[10px] transition-transform group-hover:translate-x-1"></i>
                    </span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

@push('scripts')
<script>
    (function () {
        // Salin tautan
        const btn = document.getElementById('copy-link');
        const status = document.getElementById('copy-status');
        if (btn) {
            btn.addEventListener('click', function () {
                const url = btn.dataset.url;
                const done = () => { status.classList.remove('hidden'); setTimeout(() => status.classList.add('hidden'), 2500); };
                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(url).then(done).catch(() => window.prompt('Salin tautan berikut:', url));
                } else {
                    window.prompt('Salin tautan berikut:', url);
                }
            });
        }

        // Indikator progres membaca
        const bar = document.getElementById('read-progress');
        const article = document.getElementById('article-body');
        if (bar && article) {
            const update = () => {
                const rect = article.getBoundingClientRect();
                const total = article.offsetHeight - window.innerHeight * 0.6;
                const pct = total > 0 ? Math.min(100, Math.max(0, (-rect.top + window.innerHeight * 0.2) / total * 100)) : 100;
                bar.style.width = pct + '%';
            };
            window.addEventListener('scroll', update, { passive: true });
            window.addEventListener('resize', update);
            update();
        }
    })();
</script>
@endpush
