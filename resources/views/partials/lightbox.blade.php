{{--
    Image Preview / Lightbox global (dipasang di layouts.frontend & admin.layout).

    Otomatis untuk semua <img> di halaman:
      - Gambar biasa            → klik gambar membuka preview.
      - Gambar di dalam link/tombol (mis. kartu berita) → tautan tetap berfungsi;
        muncul tombol kecil "Perbesar" di pojok gambar untuk membuka preview.
    Pemicu eksplisit: elemen dengan [data-lightbox] dan data-src / data-title /
      data-date / data-desc / data-lightbox-group.
    Kecualikan gambar: tambahkan [data-no-preview] pada gambar atau pembungkusnya.
    Gambar yang kecil (< 64px, mis. logo/ikon/avatar) diabaikan otomatis.
    Penutupan: tombol X, tombol ESC, atau klik area di luar gambar.
--}}
<style>
    .sk-lb { position: fixed; inset: 0; z-index: 2147483000; display: none; font-family: inherit; }
    .sk-lb.is-open { display: block; }
    .sk-lb__backdrop { position: absolute; inset: 0; background: rgba(2, 6, 23, .92); opacity: 0; transition: opacity .25s ease; backdrop-filter: blur(4px); }
    .sk-lb.is-visible .sk-lb__backdrop { opacity: 1; }
    .sk-lb__wrap { position: relative; height: 100%; display: flex; flex-direction: column; color: #fff; }
    .sk-lb__bar { position: relative; z-index: 2; display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 12px 16px; }
    .sk-lb__count { font-size: 12px; font-weight: 600; padding: 4px 12px; border-radius: 999px; background: rgba(255,255,255,.1); }
    .sk-lb__count:empty { visibility: hidden; }
    .sk-lb__tools { display: flex; gap: 8px; }
    .sk-lb__btn { width: 40px; height: 40px; border-radius: 999px; border: 0; background: rgba(255,255,255,.12); color: #fff; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; font-size: 15px; text-decoration: none; transition: background .2s, transform .2s; }
    .sk-lb__btn:hover { background: rgba(255,255,255,.25); }
    .sk-lb__btn:focus-visible { outline: 3px solid #38bdf8; outline-offset: 2px; }
    .sk-lb__btn--close:hover { background: #ef4444; }
    .sk-lb__stage { position: relative; flex: 1; min-height: 0; display: flex; align-items: center; justify-content: center; padding: 0 16px; overflow: hidden; }
    @media (min-width: 640px) { .sk-lb__stage { padding: 0 80px; } .sk-lb__bar { padding: 16px 24px; } }
    .sk-lb__img { max-width: 100%; max-height: 100%; object-fit: contain; border-radius: 12px; box-shadow: 0 25px 60px rgba(0,0,0,.5); user-select: none; opacity: 0; transform: scale(.96); transition: opacity .25s ease, transform .3s ease; cursor: zoom-in; background: rgba(255,255,255,.04); }
    .sk-lb__img.is-shown { opacity: 1; transform: scale(1); }
    .sk-lb__img.is-zoomed { transform: scale(2); cursor: zoom-out; }
    .sk-lb__nav { position: absolute; top: 50%; transform: translateY(-50%); z-index: 2; width: 46px; height: 46px; }
    .sk-lb__nav--prev { left: 8px; } .sk-lb__nav--next { right: 8px; }
    @media (min-width: 640px) { .sk-lb__nav--prev { left: 20px; } .sk-lb__nav--next { right: 20px; } }
    .sk-lb__loader { position: absolute; inset: 0; display: none; align-items: center; justify-content: center; font-size: 28px; color: rgba(255,255,255,.6); pointer-events: none; }
    .sk-lb.is-loading .sk-lb__loader { display: flex; }
    .sk-lb__cap { position: relative; z-index: 2; padding: 14px 16px 22px; text-align: center; }
    .sk-lb__cap-inner { max-width: 760px; margin: 0 auto; }
    .sk-lb__date { font-size: 11px; font-weight: 600; color: #7dd3fc; margin: 0 0 4px; }
    .sk-lb__title { font-size: 16px; font-weight: 700; margin: 0; }
    .sk-lb__desc { font-size: 13px; color: #cbd5e1; margin: 6px 0 0; line-height: 1.6; max-height: 6.5em; overflow-y: auto; }
    .sk-lb__hint { font-size: 10px; color: #64748b; margin: 10px 0 0; }
    @media (max-width: 639px) { .sk-lb__hint { display: none; } }
    .sk-lb [hidden] { display: none !important; }

    /* Gambar yang bisa diperbesar langsung */
    img.sk-lb-zoomable { cursor: zoom-in; }
    img.sk-lb-zoomable:focus-visible { outline: 3px solid #38bdf8; outline-offset: 2px; }
    /* Tombol "Perbesar" untuk gambar di dalam link/tombol */
    .sk-lb-expand { position: absolute; top: 10px; right: 10px; z-index: 5; width: 34px; height: 34px; border-radius: 999px; border: 0; background: rgba(15,23,42,.65); color: #fff; display: inline-flex; align-items: center; justify-content: center; cursor: zoom-in; font-size: 13px; opacity: 0; transform: scale(.85); transition: opacity .2s, transform .2s, background .2s; box-shadow: 0 4px 12px rgba(0,0,0,.25); }
    .sk-lb-host:hover > .sk-lb-expand, .sk-lb-expand:focus-visible { opacity: 1; transform: scale(1); }
    .sk-lb-expand:hover { background: #2563eb; }
    .sk-lb-expand:focus-visible { outline: 3px solid #38bdf8; outline-offset: 2px; }
    @media (hover: none) { .sk-lb-expand { opacity: 1; transform: scale(1); } }
</style>

<div id="sk-lightbox" class="sk-lb" role="dialog" aria-modal="true" aria-label="Pratinjau gambar" data-no-preview>
    <div class="sk-lb__backdrop" data-lb-close></div>
    <div class="sk-lb__wrap">
        <div class="sk-lb__bar">
            <span class="sk-lb__count" data-lb-count></span>
            <div class="sk-lb__tools">
                <button type="button" class="sk-lb__btn" data-lb-zoom title="Perbesar / perkecil (Z)" aria-label="Perbesar atau perkecil gambar"><i class="fa-solid fa-magnifying-glass-plus"></i></button>
                <a class="sk-lb__btn" data-lb-original href="#" target="_blank" rel="noopener" title="Buka gambar asli" aria-label="Buka gambar asli di tab baru"><i class="fa-solid fa-up-right-from-square"></i></a>
                <button type="button" class="sk-lb__btn sk-lb__btn--close" data-lb-close title="Tutup (Esc)" aria-label="Tutup pratinjau"><i class="fa-solid fa-xmark" style="font-size:18px"></i></button>
            </div>
        </div>
        <div class="sk-lb__stage" data-lb-stage>
            <button type="button" class="sk-lb__btn sk-lb__nav sk-lb__nav--prev" data-lb-prev aria-label="Gambar sebelumnya"><i class="fa-solid fa-chevron-left"></i></button>
            <div class="sk-lb__loader" aria-hidden="true"><i class="fa-solid fa-circle-notch fa-spin"></i></div>
            <img class="sk-lb__img" data-lb-img src="" alt="">
            <button type="button" class="sk-lb__btn sk-lb__nav sk-lb__nav--next" data-lb-next aria-label="Gambar berikutnya"><i class="fa-solid fa-chevron-right"></i></button>
        </div>
        <div class="sk-lb__cap">
            <div class="sk-lb__cap-inner">
                <p class="sk-lb__date" data-lb-date hidden></p>
                <p class="sk-lb__title" data-lb-title></p>
                <p class="sk-lb__desc" data-lb-desc hidden></p>
                <p class="sk-lb__hint">← → navigasi · Z perbesar · Esc / klik di luar gambar untuk menutup</p>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    if (window.SkLightbox) return;
    const box = document.getElementById('sk-lightbox');
    if (!box) return;

    const $ = sel => box.querySelector(sel);
    const img = $('[data-lb-img]'), stage = $('[data-lb-stage]');
    const ui = {
        count: $('[data-lb-count]'), title: $('[data-lb-title]'), date: $('[data-lb-date]'),
        desc: $('[data-lb-desc]'), original: $('[data-lb-original]'), zoom: $('[data-lb-zoom]'),
        prev: $('[data-lb-prev]'), next: $('[data-lb-next]'), close: box.querySelector('.sk-lb__btn--close'),
    };
    const MIN_SIZE = 64;
    const INTERACTIVE = 'a[href], button, label, [role="button"], summary';

    let items = [], index = 0, zoomed = false, lastFocus = null, closeTimer = null;

    // ---------- Penentuan gambar yang bisa dipreview ----------
    function isExcluded(el) {
        return !!el.closest('[data-no-preview], [data-lightbox], #sk-lightbox, [aria-hidden="true"]')
            || el.getAttribute('role') === 'presentation';
    }
    function srcOf(im) { return im.dataset.full || im.currentSrc || im.src || ''; }
    function isUsable(im) {
        const s = srcOf(im);
        if (!s || /^(about:|javascript:)/i.test(s)) return false;
        if (im.complete && im.naturalWidth > 0 && im.naturalWidth < MIN_SIZE && im.naturalHeight < MIN_SIZE) return false;
        const r = im.getBoundingClientRect();
        if (r.width > 0 && (r.width < MIN_SIZE || r.height < MIN_SIZE)) return false;
        return true;
    }
    function captionOf(im) {
        const fig = im.closest('figure');
        const fc = fig && fig.querySelector('figcaption');
        return {
            title: im.dataset.title || im.getAttribute('title') || im.alt || (fc ? fc.textContent.trim() : ''),
            date: im.dataset.date || '',
            desc: im.dataset.desc || (fc && fc.textContent.trim() !== im.alt ? fc.textContent.trim() : ''),
        };
    }
    function groupOf(el) {
        const g = el.closest('[data-lightbox-group]');
        return el.dataset.lightboxGroup || (g ? g.dataset.lightboxGroup : 'page');
    }
    function itemFromTrigger(t) {
        if (t.dataset.lightbox !== undefined) {
            const inner = t.querySelector('img');
            return { el: t, src: t.dataset.src || (inner ? srcOf(inner) : ''), title: t.dataset.title || (inner ? inner.alt : ''), date: t.dataset.date || '', desc: t.dataset.desc || '', group: groupOf(t) };
        }
        const im = t.tagName === 'IMG' ? t : t._skLbImg;
        return Object.assign({ el: t, src: srcOf(im), group: groupOf(im) }, captionOf(im));
    }

    // Tandai gambar: zoomable langsung, atau sisipkan tombol "Perbesar" bila di dalam link/tombol
    function prepare(im) {
        if (im._skLb || isExcluded(im) || !isUsable(im)) return;
        const rect = im.getBoundingClientRect();
        if (rect.width === 0 && rect.height === 0) return; // tersembunyi: dicoba lagi saat tampil
        im._skLb = true;

        const interactive = im.closest(INTERACTIVE);
        if (!interactive) {
            im.classList.add('sk-lb-zoomable');
            im.setAttribute('data-lb-trigger', '');
            if (!im.hasAttribute('tabindex')) im.tabIndex = 0;
            im.setAttribute('role', 'button');
            im.setAttribute('aria-label', 'Perbesar gambar' + (im.alt ? ': ' + im.alt : ''));
            return;
        }

        const host = im.parentElement;
        if (!host || host.querySelector(':scope > .sk-lb-expand')) return;
        if (getComputedStyle(host).position === 'static') host.style.position = 'relative';
        host.classList.add('sk-lb-host');
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'sk-lb-expand';
        btn.setAttribute('data-lb-trigger', '');
        btn.setAttribute('aria-label', 'Perbesar gambar' + (im.alt ? ': ' + im.alt : ''));
        btn.title = 'Perbesar gambar';
        btn.innerHTML = '<i class="fa-solid fa-expand"></i>';
        btn._skLbImg = im;
        host.appendChild(btn);
    }

    function scan(root) {
        (root || document).querySelectorAll('img').forEach(prepare);
    }

    // ---------- Modal ----------
    function triggersInGroup(group) {
        return Array.from(document.querySelectorAll('[data-lb-trigger], [data-lightbox]'))
            .filter(t => t.isConnected && !t.closest('#sk-lightbox'))
            .map(itemFromTrigger)
            .filter(it => it.src && it.group === group);
    }

    function setZoom(on, originEvt) {
        zoomed = on;
        if (on && originEvt) {
            const r = img.getBoundingClientRect();
            img.style.transformOrigin = ((originEvt.clientX - r.left) / r.width * 100) + '% ' + ((originEvt.clientY - r.top) / r.height * 100) + '%';
        } else if (!on) {
            img.style.transformOrigin = 'center';
        }
        img.classList.toggle('is-zoomed', on);
        ui.zoom.innerHTML = on ? '<i class="fa-solid fa-magnifying-glass-minus"></i>' : '<i class="fa-solid fa-magnifying-glass-plus"></i>';
    }

    function render() {
        const it = items[index];
        setZoom(false);
        img.classList.remove('is-shown');
        box.classList.add('is-loading');
        const pre = new Image();
        pre.onload = pre.onerror = () => {
            if (items[index] !== it) return;
            img.src = it.src;
            img.alt = it.title || 'Gambar';
            box.classList.remove('is-loading');
            requestAnimationFrame(() => img.classList.add('is-shown'));
        };
        pre.src = it.src;

        ui.title.textContent = it.title || '';
        ui.date.textContent = it.date || ''; ui.date.hidden = !it.date;
        ui.desc.textContent = it.desc || ''; ui.desc.hidden = !it.desc;
        ui.original.href = it.src;
        const many = items.length > 1;
        ui.count.textContent = many ? (index + 1) + ' / ' + items.length : '';
        ui.prev.hidden = ui.next.hidden = !many;
    }

    function open(trigger) {
        const it = itemFromTrigger(trigger);
        if (!it.src) return;
        items = triggersInGroup(it.group);
        index = Math.max(0, items.findIndex(x => x.el === trigger));
        if (!items.length) { items = [it]; index = 0; }

        clearTimeout(closeTimer);
        lastFocus = document.activeElement;
        box.classList.add('is-open');
        document.documentElement.style.overflow = 'hidden';
        requestAnimationFrame(() => box.classList.add('is-visible'));
        render();
        ui.close.focus({ preventScroll: true });
    }

    function close() {
        if (!box.classList.contains('is-open')) return;
        box.classList.remove('is-visible');
        img.classList.remove('is-shown');
        closeTimer = setTimeout(() => {
            box.classList.remove('is-open', 'is-loading');
            img.removeAttribute('src');
            document.documentElement.style.overflow = '';
            if (lastFocus && lastFocus.focus) lastFocus.focus({ preventScroll: true });
        }, 220);
    }

    function step(d) { if (items.length > 1) { index = (index + d + items.length) % items.length; render(); } }

    // ---------- Event ----------
    document.addEventListener('click', e => {
        const t = e.target.closest('[data-lightbox], [data-lb-trigger]');
        if (!t || t.closest('#sk-lightbox')) return;
        e.preventDefault();
        e.stopPropagation();
        open(t);
    }, true);

    document.addEventListener('keydown', e => {
        if (!box.classList.contains('is-open')) {
            const t = e.target;
            if ((e.key === 'Enter' || e.key === ' ') && t && t.matches && t.matches('img[data-lb-trigger]')) { e.preventDefault(); open(t); }
            return;
        }
        if (e.key === 'Escape') { e.preventDefault(); close(); }
        else if (e.key === 'ArrowLeft') step(-1);
        else if (e.key === 'ArrowRight') step(1);
        else if (e.key === 'z' || e.key === 'Z') setZoom(!zoomed);
        else if (e.key === 'Tab') {
            const f = Array.from(box.querySelectorAll('button, a[href]')).filter(n => !n.hidden && n.offsetParent !== null);
            if (!f.length) return;
            const first = f[0], last = f[f.length - 1];
            if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
            else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
        }
    });

    box.querySelectorAll('[data-lb-close]').forEach(b => b.addEventListener('click', close));
    ui.prev.addEventListener('click', e => { e.stopPropagation(); step(-1); });
    ui.next.addEventListener('click', e => { e.stopPropagation(); step(1); });
    ui.zoom.addEventListener('click', () => setZoom(!zoomed));
    img.addEventListener('click', e => { e.stopPropagation(); setZoom(!zoomed, e); });
    // Klik area di luar gambar (panggung kosong / keterangan / bar) menutup preview
    box.querySelector('.sk-lb__wrap').addEventListener('click', e => {
        if (e.target.closest('button, a, img, .sk-lb__cap-inner, .sk-lb__count')) return;
        close();
    });

    let touchX = null;
    stage.addEventListener('touchstart', e => { touchX = e.touches[0].clientX; }, { passive: true });
    stage.addEventListener('touchend', e => {
        if (touchX === null || zoomed) return;
        const dx = e.changedTouches[0].clientX - touchX;
        if (Math.abs(dx) > 50) step(dx < 0 ? 1 : -1);
        touchX = null;
    });

    // ---------- Inisialisasi & gambar yang muncul belakangan ----------
    let pending = null;
    function scheduleScan() { clearTimeout(pending); pending = setTimeout(() => scan(document), 120); }
    document.addEventListener('load', e => { if (e.target && e.target.tagName === 'IMG') scheduleScan(); }, true);
    window.addEventListener('load', scheduleScan);
    window.addEventListener('resize', scheduleScan);
    if ('MutationObserver' in window) {
        new MutationObserver(scheduleScan).observe(document.body, { childList: true, subtree: true, attributes: true, attributeFilter: ['class', 'hidden', 'src'] });
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', () => scan(document));
    else scan(document);

    window.SkLightbox = { open, close, refresh: () => scan(document) };
})();
</script>
