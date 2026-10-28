<?php

namespace App\Mail;

use App\Models\Inquiry;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

/** Email konfirmasi untuk pelanggan, sesuai bahasa yang dipakai saat mengirim formulir. */
class InquiryReceived extends Mailable
{
    public function __construct(public Inquiry $inquiry)
    {
        $this->locale($inquiry->locale ?: 'en');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('mail.customer.subject', ['name' => config('site.name')]),
            replyTo: [new Address(config('mail.from.address'), config('site.name'))],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.inquiry-customer');
    }
}
