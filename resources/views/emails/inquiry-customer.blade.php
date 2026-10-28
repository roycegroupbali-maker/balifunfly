@extends('emails.layout')

@section('body')
@php
    $i = $inquiry;
    $wa = 'https://wa.me/'.config('site.whatsapp');
@endphp
<p style="margin:0 0 14px;font-size:18px;font-weight:700;">{{ __('mail.customer.greeting', ['name' => $i->first_name]) }}</p>
<p style="margin:0 0 22px;">{{ __('mail.customer.intro', ['company' => config('site.company')]) }}</p>

<p style="margin:0 0 8px;font-size:12px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#1796a8;">{{ __('mail.customer.summary') }}</p>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e1ecee;border-radius:10px;font-size:14px;">
    @foreach ([
        [__('mail.labels.topic'), __('site.inquiry.topics.'.$i->topic)],
        [__('mail.labels.name'), $i->fullName()],
        [__('mail.labels.email'), $i->email],
        [__('mail.labels.phone'), $i->phone],
    ] as [$k, $v])
        <tr><td style="padding:10px 14px;width:34%;color:#5b6b71;border-bottom:1px solid #eef5f6;">{{ $k }}</td><td style="padding:10px 14px;border-bottom:1px solid #eef5f6;">{{ $v }}</td></tr>
    @endforeach
    @if ($i->message)
        <tr><td style="padding:10px 14px;color:#5b6b71;vertical-align:top;">{{ __('mail.labels.message') }}</td><td style="padding:10px 14px;">{!! nl2br(e($i->message)) !!}</td></tr>
    @endif
</table>

<p style="margin:26px 0 14px;">{{ __('mail.customer.faster') }}</p>
<a href="{{ $wa }}" style="display:inline-block;background:#e8a33d;color:#0c3a45;text-decoration:none;font-weight:700;padding:12px 24px;border-radius:999px;">{{ __('mail.customer.whatsapp') }}</a>

<p style="margin:28px 0 0;">{{ __('mail.customer.regards') }}<br><strong>{{ config('site.company') }}</strong></p>
@endsection

@section('footer')
<p style="margin:0 0 6px;">{{ __('mail.customer.auto') }}</p>
<p style="margin:0;">{{ config('site.phone') }} &middot; {{ config('site.address') }} &middot; {{ config('site.hours.'.app()->getLocale()) }}</p>
@endsection
