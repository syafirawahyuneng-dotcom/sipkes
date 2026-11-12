@extends('admin.layout')

@section('title', 'Tambah Layanan Pendukung')
@section('page_title', 'Tambah Layanan Pendukung Baru')

@section('content')

<div class="max-w-2xl bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
    <div class="mb-6">
        <h3 class="text-xl font-bold text-slate-800">Formulir Tambah Layanan</h3>
        <p class="text-xs text-slate-500">Tambahkan layanan pendampingan faskes oleh tim ahli TeFa V-Kes.</p>
    </div>

    <form action="{{ route('admin.support-services.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Nama Layanan *</label>
            <input type="text" name="title" required value="{{ old('title') }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Pendampingan Klaim BPJS Kesehatan">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Font Awesome Icon</label>
                <input type="text" name="icon" value="{{ old('icon', 'fa-award') }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Urutan</label>
                <input type="number" name="order" value="{{ old('order', 0) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Ringkasan Singkat</label>
            <input type="text" name="summary" value="{{ old('summary') }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Lengkap *</label>
            <textarea name="description" rows="4" required class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Poin Manfaat (1 Baris = 1 Manfaat)</label>
            <textarea name="benefits_text" rows="4" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Audit kelengkapan resume medis&#10;Pelatihan kodifikasi ICD-10&#10;Simulasi pencegahan pending klaim"></textarea>
        </div>

        <div class="pt-2">
            <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                <input type="checkbox" name="is_active" value="1" checked class="rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                <span>Tampilkan di Website Publik</span>
            </label>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ route('admin.support-services.index') }}" class="text-xs font-bold text-slate-500 hover:underline">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs shadow transition">
                Simpan Layanan
            </button>
        </div>
    </form>
</div>

@endsection

