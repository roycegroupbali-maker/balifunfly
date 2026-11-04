<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class Recaptcha implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => config('services.recaptcha.secret_key'),
            'response' => $value,
            'remoteip' => request()->ip(),
        ]);

        if (! $response->successful() || ! $response->json('success')) {
            $fail(__('site.inquiry.recaptcha_failed'));
        }
    }
}