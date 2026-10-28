<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public const COOKIE = 'bf_lang';
    public const LOCALES = ['en', 'id'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->cookie(self::COOKIE);

        // Bahasa default pengunjung baru: Inggris.
        app()->setLocale(in_array($locale, self::LOCALES, true) ? $locale : 'en');

        return $next($request);
    }
}
