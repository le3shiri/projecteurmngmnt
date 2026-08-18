@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="header-bar" style="flex-wrap: wrap; gap: 15px;">
    <div>
        <h1 class="page-title">Piloter l'Activité</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Aperçu analytique complet de votre CRM de projecteurs</p>
    </div>
    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <!-- Date filter form -->
        <form action="{{ route('dashboard') }}" method="GET" style="display: flex; gap: 8px; align-items: center; margin-right: 5px;">
            <input type="date" name="start_date" class="form-control" value="{{ $startDate ?? '' }}" style="max-width: 140px; height: 36px; font-size: 0.85rem;" title="Date début">
            <input type="date" name="end_date" class="form-control" value="{{ $endDate ?? '' }}" style="max-width: 140px; height: 36px; font-size: 0.85rem;" title="Date fin">
            <button type="submit" class="btn btn-secondary" style="height: 36px; padding: 0 12px; font-size: 0.85rem; border-radius: var(--border-radius);">Filtrer</button>
            @if($startDate || $endDate)
                <a href="{{ route('dashboard') }}" class="btn btn-secondary" style="height: 36px; padding: 0 12px; font-size: 0.85rem; display: flex; align-items: center; border-radius: var(--border-radius);">Effacer</a>
            @endif
        </form>

        <a href="{{ route('orders.create') }}" class="btn btn-primary" style="height: 36px; display: inline-flex; align-items: center;">
            <i class="fa-solid fa-plus"></i> Nouvelle Vente
        </a>
    </div>
</div>

<!-- Metrics Overview -->
<div class="metrics-grid">
    <div class="metric-card info">
        <span class="metric-label">Chiffre d'Affaires</span>
        <span class="metric-value">{{ number_format($totalSales, 2, ',', ' ') }} DH</span>
    </div>
    <div class="metric-card warning">
        <span class="metric-label">Restes à Payer (Paiements Clients)</span>
        <span class="metric-value">{{ number_format($remainingPayments, 2, ',', ' ') }} DH</span>
    </div>
    <div class="metric-card danger">
        <span class="metric-label">Dépenses Globales</span>
        <span class="metric-value">{{ number_format($totalExpenses, 2, ',', ' ') }} DH</span>
    </div>
    <a href="{{ route('commissions.index') }}" class="metric-card warning" style="text-decoration: none; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
        <span class="metric-label">Commissions Dues (Agents) <i class="fa-solid fa-arrow-right" style="font-size: 0.75rem; margin-left: 4px;"></i></span>
        <span class="metric-value">{{ number_format($commissionsPending, 2, ',', ' ') }} DH</span>
    </a>
    <div class="metric-card success">
        <span class="metric-label">Bénéfice Net</span>
        <span class="metric-value">{{ number_format($netProfit, 2, ',', ' ') }} DH</span>
    </div>
</div>

<div style="margin-bottom: 2rem;">
    <!-- Sales Curve Chart -->
    <div class="glass-card" style="margin: 0; display: flex; flex-direction: column;">
        <h3 class="card-title">Courbe de ventes annuelles</h3>
        <div style="flex: 1; min-height: 250px; position: relative;">
            <canvas id="salesChart"></canvas>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
    <!-- Recent Sales -->
    <div class="glass-card" style="margin: 0;">
        <h3 class="card-title">Ventes Récentes</h3>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Client</th>
                        <th>Agent</th>
                        <th>Total</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                        <tr>
                            <td><a href="{{ route('orders.show', $order->id) }}" style="color: var(--primary); font-weight: 600; text-decoration: none;">{{ $order->code }}</a></td>
                            <td>{{ $order->customer->name }}</td>
                            <td>{{ $order->agent->name ?? 'Direct' }}</td>
                            <td>{{ number_format($order->total, 2, ',', ' ') }} DH</td>
                            <td>
                                <span class="badge badge-{{ $order->status }}">{{ $order->status }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Prospects Call List Status -->
    <div class="glass-card" style="margin: 0;">
        <h3 class="card-title">Fichiers Prospects Importés</h3>
        <div style="display: flex; flex-direction: column; gap: 15px;">
            @foreach($prospectFiles as $file)
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px; font-size: 0.9rem;">
                        <span style="font-weight: 600;">{{ $file->name }}</span>
                        <span style="color: var(--primary);">{{ $file->progress }}% Complété</span>
                    </div>
                    <div style="background: rgba(255,255,255,0.05); height: 8px; border-radius: 4px; overflow: hidden; margin-bottom: 5px;">
                        <div style="width: {{ $file->progress }}%; background: var(--primary); height: 100%; border-radius: 4px;"></div>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.75rem; color: var(--text-secondary);">
                        <span>Agent: {{ $file->agent->name }}</span>
                        <span>Créé le: {{ $file->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Chiffre d\'Affaires (DH)',
                data: {!! json_encode($chartData) !!},
                borderColor: '#d4af37',
                backgroundColor: 'rgba(212, 175, 55, 0.1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: { color: '#94a3b8' }
                }
            },
            scales: {
                x: {
                    grid: { color: 'rgba(255,255,255,0.05)' },
                    ticks: { color: '#94a3b8' }
                },
                y: {
                    grid: { color: 'rgba(255,255,255,0.05)' },
                    ticks: { color: '#94a3b8' }
                }
            }
        }
    });
</script>
@endsection
