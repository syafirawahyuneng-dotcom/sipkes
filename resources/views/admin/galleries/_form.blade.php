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

<div>
    <label class="block text-xs font-bold text-slate-700 mb-1">Gambar Utama Berita</label>
    <div class="mb-3">
        <p id="image-preview-label" class="text-[11px] text-slate-500 mb-1 {{ $g && $g->hasValidImage() ? '' : 'hidden' }}">{{ $g && $g->hasValidImage() ? 'Gambar saat ini:' : 'Pratinjau gambar baru:' }}</p>
        <div id="image-preview-box" class="w-64 aspect-[16/9] rounded-2xl overflow-hidden border border-slate-200 shadow-sm bg-slate-100 {{ $g && $g->hasValidImage() ? '' : 'hidden' }}">
            <img id="image-preview" src="{{ $g && $g->hasValidImage() ? $g->image_url : '' }}" alt="Pratinjau gambar berita" class="w-full h-full object-cover">
        </div>
    </div>
    <input type="file" name="image" id="image-input" accept="image/jpeg,image/png,image/webp,image/gif" class="w-full text-xs px-4 py-2 rounded-xl border border-slate-200 focus:outline-none file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
    <p class="text-[11px] text-slate-400 mt-1">Format JPG, PNG, WEBP, GIF. Maksimal 5MB.{{ $g ? ' Kosongkan bila tidak ingin mengganti gambar.' : '' }}</p>
    <p id="image-error" class="text-[11px] text-red-600 mt-1 hidden"></p>
</div>

<script>
    (function () {
        const input = document.getElementById('image-input');
        const img = document.getElementById('image-preview');
        const box = document.getElementById('image-preview-box');
        const label = document.getElementById('image-preview-label');
        const err = document.getElementById('image-error');
        if (!input) return;
        input.addEventListener('change', function () {
            const file = input.files && input.files[0];
            err.classList.add('hidden');
            if (!file) return;
            if (!/^image\/(jpeg|png|webp|gif)$/.test(file.type)) {
                err.textContent = 'File harus berupa gambar JPG, PNG, WEBP, atau GIF.';
                err.classList.remove('hidden'); input.value = ''; return;
            }
            if (file.size > 5 * 1024 * 1024) {
                err.textContent = 'Ukuran gambar melebihi 5MB.';
                err.classList.remove('hidden'); input.value = ''; return;
            }
            img.src = URL.createObjectURL(file);
            label.textContent = 'Pratinjau gambar baru:';
            label.classList.remove('hidden');
            box.classList.remove('hidden');
        });
    })();
</script>

<div>
    <label class="block text-xs font-bold text-slate-700 mb-1">Ringkasan Berita</label>
    <textarea name="description" rows="3" maxlength="500" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="1–2 kalimat yang tampil di kartu daftar berita...">{{ old('description', $g?->description) }}</textarea>
</div>

<div>
    <label class="block text-xs font-bold text-slate-700 mb-1">Isi Berita Lengkap</label>
    <textarea name="content" rows="12" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 leading-relaxed" placeholder="Tulis isi berita. Pisahkan paragraf dengan satu baris kosong.">{{ old('content', $g?->content) }}</textarea>
    <p class="text-[11px] text-slate-400 mt-1">Pisahkan paragraf dengan satu baris kosong. Bila dikosongkan, ringkasan dipakai sebagai isi.</p>
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
