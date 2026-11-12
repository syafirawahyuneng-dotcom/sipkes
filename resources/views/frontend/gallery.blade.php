@extends('layouts.frontend')

@section('title', 'Galeri Kegiatan & Dokumentasi TeFa V-Kes Polije')

@section('content')

<!-- Header Banner -->
<section class="bg-primary-900 text-white py-16 px-4">
    <div class="max-w-7xl mx-auto text-center">
        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-primary-800 text-sky-300 mb-3">Dokumentasi</span>
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight">Galeri & Aktivitas TeFa V-Kes</h1>
        <p class="text-primary-200 text-sm sm:text-base max-w-2xl mx-auto mt-2">
            Dokumentasi implementasi, pelatihan faskes mitra, workshop, serta laboratorium smart health Politeknik Negeri Jember.
        </p>
    </div>
</section>

<!-- Content -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Filter Category Tabs -->
        <div class="flex flex-wrap items-center justify-center gap-2 mb-12">
            <a href="{{ route('gallery') }}" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition {{ !request('category') ? 'bg-primary-600 text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Semua Kategori
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('gallery', ['category' => $cat->slug]) }}" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition {{ request('category') == $cat->slug ? 'bg-primary-600 text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                {{ $cat->name }}
            </a>
            @endforeach
        </div>

        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($galleries as $g)
            <div class="bg-white rounded-3xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-lg transition group">
                <div class="h-56 bg-slate-100 overflow-hidden relative flex items-center justify-center">
                    @if($g->hasValidImage())
                        <img src="{{ $g->image_url }}" alt="{{ $g->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                        <div class="w-full h-full bg-gradient-to-tr from-primary-800 to-sky-600 flex items-center justify-center text-white">
                            <i class="fa-solid fa-camera text-5xl text-white/40 group-hover:scale-110 transition duration-300"></i>
                        </div>
                    @endif
                    
                    @if($g->category)
                    <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-[10px] font-bold uppercase bg-black/60 text-white backdrop-blur-xs">
                        {{ $g->category->name }}
                    </span>
                    @endif

                    @if($g->date)
                    <span class="absolute bottom-4 right-4 px-3 py-1 rounded-full text-[10px] font-semibold bg-black/60 text-white backdrop-blur-xs">
                        <i class="fa-regular fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($g->date)->isoFormat('D MMMM Y') }}
                    </span>
                    @endif
                </div>

                <div class="p-6">
                    <h3 class="font-bold text-slate-900 text-base mb-2 group-hover:text-primary-700 transition">{{ $g->title }}</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">{{ $g->description }}</p>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-16 text-slate-400">
                Belum ada foto dalam kategori ini.
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $galleries->links() }}
        </div>

    </div>
</section>

@endsection

