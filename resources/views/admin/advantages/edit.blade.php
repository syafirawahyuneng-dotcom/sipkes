@extends('admin.layout')

@section('title', 'Edit Keunggulan')
@section('page_title', 'Edit Data Keunggulan Sistem')

@section('content')

<div class="max-w-2xl bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
    <div class="mb-6">
        <h3 class="text-xl font-bold text-slate-800">Edit Data Keunggulan</h3>
        <p class="text-xs text-slate-500">Perbarui informasi keunggulan sistem SIP-Kes.</p>
    </div>

    <form action="{{ route('admin.advantages.update', $advantage) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Judul Keunggulan *</label>
            <input type="text" name="title" required value="{{ old('title', $advantage->title) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Icon Font Awesome</label>
                <input type="text" name="icon" value="{{ old('icon', $advantage->icon) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Urutan Tampil (Angka)</label>
                <input type="number" name="order" value="{{ old('order', $advantage->order) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Penjelasan *</label>
            <textarea name="description" rows="4" required class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('description', $advantage->description) }}</textarea>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ route('admin.advantages.index') }}" class="text-xs font-bold text-slate-500 hover:underline">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs shadow transition">
                Perbarui Keunggulan
            </button>
        </div>
    </form>
</div>

@endsection

