<?php

namespace App\Models\Concerns;

trait HasLocale
{
    /** Ambil kolom bertingkat bahasa, mis. loc('name') -> name_en / name_id sesuai bahasa aktif. */
    public function loc(string $field): ?string
    {
        $loc = app()->getLocale();
        $other = $loc === 'id' ? 'en' : 'id';

        return $this->{$field.'_'.$loc} ?: $this->{$field.'_'.$other};
    }

    public function imageUrl(): ?string
    {
        return $this->image ? asset($this->image) : null;
    }
}
