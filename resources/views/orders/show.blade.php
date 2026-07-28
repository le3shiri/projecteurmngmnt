@extends('layouts.app')

@section('title', 'Détails Commande ' . $order->code)

@section('content')
<div class="header-bar">
    <div>
        <h1 class="page-title">Commande {{ $order->code }}</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Créée le {{ $order->created_at->format('d/m/Y à H:i') }} par {{ $order->agent->name ?? 'Direct' }}</p>
    </div>
    <div style="display: flex; gap: 10px;">
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Liste des Ventes
        </a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem;">
    
    <!-- Left Column: Details & Documents -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        
        <!-- Info Card -->
        <div class="glass-card" style="margin: 0;">
            <h3 class="card-title">Informations de Suivi</h3>
            
            <div style="display: flex; flex-direction: column; gap: 15px; margin-bottom: 1.5rem;">
                <div>
                    <span style="font-size: 0.8rem; color: var(--text-secondary); display: block;">Statut de Commande</span>
                    <span class="badge badge-{{ $order->status }}" style="font-size: 0.9rem; margin-top: 5px;">{{ $order->status }}</span>
                </div>
                
                @if(auth()->user()->hasPermission('update_order_status'))
                <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" style="border-top: 1px solid var(--border-color); padding-top: 10px; margin-top: 5px;">
                    @csrf
                    <label class="form-label" for="status" style="font-size: 0.75rem;">Mettre à jour le statut</label>
                    <div style="display: flex; gap: 8px;">
                        <select name="status" id="status" class="form-control" style="padding: 5px; font-size: 0.85rem;">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>En attente</option>
                            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmée</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Expédiée</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Livrée</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm">Mettre à jour</button>
                    </div>
                </form>
                @endif
                
                <div>
                    <span style="font-size: 0.8rem; color: var(--text-secondary); display: block;">Client</span>
                    <span style="font-weight: 600;"><a href="{{ route('customers.show', $order->customer_id) }}" style="color: var(--primary); text-decoration: none;">{{ $order->customer->name }}</a></span>
                    <span style="font-size: 0.85rem; display: block; color: var(--text-secondary); margin-top: 3px;">
                        <i class="fa-solid fa-phone"></i> {{ $order->customer->phone ?? 'Aucun téléphone' }}
                    </span>
                </div>

                @if($order->delivery_date)
                <div>
                    <span style="font-size: 0.8rem; color: var(--text-secondary); display: block;">Livraison Prévue</span>
                    <span style="font-weight: 600;"><i class="fa-solid fa-calendar-days"></i> {{ $order->delivery_date->format('d/m/Y') }}</span>
                </div>
                @endif

                @if($order->notes)
                <div>
                    <span style="font-size: 0.8rem; color: var(--text-secondary); display: block;">Observations / Notes</span>
                    <p style="font-size: 0.85rem; font-style: italic; background: rgba(0,0,0,0.15); padding: 8px; border-radius: 6px; margin-top: 4px;">{{ $order->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Logo Attached Preview -->
        <div class="glass-card" style="margin: 0;">
            <h3 class="card-title">Logo personnalisé</h3>
            @if($order->logo_path)
                <div style="background: #000; border-radius: 8px; overflow: hidden; border: 1px solid var(--border-color); text-align: center; padding: 1.5rem 1rem;">
                    <img src="{{ asset('storage/' . $order->logo_path) }}" alt="Logo Commande" style="max-width: 100%; max-height: 200px; object-fit: contain;">
                </div>
                <div style="margin-top: 10px; text-align: center;">
                    <a href="{{ asset('storage/' . $order->logo_path) }}" target="_blank" class="btn btn-secondary btn-sm" style="width: 100%;">
                        <i class="fa-solid fa-expand"></i> Agrandir le logo
                    </a>
                </div>
            @else
                <div style="text-align: center; color: var(--text-secondary); padding: 2rem 0; border: 2px dashed var(--border-color); border-radius: 8px;">
                    <i class="fa-solid fa-circle-xmark" style="font-size: 1.5rem; margin-bottom: 8px;"></i>
                    Aucun logo joint à cette commande
                </div>
            @endif
        </div>

        <!-- Documents Generation List -->
        <div class="glass-card" style="margin: 0;">
            <h3 class="card-title">Édition des documents</h3>
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <a href="{{ route('orders.pdf', [$order->id, 'devis']) }}" class="btn btn-secondary" style="justify-content: flex-start;">
                    <i class="fa-solid fa-file-invoice" style="color: var(--info);"></i> Générer le Devis (Proforma)
                </a>
                <a href="{{ route('orders.pdf', [$order->id, 'facture']) }}" class="btn btn-secondary" style="justify-content: flex-start;">
                    <i class="fa-solid fa-file-invoice-dollar" style="color: var(--success);"></i> Générer la Facture
                </a>
                <a href="{{ route('orders.pdf', [$order->id, 'recu']) }}" class="btn btn-secondary" style="justify-content: flex-start;">
                    <i class="fa-solid fa-ticket" style="color: var(--primary);"></i> Générer le Reçu de paiement
                </a>
                <a href="{{ route('orders.pdf', [$order->id, 'bon_commande']) }}" class="btn btn-secondary" style="justify-content: flex-start;">
                    <i class="fa-solid fa-dolly" style="color: var(--warning);"></i> Générer le Bon de Commande
                </a>
            </div>
        </div>

    </div>

    <!-- Right Column: Cart items & Payment timeline -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        
        <!-- Cart Items -->
        <div class="glass-card" style="margin: 0;">
            <h3 class="card-title">Détails des articles commandés</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Description</th>
                            <th style="text-align: center;">Quantité</th>
                            <th>Prix Unitaire</th>
                            <th style="text-align: right;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td style="font-weight: 600; color: var(--primary);">{{ $item->product_code }}</td>
                                <td>{{ $item->product_name }}</td>
                                <td style="text-align: center;">{{ $item->quantity }}</td>
                                <td>{{ number_format($item->unit_price, 2, ',', ' ') }} DH</td>
                                <td style="text-align: right; font-weight: 600;">{{ number_format($item->total, 2, ',', ' ') }} DH</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Total summary right block -->
            <div style="display: flex; flex-direction: column; align-items: flex-end; margin-top: 1.5rem; border-top: 1px solid var(--border-color); padding-top: 1rem; gap: 8px;">
                <div style="font-size: 0.95rem; color: var(--text-secondary);">Total des articles : <span style="color: var(--text-primary); font-weight: 600;">{{ number_format($order->total, 2, ',', ' ') }} DH</span></div>
                <div style="font-size: 0.95rem; color: var(--text-secondary);">Acompte Espèces : <span style="color: var(--text-primary); font-weight: 600;">{{ number_format($order->advance_cash, 2, ',', ' ') }} DH</span></div>
                <div style="font-size: 0.95rem; color: var(--text-secondary);">Acompte Virement : <span style="color: var(--text-primary); font-weight: 600;">{{ number_format($order->advance_transfer, 2, ',', ' ') }} DH</span></div>
                <div style="font-size: 1.3rem; color: var(--primary); font-weight: 800; border-top: 1px dashed var(--border-color); padding-top: 8px;">Solde Restant : {{ number_format($order->remaining, 2, ',', ' ') }} DH</div>
            </div>
        </div>

        <!-- Payments logs and add a payment trigger -->
        <div class="glass-card" style="margin: 0;">
            <h3 class="card-title">Enregistrement des règlements complémentaires</h3>

            @if($order->remaining > 0)
                <form action="{{ route('orders.addPayment', $order->id) }}" method="POST" style="margin-bottom: 2rem; border-bottom: 1px solid var(--border-color); padding-bottom: 1.5rem;">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="amount">Montant (DH)</label>
                            <input type="number" step="0.01" name="amount" id="amount" class="form-control" value="{{ $order->remaining }}" max="{{ $order->remaining }}" min="0.01" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="type">Mode de paiement</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="cash">Espèces</option>
                                <option value="transfer">Virement Bancaire</option>
                                <option value="cheque">Chèque</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label" for="reference">Référence / N° de pièce (Optionnel)</label>
                            <input type="text" name="reference" id="reference" class="form-control" placeholder="N° de virement ou de chèque">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success" style="width: 100%;">
                        Enregistrer le paiement <i class="fa-solid fa-cash-register"></i>
                    </button>
                </form>
            @else
                <div class="alert alert-success" style="margin-bottom: 2rem;">
                    <i class="fa-solid fa-circle-check"></i> Cette commande est entièrement réglée. Solde restant : 0,00 DH.
                </div>
            @endif

            <h4 style="font-size: 1rem; color: var(--text-primary); margin-bottom: 10px;">Journal des règlements</h4>
            <div class="table-responsive">
                <table class="table" style="font-size: 0.85rem;">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Mode</th>
                            <th>Référence</th>
                            <th style="text-align: right;">Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Initial advance logs -->
                        @if($order->advance_cash > 0)
                            <tr>
                                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                <td><span class="badge badge-confirmed">Espèces</span></td>
                                <td>Acompte initial</td>
                                <td style="text-align: right; font-weight: 600;">{{ number_format($order->advance_cash, 2, ',', ' ') }} DH</td>
                            </tr>
                        @endif
                        @if($order->advance_transfer > 0)
                            <tr>
                                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                <td><span class="badge badge-shipped">Virement</span></td>
                                <td>Acompte initial</td>
                                <td style="text-align: right; font-weight: 600;">{{ number_format($order->advance_transfer, 2, ',', ' ') }} DH</td>
                            </tr>
                        @endif
                        
                        <!-- Subsequent payments list -->
                        @foreach($order->payments as $payment)
                            <tr>
                                <td>{{ $payment->payment_date->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge badge-{{ $payment->type == 'cash' ? 'confirmed' : ($payment->type == 'transfer' ? 'shipped' : 'pending') }}">
                                        {{ $payment->type }}
                                    </span>
                                </td>
                                <td>{{ $payment->reference ?? '-' }}</td>
                                <td style="text-align: right; font-weight: 600;">{{ number_format($payment->amount, 2, ',', ' ') }} DH</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
@endsection
