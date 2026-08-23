@extends('layouts.app')

@section('title', 'Gestion des Commandes')

@section('content')
<div class="header-bar">
    <div>
        <h1 class="page-title">Suivi des Ventes & Facturation</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Suivez les statuts de livraison, les acomptes encaissés et éditez les reçus/devis</p>
    </div>
    @if(auth()->user()->hasPermission('manage_orders'))
    <div>
        <a href="{{ route('orders.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Nouvelle Vente
        </a>
    </div>
    @endif
</div>

<div class="glass-card">
    <!-- Filter and Search -->
    <form action="{{ route('orders.index') }}" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 1.5rem;">
        <input type="text" name="search" class="form-control" placeholder="Rechercher par code commande ou client..." value="{{ $search }}" style="max-width: 280px;">
        
        <select name="status" class="form-control" style="max-width: 200px;">
            <option value="">Tous les statuts</option>
            <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>En attente de paiement</option>
            <option value="confirmed" {{ $status == 'confirmed' ? 'selected' : '' }}>Confirmée (Préparation)</option>
            <option value="shipped" {{ $status == 'shipped' ? 'selected' : '' }}>Expédiée</option>
            <option value="delivered" {{ $status == 'delivered' ? 'selected' : '' }}>Livrée & Réglée</option>
            <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>Annulée</option>
        </select>

        <input type="date" name="start_date" class="form-control" value="{{ $startDate ?? '' }}" style="max-width: 160px;" title="Date début">
        <input type="date" name="end_date" class="form-control" value="{{ $endDate ?? '' }}" style="max-width: 160px;" title="Date fin">

        <button type="submit" class="btn btn-secondary">
            Filtrer
        </button>

        @if($search || $status || $startDate || $endDate)
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Réinitialiser</a>
        @endif
    </form>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Date</th>
                    <th>Client</th>
                    @if(auth()->user()->isAdmin())
                        <th>Commercial</th>
                    @endif
                    <th>Total HT</th>
                    <th>Avances reçues</th>
                    <th>Solde Restant</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td style="font-weight: 600;">
                            <a href="{{ route('orders.show', $order->id) }}" style="color: var(--primary); text-decoration: none;">
                                {{ $order->code }}
                            </a>
                        </td>
                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('customers.show', $order->customer_id) }}" style="color: inherit; text-decoration: none; font-weight: 500;">
                                {{ $order->customer->name }}
                            </a>
                        </td>
                        @if(auth()->user()->isAdmin())
                            <td>{{ $order->agent->name ?? 'Direct' }}</td>
                        @endif
                        <td style="font-weight: 600;">{{ number_format($order->total, 2, ',', ' ') }} DH</td>
                        <td>
                            @php
                                $advances = $order->advance_cash + $order->advance_transfer;
                                $computedRemaining = max(0, (float)$order->total - (float)$advances);
                            @endphp
                            {{ number_format($advances, 2, ',', ' ') }} DH
                        </td>
                        <td>
                            @if($computedRemaining > 0)
                                <span style="color: var(--warning); font-weight: 600;">{{ number_format($computedRemaining, 2, ',', ' ') }} DH</span>
                            @else
                                <span style="color: var(--success); font-weight: 600;"><i class="fa-solid fa-circle-check"></i> Payé</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{ $order->status }}">{{ $order->status }}</span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-secondary btn-sm">
                                    <i class="fa-solid fa-eye"></i> Gérer
                                </a>
                                @if(auth()->user()->isAdmin())
                                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ? Cette action est irréversible.');" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Supprimer la commande">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align: center; color: var(--text-secondary); padding: 3rem 0;">
                            <i class="fa-solid fa-receipt" style="font-size: 3rem; color: var(--text-secondary); margin-bottom: 1rem; display: block;"></i>
                            Aucune commande enregistrée.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $orders->links() }}
    </div>
</div>
@endsection
