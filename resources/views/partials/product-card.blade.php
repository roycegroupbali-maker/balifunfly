@php
    $wa = 'https://wa.me/'.config('site.whatsapp').'?text='.rawurlencode(__('site.wa_product', ['product' => $p['name']]));
    $bg = ['paramotor'=>'from-sea to-deep','sayap'=>'from-sun to-sea','perlengkapan'=>'from-deep to-sea','sparepart'=>'from-ink to-sea','sewa'=>'from-sea to-sun','servis'=>'from-deep to-ink'][$p['cat']] ?? 'from-sea to-deep';
@endphp
@php
    $pdata = array_merge($p, ['wa' => $wa, 'bg' => $bg, 'ask' => __('site.ask_whatsapp'), 'price_label' => $p['price'] ?? __('site.price_contact')]);
    $count = count($p['images'] ?? []);
@endphp
<article data-product-card class="group relative flex flex-col overflow-hidden rounded-2xl border border-ink/10 bg-white transition hover:shadow-lg focus-within:shadow-lg">
    <script type="application/json" class="pdata">{!! json_encode($pdata, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    <div class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br {{ $bg }}">
        {{-- Gambar contoh. Untuk foto asli: tambahkan 'image' => asset('images/produk/nama.jpg') di data produk. --}}
        @if (! empty($p['image']))
            <img src="{{ $p['image'] }}" alt="{{ $p['name'] }}" loading="lazy" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
        @else
            <svg class="absolute inset-0 m-auto w-2/3 text-white/80" viewBox="0 0 200 130" fill="none" stroke="currentColor" aria-hidden="true"><path d="M10 55 Q100 -25 190 55" stroke-width="7" stroke-linecap="round"/><path d="M30 48 L100 105 M70 28 L100 105 M130 28 L100 105 M170 48 L100 105" stroke-width="1.2"/><circle cx="100" cy="112" r="6" fill="currentColor"/></svg>
        @endif
        @if ($count > 1)
            <span class="absolute bottom-3 right-3 flex items-center gap-1 rounded-full bg-night/70 px-2.5 py-1 text-xs font-semibold text-white backdrop-blur-sm">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="9" cy="11" r="1.6"/><path d="m21 16-5-5-8 8"/></svg>{{ $count }}
            </span>
        @endif
        @if ($p['tag']) <span class="absolute left-3 top-3 rounded-full bg-brand px-3 py-1 text-xs font-semibold text-white">{{ $p['tag'] }}</span> @endif
    </div>
    <div class="flex flex-1 flex-col p-5">
        <p class="text-sm font-semibold text-sea">{{ $p['cat_label'] }}</p>
        <h3 class="mt-1 font-display text-lg font-bold leading-snug">
            <button type="button" data-product-open class="text-left after:absolute after:inset-0 after:content-[''] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sea" aria-haspopup="dialog">{{ $p['name'] }}</button>
        </h3>
        <p class="mt-2 flex-1 text-sm text-ink/70">{{ $p['desc'] }}</p>
        <p class="mt-3 text-sm font-semibold text-sea group-hover:underline" aria-hidden="true">{{ __('site.details.view') }} &rarr;</p>
        <p class="mt-3 font-semibold text-deep">{{ $p['price'] ?? __('site.price_contact') }}</p>
        <a href="{{ $wa }}" target="_blank" rel="noopener" class="relative z-10 mt-3 rounded-full bg-deep px-5 py-2.5 text-center text-sm font-semibold text-white transition hover:bg-sea">{{ __('site.ask_whatsapp') }}</a>
    </div>
</article>
