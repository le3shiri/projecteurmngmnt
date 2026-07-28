@extends('layouts.app')

@section('title', 'Agent Dashboard')

@section('content')
<div class="header-bar" style="flex-wrap: wrap; gap: 15px;">
    <div>
        <h1 class="page-title">Mon Espace Commercial</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Suivi de mes ventes, commissions et prospection en temps réel</p>
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
            <i class="fa-solid fa-plus"></i> Saisir une Vente
        </a>
    </div>
</div>

<!-- Metrics Cards -->
<div class="metrics-grid">
    <div class="metric-card info">
        <span class="metric-label">Mes Ventes Réalisées</span>
        <span class="metric-value">{{ number_format($mySalesTotal, 2, ',', ' ') }} DH</span>
    </div>
    <div class="metric-card warning">
        <span class="metric-label">Commissions en attente</span>
        <span class="metric-value">{{ number_format($myPendingCommissions, 2, ',', ' ') }} DH</span>
    </div>
    <div class="metric-card success">
        <span class="metric-label">Commissions encaissées</span>
        <span class="metric-value">{{ number_format($myPaidCommissions, 2, ',', ' ') }} DH</span>
    </div>
    <div class="metric-card danger">
        <span class="metric-label">Appels Prospects Restants</span>
        <span class="metric-value">{{ $pendingCallsCount }} Appel(s)</span>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
    <!-- My Recent Orders -->
    <div class="glass-card" style="margin: 0;">
        <h3 class="card-title">Mes Dernières Commandes</h3>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Client</th>
                        <th>Total</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($myRecentOrders as $order)
                        <tr>
                            <td>
                                <a href="{{ route('orders.show', $order->id) }}" style="color: var(--primary); font-weight: 600; text-decoration: none;">
                                    {{ $order->code }}
                                </a>
                            </td>
                            <td>{{ $order->customer->name }}</td>
                            <td>{{ number_format($order->total, 2, ',', ' ') }} DH</td>
                            <td>
                                <span class="badge badge-{{ $order->status }}">{{ $order->status }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--text-secondary); padding: 2rem 0;">
                                Aucune commande saisie pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Assigned Prospects -->
    <div class="glass-card" style="margin: 0;">
        <h3 class="card-title">Fichiers de Prospect Assignés</h3>
        <div style="display: flex; flex-direction: column; gap: 15px;">
            @forelse($myProspectFiles as $file)
                <div style="background: rgba(255,255,255,0.02); padding: 15px; border-radius: var(--border-radius); border: 1px solid var(--border-color);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <span style="font-weight: 600; font-size: 1rem;">{{ $file->name }}</span>
                        <a href="{{ route('prospects.dialer', $file->id) }}" class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-phone"></i> Lancer les Appels
                        </a>
                    </div>
                    <div style="background: rgba(255,255,255,0.05); height: 6px; border-radius: 3px; overflow: hidden; margin-bottom: 8px;">
                        <div style="width: {{ $file->progress }}%; background: var(--primary); height: 100%; border-radius: 3px;"></div>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.75rem; color: var(--text-secondary);">
                        <span>Complété : {{ $file->progress }}%</span>
                        <span>Reçu le : {{ $file->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            @empty
                <div style="text-align: center; color: var(--text-secondary); padding: 2rem 0;">
                    Aucun fichier de prospects ne vous a été assigné aujourd'hui.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
