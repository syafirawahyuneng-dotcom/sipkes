@extends('layouts.frontend')

@section('title', 'Berita & Kegiatan TeFa V-Kes Polije')

@section('content')

<!-- Header Banner -->
<section class="bg-primary-900 text-white py-16 px-4">
    <div class="max-w-7xl mx-auto text-center">
        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-primary-800 text-sky-300 mb-3">Berita Terkini</span>
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight">Berita SIP-Kes & TeFa V-Kes</h1>
        <p class="text-primary-200 text-sm sm:text-base max-w-2xl mx-auto mt-2">
            Kabar terbaru seputar implementasi SIP-Kes, pelatihan faskes mitra, dan kegiatan Teaching Factory Inovasi Kesehatan Politeknik Negeri Jember.
        </p>
    </div>
</section>

<!-- Content -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Filter Category Tabs -->
        @if($categories->isNotEmpty())
        <div class="flex flex-wrap items-center justify-center gap-2 mb-12">
            <a href="{{ route('news') }}" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition {{ !request('category') ? 'bg-primary-600 text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Semua Berita
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('news', ['category' => $cat->slug]) }}" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition {{ request('category') == $cat->slug ? 'bg-primary-600 text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                {{ $cat->name }}
            </a>
            @endforeach
        </div>
        @endif

        <!-- News Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($news as $item)
            <a href="{{ $item->detail_url }}" class="bg-white rounded-3xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition group flex flex-col focus:outline-none focus:ring-2 focus:ring-primary-500">
                <div class="h-52 bg-slate-100 overflow-hidden relative flex items-center justify-center shrink-0">
                    @if($item->hasValidImage())
                        <img src="{{ $item->image_url }}" alt="{{ $item->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                        <div class="w-full h-full bg-gradient-to-tr from-primary-800 to-sky-600 flex items-center justify-center text-white">
                            <i class="fa-solid fa-newspaper text-5xl text-white/40 group-hover:scale-110 transition duration-300"></i>
                        </div>
                    @endif

                    @if($item->category)
                    <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-[10px] font-bold uppercase bg-black/60 text-white">
                        {{ $item->category->name }}
                    </span>
                    @endif
                </div>

                <div class="p-6 flex flex-col flex-grow">
                    @if($item->date)
                    <p class="text-[11px] font-semibold text-primary-600 mb-2">
                        <i class="fa-regular fa-calendar mr-1"></i> {{ $item->date->locale('id')->isoFormat('D MMMM Y') }}
                    </p>
                    @endif
                    <h2 class="font-bold text-slate-900 text-base leading-snug mb-2 group-hover:text-primary-700 transition">{{ $item->title }}</h2>
                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-3 mb-5">{{ $item->description ?: Str::limit($item->content, 160) }}</p>
                    <span class="mt-auto inline-flex items-center gap-1.5 text-xs font-bold text-primary-600 group-hover:text-primary-700">
                        Baca Selengkapnya <i class="fa-solid fa-arrow-right text-[10px] transition-transform group-hover:translate-x-1"></i>
                    </span>
                </div>
            </a>
            @empty
            <div class="col-span-full text-center py-16 text-slate-400">
                <i class="fa-regular fa-newspaper text-4xl mb-3 block"></i>
                Belum ada berita dalam kategori ini.
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $news->links() }}
        </div>

    </div>
</section>

@endsection
