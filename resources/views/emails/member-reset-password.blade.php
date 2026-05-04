<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f4f4f7; margin: 0; padding: 0; }
        .wrapper { max-width: 520px; margin: 40px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #1a1a1a, #111); padding: 30px; text-align: center; }
        .header h1 { color: #fff; font-size: 22px; margin: 0; font-weight: 800; }
        .header h1 span { color: #c8a84e; }
        .content { padding: 30px; }
        .content p { color: #333; font-size: 15px; line-height: 1.6; margin: 0 0 16px; }
        .reset-btn { display: inline-block; background: linear-gradient(135deg, #c8a84e, #a08430); color: #fff; text-decoration: none; padding: 14px 36px; border-radius: 10px; font-size: 15px; font-weight: 700; margin: 20px 0; }
        .note { background: #fff9e6; border-radius: 10px; padding: 14px 16px; font-size: 13px; color: #856404; margin-top: 20px; }
        .footer { padding: 20px 30px; text-align: center; border-top: 1px solid #f0f0f0; }
        .footer p { color: #9ca3af; font-size: 12px; margin: 0; }
        .raw-link { word-break: break-all; color: #6b7280; font-size: 12px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1><span>BEG's</span> Fit Fight</h1>
        </div>
        <div class="content">
            <p>Postovani/a <strong>{{ $member->name }} {{ $member->surname }}</strong>,</p>
            <p>Zaprimili smo zahtjev za reset lozinke na clanu portala. Kliknite dugme ispod da postavite novu lozinku.</p>

            <p style="text-align:center;">
                <a href="{{ $resetUrl }}" class="reset-btn">Resetuj lozinku</a>
            </p>

            <p>Ako dugme ne radi, kopirajte ovaj link u browser:</p>
            <p class="raw-link">{{ $resetUrl }}</p>

            <div class="note">
                Ovaj link vazi 60 minuta. Ako niste Vi trazili reset lozinke, slobodno zanemarite ovu poruku.
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} BEG's Fit Fight. Sva prava zadrzana.</p>
        </div>
    </div>
</body>
</html>
