@props(['label', 'name', 'options' => [], 'value' => null, 'required' => false, 'blank' => null])
<div {{ $attributes->only('class') }}>
    <label for="{{ $name }}" class="block text-sm font-semibold">{{ $label }} @if ($required)<span class="text-brand">*</span>@endif</label>
    <select id="{{ $name }}" name="{{ $name }}" @required($required)
        class="mt-1 w-full rounded-lg border border-ink/20 bg-white px-3 py-2 text-sm focus:border-sea focus:outline-none focus:ring-2 focus:ring-sea/30">
        @if ($blank !== null)<option value="">{{ $blank }}</option>@endif
        @foreach ($options as $k => $label2)
            <option value="{{ $k }}" @selected((string) old($name, $value) === (string) $k)>{{ $label2 }}</option>
        @endforeach
    </select>
    @error($name)<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
</div>
