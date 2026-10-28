<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'key';
    protected $keyType = 'string';
    protected $guarded = [];

    /** Semua pengaturan sebagai array key => value (di-cache; aman jika tabel belum ada). */
    public static function all_(): array
    {
        try {
            return Cache::rememberForever('site_settings', fn () => static::query()->pluck('value', 'key')->all());
        } catch (\Throwable $e) {
            return [];
        }
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $v = static::all_()[$key] ?? null;

        return ($v === null || $v === '') ? $default : $v;
    }

    /** Ambil nilai sesuai bahasa aktif: key_en / key_id (fallback ke bahasa lain). */
    public static function localized(string $key, mixed $default = null): mixed
    {
        $loc = app()->getLocale();
        $other = $loc === 'id' ? 'en' : 'id';

        return static::get($key.'_'.$loc) ?? static::get($key.'_'.$other) ?? $default;
    }

    public static function put(string $key, ?string $value): void
    {
        static::query()->updateOrInsert(['key' => $key], ['value' => $value]);
        Cache::forget('site_settings');
    }
}
