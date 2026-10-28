<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Login Admin - {{ config('site.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,800&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="flex min-h-screen items-center justify-center bg-gradient-to-br from-night via-deep to-sea/60 px-5 font-sans text-ink antialiased">
    <div class="w-full max-w-sm rounded-2xl bg-white p-8 shadow-2xl">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo-mark.png') }}" alt="" class="h-10 w-auto">
            <div>
                <h1 class="font-display text-xl font-extrabold leading-tight">Login Admin</h1>
                <p class="text-sm text-ink/60">{{ config('site.name') }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.login.attempt') }}" class="mt-7 space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm font-semibold">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                       class="mt-1 w-full rounded-lg border border-ink/20 px-3 py-2.5 text-sm focus:border-sea focus:outline-none focus:ring-2 focus:ring-sea/30">
            </div>
            <div>
                <label for="password" class="block text-sm font-semibold">Password</label>
                <input id="password" name="password" type="password" required autocomplete="current-password"
                       class="mt-1 w-full rounded-lg border border-ink/20 px-3 py-2.5 text-sm focus:border-sea focus:outline-none focus:ring-2 focus:ring-sea/30">
            </div>
            @if ($errors->any())
                <p class="text-sm text-red-600" role="alert">{{ $errors->first() }}</p>
            @endif
            <label class="flex items-center gap-2 text-sm text-ink/70"><input type="checkbox" name="remember" class="rounded"> Ingat saya</label>
            <button class="w-full rounded-full bg-deep px-5 py-3 text-sm font-semibold text-white transition hover:bg-sea">Masuk</button>
        </form>
        <a href="{{ route('home') }}" class="mt-6 block text-center text-sm text-ink/50 hover:text-ink">&larr; Kembali ke website</a>
    </div>
</body>
</html>
