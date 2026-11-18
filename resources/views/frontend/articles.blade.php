@extends('layouts.frontend')

@section('title', 'Artikel & Wawasan Rekam Medis Elektronik')
@section('meta_description', 'Artikel SIP-Kes: panduan rekam medis elektronik, regulasi PMK 24/2022, akreditasi, serta integrasi SATUSEHAT dan BPJS Kesehatan dari TeFa V-Kes Politeknik Negeri Jember.')

@section('content')

<!-- Header Banner -->
<section class="bg-primary-900 text-white py-16 px-4">
    <div class="max-w-7xl mx-auto text-center">
        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-primary-800 text-sky-300 mb-3">Artikel & Wawasan</span>
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight">Artikel SIP-Kes</h1>
        <p class="text-primary-200 text-sm sm:text-base max-w-2xl mx-auto mt-2">
            Panduan dan wawasan seputar rekam medis elektronik, regulasi, akreditasi, serta integrasi SATUSEHAT & BPJS Kesehatan untuk fasilitas pelayanan kesehatan.
        </p>
    </div>
</section>

<!-- Content -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Pencarian -->
        <form method="GET" action="{{ route('articles') }}" class="max-w-xl mx-auto mb-8 flex gap-2" role="search">
            @if(request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <label for="article-search" class="sr-only">Cari artikel</label>
            <div class="relative flex-1 min-w-0">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input id="article-search" type="search" name="q" value="{{ request('q') }}" placeholder="Cari judul artikel..." class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <button type="submit" class="px-5 py-3 rounded-xl bg-primary-600 hover:bg-primary-700 text-white text-sm font-bold transition shrink-0">Cari</button>
        </form>

        <!-- Filter Category Tabs -->
        @if($categories->isNotEmpty())
        <div class="flex flex-wrap items-center justify-center gap-2 mb-12">
            <a href="{{ route('articles', array_filter(['q' => request('q')])) }}" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition {{ !request('category') ? 'bg-primary-600 text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Semua Artikel
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('articles', array_filter(['category' => $cat->slug, 'q' => request('q')])) }}" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition {{ request('category') == $cat->slug ? 'bg-primary-600 text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                {{ $cat->name }}
            </a>
            @endforeach
        </div>
        @endif

        <!-- Articles Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($articles as $article)
                @include('frontend.partials.article_card', ['article' => $article])
            @empty
            <div class="col-span-full text-center py-16 px-6 rounded-3xl border border-dashed border-slate-200 bg-slate-50">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-primary-50 text-primary-600 flex items-center justify-center text-2xl mb-4">
                    <i class="fa-regular fa-file-lines"></i>
                </div>
                @if(request()->hasAny(['q', 'category']))
                    <p class="font-bold text-slate-800 mb-1">Artikel tidak ditemukan</p>
                    <p class="text-sm text-slate-500 mb-5">Coba kata kunci lain atau lihat semua artikel.</p>
                    <a href="{{ route('articles') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-sm font-bold transition">Lihat Semua Artikel</a>
                @else
                    <p class="font-bold text-slate-800 mb-1">Artikel segera hadir</p>
                    <p class="text-sm text-slate-500 mb-5">Tim TeFa V-Kes sedang menyiapkan artikel seputar rekam medis elektronik. Sementara itu, baca berita terbaru kami.</p>
                    <a href="{{ route('news') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-sm font-bold transition">Baca Berita <i class="fa-regular fa-newspaper"></i></a>
                @endif
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $articles->links() }}
        </div>

    </div>
</section>

@endsection
