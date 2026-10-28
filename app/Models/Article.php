<?php

namespace App\Models;

use App\Models\Concerns\HasLocale;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasLocale;

    public const CATEGORIES = ['training', 'safety', 'maintenance', 'buying', 'sparepart', 'destination'];

    protected $guarded = [];

    protected function casts(): array
    {
        return ['published_at' => 'date', 'is_active' => 'boolean'];
    }

    public function scopeVisible($q)
    {
        return $q->where('is_active', true)->whereDate('published_at', '<=', now())->orderByDesc('published_at')->orderByDesc('id');
    }

    public function toCard(): array
    {
        return [
            'title' => $this->loc('title'),
            'excerpt' => $this->loc('excerpt'),
            'category' => __('site.categories.'.$this->category),
            'date' => $this->published_at->translatedFormat('j M Y'),
            'read' => $this->read_minutes,
            'image' => $this->imageUrl(),
            'url' => route('articles.show', $this->slug),
        ];
    }
}
