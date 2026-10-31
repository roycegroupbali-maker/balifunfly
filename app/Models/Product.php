<?php

namespace App\Models;

use App\Models\Concerns\HasLocale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasLocale;

    public const CATEGORIES = ['paramotor', 'sayap', 'perlengkapan', 'sparepart', 'sewa', 'servis'];
    public const TAGS = ['beginner', 'bestseller', 'used', 'safety', 'rental', 'service'];

    protected $guarded = [];

    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'is_featured' => 'boolean'];
    }

    public const MAX_GALLERY = 10;

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order')->orderBy('id');
    }

    public function scopeVisible($q)
    {
        return $q->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }

    /** Semua foto untuk popup: foto utama dulu, lalu foto galeri. */
    public function galleryUrls(): array
    {
        $urls = $this->image ? [asset($this->image)] : [];
        foreach ($this->images as $img) {
            $urls[] = $img->url();
        }

        return $urls;
    }

    /** Bentuk array yang dipakai view publik (partials/product-card). */
    public function toCard(): array
    {
        return [
            'name' => $this->loc('name'),
            'cat' => $this->category,
            'cat_label' => __('site.categories.'.$this->category),
            'desc' => $this->loc('desc'),
            'price' => $this->price ?: null,
            'tag' => $this->tag ? __('site.tags.'.$this->tag) : null,
            'image' => $this->imageUrl(),
            'images' => $this->galleryUrls(),
            'detail' => collect(preg_split('/\R{2,}/', trim((string) $this->loc('detail'))) ?: [])->filter()->values()->all(),
        ];
    }
}
