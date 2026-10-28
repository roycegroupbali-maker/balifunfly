<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\Upload;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private const TEXT = ['phone', 'whatsapp', 'email', 'address', 'instagram', 'tagline_en', 'tagline_id', 'hours_en', 'hours_id',
        'hero_title_en', 'hero_title_id', 'hero_text_en', 'hero_text_id'];

    private const MEDIA = ['hero_video' => 'hero', 'hero_poster' => 'hero'];

    public function edit()
    {
        return view('admin.settings', ['s' => Setting::all_()]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'phone' => 'nullable|string|max:40',
            'whatsapp' => ['nullable', 'regex:/^\d{8,16}$/'],
            'email' => 'nullable|email|max:120',
            'address' => 'nullable|string|max:200',
            'instagram' => 'nullable|url|max:200',
            'tagline_en' => 'nullable|string|max:250', 'tagline_id' => 'nullable|string|max:250',
            'hours_en' => 'nullable|string|max:120', 'hours_id' => 'nullable|string|max:120',
            'hero_title_en' => 'nullable|string|max:200', 'hero_title_id' => 'nullable|string|max:200',
            'hero_text_en' => 'nullable|string|max:400', 'hero_text_id' => 'nullable|string|max:400',
            'hero_video' => 'nullable|file|mimetypes:video/mp4,video/webm|max:51200',
            'hero_poster' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ], [
            'whatsapp.regex' => 'Nomor WhatsApp harus berupa angka saja dengan kode negara, tanpa + atau spasi (contoh: 6281234567890).',
        ], [
            'instagram' => 'link Instagram', 'hero_video' => 'video hero', 'hero_poster' => 'foto cadangan hero',
        ]);

        foreach (self::TEXT as $key) {
            Setting::put($key, trim((string) $request->input($key)) ?: null);
        }

        foreach (self::MEDIA as $key => $folder) {
            if ($request->hasFile($key)) {
                Upload::delete(Setting::get($key));
                Setting::put($key, Upload::store($request->file($key), $folder));
            } elseif ($request->boolean('remove_'.$key)) {
                Upload::delete(Setting::get($key));
                Setting::put($key, null);
            }
        }

        return back()->with('ok', 'Pengaturan disimpan.');
    }

    public function password(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ], [], ['current_password' => 'password lama', 'password' => 'password baru']);

        $request->user()->update(['password' => $request->password]);

        return back()->with('ok', 'Password berhasil diganti.');
    }
}
