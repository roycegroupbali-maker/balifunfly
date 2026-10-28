@extends('layouts.app')

@section('title', $a['title'].' - '.config('site.name'))
@section('description', $a['excerpt'])

@section('content')
<section class="bg-deep text-white">
    <div class="mx-auto max-w-3xl px-5 pb-14 pt-16 md:pb-20 md:pt-24">
        <nav aria-label="{{ __('site.breadcrumb') }}" class="text-sm text-white/60">
            <a href="{{ route('home') }}" class="hover:text-white">{{ __('site.home') }}</a> <span class="mx-1">/</span>
            <a href="{{ route('articles.index') }}" class="hover:text-white">{{ __('site.articles_page.title') }}</a>
        </nav>
        <p class="mt-6 text-sm font-semibold text-sun">{{ $a['category'] }}</p>
        <h1 class="mt-3 font-display text-4xl font-extrabold leading-tight tracking-tight md:text-5xl">{{ $a['title'] }}</h1>
        <p class="mt-5 text-sm text-white/60">{{ $a['date'] }}, {{ __('site.read_time', ['n' => $a['read']]) }}</p>
    </div>
</section>

<article class="mx-auto max-w-3xl px-5 py-14">
    @if ($a['image'])
        <img src="{{ $a['image'] }}" alt="" class="mb-10 w-full rounded-2xl object-cover">
    @endif
    <div class="space-y-5 text-lg leading-relaxed text-ink/80">
        @foreach ($paragraphs as $para)
            <p>{!! nl2br(e($para)) !!}</p>
        @endforeach
    </div>
    <a href="{{ route('articles.index') }}" class="mt-12 inline-block font-semibold text-sea hover:underline">&larr; {{ __('site.articles_page.title') }}</a>
</article>

@if (count($others))
<section class="mx-auto max-w-6xl px-5 pb-20">
    <h2 class="font-display text-2xl font-bold">{{ __('site.latest_articles.title') }}</h2>
    <div class="mt-8 grid gap-x-8 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($others as $i => $a) @include('partials.article-card') @endforeach
    </div>
</section>
@endif
@endsection
