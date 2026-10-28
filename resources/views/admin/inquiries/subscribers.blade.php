@extends('admin.layout')
@section('title', 'Newsletter')
@section('content')
<h1 class="font-display text-3xl font-extrabold">Pelanggan newsletter</h1>
<p class="mt-1 text-ink/60">Email yang mendaftar lewat footer website.</p>

<div class="mt-6 overflow-hidden rounded-2xl border border-ink/10 bg-white">
    @forelse ($subscribers as $s)
        <div class="flex items-center justify-between gap-4 border-b border-ink/5 px-5 py-3 last:border-0">
            <span class="min-w-0 truncate">{{ $s->email }}</span>
            <span class="flex shrink-0 items-center gap-4 text-sm text-ink/50">
                {{ $s->created_at->translatedFormat('j M Y') }}
                <form method="POST" action="{{ route('admin.subscribers.destroy', $s) }}" onsubmit="return confirm('Hapus email ini?')">@csrf @method('DELETE')
                    <button class="font-semibold text-brand hover:underline">Hapus</button>
                </form>
            </span>
        </div>
    @empty
        <p class="px-5 py-10 text-center text-ink/50">Belum ada pelanggan.</p>
    @endforelse
</div>
<div class="mt-6">{{ $subscribers->links() }}</div>
@endsection
