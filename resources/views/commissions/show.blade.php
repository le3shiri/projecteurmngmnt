@extends('layouts.app')

@section('title', 'Détails Commissions - ' . $user->name)

@section('content')
<div class="header-bar">
    <div>
        <h1 class="page-title">Fiche de Rémunération : {{ $user->name }}</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">
            Rôle: <strong style="color: #fff; text-transform: capitalize;">{{ $user->role }}</strong>
            @if($user->phone) &bull; Téléphone: {{ $user->phone }} @endif
            @if($user->email) &bull; Email: {{ $user->email }} @endif
        </p>
    </div>
    <div style="display: flex; gap: 10px;">
        <a href="{{ route('commissions.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Retour au tableau des commissions
        </a>
    </div>
</div>

<!-- Member Stats Cards -->
<div class="metrics-grid" style="margin-bottom: 2rem;">
    <div class="metric-card info">
        <span class="metric-label">Total Commissions Cumulées</span>
        <span class="metric-value">{{ number_format($totalEarned, 2, ',', ' ') }} DH</span>
    </div>
    <div class="metric-card warning" style="border-left-color: #f59e0b;">
        <span class="metric-label">Solde Restant à Payer à l'Agent</span>
        <span class="metric-value" style="color: #f59e0b;">{{ number_format($totalPending, 2, ',', ' ') }} DH</span>
    </div>
    <div class="metric-card success" style="border-left-color: #10b981;">
        <span class="metric-label">Total Déjà Réglé (Payé)</span>
        <span class="metric-value" style="color: #10b981;">{{ number_format($totalPaid, 2, ',', ' ') }} DH</span>
    </div>
</div>

<!-- Pay All Pending Button Card if balance > 0 -->
@if($totalPending > 0 && (auth()->user()->isAdmin() || auth()->user()->hasPermission('manage_users')))
<div class="glass-card" style="margin-bottom: 2rem; background: rgba(245, 158, 11, 0.05); border: 1px solid rgba(245, 158, 11, 0.2); padding: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
    <div>
        <h4 style="margin: 0 0 5px 0; color: #f59e0b; font-size: 1.1rem;">Règlement des commissions en attente</h4>
        <p style="margin: 0; color: var(--text-secondary); font-size: 0.9rem;">
            Le solde cumulé des commissions en attente pour <strong>{{ $user->name }}</strong> s'élève à <strong>{{ number_format($totalPending, 2, ',', ' ') }} DH</strong>.
        </p>
    </div>

    <form action="{{ route('commissions.pay_all', $user->id) }}" method="POST" onsubmit="return confirm('Confirmez-vous le paiement intégral des commissions en attente ({{ number_format($totalPending, 2, ',', ' ') }} DH) à {{ $user->name }} ?')">
        @csrf
        <button type="submit" class="btn btn-success" style="font-size: 1rem; padding: 0.75rem 1.5rem;">
            <i class="fa-solid fa-hand-holding-dollar"></i> Verser tout le solde ({{ number_format($totalPending, 2, ',', ' ') }} DH)
        </button>
    </form>
</div>
@endif

<!-- Detailed Orders & Commissions Table -->
<div class="glass-card" style="margin: 0;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; margin-bottom: 1.5rem;">
        <h3 class="card-title" style="margin: 0;">Détails des Ventes & Commissions de {{ $user->name }}</h3>

        <form action="{{ route('commissions.show', $user->id) }}" method="GET" style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
            <select name="status" class="form-control" style="max-width: 140px; height: 34px; font-size: 0.85rem;">
                <option value="">Tous les statuts</option>
                <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>En attente</option>
                <option value="paid" {{ $status == 'paid' ? 'selected' : '' }}>Payé</option>
            </select>
            <input type="date" name="start_date" class="form-control" value="{{ $startDate ?? '' }}" style="max-width: 140px; height: 34px; font-size: 0.85rem;" title="Date début">
            <input type="date" name="end_date" class="form-control" value="{{ $endDate ?? '' }}" style="max-width: 140px; height: 34px; font-size: 0.85rem;" title="Date fin">
            <button type="submit" class="btn btn-secondary btn-sm" style="height: 34px; padding: 0 10px;">Filtrer</button>
            @if($startDate || $endDate || $status)
                <a href="{{ route('commissions.show', $user->id) }}" class="btn btn-secondary btn-sm" style="height: 34px; padding: 0 10px; display: flex; align-items: center;">Effacer</a>
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
                    <th>Articles & Commission / un.</th>
                    <th>Montant Commission</th>
                    <th>Statut</th>
                    <th>Date Versement</th>
                    @if(auth()->user()->isAdmin() || auth()->user()->hasPermission('manage_users'))
                        <th style="text-align: right;">Action</th>
                    @endif
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
                                    <i class="fa-solid fa-clock"></i> En attente
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
                        @if(auth()->user()->isAdmin() || auth()->user()->hasPermission('manage_users'))
                            <td style="text-align: right;">
                                @if($comm->status === 'pending')
                                    <form action="{{ route('commissions.pay', $comm->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fa-solid fa-check"></i> Payer
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('commissions.unpay', $comm->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Remettre en attente ?')">
                                        @csrf
                                        <button type="submit" class="btn btn-secondary btn-sm" style="font-size: 0.75rem;">
                                            <i class="fa-solid fa-rotate-left"></i> Annuler
                                        </button>
                                    </form>
                                @endif
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align: center; color: var(--text-secondary); padding: 3rem 0;">
                            Aucune commission enregistrée pour cet agent.
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
