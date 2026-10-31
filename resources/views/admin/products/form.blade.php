@extends('admin.layout')
@php $edit = $product->exists; @endphp
@section('title', $edit ? 'Ubah produk' : 'Tambah produk')
@section('content')
<a href="{{ route('admin.products.index') }}" class="text-sm text-ink/60 hover:text-ink">&larr; Semua produk</a>
<h1 class="mt-2 font-display text-3xl font-extrabold">{{ $edit ? 'Ubah produk' : 'Tambah produk' }}</h1>

<form method="POST" enctype="multipart/form-data" class="mt-8 space-y-8"
      action="{{ $edit ? route('admin.products.update', $product) : route('admin.products.store') }}">
    @csrf @if ($edit) @method('PUT') @endif

    <div class="grid gap-6 md:grid-cols-2">
        <fieldset class="space-y-4 rounded-2xl border border-ink/10 bg-white p-5">
            <legend class="px-2 text-sm font-bold text-sea">Bahasa Inggris (EN)</legend>
            <x-admin.input label="Nama produk" name="name_en" :value="$product->name_en" required />
            <x-admin.input label="Deskripsi singkat (di kartu produk)" name="desc_en" :value="$product->desc_en" rows="3" />
            <x-admin.input label="Deskripsi lengkap (di popup detail)" name="detail_en" :value="$product->detail_en" rows="8" hint="Pisahkan paragraf dengan satu baris kosong." />
        </fieldset>
        <fieldset class="space-y-4 rounded-2xl border border-ink/10 bg-white p-5">
            <legend class="px-2 text-sm font-bold text-sea">Bahasa Indonesia (ID)</legend>
            <x-admin.input label="Nama produk" name="name_id" :value="$product->name_id" required />
            <x-admin.input label="Deskripsi singkat (di kartu produk)" name="desc_id" :value="$product->desc_id" rows="3" />
            <x-admin.input label="Deskripsi lengkap (di popup detail)" name="detail_id" :value="$product->detail_id" rows="8" hint="Pisahkan paragraf dengan satu baris kosong." />
        </fieldset>
    </div>

    <div class="grid gap-4 rounded-2xl border border-ink/10 bg-white p-5 md:grid-cols-2">
        <x-admin.select label="Kategori" name="category" :value="$product->category" required
            :options="collect(\App\Models\Product::CATEGORIES)->mapWithKeys(fn ($c) => [$c => __('site.categories.'.$c)])->all()" blank="Pilih kategori" />
        <x-admin.select label="Label di pojok foto" name="tag" :value="$product->tag" blank="Tanpa label"
            :options="collect(\App\Models\Product::TAGS)->mapWithKeys(fn ($t) => [$t => __('site.tags.'.$t)])->all()" />
        <x-admin.input label="Harga" name="price" :value="$product->price" hint="Kosongkan untuk menampilkan “Hubungi kami”. Contoh: Rp 85.000.000" />
        <x-admin.input label="Urutan" name="sort_order" type="number" :value="$product->sort_order" hint="Angka kecil tampil lebih dulu." />
    </div>

    <div class="rounded-2xl border border-ink/10 bg-white p-5">
        <label for="image" class="block text-sm font-semibold">Foto utama</label>
        @if ($product->image)
            <div class="mt-3 flex items-center gap-4">
                <img src="{{ asset($product->image) }}" alt="" class="h-24 rounded-lg object-cover">
                <label class="flex items-center gap-2 text-sm text-ink/70"><input type="checkbox" name="remove_image" value="1"> Hapus foto ini</label>
            </div>
        @endif
        <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp" class="mt-3 block w-full text-sm file:mr-4 file:rounded-full file:border-0 file:bg-deep file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white">
        <p class="mt-1 text-xs text-ink/50">JPG, PNG, atau WebP, maksimal 4 MB. Rasio 4:3 paling pas. Foto ini yang tampil di kartu produk. Tanpa foto, tampil gambar bawaan.</p>
        @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="rounded-2xl border border-ink/10 bg-white p-5">
        <label for="gallery" class="block text-sm font-semibold">Foto tambahan (galeri)</label>
        <p class="mt-1 text-xs text-ink/50">Tampil di popup saat produk diklik, setelah foto utama. Maksimal {{ \App\Models\Product::MAX_GALLERY }} foto, masing-masing 4 MB.</p>
        @if ($product->exists && $product->images->isNotEmpty())
            <div class="mt-3 grid grid-cols-3 gap-3 sm:grid-cols-5">
                @foreach ($product->images as $img)
                    <label class="block text-xs text-ink/70">
                        <img src="{{ $img->url() }}" alt="" class="aspect-[4/3] w-full rounded-lg object-cover">
                        <span class="mt-1 flex items-center gap-1"><input type="checkbox" name="remove_gallery[]" value="{{ $img->id }}"> Hapus</span>
                    </label>
                @endforeach
            </div>
        @endif
        <input id="gallery" name="gallery[]" type="file" multiple accept="image/jpeg,image/png,image/webp" class="mt-3 block w-full text-sm file:mr-4 file:rounded-full file:border-0 file:bg-deep file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white">
        @error('gallery')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        @error('gallery.*')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="flex flex-wrap gap-6 rounded-2xl border border-ink/10 bg-white p-5 text-sm">
        <label class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active))> Tampilkan di website</label>
        <label class="flex items-center gap-2"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured))> Tampilkan sebagai produk unggulan di beranda</label>
    </div>

    <div class="flex gap-3">
        <button class="rounded-full bg-deep px-7 py-3 text-sm font-semibold text-white hover:bg-sea">{{ $edit ? 'Simpan perubahan' : 'Tambah produk' }}</button>
        <a href="{{ route('admin.products.index') }}" class="rounded-full border border-ink/20 bg-white px-7 py-3 text-sm font-semibold">Batal</a>
    </div>
</form>
@endsection
