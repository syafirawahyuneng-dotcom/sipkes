@extends('layouts.frontend')

@section('title', 'Informasi SIP-Kes & TeFa V-Kes Polije')

@section('content')

<!-- Header Banner -->
<section class="relative overflow-hidden bg-primary-900 text-white py-16 px-4">
    <div class="absolute inset-0 opacity-[0.07]" aria-hidden="true"
         style="background-image: radial-gradient(circle at 1px 1px, #fff 1px, transparent 0); background-size: 22px 22px;"></div>
    <div class="absolute -top-24 -right-24 w-80 h-80 rounded-full bg-sky-400/20 blur-3xl" aria-hidden="true"></div>
    <div class="relative max-w-7xl mx-auto text-center">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-primary-800 text-sky-300 mb-3">
            <i class="fa-solid fa-circle-info text-[10px]"></i> Informasi
        </span>
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight">Pusat Informasi SIP-Kes</h1>
        <p class="text-primary-200 text-sm sm:text-base max-w-2xl mx-auto mt-2">
            Informasi, pengumuman, dan materi visual seputar layanan SIP-Kes dan TeFa V-Kes Polije. Klik foto untuk melihat dalam ukuran lebih besar.
        </p>
    </div>
</section>

<!-- Content -->
<section class="py-14 sm:py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if($items->isNotEmpty())
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-8">
            <p class="text-sm text-slate-500">
                Menampilkan <span class="font-bold text-slate-800">{{ $items->firstItem() }}–{{ $items->lastItem() }}</span> dari <span class="font-bold text-slate-800">{{ $items->total() }}</span> informasi
            </p>
            <p class="inline-flex items-center gap-2 text-xs font-semibold text-primary-700 bg-primary-50 border border-primary-100 px-3 py-1.5 rounded-full w-fit">
                <i class="fa-solid fa-magnifying-glass-plus"></i> Klik foto untuk memperbesar
            </p>
        </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @forelse($items as $item)
            @php $hasImage = $item->hasValidImage(); @endphp
            <article class="group bg-white rounded-3xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 flex flex-col">
                <!-- Photo -->
                @if($hasImage)
                <button type="button" data-lightbox data-lightbox-group="informasi"
                        class="info-photo relative block w-full aspect-[4/3] bg-slate-100 overflow-hidden cursor-zoom-in focus:outline-none focus-visible:ring-4 focus-visible:ring-primary-400"
                        data-src="{{ $item->image_url }}"
                        data-title="{{ $item->title }}"
                        data-date="{{ $item->date?->locale('id')->isoFormat('D MMMM Y') }}"
                        data-desc="{{ $item->description }}"
                        aria-label="Perbesar foto: {{ $item->title }}">
                    <img src="{{ $item->image_url }}" alt="{{ $item->title }}" loading="lazy"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <span class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-primary-900/10 to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></span>
                    <span class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                        <span class="w-14 h-14 rounded-full bg-white/95 text-primary-700 shadow-lg flex items-center justify-center text-xl scale-75 group-hover:scale-100 transition duration-300">
                            <i class="fa-solid fa-magnifying-glass-plus"></i>
                        </span>
                    </span>
                    <span class="absolute bottom-3 right-3 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-black/60 text-white">
                        <i class="fa-solid fa-expand"></i> Perbesar
                    </span>
                </button>
                @else
                <div class="relative w-full aspect-[4/3] bg-gradient-to-tr from-primary-800 to-sky-600 flex items-center justify-center">
                    <i class="fa-solid fa-circle-info text-5xl text-white/40"></i>
                </div>
                @endif

                <!-- Body -->
                <div class="p-6 flex flex-col flex-grow">
                    @if($item->date)
                    <p class="text-[11px] font-semibold text-primary-600 mb-2">
                        <i class="fa-regular fa-calendar mr-1"></i> {{ $item->date->locale('id')->isoFormat('D MMMM Y') }}
                    </p>
                    @endif
                    <h2 class="font-bold text-slate-900 text-base leading-snug mb-2">{{ $item->title }}</h2>
                    @if($item->description)
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed line-clamp-4">{{ $item->description }}</p>
                    @endif
                    @if($hasImage)
                    <button type="button" class="info-open mt-auto pt-4 inline-flex items-center gap-1.5 text-xs font-bold text-primary-600 hover:text-primary-700 w-fit">
                        <i class="fa-regular fa-image"></i> Lihat foto
                    </button>
                    @endif
                </div>
            </article>
            @empty
            <div class="col-span-full text-center py-20 bg-white rounded-3xl border border-dashed border-slate-300">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-primary-50 text-primary-600 flex items-center justify-center text-2xl mb-4">
                    <i class="fa-solid fa-circle-info"></i>
                </div>
                <p class="font-bold text-slate-700">Belum ada informasi</p>
                <p class="text-sm text-slate-400 mt-1">Informasi terbaru akan segera ditampilkan di sini.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $items->links() }}
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // "Lihat foto" membuka foto pada kartu yang sama di lightbox global (partials/lightbox)
    document.querySelectorAll('.info-open').forEach(btn => btn.addEventListener('click', () => {
        const photo = btn.closest('article').querySelector('.info-photo');
        if (photo) photo.click();
    }));
</script>
@endpush
