@props(['label', 'name', 'type' => 'text', 'value' => null, 'hint' => null, 'required' => false, 'rows' => null])
<div {{ $attributes->only('class') }}>
    <label for="{{ $name }}" class="block text-sm font-semibold">{{ $label }} @if ($required)<span class="text-brand">*</span>@endif</label>
    @if ($rows)
        <textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $rows }}" @required($required)
            class="mt-1 w-full rounded-lg border border-ink/20 bg-white px-3 py-2 text-sm focus:border-sea focus:outline-none focus:ring-2 focus:ring-sea/30">{{ old($name, $value) }}</textarea>
    @else
        <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ old($name, $value) }}" @required($required)
            {{ $attributes->except('class') }}
            class="mt-1 w-full rounded-lg border border-ink/20 bg-white px-3 py-2 text-sm focus:border-sea focus:outline-none focus:ring-2 focus:ring-sea/30">
    @endif
    @if ($hint)<p class="mt-1 text-xs text-ink/50">{{ $hint }}</p>@endif
    @error($name)<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
</div>
