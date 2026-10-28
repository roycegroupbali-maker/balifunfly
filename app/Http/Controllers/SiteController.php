<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InquiryAdminAlert;
use App\Mail\InquiryReceived;
use App\Models\Article;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\Subscriber;

class SiteController extends Controller
{
    public function products()
    {
        $groups = Product::visible()->get()->map->toCard()->groupBy('cat');

        return view('products.index', ['groups' => $groups]);
    }

    public function home()
    {
        $featured = Product::visible()->where('is_featured', true)->limit(4)->get();
        if ($featured->isEmpty()) {
            $featured = Product::visible()->limit(4)->get();
        }

        return view('home', [
            'products' => $featured->map->toCard()->all(),
            'articles' => Article::visible()->limit(3)->get()->map->toCard()->all(),
        ]);
    }

    public function articles()
    {
        $all = Article::visible()->get()->map->toCard();

        return view('articles.index', ['featured' => $all->first(), 'articles' => $all->slice(1)->values()->all()]);
    }

    public function article(Article $article)
    {
        abort_unless($article->is_active && $article->published_at->lte(now()), 404);

        $others = Article::visible()->where('id', '!=', $article->id)->limit(3)->get()->map->toCard()->all();
        $paragraphs = preg_split('/\R{2,}/', trim((string) $article->loc('body'))) ?: [];

        return view('articles.show', ['a' => $article->toCard(), 'paragraphs' => array_filter($paragraphs), 'others' => $others]);
    }

    public function inquiry(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:80',
            'last_name'  => 'nullable|string|max:80',
            'email'      => 'required|email',
            'phone'      => 'required|string|max:30',
            'topic'      => 'required|in:'.implode(',', array_keys(__('site.inquiry.topics'))),
            'message'    => 'nullable|string|max:1000',
            'consent'    => 'accepted',
        ]);

        $inquiry = Inquiry::create(collect($data)->except('consent')->all() + ['locale' => app()->getLocale()]);

        // Kirim email setelah halaman tampil ke pengunjung; kegagalan email tidak mengganggu pengunjung (pesan tetap tersimpan di admin).
        defer(function () use ($inquiry) {
            foreach ([
                [config('mail.from.address'), new InquiryAdminAlert($inquiry)],   // notifikasi ke admin
                [$inquiry->email, new InquiryReceived($inquiry)],                  // konfirmasi ke pelanggan
            ] as [$to, $mail]) {
                try {
                    Mail::to($to)->send($mail);
                } catch (\Throwable $e) {
                    report($e);
                }
            }
        });

        return redirect()->to(url()->previous().'#kontak')
            ->with('inquiry_ok', __('site.inquiry.success'));
    }

    public function subscribe(Request $request)
    {
        $data = $request->validate(['newsletter_email' => 'required|email|max:150']);
        Subscriber::firstOrCreate(['email' => strtolower($data['newsletter_email'])]);

        return back()->with('newsletter_ok', __('site.footer.subscribed'));
    }

    public function switchLang(string $locale)
    {
        $back = url()->previous();
        $target = str_starts_with($back, url('/')) && ! str_contains($back, '/lang/') ? $back : route('home');

        return redirect()->to($target)->withCookie(cookie(SetLocale::COOKIE, $locale, 60 * 24 * 365, '/', null, null, false, false, 'lax'));
    }
}
