{{--
    WYSIWYG editor (TinyMCE 7, self-hosted via jsDelivr, lisensi GPL) — PRD Fase 2 · W-01–W-09.
    Aktif otomatis untuk <textarea class="wysiwyg">. Tambahkan data-editor="full" untuk
    preset lengkap (sisip gambar) pada Artikel & Berita. TinyMCE hanya dimuat bila halaman
    memiliki field .wysiwyg.
--}}
<style>
    .tox-tinymce { border-radius: 0.75rem !important; border-color: #e2e8f0 !important; }
    .wysiwyg-error .tox-tinymce { border-color: #f87171 !important; }
</style>
<script>
(function () {
    const fields = document.querySelectorAll('textarea.wysiwyg');
    if (!fields.length) return;

    const csrf = @json(csrf_token());
    const uploadUrl = @json(route('admin.editor.upload'));

    // Atribut required pada textarea yang disembunyikan editor membuat browser menolak submit
    // tanpa pesan; validasi wajib isi dipindahkan ke pemeriksaan saat submit (dan server).
    fields.forEach(function (ta, i) {
        if (!ta.id) ta.id = 'wysiwyg-' + i;
        if (ta.hasAttribute('required')) { ta.removeAttribute('required'); ta.dataset.required = '1'; }
    });

    const base = {
        license_key: 'gpl',
        promotion: false,
        branding: false,
        menubar: false,
        toolbar_mode: 'wrap',
        language: 'id',
        language_url: 'https://cdn.jsdelivr.net/npm/tinymce-i18n@25.11.17/langs7/id.js',
        plugins: 'lists advlist link table code fullscreen wordcount autolink',
        block_formats: 'Paragraf=p; Heading 2=h2; Heading 3=h3; Heading 4=h4',
        content_style: 'body { font-family: Inter, system-ui, sans-serif; font-size: 14px; line-height: 1.7; color: #334155; } img { max-width: 100%; height: auto; border-radius: 12px; } h2, h3, h4 { color: #0f172a; }',
        convert_urls: false,
        link_default_target: '_blank',
        link_assume_external_targets: 'https',
        resize: true,
        elementpath: false,
        setup: function (editor) {
            editor.on('change input undo redo', function () { editor.save(); });
        }
    };

    const basicToolbar = 'undo redo | blocks | bold italic underline strikethrough | bullist numlist | alignleft aligncenter alignright alignjustify | link blockquote table | removeformat code fullscreen';

    function uploadImage(blobInfo) {
        return new Promise(function (resolve, reject) {
            const data = new FormData();
            data.append('file', blobInfo.blob(), blobInfo.filename());
            fetch(uploadUrl, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                body: data,
                credentials: 'same-origin'
            }).then(function (res) {
                return res.json().then(function (json) { return { ok: res.ok, json: json }; });
            }).then(function (r) {
                if (!r.ok || !r.json.location) {
                    const msg = (r.json.errors && r.json.errors.file && r.json.errors.file[0]) || r.json.message || 'Gagal mengunggah gambar.';
                    reject({ message: msg, remove: true });
                    return;
                }
                resolve(r.json.location);
            }).catch(function () { reject({ message: 'Gagal mengunggah gambar.', remove: true }); });
        });
    }

    function init() {
        tinymce.init(Object.assign({}, base, {
            selector: 'textarea.wysiwyg:not([data-editor="full"])',
            height: 300,
            toolbar: basicToolbar
        }));

        tinymce.init(Object.assign({}, base, {
            selector: 'textarea.wysiwyg[data-editor="full"]',
            height: 500,
            plugins: base.plugins + ' image',
            toolbar: basicToolbar.replace('link blockquote table', 'link image blockquote table'),
            image_caption: false,
            automatic_uploads: true,
            images_file_types: 'jpeg,jpg,png,gif,webp',
            images_upload_handler: uploadImage
        }));
    }

    // Validasi wajib isi di sisi klien (server tetap memvalidasi).
    document.querySelectorAll('form').forEach(function (form) {
        if (!form.querySelector('textarea.wysiwyg')) return;
        form.addEventListener('submit', function (e) {
            if (window.tinymce) tinymce.triggerSave();
            let firstInvalid = null;
            form.querySelectorAll('textarea.wysiwyg[data-required]').forEach(function (ta) {
                const wrap = ta.parentElement;
                const ed = window.tinymce ? tinymce.get(ta.id) : null;
                const text = ed ? ed.getContent({ format: 'text' }).trim() : ta.value.replace(/<[^>]*>/g, '').trim();
                const hasImg = ed ? !!ed.getBody().querySelector('img') : /<img/i.test(ta.value);
                const empty = text === '' && !hasImg;
                wrap.classList.toggle('wysiwyg-error', empty);
                let msg = wrap.querySelector('[data-editor-error]');
                if (empty && !msg) {
                    msg = document.createElement('p');
                    msg.dataset.editorError = '1';
                    msg.className = 'text-[11px] text-red-600 mt-1';
                    msg.textContent = 'Bagian ini wajib diisi.';
                    wrap.appendChild(msg);
                } else if (!empty && msg) {
                    msg.remove();
                }
                if (empty && !firstInvalid) firstInvalid = ed ? ed.getContainer() : ta;
            });
            if (firstInvalid) {
                e.preventDefault();
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    });

    const s = document.createElement('script');
    s.src = 'https://cdn.jsdelivr.net/npm/tinymce@7.6.1/tinymce.min.js';
    s.referrerPolicy = 'origin';
    s.onload = init;
    document.head.appendChild(s);
})();
</script>
