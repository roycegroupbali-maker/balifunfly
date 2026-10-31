@extends('layouts.app')

@section('title', __('site.meta.products_title').' - '.config('site.name'))
@section('description', __('site.meta.products_desc', ['company' => config('site.company')]))

@section('content')
<section class="bg-deep text-white">
    <div class="mx-auto max-w-6xl px-5 py-16 md:py-24">
        <nav aria-label="{{ __('site.breadcrumb') }}" class="text-sm text-white/60">
            <a href="{{ route('home') }}" class="hover:text-white">{{ __('site.home') }}</a> <span class="mx-1">/</span> <span class="text-white">{{ __('site.nav.products') }}</span>
        </nav>
        <h1 class="mt-5 font-display text-5xl font-extrabold tracking-tight md:text-7xl">{{ __('site.products_page.title') }}</h1>
        <p class="mt-5 max-w-xl text-lg text-white/70">{{ __('site.products_page.text') }}</p>
        <div class="mt-8 flex flex-wrap gap-2">
            @foreach ($groups->keys() as $cat)
                <a href="#{{ $cat }}" class="rounded-full border border-white/30 px-4 py-2 text-sm font-medium transition hover:bg-white/10">{{ __('site.categories.'.$cat) }}</a>
            @endforeach
        </div>
    </div>
</section>

@foreach ($groups as $cat => $items)
    <section id="{{ $cat }}" class="mx-auto max-w-6xl scroll-mt-20 px-5 py-14">
        <h2 class="font-display text-3xl font-extrabold tracking-tight">{{ __('site.categories.'.$cat) }}</h2>
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($items as $p) @include('partials.product-card') @endforeach
        </div>
    </section>
@endforeach

@include('partials.product-modal')
@include('partials.inquiry')
@endsection
