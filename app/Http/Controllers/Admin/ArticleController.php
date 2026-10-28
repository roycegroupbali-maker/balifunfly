<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Support\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{
    private const ATTR = [
        'title_en' => 'judul (Inggris)', 'title_id' => 'judul (Indonesia)', 'excerpt_en' => 'ringkasan (Inggris)', 'excerpt_id' => 'ringkasan (Indonesia)',
        'body_en' => 'isi (Inggris)', 'body_id' => 'isi (Indonesia)', 'category' => 'kategori', 'published_at' => 'tanggal terbit',
        'read_minutes' => 'waktu baca', 'image' => 'foto',
    ];

    public function index()
    {
        return view('admin.articles.index', ['articles' => Article::orderByDesc('published_at')->orderByDesc('id')->get()]);
    }

    public function create()
    {
        return view('admin.articles.form', ['article' => new Article(['is_active' => true, 'published_at' => now(), 'read_minutes' => 3])]);
    }

    public function store(Request $request)
    {
        $data = $this->payload($request);
        $data['slug'] = $this->uniqueSlug($data['title_en']);
        if ($request->hasFile('image')) {
            $data['image'] = Upload::store($request->file('image'), 'articles');
        }
        Article::create($data);

        return redirect()->route('admin.articles.index')->with('ok', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.form', ['article' => $article]);
    }

    public function update(Request $request, Article $article)
    {
        $data = $this->payload($request);
        if ($request->hasFile('image')) {
            Upload::delete($article->image);
            $data['image'] = Upload::store($request->file('image'), 'articles');
        } elseif ($request->boolean('remove_image')) {
            Upload::delete($article->image);
            $data['image'] = null;
        }
        $article->update($data);

        return redirect()->route('admin.articles.index')->with('ok', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        Upload::delete($article->image);
        $article->delete();

        return redirect()->route('admin.articles.index')->with('ok', 'Artikel dihapus.');
    }

    private function payload(Request $request): array
    {
        $data = $request->validate([
            'title_en' => 'required|string|max:200',
            'title_id' => 'required|string|max:200',
            'excerpt_en' => 'nullable|string|max:500',
            'excerpt_id' => 'nullable|string|max:500',
            'body_en' => 'nullable|string|max:50000',
            'body_id' => 'nullable|string|max:50000',
            'category' => ['required', Rule::in(Article::CATEGORIES)],
            'published_at' => 'required|date',
            'read_minutes' => 'required|integer|min:1|max:120',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ], [], self::ATTR);

        unset($data['image']);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    private function uniqueSlug(string $title): string
    {
        $base = Str::slug($title) ?: 'artikel';
        $slug = $base;
        for ($i = 2; Article::where('slug', $slug)->exists(); $i++) {
            $slug = $base.'-'.$i;
        }

        return $slug;
    }
}
