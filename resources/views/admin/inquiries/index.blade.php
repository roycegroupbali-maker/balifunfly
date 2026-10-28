@extends('admin.layout')
@section('title', 'Pesan masuk')
@section('content')
<h1 class="font-display text-3xl font-extrabold">Pesan masuk</h1>
<p class="mt-1 text-ink/60">Permintaan informasi dari formulir di website.</p>

<div class="mt-6 overflow-hidden rounded-2xl border border-ink/10 bg-white">
    @forelse ($inquiries as $m)
        <a href="{{ route('admin.inquiries.show', $m) }}" class="flex items-center justify-between gap-4 border-b border-ink/5 px-5 py-4 last:border-0 hover:bg-mist">
            <span class="min-w-0">
                <span class="block truncate {{ $m->read_at ? '' : 'font-bold' }}">{{ $m->fullName() }} @unless ($m->read_at)<span class="ml-2 rounded-full bg-brand px-2 py-0.5 text-xs font-normal text-white">Baru</span>@endunless</span>
                <span class="block truncate text-sm text-ink/60">{{ __('site.inquiry.topics.'.$m->topic) }} &middot; {{ $m->phone }}</span>
            </span>
            <span class="shrink-0 text-sm text-ink/50">{{ $m->created_at->translatedFormat('j M Y, H:i') }}</span>
        </a>
    @empty
        <p class="px-5 py-10 text-center text-ink/50">Belum ada pesan masuk.</p>
    @endforelse
</div>
<div class="mt-6">{{ $inquiries->links() }}</div>
@endsection
