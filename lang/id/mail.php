<?php

return [
    'labels' => [
        'name' => 'Nama', 'email' => 'Email', 'phone' => 'Telepon / WhatsApp', 'topic' => 'Tertarik dengan',
        'message' => 'Pesan', 'language' => 'Bahasa', 'time' => 'Diterima',
    ],
    'customer' => [
        'subject' => 'Permintaan Anda sudah kami terima - :name',
        'greeting' => 'Halo :name,',
        'intro' => 'Terima kasih sudah menghubungi :company. Permintaan Anda sudah kami terima dan tim kami akan membalas dalam satu hari kerja.',
        'summary' => 'Permintaan Anda',
        'faster' => 'Butuh jawaban lebih cepat? Chat langsung dengan kami:',
        'whatsapp' => 'Chat WhatsApp',
        'regards' => 'Salam hangat,',
        'auto' => 'Ini adalah konfirmasi otomatis. Anda bisa membalas email ini jika ingin menambahkan sesuatu.',
    ],
    'admin' => [
        'subject' => '[:site] Permintaan baru dari :customer',
        'title' => 'Permintaan baru masuk',
        'intro' => 'Ada permintaan baru yang baru saja dikirim lewat formulir website.',
        'open' => 'Buka di panel admin',
        'reply' => 'Balas email ini untuk menjawab pelanggan secara langsung.',
        'footer' => 'Notifikasi otomatis dari website :site.',
    ],
];
