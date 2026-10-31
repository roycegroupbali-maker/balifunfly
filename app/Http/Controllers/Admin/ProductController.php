<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Support\Upload;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    private const ATTR = [
        'name_en' => 'nama (Inggris)', 'name_id' => 'nama (Indonesia)', 'desc_en' => 'deskripsi (Inggris)', 'desc_id' => 'deskripsi (Indonesia)', 'detail_en' => 'deskripsi lengkap (Inggris)', 'detail_id' => 'deskripsi lengkap (Indonesia)', 'gallery' => 'foto tambahan', 'gallery.*' => 'foto tambahan',
        'category' => 'kategori', 'tag' => 'label', 'price' => 'harga', 'image' => 'foto', 'sort_order' => 'urutan',
    ];

    public function index(Request $request)
    {
        $products = Product::query()
            ->when($request->filled('category'), fn ($q) => $q->where('category', $request->category))
            ->orderBy('category')->orderBy('sort_order')->orderBy('id')->get();

        return view('admin.products.index', ['products' => $products, 'category' => $request->category]);
    }

    public function create()
    {
        return view('admin.products.form', ['product' => new Product(['is_active' => true, 'sort_order' => (Product::max('sort_order') ?? 0) + 10])]);
    }

    public function store(Request $request)
    {
        $data = $this->payload($request);
        if ($request->hasFile('image')) {
            $data['image'] = Upload::store($request->file('image'), 'products');
        }
        $product = Product::create($data);
        $this->syncGallery($request, $product);

        return redirect()->route('admin.products.index')->with('ok', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', ['product' => $product]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->payload($request);
        if ($request->hasFile('image')) {
            Upload::delete($product->image);
            $data['image'] = Upload::store($request->file('image'), 'products');
        } elseif ($request->boolean('remove_image')) {
            Upload::delete($product->image);
            $data['image'] = null;
        }
        $product->update($data);
        $this->syncGallery($request, $product);

        return redirect()->route('admin.products.index')->with('ok', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        Upload::delete($product->image);
        foreach ($product->images as $img) {
            Upload::delete($img->path);
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with('ok', 'Produk dihapus.');
    }

    private function payload(Request $request): array
    {
        $data = $request->validate([
            'name_en' => 'required|string|max:150',
            'name_id' => 'required|string|max:150',
            'desc_en' => 'nullable|string|max:1000',
            'desc_id' => 'nullable|string|max:1000',
            'category' => ['required', Rule::in(Product::CATEGORIES)],
            'tag' => ['nullable', Rule::in(Product::TAGS)],
            'price' => 'nullable|string|max:60',
            'sort_order' => 'nullable|integer|min:0|max:100000',
            'detail_en' => 'nullable|string|max:6000',
            'detail_id' => 'nullable|string|max:6000',
            'gallery' => 'nullable|array|max:'.Product::MAX_GALLERY,
            'gallery.*' => 'image|mimes:jpg,jpeg,png,webp|max:4096',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ], [], self::ATTR);

        unset($data['image'], $data['gallery']);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        return $data;
    }

    /** Hapus foto galeri yang dicentang, lalu simpan foto baru (maks. Product::MAX_GALLERY per produk). */
    private function syncGallery(Request $request, Product $product): void
    {
        $remove = array_filter((array) $request->input('remove_gallery', []), 'is_numeric');
        if ($remove) {
            $product->images()->whereIn('id', $remove)->get()->each(function (ProductImage $img) {
                Upload::delete($img->path);
                $img->delete();
            });
        }

        $room = Product::MAX_GALLERY - $product->images()->count();
        $next = (int) $product->images()->max('sort_order');
        foreach (array_slice((array) $request->file('gallery', []), 0, max(0, $room)) as $file) {
            $product->images()->create(['path' => Upload::store($file, 'products'), 'sort_order' => ++$next]);
        }
    }
}
