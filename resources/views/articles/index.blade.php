@extends('layouts.app')

@section('title', __('site.meta.articles_title').' - '.config('site.name'))
@section('description', __('site.meta.articles_desc', ['name' => config('site.name')]))

@section('content')
<section class="bg-deep text-white">
    <div class="mx-auto max-w-6xl px-5 py-16 md:py-24">
        <nav aria-label="{{ __('site.breadcrumb') }}" class="text-sm text-white/60">
            <a href="{{ route('home') }}" class="hover:text-white">{{ __('site.home') }}</a> <span class="mx-1">/</span> <span class="text-white">{{ __('site.articles_page.title') }}</span>
        </nav>
        <h1 class="mt-5 font-display text-5xl font-extrabold tracking-tight md:text-7xl">{{ __('site.articles_page.title') }}</h1>
        <p class="mt-5 max-w-xl text-lg text-white/70">{{ __('site.articles_page.text') }}</p>
    </div>
</section>

@if ($featured)
<section class="mx-auto max-w-6xl px-5 py-14">
    <a href="{{ $featured['url'] }}" class="group grid overflow-hidden rounded-2xl border border-ink/10 md:grid-cols-5">
        <div class="relative min-h-64 md:col-span-3">
            @if ($featured['image'])
                <img src="{{ $featured['image'] }}" alt="" class="absolute inset-0 h-full w-full object-cover">
            @else
                <div class="absolute inset-0 bg-gradient-to-br from-sea to-deep"></div>
            @endif
        </div>
        <div class="flex flex-col justify-center p-8 md:col-span-2 md:p-10">
            <p class="text-sm font-semibold text-sea">{{ $featured['category'] }}</p>
            <h2 class="mt-3 font-display text-3xl font-bold leading-tight group-hover:text-sea">{{ $featured['title'] }}</h2>
            <p class="mt-4 text-ink/70">{{ $featured['excerpt'] }}</p>
            <p class="mt-6 text-sm text-ink/50">{{ $featured['date'] }}, {{ __('site.read_time', ['n' => $featured['read']]) }}</p>
        </div>
    </a>
</section>
@endif

@if (count($articles))
<section class="mx-auto max-w-6xl px-5 pb-20">
    <h2 class="font-display text-2xl font-bold">{{ __('site.latest_articles.title') }}</h2>
    <div class="mt-8 grid gap-x-8 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($articles as $i => $a) @include('partials.article-card') @endforeach
    </div>
</section>
@endif

@include('partials.inquiry')
@endsection
