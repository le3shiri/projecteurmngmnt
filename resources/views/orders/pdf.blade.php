<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>
    <style>
        @page {
            margin: 35px 40px 35px 40px;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #1f2937;
            margin: 0;
            padding: 0;
            font-size: 12px;
            line-height: 1.4;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .header-table td {
            vertical-align: middle;
        }
        .logo-img {
            max-height: 50px;
            width: auto;
        }
        .doc-title-box {
            text-align: right;
        }
        .doc-type {
            font-size: 18px;
            font-weight: bold;
            color: #2563eb;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }
        .doc-ref {
            font-size: 13px;
            font-weight: bold;
            color: #1f2937;
        }
        .doc-date {
            font-size: 12px;
            color: #4b5563;
            margin-top: 2px;
        }
        .divider-line {
            border-bottom: 2px solid #2563eb;
            margin-bottom: 22px;
            width: 100%;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .info-table td {
            width: 50%;
            vertical-align: top;
        }
        .info-block-title {
            font-size: 11px;
            font-weight: bold;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }
        .info-content {
            font-size: 12px;
            line-height: 1.6;
            color: #374151;
        }
        .info-content strong {
            font-size: 13px;
            color: #111827;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .items-table th {
            background-color: #f3f4f6;
            color: #374151;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
            padding: 9px 12px;
            border-top: 1px solid #e5e7eb;
            border-bottom: 1px solid #e5e7eb;
            letter-spacing: 0.5px;
        }
        .items-table td {
            padding: 11px 12px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 12px;
            color: #1f2937;
        }
        .items-table tr:last-child td {
            border-bottom: 1px solid #e5e7eb;
        }
        .ref-code {
            color: #6b7280;
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
        }
        .totals-table {
            width: 45%;
            margin-left: auto;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .totals-table td {
            padding: 6px 10px;
            font-size: 12px;
            color: #374151;
        }
        .totals-table .row-ttc {
            font-weight: bold;
            font-size: 13px;
            color: #111827;
        }
        .totals-table .row-advances {
            color: #059669;
            font-weight: bold;
        }
        .totals-table .row-remaining {
            font-size: 14px;
            font-weight: bold;
            color: #2563eb;
            border-top: 2px solid #2563eb;
            border-bottom: 2px solid #2563eb;
            padding-top: 8px;
            padding-bottom: 8px;
        }
        .words-box {
            background-color: #f9fafb;
            border: 1px solid #f3f4f6;
            border-left: 4px solid #d1d5db;
            padding: 10px 14px;
            border-radius: 4px;
            margin-bottom: 30px;
        }
        .words-title {
            font-size: 10px;
            font-weight: bold;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .words-value {
            font-size: 12px;
            font-weight: bold;
            font-style: italic;
            color: #1f2937;
        }
        .footer {
            margin-top: 35px;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
            border-top: 1px solid #f3f4f6;
            padding-top: 15px;
            line-height: 1.5;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td style="width: 50%;">
                @if($logoBase64)
                    <img src="{{ $logoBase64 }}" class="logo-img" alt="Logo">
                @else
                    <div style="font-size: 22px; font-weight: bold; color: #2563eb;">PROJECTEUR LOGO</div>
                @endif
            </td>
            <td style="width: 50%;" class="doc-title-box">
                <div class="doc-type">
                    @if($type == 'devis')
                        DEVIS N° {{ $order->code }}
                    @elseif($type == 'facture')
                        FACTURE N° {{ $order->code }}
                    @elseif($type == 'recu')
                        REÇU N° {{ $order->code }}
                    @else
                        BON DE COMMANDE N° {{ $order->code }}
                    @endif
                </div>
                <div class="doc-date">Date: {{ $order->created_at->format('d/m/Y') }}</div>
            </td>
        </tr>
    </table>

    <div class="divider-line"></div>

    <table class="info-table">
        <tr>
            <td>
                <div class="info-block-title">ÉMETTEUR</div>
                <div class="info-content">
                    <strong>{{ $emitterName ?? 'Projecteur CRM Inc.' }}</strong><br>
                    {{ $emitterSubtitle ?? 'Boutique physique et en ligne' }}<br>
                    {{ $emitterCountry ?? 'Maroc' }}<br>
                    Téléphone: {{ $emitterPhone ?? '+212 600-000000' }}<br>
                    Email: {{ $emitterEmail ?? 'contact@projecteurlogo.com' }}
                </div>
            </td>
            <td>
                <div class="info-block-title">CLIENT</div>
                <div class="info-content">
                    <strong>{!! $customerNameFormatted !!}</strong><br>
                    @if(!empty($customerCompanyFormatted))
                        Société: {!! $customerCompanyFormatted !!}<br>
                    @endif
                    Téléphone: {{ $order->customer->phone ?? 'Non spécifié' }}<br>
                    Email: {{ $order->customer->email ?? 'Non spécifié' }}<br>
                    Adresse: {!! !empty($customerAddressFormatted) ? $customerAddressFormatted : 'Non spécifiée' !!}
                </div>
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 18%; text-align: left;">RÉF</th>
                <th style="width: 44%; text-align: left;">DÉSIGNATION</th>
                <th style="width: 10%; text-align: center;">QTÉ</th>
                <th style="width: 14%; text-align: right;">P.U (DH)</th>
                <th style="width: 14%; text-align: right;">TOTAL (DH)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td class="ref-code">{{ $item->product_code }}</td>
                    <td>{!! $item->formatted_name ?? $item->product_name !!}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right;">{{ number_format($item->unit_price, 2, ',', ' ') }}</td>
                    <td style="text-align: right; font-weight: bold;">{{ number_format($item->quantity * $item->unit_price, 2, ',', ' ') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals-table">
        @if(($tva ?? 0) > 0 || ($tvaRate ?? 0) > 0)
        <tr>
            <td><strong>Total HT:</strong></td>
            <td style="text-align: right;">{{ number_format($totalHt, 2, ',', ' ') }} DH</td>
        </tr>
        <tr>
            <td><strong>TVA ({{ $tvaRate ?? 20 }}%):</strong></td>
            <td style="text-align: right;">{{ number_format($tva, 2, ',', ' ') }} DH</td>
        </tr>
        <tr class="row-ttc">
            <td><strong>Total TTC:</strong></td>
            <td style="text-align: right;">{{ number_format($totalTtc, 2, ',', ' ') }} DH</td>
        </tr>
        @else
        <tr class="row-ttc">
            <td><strong>Total Commande:</strong></td>
            <td style="text-align: right;">{{ number_format($totalTtc, 2, ',', ' ') }} DH</td>
        </tr>
        @endif
        <tr class="row-advances">
            <td>Acomptes versés:</td>
            <td style="text-align: right;">{{ number_format($advances, 2, ',', ' ') }} DH</td>
        </tr>
        <tr class="row-remaining">
            <td><strong>Reste à régler:</strong></td>
            <td style="text-align: right;">{{ number_format($remaining, 2, ',', ' ') }} DH</td>
        </tr>
    </table>

    @if(!empty($totalInWords))
    <div class="words-box">
        <div class="words-title">LA SOMME EN LETTRE</div>
        <div class="words-value">{{ $totalInWords }}</div>
    </div>
    @endif

    <div class="footer">
        <p>Merci pour votre confiance. Projecteur Logo — Boutique physique et en ligne.</p>
        <p style="font-size: 8px; margin-top: 3px; color: #d1d5db;">Document généré automatiquement via la plateforme CRM Projecteur.</p>
    </div>

</body>
</html>
