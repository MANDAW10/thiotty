<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code de validation Thiotty</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f4f4; color: #333; }
        .wrapper { max-width: 520px; margin: 40px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { background: #206B13; padding: 32px 40px; text-align: center; }
        .header h1 { color: #fff; font-size: 22px; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; }
        .header p { color: rgba(255,255,255,0.75); font-size: 13px; margin-top: 4px; }
        .body { padding: 36px 40px; }
        .body p { font-size: 15px; line-height: 1.7; color: #555; }
        .body strong { color: #222; }
        .otp-box { background: #f0fae8; border: 2px dashed #206B13; border-radius: 12px; text-align: center; padding: 24px 16px; margin: 28px 0; }
        .otp-box .otp-code { font-size: 48px; font-weight: 900; color: #206B13; letter-spacing: 12px; line-height: 1; }
        .otp-box .otp-label { font-size: 11px; color: #888; text-transform: uppercase; letter-spacing: 2px; margin-top: 8px; }
        .warning { background: #fffbea; border-left: 4px solid #f59e0b; border-radius: 8px; padding: 12px 16px; margin-top: 20px; font-size: 13px; color: #92400e; }
        .footer { background: #f8f8f8; padding: 20px 40px; text-align: center; border-top: 1px solid #eee; }
        .footer p { font-size: 12px; color: #aaa; line-height: 1.6; }
        .footer a { color: #206B13; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>🛒 Thiotty Enterprise</h1>
            <p>Vérification de votre paiement</p>
        </div>
        <div class="body">
            <p>Bonjour <strong>{{ $customerName }}</strong>,</p>
            <br>
            <p>Nous avons bien reçu votre demande de paiement pour la commande <strong>#{{ $orderRef }}</strong>. Pour finaliser et sécuriser votre commande, veuillez utiliser le code ci-dessous :</p>

            <div class="otp-box">
                <div class="otp-code">{{ $otpCode }}</div>
                <div class="otp-label">Code de validation à usage unique</div>
            </div>

            <p>Entrez ce code sur la page de vérification de Thiotty pour confirmer définitivement votre commande.</p>

            <div class="warning">
                ⚠️ <strong>Ce code est valable 10 minutes uniquement.</strong> Ne le partagez avec personne. Thiotty ne vous demandera jamais ce code par téléphone.
            </div>
        </div>
        <div class="footer">
            <p>Si vous n'êtes pas à l'origine de cette demande, ignorez simplement cet e-mail.<br>
            © {{ date('Y') }} <a href="#">Thiotty Enterprise</a> · Dakar, Sénégal</p>
        </div>
    </div>
</body>
</html>
