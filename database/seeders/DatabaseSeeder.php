<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Sengaja TIDAK membuat user contoh. Buat admin dengan: php artisan admin:create
        $this->call(ContentSeeder::class);
    }
}
