@extends('emails.layout')

@section('body')
@php
    $i = $inquiry;
    $digits = preg_replace('/\D/', '', $i->phone);
    if (str_starts_with($digits, '0')) { $digits = '62'.substr($digits, 1); }
@endphp
<p style="margin:0 0 6px;font-size:18px;font-weight:700;">{{ __('mail.admin.title') }}</p>
<p style="margin:0 0 22px;color:#5b6b71;">{{ __('mail.admin.intro') }}</p>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e1ecee;border-radius:10px;font-size:14px;">
    @foreach ([
        [__('mail.labels.name'), $i->fullName()],
        [__('mail.labels.topic'), __('site.inquiry.topics.'.$i->topic)],
        [__('mail.labels.email'), $i->email],
        [__('mail.labels.phone'), $i->phone],
        [__('mail.labels.language'), strtoupper($i->locale)],
        [__('mail.labels.time'), $i->created_at->translatedFormat('j F Y, H:i')],
    ] as [$k, $v])
        <tr><td style="padding:10px 14px;width:34%;color:#5b6b71;border-bottom:1px solid #eef5f6;">{{ $k }}</td><td style="padding:10px 14px;border-bottom:1px solid #eef5f6;">{{ $v }}</td></tr>
    @endforeach
    <tr><td style="padding:10px 14px;color:#5b6b71;vertical-align:top;">{{ __('mail.labels.message') }}</td><td style="padding:10px 14px;">{!! $i->message ? nl2br(e($i->message)) : '-' !!}</td></tr>
</table>

<p style="margin:26px 0 12px;">
    <a href="{{ route('admin.inquiries.show', $i) }}" style="display:inline-block;background:#0c3a45;color:#ffffff;text-decoration:none;font-weight:700;padding:12px 24px;border-radius:999px;">{{ __('mail.admin.open') }}</a>
    @if (strlen($digits) >= 8)
        <a href="https://wa.me/{{ $digits }}" style="display:inline-block;margin-left:8px;border:1px solid #0c3a45;color:#0c3a45;text-decoration:none;font-weight:700;padding:11px 22px;border-radius:999px;">WhatsApp</a>
    @endif
</p>
<p style="margin:0;font-size:13px;color:#5b6b71;">{{ __('mail.admin.reply') }}</p>
@endsection

@section('footer')
<p style="margin:0;">{{ __('mail.admin.footer', ['site' => config('site.name')]) }}</p>
@endsection
