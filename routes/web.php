<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\SiteController;
use App\Http\Middleware\AdminLocale;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/produk', [SiteController::class, 'products'])->name('products.index');
Route::get('/artikel', [SiteController::class, 'articles'])->name('articles.index');
Route::get('/artikel/{article:slug}', [SiteController::class, 'article'])->name('articles.show');
Route::post('/permintaan', [SiteController::class, 'inquiry'])->name('inquiry.store');
Route::post('/newsletter', [SiteController::class, 'subscribe'])->name('newsletter.store');

// Ganti bahasa (cadangan tanpa JavaScript; tombol di navbar memakai JS + localStorage).
Route::get('/lang/{locale}', [SiteController::class, 'switchLang'])->whereIn('locale', SetLocale::LOCALES)->name('lang.switch');

// Panel admin
Route::prefix('admin')->name('admin.')->middleware(AdminLocale::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [Admin\AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [Admin\AuthController::class, 'login'])->middleware('throttle:6,1')->name('login.attempt');
    });

    Route::middleware('auth')->group(function () {
        Route::post('logout', [Admin\AuthController::class, 'logout'])->name('logout');
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('products', Admin\ProductController::class)->except('show');
        Route::resource('articles', Admin\ArticleController::class)->except('show');

        Route::get('inquiries', [Admin\InquiryController::class, 'index'])->name('inquiries.index');
        Route::get('inquiries/{inquiry}', [Admin\InquiryController::class, 'show'])->name('inquiries.show');
        Route::delete('inquiries/{inquiry}', [Admin\InquiryController::class, 'destroy'])->name('inquiries.destroy');
        Route::get('subscribers', [Admin\InquiryController::class, 'subscribers'])->name('subscribers.index');
        Route::delete('subscribers/{subscriber}', [Admin\InquiryController::class, 'destroySubscriber'])->name('subscribers.destroy');

        Route::get('settings', [Admin\SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [Admin\SettingController::class, 'update'])->name('settings.update');
        Route::put('password', [Admin\SettingController::class, 'password'])->name('password.update');
    });
});
