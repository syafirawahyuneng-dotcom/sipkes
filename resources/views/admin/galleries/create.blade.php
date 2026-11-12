@extends('admin.layout')

@section('title', 'Upload Foto Galeri')
@section('page_title', 'Upload Foto Kegiatan Baru')

@section('content')

<div class="max-w-2xl bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
    <div class="mb-6">
        <h3 class="text-xl font-bold text-slate-800">Formulir Upload Foto</h3>
        <p class="text-xs text-slate-500">Unggah foto dokumentasi sosialisasi, pelatihan, atau aktivitas faskes.</p>
    </div>

    <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Judul Kegiatan / Foto *</label>
            <input type="text" name="title" required value="{{ old('title') }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Workshop Implementasi RME Polije">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Kategori Galeri</label>
                <select name="category_id" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Kegiatan</label>
                <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">File Gambar / Foto</label>
            <input type="file" name="image" accept="image/*" class="w-full text-xs px-4 py-2 rounded-xl border border-slate-200 focus:outline-none file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
            <p class="text-[11px] text-slate-400 mt-1">Format JPG, PNG, WEBP. Maksimal 2MB.</p>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Singkat</label>
            <textarea name="description" rows="3" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Penjelasan singkat mengenai dokumentasi foto ini...">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Urutan</label>
            <input type="number" name="order" value="{{ old('order', 0) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ route('admin.galleries.index') }}" class="text-xs font-bold text-slate-500 hover:underline">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs shadow transition">
                Simpan Foto
            </button>
        </div>
    </form>
</div>

@endsection

