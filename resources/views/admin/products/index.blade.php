@extends('admin.layout')
@section('title', 'Produk')
@section('content')
<div class="flex flex-wrap items-end justify-between gap-4">
    <div>
        <h1 class="font-display text-3xl font-extrabold">Produk</h1>
        <p class="mt-1 text-ink/60">Tambah, ubah, atau sembunyikan produk di halaman Produk.</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="rounded-full bg-deep px-5 py-2.5 text-sm font-semibold text-white hover:bg-sea">+ Tambah produk</a>
</div>

<div class="mt-6 flex flex-wrap gap-2 text-sm">
    <a href="{{ route('admin.products.index') }}" class="rounded-full px-3 py-1 {{ ! $category ? 'bg-deep text-white' : 'bg-white hover:bg-white/60' }}">Semua</a>
    @foreach (\App\Models\Product::CATEGORIES as $c)
        <a href="{{ route('admin.products.index', ['category' => $c]) }}" class="rounded-full px-3 py-1 {{ $category === $c ? 'bg-deep text-white' : 'bg-white hover:bg-white/60' }}">{{ __('site.categories.'.$c) }}</a>
    @endforeach
</div>

<div class="mt-6 overflow-x-auto rounded-2xl border border-ink/10 bg-white">
    <table class="w-full text-left text-sm">
        <thead class="border-b border-ink/10 bg-mist text-xs uppercase tracking-wide text-ink/50">
            <tr><th class="px-4 py-3">Produk</th><th class="px-4 py-3">Kategori</th><th class="px-4 py-3">Harga</th><th class="px-4 py-3">Status</th><th class="px-4 py-3"></th></tr>
        </thead>
        <tbody>
        @forelse ($products as $p)
            <tr class="border-b border-ink/5 last:border-0">
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        @if ($p->image)<img src="{{ asset($p->image) }}" alt="" class="h-11 w-14 rounded object-cover">@else<span class="h-11 w-14 rounded bg-gradient-to-br from-sea to-deep"></span>@endif
                        <div class="min-w-0"><p class="font-semibold">{{ $p->name_id }}</p><p class="truncate text-xs text-ink/50">{{ $p->name_en }}</p></div>
                    </div>
                </td>
                <td class="px-4 py-3">{{ __('site.categories.'.$p->category) }}</td>
                <td class="px-4 py-3">{{ $p->price ?: '-' }}</td>
                <td class="px-4 py-3">
                    <span class="rounded-full px-2 py-0.5 text-xs {{ $p->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-ink/10 text-ink/60' }}">{{ $p->is_active ? 'Tampil' : 'Disembunyikan' }}</span>
                    @if ($p->is_featured)<span class="ml-1 rounded-full bg-sun/20 px-2 py-0.5 text-xs text-deep">Beranda</span>@endif
                </td>
                <td class="whitespace-nowrap px-4 py-3 text-right">
                    <a href="{{ route('admin.products.edit', $p) }}" class="font-semibold text-sea hover:underline">Ubah</a>
                    <form method="POST" action="{{ route('admin.products.destroy', $p) }}" class="ml-3 inline" onsubmit="return confirm('Hapus produk ini?')">@csrf @method('DELETE')
                        <button class="font-semibold text-brand hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="px-4 py-10 text-center text-ink/50">Belum ada produk.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
