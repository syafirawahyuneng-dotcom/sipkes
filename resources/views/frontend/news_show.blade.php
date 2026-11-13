@extends('layouts.frontend')

@section('title', $news->title . ' - Berita SIP-Kes')

@section('content')

<!-- Header -->
<section class="bg-primary-900 text-white pt-12 pb-28 sm:pb-32 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="flex flex-wrap items-center gap-2 text-xs text-primary-200 mb-6" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[9px] text-primary-400"></i>
            <a href="{{ route('news') }}" class="hover:text-white transition">Berita</a>
            <i class="fa-solid fa-chevron-right text-[9px] text-primary-400"></i>
            <span class="text-white font-semibold line-clamp-1">{{ $news->title }}</span>
        </nav>

        @if($news->category)
        <a href="{{ route('news', ['category' => $news->category->slug]) }}" class="inline-block px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-primary-800 text-sky-300 hover:bg-primary-700 transition mb-4">
            {{ $news->category->name }}
        </a>
        @endif

        <h1 class="text-2xl sm:text-4xl font-black tracking-tight leading-tight">{{ $news->title }}</h1>

        <div class="flex flex-wrap items-center gap-x-5 gap-y-2 mt-5 text-xs text-primary-200">
            @if($news->date)
            <span><i class="fa-regular fa-calendar mr-1.5"></i> Dipublikasikan {{ $news->date->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
            @endif
            @if($news->author)
            <span><i class="fa-regular fa-user mr-1.5"></i> {{ $news->author }}</span>
            @endif
        </div>
    </div>
</section>

<!-- Article -->
<section class="bg-slate-50 pb-16 px-4">
    <div class="max-w-4xl mx-auto -mt-20 sm:-mt-24">
        <article class="bg-white rounded-3xl border border-slate-200 shadow-lg overflow-hidden">
            <div class="aspect-[16/9] bg-slate-100 flex items-center justify-center">
                @if($news->hasValidImage())
                    <img src="{{ $news->image_url }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-tr from-primary-800 to-sky-600 flex items-center justify-center">
                        <i class="fa-solid fa-newspaper text-7xl text-white/30"></i>
                    </div>
                @endif
            </div>

            <div class="p-6 sm:p-10">
                @if($news->description && $news->content)
                <p class="text-base sm:text-lg font-semibold text-slate-800 leading-relaxed border-l-4 border-primary-500 pl-4 mb-8">{{ $news->description }}</p>
                @endif

                <div class="space-y-5 text-sm sm:text-base text-slate-700 leading-relaxed">
                    @foreach($news->paragraphs() as $p)
                    <p>{!! nl2br(e($p)) !!}</p>
                    @endforeach
                </div>

                <!-- Share & Back -->
                <div class="mt-10 pt-6 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <a href="{{ route('news') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold transition w-fit">
                        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Berita
                    </a>
                    <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
                        <span>Bagikan:</span>
                        <a href="https://wa.me/?text={{ urlencode($news->title . ' - ' . url()->current()) }}" target="_blank" rel="noopener" class="w-9 h-9 rounded-full bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white flex items-center justify-center transition" title="Bagikan ke WhatsApp">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                        <button type="button" id="copy-link" data-url="{{ url()->current() }}" class="w-9 h-9 rounded-full bg-primary-50 text-primary-600 hover:bg-primary-600 hover:text-white flex items-center justify-center transition" title="Salin tautan">
                            <i class="fa-solid fa-link"></i>
                        </button>
                        <span id="copy-status" class="text-emerald-600 hidden">Tautan disalin</span>
                    </div>
                </div>
            </div>
        </article>

        <!-- Related News -->
        @if($related->isNotEmpty())
        <div class="mt-14">
            <h2 class="text-xl font-extrabold text-slate-900 mb-6">Berita Lainnya</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                @foreach($related as $r)
                <a href="{{ $r->detail_url }}" class="group bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col">
                    <div class="h-32 bg-slate-100 overflow-hidden flex items-center justify-center">
                        @if($r->hasValidImage())
                            <img src="{{ $r->image_url }}" alt="{{ $r->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full bg-gradient-to-tr from-primary-800 to-sky-600 flex items-center justify-center">
                                <i class="fa-solid fa-newspaper text-3xl text-white/40"></i>
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        @if($r->date)
                        <p class="text-[10px] font-semibold text-primary-600 mb-1">{{ $r->date->locale('id')->isoFormat('D MMMM Y') }}</p>
                        @endif
                        <h3 class="text-sm font-bold text-slate-800 leading-snug line-clamp-2 group-hover:text-primary-700 transition">{{ $r->title }}</h3>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

@endsection

@push('scripts')
<script>
    (function () {
        const btn = document.getElementById('copy-link');
        const status = document.getElementById('copy-status');
        if (!btn) return;
        btn.addEventListener('click', function () {
            const url = btn.dataset.url;
            const done = () => { status.classList.remove('hidden'); setTimeout(() => status.classList.add('hidden'), 2000); };
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(url).then(done).catch(() => window.prompt('Salin tautan berikut:', url));
            } else {
                window.prompt('Salin tautan berikut:', url);
            }
        });
    })();
</script>
@endpush
