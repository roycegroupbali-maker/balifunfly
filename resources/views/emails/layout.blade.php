<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"></head>
<body style="margin:0;padding:0;background:#eef5f6;font-family:-apple-system,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;color:#16262c;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#eef5f6;padding:24px 12px;">
<tr><td align="center">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;background:#ffffff;border-radius:14px;overflow:hidden;">
        <tr><td style="background:#0c3a45;padding:26px 32px;">
            <span style="font-size:20px;font-weight:800;letter-spacing:3px;color:#ffffff;text-transform:uppercase;">{{ config('site.name') }}</span>
            <span style="display:block;margin-top:4px;font-size:12px;color:#e8a33d;">Let's Fly &middot; Paramotor Bali</span>
        </td></tr>
        <tr><td style="padding:32px;font-size:15px;line-height:1.6;">
            @yield('body')
        </td></tr>
        <tr><td style="background:#f6fafb;padding:20px 32px;font-size:12px;line-height:1.6;color:#5b6b71;">
            @yield('footer')
        </td></tr>
    </table>
</td></tr>
</table>
</body>
</html>
