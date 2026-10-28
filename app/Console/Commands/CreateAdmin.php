<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    protected $signature = 'admin:create {email? : Email admin} {--name= : Nama admin}';
    protected $description = 'Buat akun admin baru, atau reset password admin yang sudah ada';

    public function handle(): int
    {
        $email = $this->argument('email') ?: $this->ask('Email admin');
        $name = $this->option('name') ?: $this->ask('Nama', 'Admin');

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Format email tidak valid.');
            return self::FAILURE;
        }

        $password = $this->secret('Password (minimal 8 karakter)');
        if (strlen((string) $password) < 8) {
            $this->error('Password minimal 8 karakter.');
            return self::FAILURE;
        }
        if ($password !== $this->secret('Ulangi password')) {
            $this->error('Password tidak sama.');
            return self::FAILURE;
        }

        $user = User::firstOrNew(['email' => $email]);
        $existing = $user->exists;
        $user->name = $name;
        $user->password = $password; // di-hash otomatis oleh model
        $user->save();

        $this->info($existing ? "Password admin $email diperbarui." : "Admin $email dibuat. Login di /admin/login");

        return self::SUCCESS;
    }
}
