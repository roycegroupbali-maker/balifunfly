@php
    $wa = 'https://wa.me/'.config('site.whatsapp').'?text='.rawurlencode(__('site.wa_product', ['product' => $p['name']]));
    $bg = ['paramotor'=>'from-sea to-deep','sayap'=>'from-sun to-sea','perlengkapan'=>'from-deep to-sea','sparepart'=>'from-ink to-sea','sewa'=>'from-sea to-sun','servis'=>'from-deep to-ink'][$p['cat']] ?? 'from-sea to-deep';
@endphp
<article class="group flex flex-col overflow-hidden rounded-2xl border border-ink/10 bg-white transition hover:shadow-lg">
    <div class="relative aspect-[4/3] bg-gradient-to-br {{ $bg }}">
        {{-- Gambar contoh. Untuk foto asli: tambahkan 'image' => asset('images/produk/nama.jpg') di data produk. --}}
        @if (! empty($p['image']))
            <img src="{{ $p['image'] }}" alt="{{ $p['name'] }}" loading="lazy" class="h-full w-full object-cover">
        @else
            <svg class="absolute inset-0 m-auto w-2/3 text-white/80" viewBox="0 0 200 130" fill="none" stroke="currentColor" aria-hidden="true"><path d="M10 55 Q100 -25 190 55" stroke-width="7" stroke-linecap="round"/><path d="M30 48 L100 105 M70 28 L100 105 M130 28 L100 105 M170 48 L100 105" stroke-width="1.2"/><circle cx="100" cy="112" r="6" fill="currentColor"/></svg>
        @endif
        @if ($p['tag']) <span class="absolute left-3 top-3 rounded-full bg-brand px-3 py-1 text-xs font-semibold text-white">{{ $p['tag'] }}</span> @endif
    </div>
    <div class="flex flex-1 flex-col p-5">
        <p class="text-sm font-semibold text-sea">{{ $p['cat_label'] }}</p>
        <h3 class="mt-1 font-display text-lg font-bold leading-snug">{{ $p['name'] }}</h3>
        <p class="mt-2 flex-1 text-sm text-ink/70">{{ $p['desc'] }}</p>
        <p class="mt-4 font-semibold text-deep">{{ $p['price'] ?? __('site.price_contact') }}</p>
        <a href="{{ $wa }}" target="_blank" rel="noopener" class="mt-3 rounded-full bg-deep px-5 py-2.5 text-center text-sm font-semibold text-white transition hover:bg-sea">{{ __('site.ask_whatsapp') }}</a>
    </div>
</article>
