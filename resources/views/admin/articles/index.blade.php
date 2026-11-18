@extends('admin.layout')

@section('title', 'Kelola Artikel')
@section('page_title', 'Kelola Artikel & Kategori Artikel')

@section('content')

@php
    $badge = [
        'draft' => 'bg-slate-100 text-slate-600 border-slate-200',
        'scheduled' => 'bg-amber-50 text-amber-700 border-amber-200',
        'published' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
    ];
@endphp

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h3 class="text-xl font-bold text-slate-800">Artikel SIP-Kes</h3>
        <p class="text-xs text-slate-500">Tulisan edukatif: panduan RME, regulasi, integrasi SATUSEHAT & BPJS, dan tips manajemen faskes.</p>
    </div>
    <a href="{{ route('admin.articles.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs shadow transition self-start">
        <i class="fa-solid fa-pen-to-square"></i> Tulis Artikel Baru
    </a>
</div>

@if($errors->any())
<div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs">
    @foreach($errors->all() as $err)<p>{{ $err }}</p>@endforeach
</div>
@endif

<!-- Kategori Quick Management -->
<div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm mb-6">
    <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">Kategori Artikel:</h4>
    <div class="flex flex-wrap items-center gap-2 mb-4">
        @forelse($categories as $cat)
        <div class="flex items-center gap-1.5 px-3 py-1 rounded-xl bg-slate-100 text-xs font-semibold text-slate-700 border border-slate-200">
            <span>{{ $cat->name }} <span class="text-slate-400">({{ $cat->articles_count }})</span></span>
            <form action="{{ route('admin.articles.categories.destroy', $cat) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kategori ini? Artikel di dalamnya menjadi tanpa kategori.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-slate-400 hover:text-red-500 ml-1" title="Hapus kategori"><i class="fa-solid fa-xmark text-xs"></i></button>
            </form>
        </div>
        @empty
        <p class="text-xs text-slate-400">Belum ada kategori.</p>
        @endforelse
    </div>

    <form action="{{ route('admin.articles.categories.store') }}" method="POST" class="flex items-center gap-2 max-w-sm">
        @csrf
        <input type="text" name="name" required maxlength="100" placeholder="Tambah Kategori Baru..." class="flex-1 min-w-0 text-xs px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
        <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs rounded-xl transition">Tambah</button>
    </form>
</div>

<!-- Filter -->
<form method="GET" action="{{ route('admin.articles.index') }}" class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm mb-6 grid grid-cols-1 sm:grid-cols-4 gap-3">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul artikel..." class="sm:col-span-2 text-xs px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
    <select name="status" class="text-xs px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
        <option value="">Semua Status</option>
        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Terbit</option>
        <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draf</option>
    </select>
    <div class="flex gap-2">
        <select name="category" class="flex-1 min-w-0 text-xs px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ (string) request('category') === (string) $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-3 py-2 rounded-xl bg-primary-600 hover:bg-primary-700 text-white text-xs font-bold" title="Terapkan filter"><i class="fa-solid fa-filter"></i></button>
    </div>
</form>

<!-- Daftar Artikel -->
<div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-xs text-left">
            <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-[10px]">
                <tr>
                    <th class="p-4">Artikel</th>
                    <th class="p-4 hidden md:table-cell">Kategori</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 hidden md:table-cell">Publikasi</th>
                    <th class="p-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($articles as $art)
                <tr class="hover:bg-slate-50/60">
                    <td class="p-4">
                        <div class="flex items-center gap-3 min-w-[220px]">
                            <div class="w-16 h-11 rounded-lg overflow-hidden bg-slate-100 shrink-0 flex items-center justify-center">
                                @if($art->hasValidCover())
                                    <img src="{{ $art->cover_url }}" alt="{{ $art->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-tr from-primary-800 to-sky-600 flex items-center justify-center"><i class="fa-solid fa-file-lines text-white/50"></i></div>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <p class="font-bold text-slate-800 line-clamp-2">
                                    @if($art->is_featured)<i class="fa-solid fa-star text-amber-400 mr-1" title="Artikel unggulan"></i>@endif{{ $art->title }}
                                </p>
                                <p class="text-[11px] text-slate-400">{{ $art->author ?: '—' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="p-4 hidden md:table-cell text-slate-600">{{ $art->category?->name ?? '—' }}</td>
                    <td class="p-4">
                        <span class="inline-block px-2.5 py-1 rounded-full border text-[10px] font-bold uppercase {{ $badge[$art->state] }}">{{ $art->state_label }}</span>
                    </td>
                    <td class="p-4 hidden md:table-cell text-slate-600 whitespace-nowrap">
                        {{ $art->published_at ? $art->published_at->locale('id')->isoFormat('D MMM Y, HH:mm') : '—' }}
                    </td>
                    <td class="p-4">
                        <div class="flex items-center justify-end gap-3 whitespace-nowrap font-bold">
                            <a href="{{ route('admin.articles.preview', $art) }}" target="_blank" class="text-slate-500 hover:text-slate-800">Pratinjau</a>
                            <a href="{{ route('admin.articles.edit', $art) }}" class="text-primary-600 hover:text-primary-800">Edit</a>
                            <form action="{{ route('admin.articles.publish', $art) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="{{ $art->status === 'published' ? 'text-amber-600 hover:text-amber-700' : 'text-emerald-600 hover:text-emerald-700' }}">
                                    {{ $art->status === 'published' ? 'Batalkan Terbit' : 'Terbitkan' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.articles.destroy', $art) }}" method="POST" class="inline" onsubmit="return confirm('Hapus artikel ini beserta gambar utamanya?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-12 text-center text-slate-400">
                        <i class="fa-regular fa-file-lines text-3xl mb-2 block"></i>
                        Belum ada artikel{{ request()->hasAny(['q', 'status', 'category']) ? ' yang sesuai filter' : '' }}.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8">
    {{ $articles->links() }}
</div>

@endsection
