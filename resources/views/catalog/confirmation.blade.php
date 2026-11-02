<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande Confirmée - Espace Privilège Projecteur LOGO</title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-primary: #0b1120;
            --bg-card: rgba(26, 38, 64, 0.85);
            --border-gold: rgba(212, 175, 55, 0.35);
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --gold: #d4af37;
            --gold-light: #f5d77f;
            --gold-gradient: linear-gradient(135deg, #d4af37 0%, #f59e0b 100%);
            --success: #10b981;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }
        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
        }
        .confirm-card {
            background: var(--bg-card);
            border: 1px solid var(--border-gold);
            border-radius: 20px;
            max-width: 640px;
            width: 100%;
            padding: 2.5rem;
            text-align: center;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(12px);
        }
        .icon-check {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(16, 185, 129, 0.15);
            border: 2px solid var(--success);
            color: var(--success);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin: 0 auto 1.5rem;
        }
        .code-pill {
            display: inline-block;
            background: rgba(212, 175, 55, 0.15);
            border: 1px dashed var(--gold);
            color: var(--gold-light);
            padding: 6px 18px;
            border-radius: 8px;
            font-family: monospace;
            font-size: 1.2rem;
            font-weight: 700;
            margin: 1rem 0;
            letter-spacing: 1px;
        }
        .order-summary-box {
            background: rgba(11, 17, 32, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 1.25rem;
            text-align: left;
            margin: 1.5rem 0;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            font-size: 0.92rem;
            margin-bottom: 8px;
            color: var(--text-secondary);
        }
        .btn-whatsapp {
            background: #25d366;
            color: #fff;
            padding: 12px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: transform 0.2s, background 0.2s;
            margin-top: 1rem;
        }
        .btn-whatsapp:hover {
            transform: translateY(-2px);
            background: #22bf5b;
        }
        .btn-back {
            display: inline-block;
            color: var(--text-secondary);
            text-decoration: none;
            margin-top: 1.2rem;
            font-size: 0.9rem;
        }
        .btn-back:hover {
            color: #fff;
        }
    </style>
</head>
<body>

    <div class="confirm-card">
        <div class="icon-check">
            <i class="fa-solid fa-check"></i>
        </div>

        <h1 style="font-size: 1.8rem; margin-bottom: 0.5rem; color: #fff;">Commande Bien Reçue !</h1>
        <p style="color: var(--text-secondary); line-height: 1.5;">
            Merci <strong>{{ $customer->name }}</strong>. Votre commande a été enregistrée avec succès dans notre système avec votre tarification privilégiée.
        </p>

        @if($order)
            <div class="code-pill">{{ $order->code }}</div>

            <div class="order-summary-box">
                <div style="font-weight: 700; color: #fff; margin-bottom: 10px; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 6px;">
                    Détails de votre commande
                </div>
                @foreach($order->items as $item)
                    <div class="summary-item">
                        <span>{{ $item->quantity }}x {{ $item->product_name }}</span>
                        <span style="color: #fff; font-weight: 600;">{{ number_format($item->total, 2, ',', ' ') }} DH</span>
                    </div>
                @endforeach
                <div class="summary-item" style="color: var(--success); font-weight: 600; border-top: 1px dashed rgba(255,255,255,0.1); padding-top: 8px; margin-top: 8px;">
                    <span>Remise VIP appliquée (-{{ (int)$order->discount_rate }}%)</span>
                    <span>-{{ number_format($order->discount_amount, 2, ',', ' ') }} DH</span>
                </div>
                <div class="summary-item" style="font-size: 1.15rem; font-weight: 800; color: var(--gold-light); margin-top: 6px;">
                    <span>Total à régler :</span>
                    <span>{{ number_format($order->total, 2, ',', ' ') }} DH</span>
                </div>
            </div>
        @endif

        <p style="font-size: 0.88rem; color: var(--text-secondary); margin-bottom: 1rem;">
            Notre administrateur va examiner votre commande, préparer la fabrication et vous contacter par téléphone pour confirmer la livraison.
        </p>

        @php
            $waMessage = rawurlencode("Bonjour Projecteur LOGO, je viens de passer la commande privilège " . ($order ? $order->code : '') . " pour " . $customer->name . ".");
        @endphp
        <a href="https://wa.me/212607056637?text={{ $waMessage }}" target="_blank" class="btn-whatsapp">
            <i class="fa-brands fa-whatsapp" style="font-size: 1.2rem;"></i> Nous contacter sur WhatsApp
        </a>

        <div>
            <a href="{{ route('catalog.special', $link->token) }}" class="btn-back">
                <i class="fa-solid fa-arrow-left"></i> Revenir au catalogue
            </a>
        </div>
    </div>

</body>
</html>

