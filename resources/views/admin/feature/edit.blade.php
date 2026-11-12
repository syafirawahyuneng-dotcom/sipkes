@extends('admin.layout')

@section('title', 'Edit Fitur RME')
@section('page_title', 'Edit Modul Fitur SIP-Kes')

@section('content')

<div class="max-w-2xl bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
    <div class="mb-6">
        <h3 class="text-xl font-bold text-slate-800">Edit Data Fitur</h3>
        <p class="text-xs text-slate-500">Perbarui rincian informasi modul untuk portal publik.</p>
    </div>

    @if($errors->any())
    <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.features.update', $feature) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Nama Modul / Fitur *</label>
            <input type="text" name="name" required value="{{ old('name', $feature->name) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Kategori Modul</label>
                <input type="text" name="category" value="{{ old('category', $feature->category) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Font Awesome Icon</label>
                <input type="text" name="icon" value="{{ old('icon', $feature->icon) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Fitur *</label>
            <textarea name="description" rows="4" required class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('description', $feature->description) }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Urutan Tampil (Angka)</label>
                <input type="number" name="order" value="{{ old('order', $feature->order) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div class="pt-5">
                <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $feature->is_featured) ? 'checked' : '' }} class="rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                    <span>Tampilkan sebagai Fitur Unggulan di Beranda</span>
                </label>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ route('admin.features.index') }}" class="text-xs font-bold text-slate-500 hover:underline">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs shadow transition">
                Perbarui Fitur
            </button>
        </div>
    </form>
</div>

@endsection

