<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Deskripsi panjang (tampil di popup detail produk).
        Schema::table('products', function (Blueprint $t) {
            $t->text('detail_en')->nullable()->after('desc_id');
            $t->text('detail_id')->nullable()->after('detail_en');
        });

        // Foto tambahan (galeri). Foto utama tetap di kolom products.image.
        Schema::create('product_images', function (Blueprint $t) {
            $t->id();
            $t->foreignId('product_id')->constrained()->cascadeOnDelete();
            $t->string('path');
            $t->unsignedInteger('sort_order')->default(0);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_images');
        Schema::table('products', function (Blueprint $t) {
            $t->dropColumn(['detail_en', 'detail_id']);
        });
    }
};
