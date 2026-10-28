<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\SetLocale;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Cookie bahasa dibaca juga oleh JavaScript (sinkron dengan localStorage), jadi tidak dienkripsi.
        $middleware->encryptCookies(except: [SetLocale::COOKIE]);
        $middleware->web(append: [SetLocale::class]);
        $middleware->redirectGuestsTo(fn () => route('admin.login'));
        $middleware->redirectUsersTo(fn () => route('admin.dashboard'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Upload melebihi batas PHP (post_max_size): body kosong sehingga muncul "Page Expired". Tampilkan pesan yang jelas.
        $exceptions->render(function (\Throwable $e, Request $request) {
            $tooBig = $e instanceof \Illuminate\Http\Exceptions\PostTooLargeException
                || ($e instanceof \Illuminate\Session\TokenMismatchException && $request->is('admin/*') && empty($_POST) && (int) $request->server('CONTENT_LENGTH') > 0);

            if ($tooBig && $request->is('admin/*')) {
                // Session belum aktif di tahap ini, jadi pesan dikirim lewat parameter URL.
                $back = strtok((string) $request->headers->get('referer', ''), '?') ?: route('admin.dashboard');

                return redirect()->to($back.'?too_big=1');
            }
        });

        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
