@extends('layouts.app')

@section('title', 'Mes Commissions & Rémunérations')

@section('content')
<div class="header-bar">
    <div>
        <h1 class="page-title">Mes Commissions & Gains</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Suivez le détail de vos gains générés sur vos ventes et l'état des versements</p>
    </div>
</div>

<!-- Personal Stats -->
<div class="metrics-grid" style="margin-bottom: 2rem;">
    <div class="metric-card info">
        <span class="metric-label">Total Gains Cumulés</span>
        <span class="metric-value">{{ number_format($myEarned, 2, ',', ' ') }} DH</span>
    </div>
    <div class="metric-card warning" style="border-left-color: #f59e0b;">
        <span class="metric-label">Commissions en Attente de Versement</span>
        <span class="metric-value" style="color: #f59e0b;">{{ number_format($myPending, 2, ',', ' ') }} DH</span>
    </div>
    <div class="metric-card success" style="border-left-color: #10b981;">
        <span class="metric-label">Commissions Reçues (Déjà Payées)</span>
        <span class="metric-value" style="color: #10b981;">{{ number_format($myPaid, 2, ',', ' ') }} DH</span>
    </div>
</div>

<div class="glass-card" style="margin: 0;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; margin-bottom: 1.5rem;">
        <h3 class="card-title" style="margin: 0;">Historique de mes Commissions</h3>

        <form action="{{ route('commissions.index') }}" method="GET" style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
            <select name="status" class="form-control" style="max-width: 140px; height: 34px; font-size: 0.85rem;">
                <option value="">Tous les statuts</option>
                <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>En attente</option>
                <option value="paid" {{ $status == 'paid' ? 'selected' : '' }}>Payé</option>
            </select>
            <input type="date" name="start_date" class="form-control" value="{{ $startDate ?? '' }}" style="max-width: 140px; height: 34px; font-size: 0.85rem;" title="Date début">
            <input type="date" name="end_date" class="form-control" value="{{ $endDate ?? '' }}" style="max-width: 140px; height: 34px; font-size: 0.85rem;" title="Date fin">
            <button type="submit" class="btn btn-secondary btn-sm" style="height: 34px; padding: 0 10px;">Filtrer</button>
            @if($startDate || $endDate || $status)
                <a href="{{ route('commissions.index') }}" class="btn btn-secondary btn-sm" style="height: 34px; padding: 0 10px; display: flex; align-items: center;">Effacer</a>
            @endif
        </form>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Date Vente</th>
                    <th>Code Commande</th>
                    <th>Client</th>
                    <th>Montant Vente</th>
                    <th>Detail Produits</th>
                    <th>Gain Commission</th>
                    <th>Statut Versement</th>
                    <th>Date Versement</th>
                </tr>
            </thead>
            <tbody>
                @forelse($commissions as $comm)
                    <tr>
                        <td>{{ $comm->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($comm->order)
                                <a href="{{ route('orders.show', $comm->order->id) }}" style="color: var(--primary); font-weight: 600; text-decoration: none;">
                                    {{ $comm->order->code }}
                                </a>
                            @else
                                <span style="color: var(--text-secondary);">Commande supprimée</span>
                            @endif
                        </td>
                        <td>{{ $comm->order->customer->name ?? '-' }}</td>
                        <td>{{ $comm->order ? number_format($comm->order->total, 2, ',', ' ') . ' DH' : '-' }}</td>
                        <td>
                            @if($comm->order && $comm->order->items->count() > 0)
                                <ul style="margin: 0; padding-left: 15px; font-size: 0.82rem; color: var(--text-secondary);">
                                    @foreach($comm->order->items as $item)
                                        <li>{{ $item->quantity }}x {{ $item->product_name }} ({{ number_format($item->commission_agent, 2, ',', ' ') }} DH/un)</li>
                                    @endforeach
                                </ul>
                            @else
                                <span style="color: var(--text-secondary); font-size: 0.85rem;">-</span>
                            @endif
                        </td>
                        <td style="font-weight: 700; color: #fff; font-size: 1rem;">
                            {{ number_format($comm->amount, 2, ',', ' ') }} DH
                        </td>
                        <td>
                            @if($comm->status === 'paid')
                                <span class="badge badge-confirmed" style="background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3);">
                                    <i class="fa-solid fa-circle-check"></i> Payée
                                </span>
                            @else
                                <span class="badge badge-warning" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.3);">
                                    <i class="fa-solid fa-clock"></i> En attente de paiement par l'admin
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($comm->paid_at)
                                <span style="font-size: 0.85rem; color: var(--text-secondary);">
                                    {{ $comm->paid_at->format('d/m/Y') }}
                                </span>
                            @else
                                <span style="color: var(--text-secondary); font-size: 0.85rem;">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: var(--text-secondary); padding: 3rem 0;">
                            Aucune commission enregistrée pour le moment.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $commissions->links() }}
    </div>
</div>
@endsection
