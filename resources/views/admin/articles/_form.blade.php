{{-- Field form Artikel, dipakai oleh create & edit. $article = null saat membuat baru. --}}
@php
    $a = $article ?? null;
    $statusValue = old('status', $a?->status ?? 'draft');
    $publishedValue = old('published_at', $a?->published_at?->format('Y-m-d\TH:i'));
    $input = 'w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500';
@endphp

@if($errors->any())
<div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs">
    <ul class="list-disc list-inside">
        @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <!-- Kolom utama -->
    <div class="xl:col-span-2 space-y-5">
        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Judul Artikel *</label>
            <input type="text" name="title" required maxlength="255" value="{{ old('title', $a?->title) }}" class="{{ $input }}" placeholder="Panduan Memulai Rekam Medis Elektronik di Klinik Pratama">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Ringkasan</label>
            <textarea name="excerpt" rows="3" maxlength="300" class="{{ $input }}" placeholder="1–2 kalimat yang tampil di kartu daftar artikel. Bila kosong, diambil otomatis dari isi.">{{ old('excerpt', $a?->excerpt) }}</textarea>
            <p class="text-[11px] text-slate-400 mt-1">Teks polos, maksimal 300 karakter.</p>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Isi Artikel *</label>
            <textarea name="content" rows="18" required class="wysiwyg {{ $input }}" data-editor="full">{{ old('content', $a?->content) }}</textarea>
            <p class="text-[11px] text-slate-400 mt-1">Gunakan heading, daftar, tabel, dan sisipkan gambar langsung dari toolbar editor.</p>
        </div>
    </div>

    <!-- Kolom samping -->
    <div class="space-y-5">
        <div class="rounded-2xl border border-slate-200 bg-slate-50/60 p-5 space-y-4">
            <p class="text-xs font-bold text-slate-800 uppercase tracking-wider">Publikasi</p>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Status *</label>
                <select name="status" class="{{ $input }} bg-white">
                    <option value="draft" {{ $statusValue === 'draft' ? 'selected' : '' }}>Draf (belum tampil di portal)</option>
                    <option value="published" {{ $statusValue === 'published' ? 'selected' : '' }}>Terbit</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal & Jam Publikasi</label>
                <input type="datetime-local" name="published_at" value="{{ $publishedValue }}" class="{{ $input }} bg-white">
                <p class="text-[11px] text-slate-400 mt-1">Kosongkan untuk memakai waktu saat diterbitkan. Tanggal di masa depan = terjadwal.</p>
            </div>
            <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $a?->is_featured) ? 'checked' : '' }} class="rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                <span>Artikel unggulan (diprioritaskan di beranda)</span>
            </label>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Kategori Artikel</label>
            <select name="category_id" class="{{ $input }}">
                <option value="">-- Tanpa Kategori --</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ (string) old('category_id', $a?->category_id) === (string) $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <p class="text-[11px] text-slate-400 mt-1">Kategori dikelola di halaman daftar artikel.</p>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Penulis</label>
            <input type="text" name="author" maxlength="255" value="{{ old('author', $a?->author) }}" class="{{ $input }}" placeholder="{{ Auth::guard('admin')->user()->name ?? 'Tim TeFa V-Kes' }}">
            <p class="text-[11px] text-slate-400 mt-1">Bila kosong, memakai nama admin yang login.</p>
        </div>

        <x-admin.image-input name="cover_image" label="Gambar Utama (Cover)" :url="$a?->cover_url" hint="Disarankan rasio 16:9, minimal 1200×675 px" stacked />

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Meta Description (SEO)</label>
            <textarea name="meta_description" rows="3" maxlength="160" class="{{ $input }}" placeholder="Deskripsi singkat untuk mesin pencari & media sosial.">{{ old('meta_description', $a?->meta_description) }}</textarea>
            <p class="text-[11px] text-slate-400 mt-1">Maksimal 160 karakter. Bila kosong, memakai ringkasan.</p>
        </div>
    </div>
</div>
