@php
    $tagline = config('site.tagline.'.app()->getLocale());
    $hours = config('site.hours.'.app()->getLocale());
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('favicon.ico') }}?v=2" sizes="any">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}?v=2">
<link rel="icon" type="image/png" sizes="192x192" href="{{ asset('icon-192.png') }}?v=2">
<link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}?v=2">
    <title>@yield('title', config('site.name').' - Paramotor Bali')</title>
    <meta name="description" content="@yield('description', $tagline)">
    <meta property="og:title" content="@yield('title', config('site.name'))">
    <meta property="og:description" content="@yield('description', $tagline)">
    <meta property="og:locale" content="{{ app()->getLocale() === 'id' ? 'id_ID' : 'en_US' }}">
    <meta name="theme-color" content="#071E27">
    <script>try{if(!matchMedia('(prefers-reduced-motion: reduce)').matches)document.documentElement.classList.add('js')}catch(e){}</script>
    {{-- Sinkronkan pilihan bahasa dari localStorage (jika cookie hilang) sebelum halaman tampil. --}}
    <script>
        (function () {
            try {
                var cur = document.documentElement.lang, saved = localStorage.getItem('bf_lang');
                var hasCookie = /(?:^|; )bf_lang=/.test(document.cookie);
                if (!hasCookie && (saved === 'en' || saved === 'id') && saved !== cur && !sessionStorage.getItem('bf_sync')) {
                    sessionStorage.setItem('bf_sync', '1');
                    document.cookie = 'bf_lang=' + saved + '; path=/; max-age=31536000; SameSite=Lax';
                    location.reload();
                } else if (hasCookie) { localStorage.setItem('bf_lang', cur); }
            } catch (e) {}
        })();
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,800&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>@media (prefers-reduced-motion: reduce){*{animation:none!important;transition:none!important;scroll-behavior:auto!important}}</style>
</head>
<body class="bg-white font-sans text-ink antialiased">
@php
    $nav = [
        [__('site.nav.services'), route('home').'#layanan', null],
        [__('site.nav.products'), route('products.index'), 'products.*'],
        [__('site.nav.training'), route('home').'#pelatihan', null],
        [__('site.nav.articles'), route('articles.index'), 'articles.*'],
        [__('site.nav.contact'), route('home').'#kontak', null],
    ];
    $wa = 'https://wa.me/'.config('site.whatsapp').'?text='.rawurlencode(__('site.wa_greeting', ['name' => config('site.name')]));
    $lang = app()->getLocale();
@endphp

<a href="#konten" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded focus:bg-white focus:px-3 focus:py-2">{{ __('site.skip') }}</a>

{{-- Switch bahasa: dipakai di navbar desktop dan menu seluler --}}
@php
    $switcher = function (string $extra = '') use ($lang) {
        $html = '<div class="inline-flex items-center rounded-full border border-white/20 p-0.5 text-xs font-semibold tracking-wide '.$extra.'" role="group" aria-label="'.e(__('site.lang.label')).'">';
        foreach (['en' => 'EN', 'id' => 'ID'] as $code => $label) {
            $on = $lang === $code;
            $html .= '<a href="'.e(route('lang.switch', $code)).'" data-lang="'.$code.'" lang="'.$code.'" hreflang="'.$code.'" title="'.e(__('site.lang.'.$code)).'"'
                .($on ? ' aria-current="true"' : '')
                .' class="rounded-full px-3 py-1 transition-colors '.($on ? 'bg-white text-night' : 'text-white/70 hover:text-white').'">'.$label.'</a>';
        }
        return new \Illuminate\Support\HtmlString($html.'</div>');
    };
@endphp

<div id="bf-progress" aria-hidden="true" class="pointer-events-none fixed inset-x-0 top-0 z-50 h-0.5 bg-sun"></div>

