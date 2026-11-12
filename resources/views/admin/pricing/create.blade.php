@extends('admin.layout')

@section('title', 'Tambah Paket Harga')
@section('page_title', 'Tambah Paket Berlangganan Baru')

@section('content')

<div class="max-w-2xl bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
    <div class="mb-6">
        <h3 class="text-xl font-bold text-slate-800">Formulir Tambah Paket</h3>
        <p class="text-xs text-slate-500">Buat paket berlangganan baru dengan rincian fitur per baris.</p>
    </div>

    <form action="{{ route('admin.pricing.store') }}" method="POST" class="space-y-4">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Paket *</label>
                <input type="text" name="name" required value="{{ old('name') }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Klinik Pratama">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Badge (Opsional)</label>
                <input type="text" name="badge" value="{{ old('badge') }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Paling Populer">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Harga Langganan (Angka Rp) *</label>
                <input type="number" name="price" required value="{{ old('price') }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="350000">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Periode Waktu *</label>
                <input type="text" name="period" required value="{{ old('period', 'bulan') }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="bulan / tahun">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Ringkas</label>
            <input type="text" name="description" value="{{ old('description') }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Dirancang untuk Klinik Rawat Jalan...">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Fitur yang Termasuk (1 Baris = 1 Fitur)</label>
            <textarea name="features_text" rows="5" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Akses Sistem RME Cloud&#10;Bridging SATUSEHAT Kemenkes&#10;Modul Kasir & Farmasi&#10;Free Training SDM"></textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Ketentuan Layanan (1 Baris = 1 Poin)</label>
            <textarea name="terms_text" rows="3" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Biaya langganan bulanan&#10;Termasuk backup data mingguan"></textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Urutan</label>
                <input type="number" name="order" value="{{ old('order', 0) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div class="pt-5">
                <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                    <input type="checkbox" name="is_active" value="1" checked class="rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                    <span>Status Paket Aktif & Tampil di Publik</span>
                </label>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ route('admin.pricing.index') }}" class="text-xs font-bold text-slate-500 hover:underline">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs shadow transition">
                Simpan Paket
            </button>
        </div>
    </form>
</div>

@endsection

