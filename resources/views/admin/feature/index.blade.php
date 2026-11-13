@extends('admin.layout')

@section('title', 'Kelola Fitur & Modul')
@section('page_title', 'Kelola Fitur & Modul SIP-Kes')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h3 class="text-xl font-bold text-slate-800">Daftar Modul SIP-Kes</h3>
        <p class="text-xs text-slate-500">Kelola semua fitur yang ditampilkan pada halaman portal publik.</p>
    </div>
    <a href="{{ route('admin.features.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs shadow transition">
        <i class="fa-solid fa-plus"></i> Tambah Fitur Baru
    </a>
</div>

<div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider">
                    <th class="p-4 w-12 text-center">Urutan</th>
                    <th class="p-4">Nama Fitur</th>
                    <th class="p-4">Kategori</th>
                    <th class="p-4">Deskripsi</th>
                    <th class="p-4 text-center">Unggulan (Home)</th>
                    <th class="p-4 text-center w-28">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($features as $feat)
                <tr class="hover:bg-slate-50 transition">
                    <td class="p-4 text-center font-bold text-slate-500">{{ $feat->order }}</td>
                    <td class="p-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center shrink-0">
                                <i class="fa-solid {{ $feat->icon ?? 'fa-circle-check' }}"></i>
                            </div>
                            <span class="font-bold text-slate-800">{{ $feat->name }}</span>
                        </div>
                    </td>
                    <td class="p-4">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-slate-100 text-slate-600">
                            {{ $feat->category ?? '-' }}
                        </span>
                    </td>
                    <td class="p-4 text-slate-600 max-w-xs">{{ Str::limit($feat->description, 75) }}</td>
                    <td class="p-4 text-center">
                        @if($feat->is_featured)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-700">Ya</span>
                        @else
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500">Tidak</span>
                        @endif
                    </td>
                    <td class="p-4 text-center space-x-2">
                        <a href="{{ $feat->detail_url }}" target="_blank" class="text-slate-500 hover:text-slate-800 font-bold">Lihat</a>
                        <a href="{{ route('admin.features.edit', $feat) }}" class="text-primary-600 hover:text-primary-800 font-bold">Edit</a>
                        <form action="{{ route('admin.features.destroy', $feat) }}" method="POST" class="inline" onsubmit="return confirm('Hapus fitur ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 font-bold">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-slate-400">Belum ada fitur.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(method_exists($features, 'links'))
    <div class="p-4 border-t border-slate-100">
        {{ $features->links() }}
    </div>
    @endif
</div>

@endsection

