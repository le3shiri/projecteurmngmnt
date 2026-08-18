@extends('layouts.app')

@section('title', 'Gestion des Commissions & Rémunérations')

@section('content')
<div class="header-bar" style="flex-wrap: wrap; gap: 15px;">
    <div>
        <h1 class="page-title">Suivi des Commissions & Rémunérations</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Consultez les montants dus à chaque membre de l'équipe et validez les versements</p>
    </div>
    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <!-- Filters Form -->
        <form action="{{ route('commissions.index') }}" method="GET" style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
            <select name="agent_id" class="form-control" style="max-width: 170px; height: 36px; font-size: 0.85rem;">
                <option value="">Tous les collaborateurs</option>
                @foreach($allAgents as $ag)
                    <option value="{{ $ag->id }}" {{ $selectedAgentId == $ag->id ? 'selected' : '' }}>{{ $ag->name }}</option>
                @endforeach
            </select>

            <select name="status" class="form-control" style="max-width: 130px; height: 36px; font-size: 0.85rem;">
                <option value="">Tous statuts</option>
                <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>En attente</option>
                <option value="paid" {{ $status == 'paid' ? 'selected' : '' }}>Payé</option>
            </select>

            <input type="date" name="start_date" class="form-control" value="{{ $startDate ?? '' }}" style="max-width: 140px; height: 36px; font-size: 0.85rem;" title="Date début">
            <input type="date" name="end_date" class="form-control" value="{{ $endDate ?? '' }}" style="max-width: 140px; height: 36px; font-size: 0.85rem;" title="Date fin">

            <button type="submit" class="btn btn-secondary" style="height: 36px; padding: 0 12px; font-size: 0.85rem; border-radius: var(--border-radius);">
                <i class="fa-solid fa-filter"></i> Filtrer
            </button>
            @if($startDate || $endDate || $status || $selectedAgentId)
                <a href="{{ route('commissions.index') }}" class="btn btn-secondary" style="height: 36px; padding: 0 12px; font-size: 0.85rem; display: flex; align-items: center; border-radius: var(--border-radius);">
                    Effacer
                </a>
            @endif
        </form>
    </div>
</div>

<!-- Overall Metrics Summary -->
<div class="metrics-grid" style="margin-bottom: 2rem;">
    <div class="metric-card info">
        <span class="metric-label">Commissions Totales Cumulées</span>
        <span class="metric-value">{{ number_format($overallEarned, 2, ',', ' ') }} DH</span>
    </div>
    <div class="metric-card warning">
        <span class="metric-label">Commissions en Attente de Versement</span>
        <span class="metric-value" style="color: #f59e0b;">{{ number_format($overallPending, 2, ',', ' ') }} DH</span>
    </div>
    <div class="metric-card success">
        <span class="metric-label">Commissions Réglées (Déjà Payées)</span>
        <span class="metric-value" style="color: #10b981;">{{ number_format($overallPaid, 2, ',', ' ') }} DH</span>
    </div>
</div>

