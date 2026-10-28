@extends('admin.layout')
@section('title', 'Artikel')
@section('content')
<div class="flex flex-wrap items-end justify-between gap-4">
    <div>
        <h1 class="font-display text-3xl font-extrabold">Artikel</h1>
        <p class="mt-1 text-ink/60">Tulis dan atur artikel yang tampil di halaman Artikel.</p>
    </div>
    <a href="{{ route('admin.articles.create') }}" class="rounded-full bg-deep px-5 py-2.5 text-sm font-semibold text-white hover:bg-sea">+ Tambah artikel</a>
</div>

<div class="mt-6 overflow-x-auto rounded-2xl border border-ink/10 bg-white">
    <table class="w-full text-left text-sm">
        <thead class="border-b border-ink/10 bg-mist text-xs uppercase tracking-wide text-ink/50">
            <tr><th class="px-4 py-3">Judul</th><th class="px-4 py-3">Kategori</th><th class="px-4 py-3">Tanggal</th><th class="px-4 py-3">Status</th><th class="px-4 py-3"></th></tr>
        </thead>
        <tbody>
        @forelse ($articles as $a)
            <tr class="border-b border-ink/5 last:border-0">
                <td class="px-4 py-3"><p class="font-semibold">{{ $a->title_id }}</p><p class="text-xs text-ink/50">{{ $a->title_en }}</p></td>
                <td class="px-4 py-3">{{ __('site.categories.'.$a->category) }}</td>
                <td class="whitespace-nowrap px-4 py-3">{{ $a->published_at->translatedFormat('j M Y') }}</td>
                <td class="px-4 py-3">
                    @if (! $a->is_active)<span class="rounded-full bg-ink/10 px-2 py-0.5 text-xs text-ink/60">Draf</span>
                    @elseif ($a->published_at->isFuture())<span class="rounded-full bg-sun/20 px-2 py-0.5 text-xs text-deep">Terjadwal</span>
                    @else<span class="rounded-full bg-emerald-100 px-2 py-0.5 text-xs text-emerald-800">Terbit</span>@endif
                </td>
                <td class="whitespace-nowrap px-4 py-3 text-right">
                    <a href="{{ route('articles.show', $a->slug) }}" target="_blank" class="text-ink/50 hover:underline">Lihat</a>
                    <a href="{{ route('admin.articles.edit', $a) }}" class="ml-3 font-semibold text-sea hover:underline">Ubah</a>
                    <form method="POST" action="{{ route('admin.articles.destroy', $a) }}" class="ml-3 inline" onsubmit="return confirm('Hapus artikel ini?')">@csrf @method('DELETE')
                        <button class="font-semibold text-brand hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="px-4 py-10 text-center text-ink/50">Belum ada artikel.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
