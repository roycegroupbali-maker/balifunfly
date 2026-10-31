<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('favicon.ico') }}?v=2" sizes="any">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}?v=2">
<link rel="icon" type="image/png" sizes="192x192" href="{{ asset('icon-192.png') }}?v=2">
<link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}?v=2">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Admin') - {{ config('site.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,800&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-mist font-sans text-ink antialiased">
@php
    $menu = [
        ['Dashboard', 'admin.dashboard', 'admin.dashboard'],
        ['Produk', 'admin.products.index', 'admin.products.*'],
        ['Artikel', 'admin.articles.index', 'admin.articles.*'],
        ['Pesan masuk', 'admin.inquiries.index', 'admin.inquiries.*'],
        ['Newsletter', 'admin.subscribers.index', 'admin.subscribers.*'],
        ['Pengaturan', 'admin.settings.edit', 'admin.settings.*'],
    ];
@endphp
<div class="lg:flex">
    <aside class="bg-night text-white lg:sticky lg:top-0 lg:h-screen lg:w-64 lg:shrink-0">
        <div class="flex items-center justify-between gap-3 px-5 py-4 lg:block lg:py-6">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo-mark.png') }}" alt="" class="h-9 w-auto">
                <span class="font-display text-lg font-extrabold uppercase tracking-[0.14em]">Admin</span>
            </a>
            <a href="{{ route('home') }}" target="_blank" class="text-sm text-white/60 hover:text-white lg:mt-3 lg:block">Lihat website &nearr;</a>
        </div>
        <nav class="flex gap-1 overflow-x-auto px-3 pb-3 lg:block lg:space-y-1 lg:pb-0" aria-label="Menu admin">
            @foreach ($menu as [$label, $route, $match])
                <a href="{{ route($route) }}" class="whitespace-nowrap rounded-lg px-3 py-2 text-sm font-medium transition-colors lg:block {{ request()->routeIs($match) ? 'bg-white/10 text-sun' : 'text-white/75 hover:bg-white/5 hover:text-white' }}">{{ $label }}</a>
            @endforeach
        </nav>
        <div class="hidden border-t border-white/10 p-4 text-sm lg:absolute lg:inset-x-0 lg:bottom-0 lg:block">
            <p class="truncate text-white/60">{{ auth()->user()->email }}</p>
            <form method="POST" action="{{ route('admin.logout') }}" class="mt-2">@csrf
                <button class="font-semibold text-white/80 hover:text-white">Keluar</button>
            </form>
        </div>
    </aside>

    <main class="min-w-0 flex-1 px-5 py-8 lg:px-10">
        <div class="mx-auto max-w-5xl">
            @if (session('ok'))
                <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">{{ session('ok') }}</div>
            @endif
            @if (request()->query('too_big'))
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
                    <p class="font-semibold">File terlalu besar untuk batas server saat ini.</p>
                    <p class="mt-1">Batas upload sekarang: {{ ini_get('upload_max_filesize') }} per file (total form maks. {{ ini_get('post_max_size') }}). Kecilkan ukuran video (lihat panduan kompres di bawah), atau naikkan batas upload PHP di Herd.</p>
                </div>
            @endif
            @if ($errors->any() && ! View::hasSection('own_errors'))
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
                    <p class="font-semibold">Periksa kembali isian Anda:</p>
                    <ul class="mt-1 list-inside list-disc">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif
            @yield('content')
            <form method="POST" action="{{ route('admin.logout') }}" class="mt-10 lg:hidden">@csrf
                <button class="text-sm font-semibold text-ink/60">Keluar ({{ auth()->user()->email }})</button>
            </form>
        </div>
    </main>
</div>
</body>
</html>
