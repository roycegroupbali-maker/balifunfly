@extends('admin.layout')
@section('title', 'Pesan dari '.$inquiry->fullName())
@section('content')
<a href="{{ route('admin.inquiries.index') }}" class="text-sm text-ink/60 hover:text-ink">&larr; Semua pesan</a>
<h1 class="mt-2 font-display text-3xl font-extrabold">{{ $inquiry->fullName() }}</h1>
<p class="mt-1 text-sm text-ink/50">Dikirim {{ $inquiry->created_at->translatedFormat('j F Y, H:i') }} &middot; bahasa {{ strtoupper($inquiry->locale) }}</p>

<dl class="mt-8 grid gap-6 rounded-2xl border border-ink/10 bg-white p-6 sm:grid-cols-2">
    <div><dt class="text-xs uppercase tracking-wide text-ink/50">Email</dt><dd class="mt-1"><a class="text-sea hover:underline" href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a></dd></div>
    <div><dt class="text-xs uppercase tracking-wide text-ink/50">Telepon / WhatsApp</dt>
        <dd class="mt-1">{{ $inquiry->phone }}
            @php $digits = preg_replace('/\D/', '', $inquiry->phone); if (str_starts_with($digits, '0')) $digits = '62'.substr($digits, 1); @endphp
            @if (strlen($digits) >= 8)<a class="ml-2 text-sea hover:underline" target="_blank" rel="noopener" href="https://wa.me/{{ $digits }}">Buka WhatsApp</a>@endif
        </dd></div>
    <div><dt class="text-xs uppercase tracking-wide text-ink/50">Tertarik dengan</dt><dd class="mt-1">{{ __('site.inquiry.topics.'.$inquiry->topic) }}</dd></div>
    <div class="sm:col-span-2"><dt class="text-xs uppercase tracking-wide text-ink/50">Pesan</dt><dd class="mt-1 whitespace-pre-line">{{ $inquiry->message ?: '-' }}</dd></div>
</dl>

<form method="POST" action="{{ route('admin.inquiries.destroy', $inquiry) }}" class="mt-6" onsubmit="return confirm('Hapus pesan ini?')">@csrf @method('DELETE')
    <button class="text-sm font-semibold text-brand hover:underline">Hapus pesan</button>
</form>
@endsection
