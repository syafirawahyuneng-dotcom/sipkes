@extends('admin.layout')

@section('title', 'Kelola Beranda')
@section('page_title', 'Kelola Konten Hero & Banner Beranda')

@section('content')

<div class="max-w-4xl bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
    <div class="mb-6">
        <h3 class="text-xl font-bold text-slate-800">Edit Hero Section Beranda</h3>
        <p class="text-xs text-slate-500">Sesuaikan teks headline, sub-headline, badge, dan tombol aksi yang tampil pada pengunjung pertama kali.</p>
    </div>

    <form action="{{ route('admin.home.update') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Badge / Label Kecil Atas</label>
            <input type="text" name="badge" value="{{ old('badge', $banner->badge) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="🏥 Portal Resmi SIP-Kes • TeFa V-Kes Polije">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Judul Utama (Headline) *</label>
            <input type="text" name="title" required value="{{ old('title', $banner->title) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Singkat (Subtitle) *</label>
            <textarea name="subtitle" rows="3" required class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('subtitle', $banner->subtitle) }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Teks Tombol Utama</label>
                <input type="text" name="primary_btn_text" value="{{ old('primary_btn_text', $banner->primary_btn_text) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">URL Target Tombol Utama</label>
                <input type="text" name="primary_btn_url" value="{{ old('primary_btn_url', $banner->primary_btn_url) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Teks Tombol Kedua</label>
                <input type="text" name="secondary_btn_text" value="{{ old('secondary_btn_text', $banner->secondary_btn_text) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">URL Target Tombol Kedua</label>
                <input type="text" name="secondary_btn_url" value="{{ old('secondary_btn_url', $banner->secondary_btn_url) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs shadow-md transition">
                <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Perubahan Beranda
            </button>
        </div>
    </form>
</div>

@endsection

