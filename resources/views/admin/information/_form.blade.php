{{-- Field form Informasi, dipakai oleh create & edit. $information = null saat membuat baru. --}}
@php $info = $information ?? null; @endphp

@if($errors->any())
<div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs">
    <ul class="list-disc list-inside">
        @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

<div>
    <label class="block text-xs font-bold text-slate-700 mb-1">Judul Informasi *</label>
    <input type="text" name="title" required maxlength="255" value="{{ old('title', $info?->title) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Contoh: Jadwal Pelatihan Pengguna SIP-Kes Bulan Desember">
</div>

<x-admin.image-input name="image" label="Foto Informasi" :url="$info?->image_url ?? ''" :required="! $info"
    hint="Foto/poster informasi. Pengunjung dapat mengklik foto untuk melihatnya dalam ukuran besar. JPG, PNG, WEBP, GIF · maks. 5 MB." ratio="aspect-[4/3]" />

<div>
    <label class="block text-xs font-bold text-slate-700 mb-1">Keterangan</label>
    <textarea name="description" rows="4" maxlength="2000" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Penjelasan singkat mengenai informasi ini...">{{ old('description', $info?->description) }}</textarea>
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
    <div>
        <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal</label>
        <input type="date" name="date" value="{{ old('date', $info ? $info->date?->format('Y-m-d') : date('Y-m-d')) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
    </div>
    <div>
        <label class="block text-xs font-bold text-slate-700 mb-1">Urutan Tampil</label>
        <input type="number" name="order" value="{{ old('order', $info?->order ?? 0) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
    </div>
    <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700 pb-3">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $info?->is_active ?? true) ? 'checked' : '' }} class="rounded border-slate-300 text-primary-600 focus:ring-primary-500">
        <span>Tampilkan di portal</span>
    </label>
</div>
