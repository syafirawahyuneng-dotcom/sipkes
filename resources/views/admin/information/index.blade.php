@extends('admin.layout')

@section('title', 'Kelola Informasi')
@section('page_title', 'Kelola Informasi')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h3 class="text-xl font-bold text-slate-800">Informasi Bergambar</h3>
        <p class="text-xs text-slate-500">Tampil di portal pada menu Fitur & Layanan → Informasi. Foto dapat diperbesar oleh pengunjung.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('information') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
            <i class="fa-solid fa-eye"></i> Lihat Halaman
        </a>
        <a href="{{ route('admin.information.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs shadow transition">
            <i class="fa-solid fa-plus"></i> Tambah Informasi
        </a>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($items as $item)
    <div class="bg-white rounded-3xl overflow-hidden border border-slate-200 shadow-sm flex flex-col justify-between">
        <div>
            <div class="aspect-[4/3] bg-slate-100 overflow-hidden relative flex items-center justify-center">
                @if($item->hasValidImage())
                    <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-tr from-primary-800 to-sky-600 flex items-center justify-center">
                        <i class="fa-solid fa-circle-info text-4xl text-white/40"></i>
                    </div>
                @endif
                <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $item->is_active ? 'bg-emerald-500 text-white' : 'bg-slate-700 text-white' }}">
                    {{ $item->is_active ? 'Tampil' : 'Disembunyikan' }}
                </span>
            </div>
            <div class="p-5">
                <h4 class="font-bold text-slate-900 text-sm mb-1">{{ $item->title }}</h4>
                <p class="text-xs text-slate-500 line-clamp-2">{{ $item->description }}</p>
                <p class="text-[10px] text-slate-400 mt-2">
                    @if($item->date)<i class="fa-regular fa-calendar mr-1"></i> {{ $item->date->format('d/m/Y') }} · @endif
                    Urutan #{{ $item->order }}
                </p>
            </div>
        </div>

        <div class="p-4 pt-3 flex items-center justify-end gap-3 text-xs border-t border-slate-100">
            <a href="{{ route('admin.information.edit', $item) }}" class="text-primary-600 hover:text-primary-800 font-bold">Edit</a>
            <form action="{{ route('admin.information.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus informasi ini beserta fotonya?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700 font-bold">Hapus</button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-12 text-slate-400 bg-white rounded-3xl border border-slate-200">
        Belum ada informasi. Klik <span class="font-bold text-slate-600">Tambah Informasi</span> untuk mulai.
    </div>
    @endforelse
</div>

<div class="mt-8">
    {{ $items->links() }}
</div>

@endsection
