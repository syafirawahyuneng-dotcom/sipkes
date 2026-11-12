@extends('admin.layout')

@section('title', 'Tambah Keunggulan')
@section('page_title', 'Tambah Keunggulan Sistem Baru')

@section('content')

<div class="max-w-2xl bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
    <div class="mb-6">
        <h3 class="text-xl font-bold text-slate-800">Formulir Keunggulan</h3>
        <p class="text-xs text-slate-500">Tambahkan pilar keunggulan nilai jual SIP-Kes untuk ditampilkan di beranda dan halaman keunggulan.</p>
    </div>

    <form action="{{ route('admin.advantages.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Judul Keunggulan *</label>
            <input type="text" name="title" required value="{{ old('title') }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Contoh: Terintegrasi BPJS Kesehatan">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Icon Font Awesome</label>
                <input type="text" name="icon" value="{{ old('icon', 'fa-shield-halved') }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="fa-cloud">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Urutan Tampil (Angka)</label>
                <input type="number" name="order" value="{{ old('order', 0) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Penjelasan *</label>
            <textarea name="description" rows="4" required class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Jelaskan secara mendalam nilai tambah fitur ini bagi fasilitas kesehatan...">{{ old('description') }}</textarea>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ route('admin.advantages.index') }}" class="text-xs font-bold text-slate-500 hover:underline">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs shadow transition">
                Simpan Keunggulan
            </button>
        </div>
    </form>
</div>

@endsection

