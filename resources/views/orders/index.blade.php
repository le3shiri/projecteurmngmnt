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
    @php
        $perPageOptions = [15, 25, 50, 100, 150, 200];
        if (!in_array((int)$perPage, $perPageOptions)) {
            $perPageOptions[] = (int)$perPage;
            sort($perPageOptions);
        }
    @endphp

    <!-- Filter and Search -->
    <form action="{{ route('orders.index') }}" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center; margin-bottom: 1.5rem;">
        <input type="text" name="search" class="form-control" placeholder="Rechercher par code commande ou client..." value="{{ $search }}" style="max-width: 260px;">
        
        <select name="status" class="form-control" style="max-width: 180px;">
            <option value="">Tous les statuts</option>
            <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>En attente de paiement</option>
            <option value="confirmed" {{ $status == 'confirmed' ? 'selected' : '' }}>Confirmée (Préparation)</option>
            <option value="shipped" {{ $status == 'shipped' ? 'selected' : '' }}>Expédiée</option>
            <option value="delivered" {{ $status == 'delivered' ? 'selected' : '' }}>Livrée & Réglée</option>
            <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>Annulée</option>
        </select>

        @if(!auth()->user()->isAgent() && !empty($agents))
        <select name="agent_id" class="form-control" style="max-width: 190px;">
            <option value="">Tous les commerciaux</option>
            @foreach($agents as $ag)
                <option value="{{ $ag->id }}" {{ (string)$agentId === (string)$ag->id ? 'selected' : '' }}>
                    {{ $ag->name }}
                </option>
            @endforeach
            <option value="none" {{ $agentId === 'none' ? 'selected' : '' }}>Direct (Sans commercial)</option>
        </select>
        @endif

        <input type="date" name="start_date" class="form-control" value="{{ $startDate ?? '' }}" style="max-width: 145px;" title="Date début">
        <input type="date" name="end_date" class="form-control" value="{{ $endDate ?? '' }}" style="max-width: 145px;" title="Date fin">

        <div style="display: flex; align-items: center; gap: 6px;">
            <label for="per_page" style="color: var(--text-secondary); font-size: 0.85rem; white-space: nowrap;">Afficher :</label>
            <select name="per_page" id="per_page" class="form-control" style="width: auto; min-width: 100px;" onchange="this.form.submit()" title="Nombre de commandes par page (jusqu'à 200)">
                @foreach($perPageOptions as $option)
                    <option value="{{ $option }}" {{ (int)$perPage === (int)$option ? 'selected' : '' }}>
                        {{ $option }} / page
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-secondary">
            <i class="fa-solid fa-filter"></i> Filtrer
        </button>

        @if($search || $status || $startDate || $endDate || ($agentId !== null && $agentId !== '') || (int)$perPage !== 15)
            <a href="{{ route('orders.index') }}" class="btn btn-secondary" title="Réinitialiser tous les filtres">Réinitialiser</a>
        @endif
    </form>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem; font-size: 0.85rem; color: var(--text-secondary);">
        <div>
            <i class="fa-solid fa-receipt"></i> Affichage de <strong>{{ $orders->firstItem() ?? 0 }}</strong> à <strong>{{ $orders->lastItem() ?? 0 }}</strong> sur <strong>{{ $orders->total() }}</strong> commandes
        </div>
        <div>
            Page <strong>{{ $orders->currentPage() }}</strong> sur <strong>{{ $orders->lastPage() ?: 1 }}</strong>
        </div>
    </div>

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
                    @php
                        $isPendingVip = ($order->source === 'customer_vip' && $order->status === 'pending');
                    @endphp
                    <tr @if($isPendingVip) style="background: linear-gradient(90deg, rgba(212, 175, 55, 0.18) 0%, rgba(30, 41, 59, 0.85) 100%); border-left: 4px solid var(--primary); box-shadow: inset 0 0 12px rgba(212, 175, 55, 0.1);" @endif>
                        <td style="font-weight: 600;">
                            <a href="{{ route('orders.show', $order->id) }}" style="color: var(--primary); text-decoration: none;">
                                {{ $order->code }}
                            </a>
                            @if($isPendingVip)
                                <span class="badge" style="background: linear-gradient(135deg, #d4af37, #f59e0b); color: #0b1120; font-weight: 800; font-size: 0.7rem; margin-left: 6px; padding: 2px 7px; border-radius: 4px; box-shadow: 0 2px 6px rgba(212, 175, 55, 0.3);">
                                    <i class="fa-solid fa-crown"></i> VIP -{{ (int)$order->discount_rate }}%
                                </span>
                            @endif
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
                            @if($isPendingVip)
                                <span class="badge" style="background: rgba(245, 158, 11, 0.2); color: #f59e0b; border: 1px solid #f59e0b; font-weight: 700;">
                                    <i class="fa-solid fa-clock"></i> À valider (VIP)
                                </span>
                            @else
                                <span class="badge badge-{{ $order->status }}">{{ $order->status }}</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-secondary btn-sm">
                                    <i class="fa-solid fa-eye"></i> Gérer
                                </a>
                                @if(auth()->user()->isAdmin() || auth()->user()->hasPermission('manage_orders'))
                                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-secondary btn-sm" title="Modifier la commande">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                @endif
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

    <div style="margin-top: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
        <div style="font-size: 0.85rem; color: var(--text-secondary);">
            {{ $orders->total() }} commande(s) au total
        </div>
        <div>
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
