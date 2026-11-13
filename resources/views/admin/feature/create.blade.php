@extends('admin.layout')

@section('title', 'Tambah Fitur')
@section('page_title', 'Tambah Fitur / Modul Baru')

@section('content')

<div class="max-w-2xl bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
    <div class="mb-6">
        <h3 class="text-xl font-bold text-slate-800">Formulir Tambah Fitur</h3>
        <p class="text-xs text-slate-500">Isi data nama fitur, kategori modul, dan deskripsi sesuai fungsi produk SIP-Kes.</p>
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

    <form action="{{ route('admin.features.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Nama Modul / Fitur *</label>
            <input type="text" name="name" required value="{{ old('name') }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Contoh: Pendaftaran Pasien & Cetak Kartu">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Kategori Modul</label>
                <input type="text" name="category" value="{{ old('category') }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Pelayanan / Rekam Medis / Integrasi...">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Font Awesome Icon</label>
                <input type="text" name="icon" value="{{ old('icon', 'fa-circle-check') }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="fa-stethoscope">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Fitur *</label>
            <textarea name="description" rows="4" required class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Jelaskan kapabilitas dan manfaat fitur ini bagi dokter atau staf faskes...">{{ old('description') }}</textarea>
        </div>

        <!-- Konten Halaman Detail Fitur -->
        <div class="pt-4 border-t border-slate-100">
            <p class="text-xs font-bold text-slate-800 mb-1">Konten Halaman Detail Fitur</p>
            <p class="text-[11px] text-slate-500 mb-3">Tulis satu poin per baris. Bagian yang dikosongkan tidak ditampilkan di halaman detail.</p>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Pengguna Modul</label>
                    <textarea name="users" rows="3" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Dokter&#10;Perawat&#10;Petugas pendaftaran">{{ old('users') }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Fungsi Utama</label>
                    <textarea name="functions" rows="5" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Mencatat identitas pasien baru&#10;Memeriksa keaktifan kartu BPJS">{{ old('functions') }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Manfaat bagi Faskes</label>
                    <textarea name="benefits" rows="4" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Pendaftaran lebih cepat&#10;Mencegah duplikasi rekam medis">{{ old('benefits') }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Alur Penggunaan (urut)</label>
                    <textarea name="workflow" rows="4" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Petugas mencari data pasien&#10;Petugas memilih poli tujuan">{{ old('workflow') }}</textarea>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Urutan Tampil (Angka)</label>
                <input type="number" name="order" value="{{ old('order', 0) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div class="pt-5">
                <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                    <span>Tampilkan sebagai Fitur Unggulan di Beranda</span>
                </label>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ route('admin.features.index') }}" class="text-xs font-bold text-slate-500 hover:underline">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs shadow transition">
                Simpan Fitur
            </button>
        </div>
    </form>
</div>

@endsection

