<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Product;
use Illuminate\Database\Seeder;

/** Memindahkan konten awal (dari lang/*) ke database. Aman dijalankan ulang: hanya mengisi tabel yang masih kosong. */
class ContentSeeder extends Seeder
{
    public function run(): void
    {
        if (Product::count() === 0) {
            $rows = [
                ['trainer', 'paramotor', 'beginner'], ['cross', 'paramotor', 'bestseller'], ['used', 'paramotor', 'used'],
                ['wing_a', 'sayap', 'beginner'], ['wing_b', 'sayap', null],
                ['harness', 'perlengkapan', null], ['helmet', 'perlengkapan', null], ['reserve', 'perlengkapan', 'safety'],
                ['propeller', 'sparepart', null], ['carb', 'sparepart', null],
                ['rental', 'sewa', 'rental'], ['service', 'servis', 'service'],
            ];
            foreach ($rows as $i => [$key, $cat, $tag]) {
                Product::create([
                    'name_en' => trans("site.products.$key.name", [], 'en'),
                    'name_id' => trans("site.products.$key.name", [], 'id'),
                    'desc_en' => trans("site.products.$key.desc", [], 'en'),
                    'desc_id' => trans("site.products.$key.desc", [], 'id'),
                    'category' => $cat,
                    'tag' => $tag,
                    'is_featured' => $i < 4,
                    'sort_order' => ($i + 1) * 10,
                ]);
            }
        }

        if (Article::count() === 0) {
            $rows = [
                ['prepare', 'training', '2026-10-21', 5], ['weather', 'safety', '2026-10-14', 4],
                ['maintenance', 'maintenance', '2026-10-07', 6], ['buying', 'buying', '2026-09-30', 5],
                ['spares', 'sparepart', '2026-09-22', 3], ['spots', 'destination', '2026-09-15', 4],
            ];
            foreach ($rows as [$key, $cat, $date, $read]) {
                Article::create([
                    'slug' => $key,
                    'title_en' => trans("site.articles.$key.title", [], 'en'),
                    'title_id' => trans("site.articles.$key.title", [], 'id'),
                    'excerpt_en' => trans("site.articles.$key.excerpt", [], 'en'),
                    'excerpt_id' => trans("site.articles.$key.excerpt", [], 'id'),
                    'body_en' => trans("site.articles.$key.excerpt", [], 'en'),
                    'body_id' => trans("site.articles.$key.excerpt", [], 'id'),
                    'category' => $cat,
                    'published_at' => $date,
                    'read_minutes' => $read,
                ]);
            }
        }
    }
}
