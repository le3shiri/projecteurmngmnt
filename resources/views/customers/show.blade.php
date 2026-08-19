@extends('layouts.app')

@section('title', 'Fiche Client')

@section('content')
<div class="header-bar">
    <div>
        <h1 class="page-title">Profil Client : {{ $customer->name }}</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Aperçu complet du dossier client et de son historique d'achats</p>
    </div>
    <div style="display: flex; gap: 10px; align-items: center;">
        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary">
            <i class="fa-solid fa-pen"></i> Modifier Profil
        </a>
        @if(auth()->user()->isAdmin())
            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce client ? Cette action est irréversible.');" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fa-solid fa-trash"></i> Supprimer le Client
                </button>
            </form>
        @endif
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">
            Retour
        </a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem;">
    <!-- Customer Contact Card -->
    <div class="glass-card" style="margin: 0; align-self: start;">
        <h3 class="card-title">Coordonnées</h3>
        <div style="display: flex; flex-direction: column; gap: 15px;">
            <div>
                <span style="font-size: 0.8rem; color: var(--text-secondary); display: block;">Nom complet</span>
                <span style="font-weight: 600; font-size: 1.1rem;">{{ $customer->name }}</span>
            </div>
            <div>
                <span style="font-size: 0.8rem; color: var(--text-secondary); display: block;">Téléphone</span>
                <span style="font-weight: 600; font-size: 1rem;"><a href="tel:{{ $customer->phone }}" style="color: var(--primary); text-decoration: none;">{{ $customer->phone ?? 'Non spécifié' }}</a></span>
            </div>
            <div>
                <span style="font-size: 0.8rem; color: var(--text-secondary); display: block;">Email</span>
                <span>{{ $customer->email ?? 'Non spécifié' }}</span>
            </div>
            <div>
                <span style="font-size: 0.8rem; color: var(--text-secondary); display: block;">Entreprise</span>
                <span>{{ $customer->company ?? '-' }}</span>
            </div>
            <div>
                <span style="font-size: 0.8rem; color: var(--text-secondary); display: block;">Adresse de livraison</span>
                <span style="font-size: 0.9rem;">{!! nl2br(e($customer->address)) ?? '-' !!}</span>
            </div>
            @if($customer->notes)
                <div style="border-top: 1px solid var(--border-color); padding-top: 10px; margin-top: 10px;">
                    <span style="font-size: 0.8rem; color: var(--text-secondary); display: block;">Notes / Observations</span>
                    <p style="font-size: 0.85rem; font-style: italic;">{{ $customer->notes }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Purchase History -->
    <div class="glass-card" style="margin: 0;">
        <h3 class="card-title">Historique des Commandes</h3>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Date</th>
                        <th>Agent</th>
                        <th>Total</th>
                        <th>Solde restant</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customer->orders as $order)
                        <tr>
                            <td>
                                <a href="{{ route('orders.show', $order->id) }}" style="color: var(--primary); font-weight: 600; text-decoration: none;">
                                    {{ $order->code }}
                                </a>
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                            <td>{{ $order->agent->name ?? 'Direct' }}</td>
                            <td>{{ number_format($order->total, 2, ',', ' ') }} DH</td>
                            <td>
                                @if($order->remaining > 0)
                                    <span style="color: var(--warning); font-weight: 600;">{{ number_format($order->remaining, 2, ',', ' ') }} DH</span>
                                @else
                                    <span style="color: var(--success);"><i class="fa-solid fa-circle-check"></i> Réglé</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-{{ $order->status }}">{{ $order->status }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: var(--text-secondary); padding: 3rem 0;">
                                <i class="fa-solid fa-folder-open" style="font-size: 2.5rem; display: block; margin-bottom: 10px; color: var(--text-secondary);"></i>
                                Aucune commande enregistrée pour ce client.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
