@extends('admin.layout')
@php $edit = $article->exists; @endphp
@section('title', $edit ? 'Ubah artikel' : 'Tambah artikel')
@section('content')
<a href="{{ route('admin.articles.index') }}" class="text-sm text-ink/60 hover:text-ink">&larr; Semua artikel</a>
<h1 class="mt-2 font-display text-3xl font-extrabold">{{ $edit ? 'Ubah artikel' : 'Tambah artikel' }}</h1>

<form method="POST" enctype="multipart/form-data" class="mt-8 space-y-8"
      action="{{ $edit ? route('admin.articles.update', $article) : route('admin.articles.store') }}">
    @csrf @if ($edit) @method('PUT') @endif

    <div class="grid gap-6 lg:grid-cols-2">
        <fieldset class="space-y-4 rounded-2xl border border-ink/10 bg-white p-5">
            <legend class="px-2 text-sm font-bold text-sea">Bahasa Inggris (EN)</legend>
            <x-admin.input label="Judul" name="title_en" :value="$article->title_en" required />
            <x-admin.input label="Ringkasan (tampil di kartu)" name="excerpt_en" :value="$article->excerpt_en" rows="2" />
            <x-admin.input label="Isi artikel" name="body_en" :value="$article->body_en" rows="14" hint="Pisahkan paragraf dengan satu baris kosong." />
        </fieldset>
        <fieldset class="space-y-4 rounded-2xl border border-ink/10 bg-white p-5">
            <legend class="px-2 text-sm font-bold text-sea">Bahasa Indonesia (ID)</legend>
            <x-admin.input label="Judul" name="title_id" :value="$article->title_id" required />
            <x-admin.input label="Ringkasan (tampil di kartu)" name="excerpt_id" :value="$article->excerpt_id" rows="2" />
            <x-admin.input label="Isi artikel" name="body_id" :value="$article->body_id" rows="14" hint="Pisahkan paragraf dengan satu baris kosong." />
        </fieldset>
    </div>

    <div class="grid gap-4 rounded-2xl border border-ink/10 bg-white p-5 md:grid-cols-3">
        <x-admin.select label="Kategori" name="category" :value="$article->category" required blank="Pilih kategori"
            :options="collect(\App\Models\Article::CATEGORIES)->mapWithKeys(fn ($c) => [$c => __('site.categories.'.$c)])->all()" />
        <x-admin.input label="Tanggal terbit" name="published_at" type="date" :value="optional($article->published_at)->format('Y-m-d')" required hint="Tanggal di masa depan = terjadwal." />
        <x-admin.input label="Waktu baca (menit)" name="read_minutes" type="number" min="1" :value="$article->read_minutes" required />
    </div>

    <div class="rounded-2xl border border-ink/10 bg-white p-5">
        <label for="image" class="block text-sm font-semibold">Foto sampul</label>
        @if ($article->image)
            <div class="mt-3 flex items-center gap-4">
                <img src="{{ asset($article->image) }}" alt="" class="h-24 rounded-lg object-cover">
                <label class="flex items-center gap-2 text-sm text-ink/70"><input type="checkbox" name="remove_image" value="1"> Hapus foto ini</label>
            </div>
        @endif
        <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp" class="mt-3 block w-full text-sm file:mr-4 file:rounded-full file:border-0 file:bg-deep file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white">
        <p class="mt-1 text-xs text-ink/50">JPG, PNG, atau WebP, maksimal 4 MB.</p>
        @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <label class="flex items-center gap-2 rounded-2xl border border-ink/10 bg-white p-5 text-sm"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $article->is_active))> Terbitkan (hilangkan centang untuk menyimpan sebagai draf)</label>

    <div class="flex gap-3">
        <button class="rounded-full bg-deep px-7 py-3 text-sm font-semibold text-white hover:bg-sea">{{ $edit ? 'Simpan perubahan' : 'Tambah artikel' }}</button>
        <a href="{{ route('admin.articles.index') }}" class="rounded-full border border-ink/20 bg-white px-7 py-3 text-sm font-semibold">Batal</a>
    </div>
</form>
@endsection
