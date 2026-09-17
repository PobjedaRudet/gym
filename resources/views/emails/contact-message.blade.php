<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nova poruka sa kontakt forme</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f4f4f4; padding:24px; margin:0;">
    <div style="max-width:560px; margin:0 auto; background:#ffffff; border-radius:8px; overflow:hidden;">
        <div style="background:#111111; padding:20px 28px;">
            <h2 style="color:#ECD008; margin:0; font-size:18px; text-transform:uppercase; letter-spacing:.5px;">Nova poruka sa kontakt forme</h2>
        </div>
        <div style="padding:28px;">
            <table style="width:100%; border-collapse:collapse; font-size:14px; color:#222;">
                <tr>
                    <td style="padding:8px 0; width:140px; color:#777;">Ime i prezime</td>
                    <td style="padding:8px 0; font-weight:bold;">{{ $data['ime_prezime'] }}</td>
                </tr>
                <tr>
                    <td style="padding:8px 0; color:#777;">Email</td>
                    <td style="padding:8px 0;"><a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a></td>
                </tr>
                <tr>
                    <td style="padding:8px 0; color:#777;">Telefon</td>
                    <td style="padding:8px 0;">{{ $data['telefon'] ?: '-' }}</td>
                </tr>
                <tr>
                    <td style="padding:8px 0; color:#777;">Predmet</td>
                    <td style="padding:8px 0;">{{ $data['predmet'] }}</td>
                </tr>
            </table>
            <div style="margin-top:18px; padding-top:18px; border-top:1px solid #eee;">
                <p style="color:#777; font-size:13px; margin:0 0 6px;">Poruka</p>
                <p style="white-space:pre-line; margin:0; line-height:1.6;">{{ $data['poruka'] }}</p>
            </div>
        </div>
        <div style="background:#f4f4f4; padding:14px 28px; font-size:12px; color:#999;">
            Poslano putem kontakt forme na begsfit-fight.ba
        </div>
    </div>
</body>
</html>
