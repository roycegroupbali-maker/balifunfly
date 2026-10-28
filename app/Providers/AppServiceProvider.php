<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Pengaturan yang diubah lewat panel admin menimpa nilai default di config/site.php.
        $s = \App\Models\Setting::all_();
        foreach (['phone', 'whatsapp', 'email', 'address', 'instagram', 'tagline_en', 'tagline_id', 'hours_en', 'hours_id'] as $key) {
            if (! empty($s[$key])) {
                config(['site.'.str_replace('_', '.', $key) => $s[$key]]);
            }
        }
    }
}
