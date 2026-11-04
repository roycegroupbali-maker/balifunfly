@php
    $field = 'mt-1.5 w-full rounded-lg border border-ink/15 bg-white px-4 py-3 focus:border-sea focus:outline-none focus:ring-2 focus:ring-sea/20';
@endphp
<section id="kontak" class="scroll-mt-16 bg-mist">
    <div class="mx-auto grid max-w-6xl gap-12 px-5 py-20 lg:grid-cols-5">
        <div class="lg:col-span-2">
            <h2 class="font-display text-4xl font-extrabold tracking-tight">{{ __('site.inquiry.title') }}</h2>
            <p class="mt-4 text-ink/70">{{ __('site.inquiry.text') }}</p>
            <p class="mt-6 text-sm text-ink/70">{{ __('site.inquiry.faster') }} <a class="font-semibold text-sea underline" href="https://wa.me/{{ config('site.whatsapp') }}" target="_blank" rel="noopener">{{ __('site.inquiry.faster_link') }}</a>.</p>
        </div>
        <form method="POST" action="{{ route('inquiry.store') }}" class="grid gap-5 sm:grid-cols-2 lg:col-span-3">
            @csrf
            @if (session('inquiry_ok'))
                <p class="rounded-lg bg-sea/10 px-4 py-3 font-medium text-sea sm:col-span-2" role="status">{{ session('inquiry_ok') }}</p>
            @endif
            <div>
                <label for="first_name" class="text-sm font-semibold">{{ __('site.inquiry.first_name') }}</label>
                <input id="first_name" name="first_name" value="{{ old('first_name') }}" required class="{{ $field }}">
                @error('first_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="last_name" class="text-sm font-semibold">{{ __('site.inquiry.last_name') }}</label>
                <input id="last_name" name="last_name" value="{{ old('last_name') }}" class="{{ $field }}">
            </div>
            <div>
                <label for="email" class="text-sm font-semibold">{{ __('site.inquiry.email') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required class="{{ $field }}">
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="phone" class="text-sm font-semibold">{{ __('site.inquiry.phone') }}</label>
                <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required class="{{ $field }}">
                @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="sm:col-span-2">
                <label for="topic" class="text-sm font-semibold">{{ __('site.inquiry.topic') }}</label>
                <select id="topic" name="topic" required class="{{ $field }}">
                    <option value="" disabled @selected(! old('topic'))>{{ __('site.inquiry.topic_placeholder') }}</option>
                    @foreach (__('site.inquiry.topics') as $key => $label)
                        <option value="{{ $key }}" @selected(old('topic') === $key)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('topic') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="sm:col-span-2">
                <label for="message" class="text-sm font-semibold">{{ __('site.inquiry.message') }}</label>
                <textarea id="message" name="message" rows="4" class="{{ $field }}">{{ old('message') }}</textarea>
            </div>
            <div class="sm:col-span-2">
                <label class="flex items-start gap-3 text-sm text-ink/70">
                    <input type="checkbox" name="consent" value="1" required class="mt-1 h-4 w-4 rounded border-ink/30 text-sea focus:ring-sea">
                    <span>{{ __('site.inquiry.consent') }}</span>
                </label>
                @error('consent') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="sm:col-span-2">
                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                @error('g-recaptcha-response') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="sm:col-span-2">
                <button class="rounded-full bg-deep px-8 py-3.5 font-semibold text-white transition hover:bg-sea focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sea">{{ __('site.inquiry.submit') }}</button>
            </div>
        </form>
            <script src="https://www.google.com/recaptcha/api.js?hl={{ app()->getLocale() }}" async defer></script>
    </div>
</section>