<!-- Member Commission Cards Summary -->
<div style="margin-bottom: 2rem;">
    <h3 class="card-title" style="margin-bottom: 1rem;">
        <i class="fa-solid fa-users-gear" style="color: var(--primary); margin-right: 8px;"></i>
        Récapitulatif par Collaborateur
    </h3>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.25rem;">
        @forelse($agentSummaries as $sum)
            <div class="glass-card" style="margin: 0; padding: 1.25rem; position: relative; border-left: 4px solid {{ $sum['total_pending'] > 0 ? '#f59e0b' : '#10b981' }};">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem;">
                    <div>
                        <h4 style="margin: 0; font-size: 1.1rem; color: #fff;">{{ $sum['agent']->name }}</h4>
                        <span style="font-size: 0.8rem; color: var(--text-secondary);">
                            Rôle: <strong style="text-transform: capitalize;">{{ $sum['agent']->role }}</strong>
                            @if($sum['agent']->phone)
                                &bull; {{ $sum['agent']->phone }}
                            @endif
                        </span>
                    </div>
                    <span class="badge {{ $sum['total_pending'] > 0 ? 'badge-warning' : 'badge-confirmed' }}" style="font-size: 0.75rem;">
                        {{ $sum['pending_count'] }} en attente
                    </span>
                </div>

                <div style="background: rgba(0, 0, 0, 0.2); padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1rem;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 6px; font-size: 0.85rem;">
                        <span style="color: var(--text-secondary);">Total Gagné:</span>
                        <strong style="color: #fff;">{{ number_format($sum['total_earned'], 2, ',', ' ') }} DH</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 6px; font-size: 0.85rem;">
                        <span style="color: var(--text-secondary);">Déjà Payé:</span>
                        <strong style="color: #10b981;">{{ number_format($sum['total_paid'], 2, ',', ' ') }} DH</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.9rem; font-weight: 700; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 6px; margin-top: 4px;">
                        <span style="color: #f59e0b;">À Payer (Solde Dû):</span>
                        <span style="color: #f59e0b; font-size: 1.05rem;">{{ number_format($sum['total_pending'], 2, ',', ' ') }} DH</span>
                    </div>
                </div>

                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                    <a href="{{ route('commissions.show', $sum['agent']->id) }}" class="btn btn-secondary btn-sm" style="flex: 1; text-align: center; justify-content: center;">
                        <i class="fa-solid fa-eye"></i> Voir Détails
                    </a>
                    
                    @if($sum['total_pending'] > 0)
                        <form action="{{ route('commissions.pay_all', $sum['agent']->id) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Voulez-vous marquer TOUTES les commissions en attente ({{ number_format($sum['total_pending'], 2, ',', ' ') }} DH) pour {{ $sum['agent']->name }} comme PAYÉES ?')">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm" style="width: 100%; justify-content: center;">
                                <i class="fa-solid fa-hand-holding-dollar"></i> Payer Solde
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="glass-card" style="grid-column: 1 / -1; margin: 0; text-align: center; color: var(--text-secondary); padding: 2rem;">
                Aucun collaborateur trouvé avec des commissions enregistrées.
            </div>
        @endforelse
    </div>
</div>

<!-- Detailed Commissions Table -->
<div class="glass-card" style="margin: 0;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; margin-bottom: 1.5rem;">
        <h3 class="card-title" style="margin: 0;">
            <i class="fa-solid fa-list-check" style="color: var(--primary); margin-right: 8px;"></i>
            Historique Détillé des Commissions Par Commande
        </h3>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Collaborateur</th>
                    <th>Commande</th>
                    <th>Client</th>
                    <th>Montant Commande</th>
                    <th>Commission Due</th>
                    <th>Statut</th>
                    <th>Date Versement</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($commissions as $comm)
                    <tr>
                        <td>{{ $comm->created_at->format('d/m/Y H:i') }}</td>
                        <td style="font-weight: 600;">
                            <a href="{{ route('commissions.show', $comm->agent_id) }}" style="color: #fff; text-decoration: none;">
                                {{ $comm->agent->name ?? 'N/A' }}
                            </a>
                        </td>
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
                        <td style="font-weight: 700; color: #fff; font-size: 0.95rem;">
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
                        <td style="text-align: right;">
                            @if($comm->status === 'pending')
                                <form action="{{ route('commissions.pay', $comm->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm" title="Marquer comme payée et remettre l'argent à l'agent">
                                        <i class="fa-solid fa-check"></i> Payer
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('commissions.unpay', $comm->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Remettre cette commission en statut En attente ?')">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary btn-sm" style="font-size: 0.75rem; padding: 3px 8px;" title="Annuler le statut payé">
                                        <i class="fa-solid fa-rotate-left"></i> Annuler
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align: center; color: var(--text-secondary); padding: 3rem 0;">
                            Aucune commission trouvée pour les critères sélectionnés.
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
