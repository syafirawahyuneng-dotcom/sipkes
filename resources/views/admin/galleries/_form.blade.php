{{-- Field form Berita, dipakai oleh create & edit. $gallery = null saat membuat baru. --}}
@php $g = $gallery ?? null; @endphp

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
    <label class="block text-xs font-bold text-slate-700 mb-1">Judul Berita *</label>
    <input type="text" name="title" required value="{{ old('title', $g?->title) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Workshop Implementasi SIP-Kes di Klinik Mitra">
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <label class="block text-xs font-bold text-slate-700 mb-1">Kategori Berita</label>
        <select name="category_id" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ (string) old('category_id', $g?->category_id) === (string) $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Publikasi</label>
        <input type="date" name="date" value="{{ old('date', $g ? $g->date?->format('Y-m-d') : date('Y-m-d')) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
    </div>
</div>

<x-admin.image-input name="image" label="Gambar Utama Berita" :url="$g && $g->hasValidImage() ? $g->image_url : ''" hint="Disarankan rasio 16:9, minimal 1200×675 px" />

<div>
    <label class="block text-xs font-bold text-slate-700 mb-1">Ringkasan Berita</label>
    <textarea name="description" rows="3" maxlength="500" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="1–2 kalimat yang tampil di kartu daftar berita...">{{ old('description', $g?->description) }}</textarea>
</div>

<div>
    <label class="block text-xs font-bold text-slate-700 mb-1">Isi Berita Lengkap</label>
    <textarea name="content" rows="14" data-editor="full" class="wysiwyg w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 leading-relaxed">{{ old('content', $g?->content) }}</textarea>
    <p class="text-[11px] text-slate-400 mt-1">Gunakan toolbar untuk heading, daftar, perataan, dan sisip gambar. Bila dikosongkan, ringkasan dipakai sebagai isi.</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <label class="block text-xs font-bold text-slate-700 mb-1">Penulis / Sumber</label>
        <input type="text" name="author" value="{{ old('author', $g?->author) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Tim TeFa V-Kes Polije">
    </div>
    <div>
        <label class="block text-xs font-bold text-slate-700 mb-1">Urutan</label>
        <input type="number" name="order" value="{{ old('order', $g?->order ?? 0) }}" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
    </div>
</div>
