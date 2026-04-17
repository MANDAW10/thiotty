<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Commande - Thiotty Enterprise</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f4f4f4; color: #333; }
        .container { max-width: 620px; margin: 30px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .header { background: #206B13; padding: 32px 40px; text-align: center; }
        .header h1 { color: #fff; font-size: 22px; font-weight: 900; letter-spacing: 2px; text-transform: uppercase; }
        .header p { color: rgba(255,255,255,0.8); font-size: 13px; margin-top: 6px; }
        .badge { display: inline-block; background: #f8b703; color: #1a1a1a; font-weight: 900; font-size: 14px; padding: 6px 16px; border-radius: 20px; margin-top: 12px; letter-spacing: 1px; }
        .body { padding: 36px 40px; }
        .section-title { font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; color: #206B13; margin-bottom: 14px; border-bottom: 2px solid #e8f5e2; padding-bottom: 8px; }
        .info-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f0f0f0; font-size: 14px; }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #888; font-weight: 600; }
        .info-value { color: #111; font-weight: 700; text-align: right; max-width: 60%; }
        .items-table { width: 100%; border-collapse: collapse; margin-top: 6px; }
        .items-table th { background: #f7f7f7; padding: 10px 12px; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #666; font-weight: 800; text-align: left; }
        .items-table td { padding: 12px 12px; font-size: 14px; border-bottom: 1px solid #f3f3f3; vertical-align: middle; }
        .items-table tr:last-child td { border-bottom: none; }
        .product-name { font-weight: 700; color: #111; }
        .total-box { background: #f0fae8; border: 2px solid #206B13; border-radius: 10px; padding: 18px 24px; margin-top: 24px; display: flex; justify-content: space-between; align-items: center; }
        .total-label { font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #206B13; }
        .total-amount { font-size: 22px; font-weight: 900; color: #206B13; }
        .status-pill { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-wave { background: #e8f4fd; color: #0c5460; }
        .footer { background: #1a1a1a; padding: 24px 40px; text-align: center; }
        .footer p { color: #888; font-size: 12px; line-height: 1.8; }
        .footer strong { color: #f8b703; }
        .divider { height: 1px; background: #f0f0f0; margin: 24px 0; }
        .section { margin-bottom: 28px; }
    </style>
</head>
<body>
    <div class="container">

        <!-- HEADER -->
        <div class="header">
            <h1>🛒 Thiotty Enterprise</h1>
            <p>Nouvelle commande reçue sur votre boutique</p>
            <div class="badge">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
        </div>

        <!-- BODY -->
        <div class="body">

            <!-- Infos client -->
            <div class="section">
                <div class="section-title">👤 Informations Client</div>
                <div class="info-row">
                    <span class="info-label">Nom</span>
                    <span class="info-value">{{ $order->customer_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Téléphone</span>
                    <span class="info-value">{{ $order->customer_phone }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Adresse</span>
                    <span class="info-value">{{ $order->customer_address }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Zone de livraison</span>
                    <span class="info-value">{{ $order->deliveryZone->name ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date</span>
                    <span class="info-value">{{ $order->created_at->format('d/m/Y à H:i') }}</span>
                </div>
            </div>

            <div class="divider"></div>

            <!-- Articles commandés -->
            <div class="section">
                <div class="section-title">📦 Articles Commandés</div>
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th style="text-align:center">Qté</th>
                            <th style="text-align:right">Prix unitaire</th>
                            <th style="text-align:right">Sous-total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td class="product-name">{{ $item->product->name ?? 'Produit supprimé' }}</td>
                            <td style="text-align:center; color:#206B13; font-weight:800;">{{ $item->quantity }}</td>
                            <td style="text-align:right; color:#555;">{{ number_format($item->unit_price, 0, ',', ' ') }} CFA</td>
                            <td style="text-align:right; font-weight:800;">{{ number_format($item->unit_price * $item->quantity, 0, ',', ' ') }} CFA</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="divider"></div>

            <!-- Paiement -->
            <div class="section">
                <div class="section-title">💳 Détails du Paiement</div>
                <div class="info-row">
                    <span class="info-label">Sous-total produits</span>
                    <span class="info-value">{{ number_format($order->total_amount - $order->delivery_fee, 0, ',', ' ') }} CFA</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Frais de livraison</span>
                    <span class="info-value">{{ number_format($order->delivery_fee, 0, ',', ' ') }} CFA</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Mode de paiement</span>
                    <span class="info-value">
                        <span class="status-pill {{ $order->payment_method === 'wave' ? 'status-wave' : 'status-pending' }}">
                            {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}
                        </span>
                    </span>
                </div>
            </div>

            <!-- Total final -->
            <div class="total-box">
                <span class="total-label">💰 Total à encaisser</span>
                <span class="total-amount">{{ number_format($order->total_amount, 0, ',', ' ') }} CFA</span>
            </div>

        </div>

        <!-- FOOTER -->
        <div class="footer">
            <p>Cet e-mail a été généré automatiquement par <strong>Thiotty Enterprise</strong>.<br>
            Connectez-vous à votre <strong>tableau de bord admin</strong> pour gérer cette commande.</p>
        </div>

    </div>
</body>
</html>