<header id="site-header" data-scrolled="false" class="bf-down sticky top-0 z-40 border-b border-white/10 bg-night/60 text-white backdrop-blur-md transition-[background-color,box-shadow] duration-300 data-[scrolled=true]:bg-night/95 data-[scrolled=true]:shadow-lg data-[scrolled=true]:shadow-black/20">
    <div class="mx-auto flex h-16 max-w-6xl items-center justify-between gap-4 px-5">
        <a href="{{ route('home') }}" aria-label="{{ config('site.name') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/logo-mark.png') }}" alt="{{ config('site.company') }}" class="h-10 w-auto">
            <span class="font-display text-lg font-extrabold uppercase tracking-[0.18em]">{{ config('site.name') }}</span>
        </a>
        <nav class="hidden items-center gap-7 text-sm font-medium md:flex" aria-label="{{ __('site.nav.main') }}">
            @foreach ($nav as [$label, $url, $match])
                <a href="{{ $url }}" class="{{ $match && request()->routeIs($match) ? 'text-sun' : 'text-white/75 hover:text-white' }} transition-colors">{{ $label }}</a>
            @endforeach
            {{ $switcher() }}
            <a href="{{ $wa }}" target="_blank" rel="noopener" class="rounded-full bg-sun px-5 py-2 font-semibold text-deep transition hover:brightness-95 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">{{ __('site.nav.whatsapp') }}</a>
        </nav>
        <div class="flex items-center gap-2 md:hidden">
            {{ $switcher() }}
            <button type="button" class="rounded p-2" aria-label="{{ __('site.nav.open_menu') }}" aria-expanded="false" aria-controls="menu-mobile"
                    onclick="const o=document.getElementById('menu-mobile').classList.toggle('hidden');this.setAttribute('aria-expanded',!o)">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
        </div>
    </div>
    <nav id="menu-mobile" class="hidden border-t border-white/10 bg-night/95 px-5 py-4 md:hidden" aria-label="{{ __('site.nav.mobile') }}">
        @foreach ($nav as [$label, $url, $match])
            <a href="{{ $url }}" class="block py-2 font-medium text-white/90">{{ $label }}</a>
        @endforeach
        <a href="{{ $wa }}" target="_blank" rel="noopener" class="mt-3 block rounded-full bg-sun px-5 py-2 text-center font-semibold text-deep">{{ __('site.nav.whatsapp') }}</a>
    </nav>
</header>

<main id="konten">@yield('content')</main>

<footer class="bg-deep text-white">
    <div class="mx-auto grid max-w-6xl gap-12 px-5 py-14 md:grid-cols-3 [&>*]:min-w-0">
        <div>
            <img src="{{ asset('images/logo.png') }}" alt="{{ config('site.company') }}" class="h-20 w-auto rounded-xl bg-white p-2">
            <p class="mt-3 text-white/70">{{ $tagline }}</p>
            <p class="mt-4 text-sm font-semibold text-white/90">{{ config('site.company') }}</p>
        </div>
        <address class="space-y-1 text-sm not-italic text-white/70">
            <p class="font-semibold text-white">{{ __('site.footer.contact') }}</p>
            <p>{{ config('site.address') }}</p>
            <p><a class="hover:text-white" href="tel:{{ preg_replace('/[^+\d]/', '', config('site.phone')) }}">{{ config('site.phone') }}</a></p>
            <p><a class="hover:text-white" href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a></p>
            <p>{{ $hours }}</p>
            <p><a class="hover:text-white" href="{{ config('site.instagram') }}" target="_blank" rel="noopener">{{ __('site.footer.instagram') }}</a></p>
        </address>
        <form method="POST" action="{{ route('newsletter.store') }}">
            @csrf
            <label for="newsletter_email" class="font-semibold">{{ __('site.footer.newsletter') }}</label>
            <div class="mt-3 flex gap-2">
                <input id="newsletter_email" name="newsletter_email" type="email" required placeholder="{{ __('site.footer.newsletter_placeholder') }}" value="{{ old('newsletter_email') }}"
                       class="min-w-0 flex-1 rounded-full border border-white/20 bg-white/10 px-5 py-3 text-white placeholder-white/40 focus:border-sun focus:outline-none">
                <button class="rounded-full bg-sun px-5 py-3 font-semibold text-deep transition hover:brightness-95">{{ __('site.footer.subscribe') }}</button>
            </div>
            @error('newsletter_email') <p class="mt-2 text-sm text-sun">{{ $message }}</p> @enderror
            @if (session('newsletter_ok')) <p class="mt-2 text-sm text-sun" role="status">{{ session('newsletter_ok') }}</p> @endif
        </form>
    </div>
    <div class="border-t border-white/10 py-5 text-sm text-white/50">
        <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-2 px-5 sm:flex-row">
            <span>&copy; {{ date('Y') }} {{ config('site.company') }}. {{ __('site.footer.rights') }}</span>
            <a href="{{ route('admin.login') }}" rel="nofollow" class="text-white/40 transition-colors hover:text-white">{{ __('site.footer.admin') }}</a>
        </div>
    </div>
