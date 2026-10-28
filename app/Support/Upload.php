<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/** Simpan file upload langsung di public/uploads/... (tanpa perlu storage:link). */
class Upload
{
    public static function store(UploadedFile $file, string $folder): string
    {
        $dir = public_path('uploads/'.$folder);
        File::ensureDirectoryExists($dir);

        $ext = strtolower($file->guessExtension() ?: $file->getClientOriginalExtension());
        $name = Str::random(16).'.'.$ext;
        $file->move($dir, $name);

        return 'uploads/'.$folder.'/'.$name;
    }

    /** Hapus file lama; hanya file di dalam public/uploads yang boleh dihapus. */
    public static function delete(?string $path): void
    {
        if (! $path || ! str_starts_with($path, 'uploads/') || str_contains($path, '..')) {
            return;
        }
        $full = public_path($path);
        if (is_file($full)) {
            @unlink($full);
        }
    }
}
