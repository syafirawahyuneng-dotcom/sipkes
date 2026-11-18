{{--
    Input gambar bersama untuk form admin (PRD Fase 2 · G-01–G-07).
    Pratinjau langsung, tampilkan gambar saat ini, ganti, dan hapus.

    <x-admin.image-input name="image" label="Gambar Fitur" :url="$feature->image_url" hint="Rasio 16:10" />
--}}
@props([
    'name' => 'image',
    'label' => 'Gambar',
    'url' => '',
    'hint' => null,
    'ratio' => 'aspect-[16/9]',
    'required' => false,
    'stacked' => false, // true untuk kolom sempit (pratinjau di atas input)
])
@php
    $id = 'img-' . preg_replace('/[^a-z0-9]+/i', '-', $name) . '-' . substr(md5($name . uniqid('', true)), 0, 6);
    $hasCurrent = filled($url);
    $boxWidth = $stacked ? 'w-full' : 'w-full sm:w-64';
@endphp

<div data-image-input class="space-y-2">
    <label for="{{ $id }}" class="block text-xs font-bold text-slate-700">{{ $label }}{{ $required ? ' *' : '' }}</label>

    <div class="flex flex-col {{ $stacked ? '' : 'sm:flex-row sm:items-start' }} gap-4">
        <div data-preview-box class="{{ $boxWidth }} {{ $ratio }} rounded-2xl overflow-hidden border border-slate-200 shadow-sm bg-slate-100 shrink-0 relative {{ $hasCurrent ? '' : 'hidden' }}">
            <img data-preview src="{{ $url }}" data-original="{{ $url }}" alt="Pratinjau {{ strtolower($label) }}" class="w-full h-full object-cover">
            <span data-preview-label class="absolute top-2 left-2 px-2 py-0.5 rounded-md text-[10px] font-bold bg-black/60 text-white">{{ $hasCurrent ? 'Gambar saat ini' : 'Pratinjau baru' }}</span>
        </div>

        <div data-empty-box class="{{ $boxWidth }} {{ $ratio }} rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 text-slate-400 flex-col items-center justify-center text-center shrink-0 {{ $hasCurrent ? 'hidden' : 'flex' }}">
            <i class="fa-regular fa-image text-3xl mb-1"></i>
            <span class="text-[11px] font-semibold">Belum ada gambar</span>
        </div>

        <div class="flex-1 min-w-0 space-y-2">
            <input type="file" name="{{ $name }}" id="{{ $id }}" data-file accept="image/jpeg,image/png,image/webp,image/gif"
                   class="w-full text-xs px-4 py-2 rounded-xl border border-slate-200 focus:outline-none file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
            <p class="text-[11px] text-slate-400 leading-relaxed">
                Format JPG, PNG, WEBP, GIF. Maksimal 5 MB.{{ $hint ? ' ' . $hint . '.' : '' }}{{ $hasCurrent ? ' Kosongkan bila tidak ingin mengganti gambar.' : '' }}
            </p>
            @if($hasCurrent)
            <label class="inline-flex items-center gap-2 cursor-pointer text-[11px] font-bold text-red-600">
                <input type="checkbox" name="remove_{{ $name }}" value="1" data-remove class="rounded border-slate-300 text-red-600 focus:ring-red-500">
                Hapus gambar ini
            </label>
            @endif
            <p data-error class="text-[11px] text-red-600 hidden"></p>
            @error($name)
            <p class="text-[11px] text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-image-input]').forEach(function (wrap) {
            const input = wrap.querySelector('[data-file]');
            const img = wrap.querySelector('[data-preview]');
            const box = wrap.querySelector('[data-preview-box]');
            const empty = wrap.querySelector('[data-empty-box]');
            const label = wrap.querySelector('[data-preview-label]');
            const err = wrap.querySelector('[data-error]');
            const remove = wrap.querySelector('[data-remove]');
            const show = function (hasImage) {
                box.classList.toggle('hidden', !hasImage);
                empty.classList.toggle('hidden', hasImage);
                empty.classList.toggle('flex', !hasImage);
            };

            input.addEventListener('change', function () {
                const file = input.files && input.files[0];
                err.classList.add('hidden');
                if (!file) { img.src = img.dataset.original; label.textContent = 'Gambar saat ini'; show(!!img.dataset.original); return; }
                if (!/^image\/(jpeg|png|webp|gif)$/.test(file.type)) {
                    err.textContent = 'File harus berupa gambar JPG, PNG, WEBP, atau GIF.';
                    err.classList.remove('hidden'); input.value = ''; return;
                }
                if (file.size > 5 * 1024 * 1024) {
                    err.textContent = 'Ukuran gambar melebihi 5 MB.';
                    err.classList.remove('hidden'); input.value = ''; return;
                }
                img.src = URL.createObjectURL(file);
                label.textContent = 'Pratinjau baru';
                if (remove) remove.checked = false;
                show(true);
            });

            if (remove) {
                remove.addEventListener('change', function () {
                    box.classList.toggle('opacity-40', remove.checked);
                    if (remove.checked) { input.value = ''; img.src = img.dataset.original; label.textContent = 'Akan dihapus'; }
                    else { label.textContent = 'Gambar saat ini'; }
                });
            }
        });
    });
</script>
@endpush
@endonce
