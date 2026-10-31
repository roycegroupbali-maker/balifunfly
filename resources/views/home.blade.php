@extends('layouts.app')

@section('title', config('site.name').' - '.__('site.meta.home_title'))

@php
    $services = __('site.services.items');
    $steps = __('site.training.steps');
    $features = __('site.features');
    $faq = __('site.faq.items');
@endphp

@section('content')
{{-- Hero. Video: public/videos/hero.mp4 (opsional hero-mobile.mp4 untuk layar kecil) — foto cadangan: public/images/hero.jpg --}}
@php
    // Prioritas: file yang diunggah lewat admin, lalu file manual di public/videos & public/images.
    $setVideo = \App\Models\Setting::get('hero_video');
    $setPoster = \App\Models\Setting::get('hero_poster');
    $heroVideo = ($setVideo && file_exists(public_path($setVideo))) ? asset($setVideo) : (file_exists(public_path('videos/hero.mp4')) ? asset('videos/hero.mp4') : null);
    $heroPoster = ($setPoster && file_exists(public_path($setPoster))) ? asset($setPoster) : (file_exists(public_path('images/hero.jpg')) ? asset('images/hero.jpg') : null);
    $heroTitle = \App\Models\Setting::localized('hero_title', __('site.hero.title'));
    $heroText = \App\Models\Setting::localized('hero_text', __('site.hero.text', ['company' => config('site.company')]));
@endphp
<section class="relative isolate -mt-16 overflow-hidden bg-gradient-to-br from-night via-deep to-sea/70 text-white">
    @if ($heroPoster)
        <img src="{{ $heroPoster }}" alt="" class="absolute inset-0 -z-30 h-full w-full object-cover">
    @endif
    @if ($heroVideo)
        {{-- Sumber video dipasang oleh JS (hemat data & performa di seluler); kalau gagal, foto/gradien tetap tampil. --}}
        <video id="hero-video" class="absolute inset-0 -z-20 h-full w-full object-cover opacity-0 transition-opacity duration-700 motion-reduce:hidden"
               autoplay muted loop playsinline preload="metadata" aria-hidden="true" tabindex="-1"
               @if ($heroPoster) poster="{{ $heroPoster }}" @endif
               disablepictureinpicture disableremoteplayback data-src="{{ $heroVideo }}"></video>
    @endif
    <div class="absolute inset-0 -z-10 bg-gradient-to-b from-night/80 via-night/45 to-night/90"></div>
    <div class="absolute inset-0 -z-10 bg-gradient-to-r from-night/70 via-transparent to-transparent"></div>
    <div class="mx-auto max-w-6xl px-5 pb-28 pt-40 md:pb-44 md:pt-56">
        <p class="mb-5 inline-block rounded-full border border-sun/60 bg-night/30 px-4 py-1.5 text-sm font-semibold text-sun backdrop-blur-sm">{{ __('site.hero.badge') }}</p>
        <h1 class="max-w-3xl font-display text-5xl font-extrabold leading-[1.05] tracking-tight md:text-7xl">{{ $heroTitle }}</h1>
        <p class="mt-6 max-w-xl text-lg text-white/85">{{ $heroText }}</p>
        <div class="mt-9 flex flex-wrap gap-3">
            <a href="{{ route('products.index') }}" class="rounded-full bg-sun px-7 py-3.5 font-semibold text-deep transition hover:brightness-95">{{ __('site.hero.cta_products') }}</a>
            <a href="#kontak" class="rounded-full border border-white/40 px-7 py-3.5 font-semibold transition hover:bg-white/10">{{ __('site.hero.cta_class') }}</a>
        </div>
    </div>
</section>
@if ($heroVideo)
<script>
    (function () {
        var v = document.getElementById('hero-video');
        if (!v) return;
        var c = navigator.connection || {};
        if (c.saveData || window.matchMedia('(prefers-reduced-motion: reduce)').matches) { v.remove(); return; }
        v.src = v.dataset.src;
        v.addEventListener('playing', function () { v.classList.remove('opacity-0'); });
        v.addEventListener('error', function () { v.remove(); });
        var p = v.play(); if (p && p.catch) p.catch(function () {});
        // Hemat baterai & data: jeda video saat hero tidak terlihat atau tab disembunyikan.
        if ('IntersectionObserver' in window) {
            new IntersectionObserver(function (e) { e[0].isIntersecting ? v.play().catch(function () {}) : v.pause(); }).observe(v);
        }
    })();
