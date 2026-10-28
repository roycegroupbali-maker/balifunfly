<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class MailTest extends Command
{
    protected $signature = 'mail:test {to? : Alamat email tujuan (default: MAIL_FROM_ADDRESS)}';
    protected $description = 'Kirim email percobaan untuk mengecek pengaturan SMTP';

    public function handle(): int
    {
        $to = $this->argument('to') ?: config('mail.from.address');
        $this->info('Mailer: '.config('mail.default').' | host: '.config('mail.mailers.smtp.host').':'.config('mail.mailers.smtp.port').' | dari: '.config('mail.from.address'));

        try {
            Mail::raw('Email percobaan dari website '.config('site.name').'. Jika Anda membaca ini, pengaturan email sudah benar.', function ($m) use ($to) {
                $m->to($to)->subject('Tes email '.config('site.name'));
            });
        } catch (\Throwable $e) {
            $this->error('Gagal: '.$e->getMessage());
            return self::FAILURE;
        }

        $this->info("Terkirim ke $to. Cek inbox (dan folder Spam).");

        return self::SUCCESS;
    }
}
