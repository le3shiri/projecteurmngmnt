@extends('layouts.app')

@section('title', 'Supplier Dashboard')

@section('content')
<div class="header-bar">
    <div>
        <h1 class="page-title">Espace Fournisseur & Préparation</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Suivi de l'état de préparation et d'expédition des commandes</p>
    </div>
    <div>
        <a href="{{ route('supplier.index') }}" class="btn btn-primary">
            <i class="fa-solid fa-list-check"></i> Traiter les Commandes
        </a>
    </div>
</div>

<!-- Metrics Cards -->
<div class="metrics-grid">
    <div class="metric-card warning">
        <span class="metric-label">À Préparer (Nouveaux)</span>
        <span class="metric-value">{{ $pendingPreparation }} Commande(s)</span>
    </div>
    <div class="metric-card info">
        <span class="metric-label">En cours de préparation</span>
        <span class="metric-value">{{ $preparingCount }} Commande(s)</span>
    </div>
    <div class="metric-card success">
        <span class="metric-label">Expédié (Ce mois)</span>
        <span class="metric-value">{{ $shippedCount }} Commande(s)</span>
    </div>
</div>

<div class="glass-card">
    <h3 class="card-title">Flux de préparation logistique</h3>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Code Commande</th>
                    <th>Client</th>
                    <th>Date Commande</th>
                    <th>Étape logistique</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentSupplierOrders as $order)
                    <tr>
                        <td style="font-weight: 600;">{{ $order->code }}</td>
                        <td>{{ $order->customer->name }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @php
                                $status = $order->supplierOrder->status ?? 'pending';
                            @endphp
                            <span class="badge badge-{{ $status === 'pending' ? 'pending' : ($status === 'preparing' ? 'info' : 'success') }}">
                                {{ $status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-secondary btn-sm">
                                <i class="fa-solid fa-eye"></i> Ouvrir les détails
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--text-secondary); padding: 2rem 0;">
                            Aucune commande à traiter pour le moment.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
