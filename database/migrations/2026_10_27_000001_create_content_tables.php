<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $t) {
            $t->id();
            $t->string('name_en');
            $t->string('name_id');
            $t->text('desc_en')->nullable();
            $t->text('desc_id')->nullable();
            $t->string('category', 30)->index();
            $t->string('tag', 30)->nullable();
            $t->string('price')->nullable();
            $t->string('image')->nullable();
            $t->boolean('is_active')->default(true);
            $t->boolean('is_featured')->default(false);
            $t->unsignedInteger('sort_order')->default(0);
            $t->timestamps();
        });

        Schema::create('articles', function (Blueprint $t) {
            $t->id();
            $t->string('slug')->unique();
            $t->string('title_en');
            $t->string('title_id');
            $t->text('excerpt_en')->nullable();
            $t->text('excerpt_id')->nullable();
            $t->longText('body_en')->nullable();
            $t->longText('body_id')->nullable();
            $t->string('category', 30);
            $t->date('published_at');
            $t->unsignedSmallInteger('read_minutes')->default(3);
            $t->string('image')->nullable();
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        Schema::create('inquiries', function (Blueprint $t) {
            $t->id();
            $t->string('first_name');
            $t->string('last_name')->nullable();
            $t->string('email');
            $t->string('phone', 40);
            $t->string('topic', 30);
            $t->text('message')->nullable();
            $t->string('locale', 5)->default('en');
            $t->timestamp('read_at')->nullable();
            $t->timestamps();
        });

        Schema::create('subscribers', function (Blueprint $t) {
            $t->id();
            $t->string('email')->unique();
            $t->timestamps();
        });

        Schema::create('settings', function (Blueprint $t) {
            $t->string('key')->primary();
            $t->text('value')->nullable();
        });
    }

    public function down(): void
    {
        foreach (['settings', 'subscribers', 'inquiries', 'articles', 'products'] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
