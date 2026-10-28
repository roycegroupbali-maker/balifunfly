<?php

namespace App\Mail;

use App\Models\Inquiry;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

/** Notifikasi untuk admin saat ada permintaan baru. Balas email ini = membalas pelanggan langsung. */
class InquiryAdminAlert extends Mailable
{
    public function __construct(public Inquiry $inquiry)
    {
        $this->locale('id'); // panel & notifikasi admin selalu berbahasa Indonesia
    }

    public function envelope(): Envelope
    {
        $name = trim(preg_replace('/[\r\n]+/', ' ', $this->inquiry->fullName()));

        return new Envelope(
            subject: __('mail.admin.subject', ['site' => config('site.name'), 'customer' => $name]),
            replyTo: [new Address($this->inquiry->email, $name)],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.inquiry-admin');
    }
}
