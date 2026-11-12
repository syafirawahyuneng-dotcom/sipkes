@extends('admin.layout')

@section('title', 'Kelola Galeri')
@section('page_title', 'Kelola Galeri Foto & Kategori Dokumentasi')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h3 class="text-xl font-bold text-slate-800">Galeri Foto TeFa V-Kes</h3>
        <p class="text-xs text-slate-500">Unggah dan kelola foto kegiatan sosialisasi, pelatihan, dan fasilitas rekam medis.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.galleries.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs shadow transition">
            <i class="fa-solid fa-cloud-arrow-up"></i> Upload Foto Baru
        </a>
    </div>
</div>

<!-- Kategori Quick Management -->
<div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm mb-8">
    <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">Kategori Galeri:</h4>
    <div class="flex flex-wrap items-center gap-2 mb-4">
        @foreach($categories as $cat)
        <div class="flex items-center gap-1.5 px-3 py-1 rounded-xl bg-slate-100 text-xs font-semibold text-slate-700 border border-slate-200">
            <span>{{ $cat->name }}</span>
            <form action="{{ route('admin.galleries.category.destroy', $cat) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kategori ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-slate-400 hover:text-red-500 ml-1"><i class="fa-solid fa-xmark text-xs"></i></button>
            </form>
        </div>
        @endforeach
    </div>

    <form action="{{ route('admin.galleries.category.store') }}" method="POST" class="flex items-center gap-2 max-w-sm">
        @csrf
        <input type="text" name="name" required placeholder="Tambah Kategori Baru..." class="flex-1 text-xs px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
        <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs rounded-xl transition">
            Tambah
        </button>
    </form>
</div>

<!-- Gallery Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($galleries as $g)
    <div class="bg-white rounded-3xl overflow-hidden border border-slate-200 shadow-sm flex flex-col justify-between">
        <div>
            <div class="h-44 bg-slate-100 overflow-hidden relative flex items-center justify-center">
                @if($g->hasValidImage())
                    <img src="{{ $g->image_url }}" alt="{{ $g->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-tr from-primary-800 to-sky-600 flex items-center justify-center text-white">
                        <i class="fa-solid fa-camera text-4xl text-white/40"></i>
                    </div>
                @endif
                @if($g->category)
                <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-black/60 text-white backdrop-blur-xs">
                    {{ $g->category->name }}
                </span>
                @endif
            </div>
            <div class="p-5">
                <h4 class="font-bold text-slate-900 text-sm mb-1">{{ $g->title }}</h4>
                <p class="text-xs text-slate-500 line-clamp-2">{{ $g->description }}</p>
                @if($g->date)
                <p class="text-[10px] text-slate-400 mt-2"><i class="fa-regular fa-calendar mr-1"></i> {{ $g->date->format('d/m/Y') }}</p>
                @endif
            </div>
        </div>

        <div class="p-4 pt-0 flex items-center justify-end gap-3 text-xs border-t border-slate-100">
            <a href="{{ route('admin.galleries.edit', $g) }}" class="text-primary-600 hover:text-primary-800 font-bold">Edit</a>
            <form action="{{ route('admin.galleries.destroy', $g) }}" method="POST" class="inline" onsubmit="return confirm('Hapus foto ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700 font-bold">Hapus</button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-12 text-slate-400 bg-white rounded-3xl border border-slate-200">
        Belum ada foto dalam galeri.
    </div>
    @endforelse
</div>

<div class="mt-8">
    {{ $galleries->links() }}
</div>

@endsection

