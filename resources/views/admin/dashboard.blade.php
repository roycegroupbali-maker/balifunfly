@extends('admin.layout')
@section('title', 'Dashboard')
@section('content')
<h1 class="font-display text-3xl font-extrabold">Dashboard</h1>
<p class="mt-1 text-ink/60">Kelola isi website dari sini.</p>

<div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    @foreach ([
        ['Produk', $counts['products'], 'admin.products.index'],
        ['Artikel', $counts['articles'], 'admin.articles.index'],
        ['Pesan baru', $counts['inquiries_new'], 'admin.inquiries.index'],
        ['Pelanggan newsletter', $counts['subscribers'], 'admin.subscribers.index'],
    ] as [$label, $n, $route])
        <a href="{{ route($route) }}" class="rounded-2xl border border-ink/10 bg-white p-5 transition hover:shadow-md">
            <p class="font-display text-4xl font-extrabold text-deep">{{ $n }}</p>
            <p class="mt-1 text-sm text-ink/60">{{ $label }}</p>
        </a>
    @endforeach
</div>

<div class="mt-10 flex flex-wrap gap-3">
    <a href="{{ route('admin.products.create') }}" class="rounded-full bg-deep px-5 py-2.5 text-sm font-semibold text-white hover:bg-sea">+ Tambah produk</a>
    <a href="{{ route('admin.articles.create') }}" class="rounded-full bg-deep px-5 py-2.5 text-sm font-semibold text-white hover:bg-sea">+ Tambah artikel</a>
    <a href="{{ route('admin.settings.edit') }}" class="rounded-full border border-ink/20 bg-white px-5 py-2.5 text-sm font-semibold hover:bg-white/60">Ubah hero &amp; kontak</a>
</div>

<h2 class="mt-12 font-display text-xl font-bold">Pesan terbaru</h2>
<div class="mt-4 overflow-hidden rounded-2xl border border-ink/10 bg-white">
    @forelse ($latest as $m)
        <a href="{{ route('admin.inquiries.show', $m) }}" class="flex items-center justify-between gap-4 border-b border-ink/5 px-5 py-4 last:border-0 hover:bg-mist">
            <span class="min-w-0">
                <span class="block truncate font-semibold">{{ $m->fullName() }} @unless ($m->read_at)<span class="ml-2 rounded-full bg-brand px-2 py-0.5 text-xs text-white">Baru</span>@endunless</span>
                <span class="block truncate text-sm text-ink/60">{{ __('site.inquiry.topics.'.$m->topic) }}</span>
            </span>
            <span class="shrink-0 text-sm text-ink/50">{{ $m->created_at->diffForHumans() }}</span>
        </a>
    @empty
        <p class="px-5 py-8 text-center text-ink/50">Belum ada pesan masuk.</p>
    @endforelse
</div>
@endsection
