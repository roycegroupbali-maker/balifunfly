{{-- Popup detail produk: galeri foto + deskripsi lengkap. Data dibaca dari <script class="pdata"> di tiap kartu. --}}
<dialog id="product-modal" aria-labelledby="pm-name"
        class="m-auto max-h-[92vh] w-[min(1100px,calc(100%-1.5rem))] overflow-y-auto overscroll-contain rounded-2xl bg-white p-0 text-ink shadow-2xl backdrop:bg-night/80 backdrop:backdrop-blur-sm md:overflow-hidden">
    <div class="relative grid md:max-h-[92vh] md:grid-cols-[1.15fr_1fr]">
        <button type="button" id="pm-close" aria-label="{{ __('site.details.close') }}"
                class="absolute right-3 top-3 z-20 flex h-10 w-10 items-center justify-center rounded-full bg-white/90 text-ink shadow transition hover:bg-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-sea">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg>
        </button>

        {{-- Galeri --}}
        <div class="bg-night">
            <div id="pm-stage" class="relative aspect-[4/3] w-full select-none overflow-hidden md:aspect-auto md:h-[min(560px,60vh)]">
                <img id="pm-main" alt="" class="absolute inset-0 hidden h-full w-full object-contain">
                <div id="pm-fallback" class="absolute inset-0 hidden bg-gradient-to-br">
                    <svg class="absolute inset-0 m-auto w-2/3 text-white/80" viewBox="0 0 200 130" fill="none" stroke="currentColor" aria-hidden="true"><path d="M10 55 Q100 -25 190 55" stroke-width="7" stroke-linecap="round"/><path d="M30 48 L100 105 M70 28 L100 105 M130 28 L100 105 M170 48 L100 105" stroke-width="1.2"/><circle cx="100" cy="112" r="6" fill="currentColor"/></svg>
                </div>
                <span id="pm-tag" class="absolute left-3 top-3 hidden rounded-full bg-brand px-3 py-1 text-xs font-semibold text-white"></span>
                <button type="button" id="pm-prev" aria-label="{{ __('site.details.prev') }}" class="absolute left-3 top-1/2 hidden h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-white/85 text-ink shadow transition hover:bg-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-sea">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="m15 6-6 6 6 6"/></svg>
                </button>
                <button type="button" id="pm-next" aria-label="{{ __('site.details.next') }}" class="absolute right-3 top-1/2 hidden h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-white/85 text-ink shadow transition hover:bg-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-sea">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="m9 6 6 6-6 6"/></svg>
                </button>
                <span id="pm-count" class="absolute bottom-3 right-3 hidden rounded-full bg-night/70 px-3 py-1 text-xs font-semibold text-white" aria-live="polite"></span>
            </div>
            <div id="pm-thumbs" class="flex gap-2 overflow-x-auto p-3" role="tablist"></div>
        </div>

        {{-- Info --}}
        <div class="flex flex-col p-6 md:overflow-y-auto md:p-8">
            <p id="pm-cat" class="text-sm font-semibold text-sea"></p>
            <h2 id="pm-name" class="mt-1 pr-10 font-display text-2xl font-extrabold leading-tight md:text-3xl"></h2>
            <p id="pm-price" class="mt-3 text-xl font-bold text-deep"></p>
            <p id="pm-desc" class="mt-4 text-ink/80"></p>
            <div id="pm-detail-wrap" class="mt-5 hidden border-t border-ink/10 pt-5">
                <h3 class="font-display text-sm font-bold uppercase tracking-wide text-ink/50">{{ __('site.details.about') }}</h3>
                <div id="pm-detail" class="mt-3 space-y-3 text-sm leading-relaxed text-ink/80"></div>
            </div>
            <a id="pm-wa" target="_blank" rel="noopener" class="mt-6 rounded-full bg-deep px-6 py-3 text-center font-semibold text-white transition hover:bg-sea md:sticky md:bottom-0"></a>
        </div>
    </div>
</dialog>

