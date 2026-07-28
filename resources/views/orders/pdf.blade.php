<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
            font-size: 13px;
            line-height: 1.5;
        }
        .header {
            margin-bottom: 30px;
            border-bottom: 2px solid #d4af37;
            padding-bottom: 15px;
        }
        .company-title {
            font-size: 22px;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .document-title {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
            color: #d4af37;
            text-transform: uppercase;
        }
        .info-table {
            width: 100%;
            margin-bottom: 30px;
        }
        .info-table td {
            vertical-align: top;
            width: 50%;
        }
        .section-title {
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 5px;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            background-color: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            padding: 8px 10px;
            text-align: left;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }
        .items-table td {
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
        }
        .totals-table {
            width: 40%;
            margin-left: auto;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 6px 10px;
            border-bottom: 1px solid #e2e8f0;
        }
        .totals-table .grand-total {
            font-weight: bold;
            color: #d4af37;
            font-size: 15px;
            border-bottom: 2px solid #d4af37;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <table style="width: 100%;">
            <tr>
                <td>
                    <span class="company-title">PROJETEUR LOGO</span><br>
                    <span style="color: #64748b; font-size: 11px;">Spécialiste de la projection de logo LED publicitaire</span>
                </td>
                <td style="text-align: right;">
                    <span class="document-title">
                        @if($type == 'devis')
                            Devis Proforma
                        @elseif($type == 'facture')
                            Facture Officielle
                        @elseif($type == 'recu')
                            Reçu de Paiement
                        @else
                            Bon de Commande
                        @endif
                    </span><br>
                    <span style="font-weight: bold;">Réf: {{ $order->code }}</span><br>
                    <span style="color: #64748b;">Date: {{ $order->created_at->format('d/m/Y') }}</span>
                </td>
            </tr>
        </table>
    </div>

    <table class="info-table">
        <tr>
            <td>
                <div class="section-title">Émetteur</div>
                <strong>ProjetEUR CRM Inc.</strong><br>
                Boutique physique et en ligne<br>
                Maroc<br>
                Téléphone: +212 600-000000<br>
                Email: contact@projecteurlogo.com
            </td>
            <td>
                <div class="section-title">Destinataire (Client)</div>
                <strong>{{ $order->customer->name }}</strong><br>
                @if($order->customer->company)
                    Société: {{ $order->customer->company }}<br>
                @endif
                Téléphone: {{ $order->customer->phone ?? 'Non spécifié' }}<br>
                Email: {{ $order->customer->email ?? 'Non spécifié' }}<br>
                Adresse: {{ $order->customer->address ?? 'Non spécifiée' }}
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 15%;">Réf</th>
                <th style="width: 50%;">Désignation</th>
                <th style="text-align: center; width: 10%;">Qté</th>
                <th style="text-align: right; width: 15%;">P.U (DH)</th>
                <th style="text-align: right; width: 15%;">Total (DH)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td style="font-family: monospace;">{{ $item->product_code }}</td>
                    <td>{{ $item->product_name }}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right;">{{ number_format($item->unit_price, 2, ',', ' ') }}</td>
                    <td style="text-align: right; font-weight: bold;">{{ number_format($item->total, 2, ',', ' ') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals-table">
        <tr>
            <td><strong>Total HT:</strong></td>
            <td style="text-align: right;">{{ number_format($order->total / 1.2, 2, ',', ' ') }} DH</td>
        </tr>
        <tr>
            <td><strong>TVA (20%):</strong></td>
            <td style="text-align: right;">{{ number_format(($order->total / 1.2) * 0.2, 2, ',', ' ') }} DH</td>
        </tr>
        <tr style="background-color: #f8fafc;">
            <td><strong>Total TTC:</strong></td>
            <td style="text-align: right; font-weight: bold;">{{ number_format($order->total, 2, ',', ' ') }} DH</td>
        </tr>
        <tr>
            <td>Acomptes versés:</td>
            <td style="text-align: right; color: #10b981;">{{ number_format($order->advance_cash + $order->advance_transfer, 2, ',', ' ') }} DH</td>
        </tr>
        <tr class="grand-total">
            <td><strong>Reste à régler:</strong></td>
            <td style="text-align: right; font-weight: bold;">{{ number_format($order->remaining, 2, ',', ' ') }} DH</td>
        </tr>
    </table>

    @if($order->notes)
        <div style="margin-top: 30px; border-left: 3px solid #d4af37; padding-left: 10px; background-color: #f8fafc; padding: 10px; border-radius: 4px;">
            <div class="section-title">Instructions spéciales / Conditions</div>
            <p style="margin: 0; font-size: 11px; font-style: italic;">{{ $order->notes }}</p>
        </div>
    @endif

    <div class="footer">
        <p>Merci pour votre confiance. ProjetEUR Logo — Boutique physique et en ligne.</p>
        <p style="font-size: 8px; margin-top: 5px;">Document généré automatiquement via la plateforme CRM ProjetEUR.</p>
    </div>

</body>
</html>