</script>
@endif

{{-- Keunggulan --}}
<section class="border-b border-ink/10 bg-white">
    <div class="mx-auto grid max-w-6xl gap-8 px-5 py-14 md:grid-cols-3">
        @foreach ($features as [$t, $d])
            <div class="flex gap-4">
                <span class="mt-1 h-3 w-3 shrink-0 rounded-full bg-sun"></span>
                <div><h3 class="font-display text-lg font-bold">{{ $t }}</h3><p class="mt-1 text-ink/70">{{ $d }}</p></div>
            </div>
        @endforeach
    </div>
</section>

{{-- Layanan --}}
<section id="layanan" class="mx-auto max-w-6xl scroll-mt-16 px-5 py-20">
    <h2 class="max-w-xl font-display text-4xl font-extrabold tracking-tight">{{ __('site.services.title') }}</h2>
    <div class="mt-12 grid gap-x-12 md:grid-cols-2">
        @foreach ($services as [$title, $desc])
            <div class="border-t border-ink/15 py-7">
                <h3 class="font-display text-xl font-bold">{{ $title }}</h3>
                <p class="mt-2 text-ink/70">{{ $desc }}</p>
            </div>
        @endforeach
    </div>
</section>

@if (count($products))
{{-- Produk unggulan --}}
<section class="mx-auto max-w-6xl px-5 py-20">
    <div class="flex items-end justify-between gap-4">
        <h2 class="font-display text-4xl font-extrabold tracking-tight">{{ __('site.featured.title') }}</h2>
        <a href="{{ route('products.index') }}" class="font-semibold text-sea hover:underline">{{ __('site.featured.all') }}</a>
    </div>
    <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($products as $p) @include('partials.product-card') @endforeach
    </div>
</section>
@endif

{{-- Pelatihan --}}
<section id="pelatihan" class="scroll-mt-16 bg-mist">
    <div class="mx-auto grid max-w-6xl gap-12 px-5 py-20 lg:grid-cols-5">
        <div class="lg:col-span-2">
            <h2 class="font-display text-4xl font-extrabold tracking-tight">{{ __('site.training.title') }}</h2>
            <p class="mt-4 text-ink/70">{{ __('site.training.text') }}</p>
            <a href="#kontak" class="mt-7 inline-block rounded-full bg-deep px-7 py-3.5 font-semibold text-white transition hover:bg-sea">{{ __('site.training.cta') }}</a>
        </div>
        <ol class="space-y-6 lg:col-span-3">
            @foreach ($steps as $i => [$title, $desc])
                <li class="flex gap-5">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-sea font-display font-bold text-white">{{ $i + 1 }}</span>
                    <div>
                        <h3 class="font-display text-lg font-bold">{{ $title }}</h3>
                        <p class="mt-1 text-ink/70">{{ $desc }}</p>
                    </div>
                </li>
            @endforeach
        </ol>
    </div>
</section>

@if (count($articles))
{{-- Artikel terbaru --}}
<section class="mx-auto max-w-6xl px-5 py-20">
    <div class="flex items-end justify-between gap-4">
        <h2 class="font-display text-4xl font-extrabold tracking-tight">{{ __('site.latest_articles.title') }}</h2>
        <a href="{{ route('articles.index') }}" class="font-semibold text-sea hover:underline">{{ __('site.latest_articles.all') }}</a>
    </div>
    <div class="mt-10 grid gap-x-8 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($articles as $i => $a) @include('partials.article-card') @endforeach
    </div>
</section>
@endif

{{-- FAQ --}}
<section class="mx-auto max-w-3xl px-5 py-20">
    <h2 class="font-display text-4xl font-extrabold tracking-tight">{{ __('site.faq.title') }}</h2>
    <div class="mt-8 divide-y divide-ink/10 border-y border-ink/10">
        @foreach ($faq as [$q, $a])
            <details class="group py-5">
                <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-display text-lg font-bold">{{ $q }}<span class="text-sea transition group-open:rotate-45" aria-hidden="true">+</span></summary>
                <p class="mt-3 text-ink/70">{{ $a }}</p>
            </details>
        @endforeach
    </div>
</section>

@include('partials.inquiry')
@if (count($products))
@include('partials.product-modal')
@endif
@endsection