<script>
(function () {
    var dlg = document.getElementById('product-modal');
    if (!dlg || typeof dlg.showModal !== 'function') return;
    var $ = function (id) { return document.getElementById(id); };
    var T = { photo: @json(__('site.details.photo')), photos: @json(__('site.details.photos')) };
    var main = $('pm-main'), fb = $('pm-fallback'), thumbs = $('pm-thumbs'), count = $('pm-count'), prev = $('pm-prev'), next = $('pm-next');
    var imgs = [], cur = 0, name = '', opener = null;

    function fill(tpl, o) { return tpl.replace(/:(\w+)/g, function (m, k) { return k in o ? o[k] : m; }); }

    function show(i) {
        if (!imgs.length) return;
        cur = (i + imgs.length) % imgs.length;
        main.src = imgs[cur];
        main.alt = name + ' - ' + fill(T.photo, { n: cur + 1, total: imgs.length });
        count.textContent = (cur + 1) + ' / ' + imgs.length;
        Array.prototype.forEach.call(thumbs.children, function (b, k) {
            var on = k === cur;
            b.setAttribute('aria-selected', on);
            b.className = 'h-16 w-20 shrink-0 overflow-hidden rounded-lg border-2 transition ' + (on ? 'border-sun opacity-100' : 'border-transparent opacity-60 hover:opacity-100');
            if (on) b.scrollIntoView({ block: 'nearest', inline: 'center' });
        });
        [1, -1].forEach(function (d) { var n = new Image(); n.src = imgs[(cur + d + imgs.length) % imgs.length]; });
    }

    function open(card) {
        var d;
        try { d = JSON.parse(card.querySelector('.pdata').textContent); } catch (e) { return; }
        opener = card.querySelector('[data-product-open]');
        name = d.name; imgs = d.images || [];
        $('pm-cat').textContent = d.cat_label;
        $('pm-name').textContent = d.name;
        $('pm-price').textContent = d.price_label;
        $('pm-desc').textContent = d.desc || '';
        $('pm-desc').classList.toggle('hidden', !d.desc);
        var tag = $('pm-tag'); tag.textContent = d.tag || ''; tag.classList.toggle('hidden', !d.tag);
        var wa = $('pm-wa'); wa.href = d.wa; wa.textContent = d.ask;

        var det = $('pm-detail'); det.textContent = '';
        (d.detail || []).forEach(function (t) { var p = document.createElement('p'); p.textContent = t; det.appendChild(p); });
        $('pm-detail-wrap').classList.toggle('hidden', !(d.detail && d.detail.length));

        var has = imgs.length > 0, multi = imgs.length > 1;
        main.classList.toggle('hidden', !has);
        fb.classList.toggle('hidden', has);
        fb.className = 'absolute inset-0 bg-gradient-to-br ' + d.bg + (has ? ' hidden' : '');
        [prev, next, count].forEach(function (e) { e.classList.toggle('hidden', !multi); e.classList.toggle('flex', multi && e !== count); });
        thumbs.textContent = '';
        thumbs.classList.toggle('hidden', !multi);
        if (multi) imgs.forEach(function (src, k) {
            var b = document.createElement('button'), im = document.createElement('img');
            b.type = 'button'; b.setAttribute('role', 'tab');
            b.setAttribute('aria-label', fill(T.photo, { n: k + 1, total: imgs.length }));
            im.src = src; im.alt = ''; im.loading = 'lazy'; im.className = 'h-full w-full object-cover';
            b.appendChild(im); b.addEventListener('click', function () { show(k); });
            thumbs.appendChild(b);
        });
        dlg.scrollTop = 0; $('pm-detail-wrap').parentElement.scrollTop = 0;
        show(0);
        dlg.showModal();
        document.documentElement.classList.add('overflow-hidden');
    }

    document.addEventListener('click', function (e) {
        var b = e.target.closest('[data-product-open]');
        if (b) open(b.closest('[data-product-card]'));
    });
    prev.addEventListener('click', function () { show(cur - 1); });
    next.addEventListener('click', function () { show(cur + 1); });
    $('pm-close').addEventListener('click', function () { dlg.close(); });
    dlg.addEventListener('click', function (e) { if (e.target === dlg) dlg.close(); });  // klik di luar popup
    dlg.addEventListener('close', function () {
        document.documentElement.classList.remove('overflow-hidden');
        if (opener) opener.focus();
    });
    dlg.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowLeft') { show(cur - 1); } else if (e.key === 'ArrowRight') { show(cur + 1); }
    });

    // Geser (swipe) di layar sentuh
    var x0 = null, stage = $('pm-stage');
    stage.addEventListener('touchstart', function (e) { x0 = e.touches[0].clientX; }, { passive: true });
    stage.addEventListener('touchend', function (e) {
        if (x0 === null) return;
        var dx = e.changedTouches[0].clientX - x0; x0 = null;
        if (Math.abs(dx) > 40) show(cur + (dx < 0 ? 1 : -1));
    }, { passive: true });
})();
</script>