</footer>

<a href="{{ $wa }}" target="_blank" rel="noopener" aria-label="{{ __('site.wa_float') }}"
   class="bf-wa fixed bottom-5 right-5 z-40 flex h-14 w-14 items-center justify-center rounded-full bg-[#25D366] text-white shadow-lg transition hover:scale-105">
    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 11.5a8.4 8.4 0 0 1-12.4 7.4L3 20.5l1.7-5.4A8.4 8.4 0 1 1 21 11.5Z"/></svg>
</a>
<script>
    (function () {
        var h = document.getElementById('site-header');
        var bar = document.getElementById('bf-progress'), ticking = false;
        var onScroll = function () {
            h.dataset.scrolled = window.scrollY > 24 ? 'true' : 'false';
            if (ticking) return; ticking = true;
            requestAnimationFrame(function () {
                var max = document.documentElement.scrollHeight - window.innerHeight;
                bar.style.transform = 'scaleX(' + (max > 0 ? Math.min(1, window.scrollY / max) : 0) + ')';
                ticking = false;
            });
        };
        onScroll(); window.addEventListener('scroll', onScroll, { passive: true });

        // Animasi masuk: elemen yang sudah terlihat langsung bergerak masuk, sisanya muncul saat di-scroll.
        if (document.documentElement.classList.contains('js') && 'IntersectionObserver' in window) {
            var SKIP = /^(SCRIPT|STYLE|TEMPLATE|DIALOG|VIDEO)$/;
            var targets = [];
            var collect = function (root) {
                Array.prototype.forEach.call(root.children, function (el, i) {
                    if (SKIP.test(el.tagName) || el.getAttribute('aria-hidden') === 'true') return;
                    if (el.matches('div.grid, ol, div.divide-y')) { collect(el); return; }
                    targets.push([el, Math.min(i, 6) * 90]);
                });
            };
            document.querySelectorAll('#konten > section, #konten > article').forEach(function (sec) {
                collect(sec.querySelector(':scope > .mx-auto') || sec);
            });
            document.querySelectorAll('footer .grid').forEach(collect);

            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (en) {
                    if (!en.isIntersecting) return;
                    var el = en.target; io.unobserve(el);
                    el.classList.add('is-in');
                    // Lepas atribut setelah selesai supaya efek hover elemen (mis. kartu) tidak ikut lambat.
                    setTimeout(function () { el.removeAttribute('data-reveal'); el.classList.remove('is-in'); el.style.removeProperty('--d'); }, 1100 + (parseInt(el.style.getPropertyValue('--d')) || 0));
                });
            }, { rootMargin: '0px 0px -8% 0px', threshold: 0.06 });

            targets.forEach(function (t) {
                var el = t[0], d = t[1];
                el.style.setProperty('--d', d + 'ms');
                if (el.getBoundingClientRect().top < window.innerHeight * 0.92) {
                    el.classList.add('bf-in');
                    el.addEventListener('animationend', function () { el.classList.remove('bf-in'); el.style.removeProperty('--d'); }, { once: true });
                } else {
                    el.setAttribute('data-reveal', '');
                    io.observe(el);
                }
            });
        }

        // Switch bahasa: simpan ke localStorage + cookie (dibaca server), lalu muat ulang halaman ini.
        document.querySelectorAll('[data-lang]').forEach(function (a) {
            a.addEventListener('click', function (e) {
                var l = a.dataset.lang;
                if (l === document.documentElement.lang) { e.preventDefault(); return; }
                try { localStorage.setItem('bf_lang', l); sessionStorage.removeItem('bf_sync'); } catch (err) {}
                document.cookie = 'bf_lang=' + l + '; path=/; max-age=31536000; SameSite=Lax';
                e.preventDefault();
                location.reload();
            });
        });
    })();
</script>
</body>
</html>
