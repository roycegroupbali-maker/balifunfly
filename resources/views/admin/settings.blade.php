@extends('admin.layout')
@section('title', 'Pengaturan')
@section('content')
@php
    $v = fn ($k, $default = '') => old($k, $s[$k] ?? $default);
    $heroUrl = fn ($k) => ! empty($s[$k]) ? asset($s[$k]) : null;
@endphp
<h1 class="font-display text-3xl font-extrabold">Pengaturan</h1>
<p class="mt-1 text-ink/60">Kontak, teks hero, dan video hero di halaman utama. Kolom kosong memakai nilai bawaan website.</p>

<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="mt-8 space-y-8">
    @csrf @method('PUT')

    <section class="rounded-2xl border border-ink/10 bg-white p-6">
        <h2 class="font-display text-xl font-bold">Video hero</h2>
        <p class="mt-1 text-sm text-ink/60">Video latar di bagian atas halaman utama. Cukup 1 video, otomatis menyesuaikan desktop, tablet, dan HP. Pakai MP4 (H.264), 720p, tanpa suara, 10–20 detik, idealnya di bawah 8 MB. Batas upload server saat ini: {{ ini_get('upload_max_filesize') }}.</p>
        <details class="mt-4 rounded-lg bg-mist p-4 text-sm">
            <summary class="cursor-pointer font-semibold">Cara mengecilkan video (disarankan)</summary>
            <p class="mt-3">Dengan <a href="https://handbrake.fr" target="_blank" rel="noopener" class="text-sea underline">HandBrake</a>: pilih preset “Fast 720p30”, hapus audio, lalu centang “Web optimized”. Atau lewat Terminal (ffmpeg):</p>
            <pre class="mt-2 overflow-x-auto rounded bg-night p-3 text-xs text-white">ffmpeg -i video-asli.mp4 -vf "scale=-2:720" -c:v libx264 -crf 28 -preset slow -an -movflags +faststart hero.mp4</pre>
            <p class="mt-2 text-ink/60">Hasilnya biasanya 3–8 MB untuk 15 detik, cukup tajam untuk desktop dan ringan untuk HP.</p>
        </details>
        <div class="mt-5 space-y-6">
            @foreach ([
                ['hero_video', 'Video hero', 'video/mp4,video/webm', 'Maksimal 50 MB (atau sesuai batas server di atas).'],
                ['hero_poster', 'Foto cadangan hero (opsional)', 'image/jpeg,image/png,image/webp', 'Tampil saat video belum termuat atau gagal.'],
            ] as [$k, $label, $accept, $hint])
                <div>
                    <label for="{{ $k }}" class="block text-sm font-semibold">{{ $label }}</label>
                    @if ($heroUrl($k))
                        <div class="mt-2 flex flex-wrap items-center gap-4 text-sm">
                            @if ($k === 'hero_poster')<img src="{{ $heroUrl($k) }}" alt="" class="h-20 rounded-lg object-cover">
                            @else<video src="{{ $heroUrl($k) }}" class="h-24 rounded-lg" muted controls preload="none"></video>@endif
                            <label class="flex items-center gap-2 text-ink/70"><input type="checkbox" name="remove_{{ $k }}" value="1"> Hapus file ini</label>
                        </div>
                    @endif
                    <input id="{{ $k }}" name="{{ $k }}" type="file" accept="{{ $accept }}" class="mt-2 block w-full text-sm file:mr-4 file:rounded-full file:border-0 file:bg-deep file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white">
                    <p class="mt-1 text-xs text-ink/50">{{ $hint }}</p>
                    @error($k)<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            @endforeach
        </div>
    </section>

    <section class="rounded-2xl border border-ink/10 bg-white p-6">
        <h2 class="font-display text-xl font-bold">Teks hero</h2>
        <div class="mt-5 grid gap-6 md:grid-cols-2">
            <div class="space-y-4">
                <p class="text-sm font-bold text-sea">Bahasa Inggris (EN)</p>
                <x-admin.input label="Judul" name="hero_title_en" :value="$s['hero_title_en'] ?? null" :placeholder="__('site.hero.title', [], 'en')" rows="3" />
                <x-admin.input label="Deskripsi" name="hero_text_en" :value="$s['hero_text_en'] ?? null" rows="3" />
            </div>
            <div class="space-y-4">
                <p class="text-sm font-bold text-sea">Bahasa Indonesia (ID)</p>
                <x-admin.input label="Judul" name="hero_title_id" :value="$s['hero_title_id'] ?? null" rows="3" />
                <x-admin.input label="Deskripsi" name="hero_text_id" :value="$s['hero_text_id'] ?? null" rows="3" />
            </div>
        </div>
    </section>

    <section class="rounded-2xl border border-ink/10 bg-white p-6">
        <h2 class="font-display text-xl font-bold">Kontak &amp; footer</h2>
        <div class="mt-5 grid gap-4 md:grid-cols-2">
            <x-admin.input label="Telepon" name="phone" :value="$s['phone'] ?? config('site.phone')" />
            <x-admin.input label="Nomor WhatsApp" name="whatsapp" :value="$s['whatsapp'] ?? config('site.whatsapp')" hint="Angka saja dengan kode negara, tanpa + atau spasi. Contoh: 6281234567890" />
            <x-admin.input label="Email" name="email" type="email" :value="$s['email'] ?? config('site.email')" />
            <x-admin.input label="Link Instagram" name="instagram" type="url" :value="$s['instagram'] ?? config('site.instagram')" />
            <x-admin.input label="Alamat" name="address" :value="$s['address'] ?? config('site.address')" class="md:col-span-2" />
            <x-admin.input label="Tagline (EN)" name="tagline_en" :value="$s['tagline_en'] ?? config('site.tagline.en')" rows="2" />
            <x-admin.input label="Tagline (ID)" name="tagline_id" :value="$s['tagline_id'] ?? config('site.tagline.id')" rows="2" />
            <x-admin.input label="Jam buka (EN)" name="hours_en" :value="$s['hours_en'] ?? config('site.hours.en')" />
            <x-admin.input label="Jam buka (ID)" name="hours_id" :value="$s['hours_id'] ?? config('site.hours.id')" />
        </div>
    </section>

    <button class="rounded-full bg-deep px-7 py-3 text-sm font-semibold text-white hover:bg-sea">Simpan pengaturan</button>
</form>

<section class="mt-12 rounded-2xl border border-ink/10 bg-white p-6">
    <h2 class="font-display text-xl font-bold">Ganti password admin</h2>
    <form method="POST" action="{{ route('admin.password.update') }}" class="mt-5 grid max-w-md gap-4">
        @csrf @method('PUT')
        <x-admin.input label="Password lama" name="current_password" type="password" required autocomplete="current-password" />
        <x-admin.input label="Password baru" name="password" type="password" required autocomplete="new-password" hint="Minimal 8 karakter." />
        <x-admin.input label="Ulangi password baru" name="password_confirmation" type="password" required autocomplete="new-password" />
        <div><button class="rounded-full border border-deep px-6 py-2.5 text-sm font-semibold text-deep hover:bg-deep hover:text-white">Ganti password</button></div>
    </form>
</section>
@endsection
