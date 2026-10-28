@php $fallbacks = ['from-sea to-deep', 'from-sun to-sea', 'from-deep to-sea']; @endphp
<article class="group">
    <a href="{{ $a['url'] }}" class="block">
        <div class="aspect-[4/3] overflow-hidden rounded-xl">
            @if ($a['image'])
                <img src="{{ $a['image'] }}" alt="" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
            @else
                <div class="h-full w-full bg-gradient-to-br {{ $fallbacks[$i % 3] }}"></div>
            @endif
        </div>
        <p class="mt-4 text-sm font-semibold text-sea">{{ $a['category'] }}</p>
        <h3 class="mt-1 font-display text-xl font-bold leading-snug group-hover:text-sea">{{ $a['title'] }}</h3>
        <p class="mt-2 line-clamp-2 text-ink/70">{{ $a['excerpt'] }}</p>
        <p class="mt-3 text-sm text-ink/50">{{ $a['date'] }}, {{ __('site.read_time', ['n' => $a['read']]) }}</p>
    </a>
</article>
