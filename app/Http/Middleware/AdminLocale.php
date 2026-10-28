<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/** Panel admin selalu berbahasa Indonesia, terlepas dari pilihan bahasa pengunjung. */
class AdminLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        app()->setLocale('id');
        $response = $next($request);
        $response->headers->set('Cache-Control', 'no-store, private');
        $response->headers->set('X-Robots-Tag', 'noindex, nofollow');

        return $response;
    }
}
