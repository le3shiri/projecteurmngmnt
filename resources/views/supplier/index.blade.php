@extends('layouts.app')

@section('title', 'Logistique Fournisseur')

@section('content')
<div class="header-bar">
    <div>
        <h1 class="page-title">Commandes logistiques</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Suivez l'état de préparation et d'expédition des colis. Enregistrez les numéros de suivi.</p>
    </div>
</div>

<div class="glass-card">
    <!-- Filter options & Date Filter -->
    <div style="display: flex; justify-content: space-between; align-items: center; gap: 15px; flex-wrap: wrap; margin-bottom: 1.5rem;">
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('supplier.index') }}" class="btn {{ !$status ? 'btn-primary' : 'btn-secondary' }} btn-sm">Tous</a>
            <a href="{{ route('supplier.index', ['status' => 'pending']) }}" class="btn {{ $status == 'pending' ? 'btn-primary' : 'btn-secondary' }} btn-sm">En attente</a>
            <a href="{{ route('supplier.index', ['status' => 'preparing']) }}" class="btn {{ $status == 'preparing' ? 'btn-primary' : 'btn-secondary' }} btn-sm">Préparation</a>
            <a href="{{ route('supplier.index', ['status' => 'shipped']) }}" class="btn {{ $status == 'shipped' ? 'btn-primary' : 'btn-secondary' }} btn-sm">Expédié</a>
            <a href="{{ route('supplier.index', ['status' => 'completed']) }}" class="btn {{ $status == 'completed' ? 'btn-primary' : 'btn-secondary' }} btn-sm">Livré</a>
        </div>

        <form action="{{ route('supplier.index') }}" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
            @if($status)
                <input type="hidden" name="status" value="{{ $status }}">
            @endif
            <input type="date" name="start_date" class="form-control" value="{{ $startDate ?? '' }}" style="max-width: 150px; height: 32px; padding: 2px 8px; font-size: 0.85rem;" title="Date début">
            <input type="date" name="end_date" class="form-control" value="{{ $endDate ?? '' }}" style="max-width: 150px; height: 32px; padding: 2px 8px; font-size: 0.85rem;" title="Date fin">
            <button type="submit" class="btn btn-secondary btn-sm" style="height: 32px; padding: 0 10px; font-size: 0.85rem;">Filtrer</button>
            @if($startDate || $endDate)
                <a href="{{ route('supplier.index', $status ? ['status' => $status] : []) }}" class="btn btn-secondary btn-sm" style="height: 32px; padding: 0 10px; font-size: 0.85rem; display: flex; align-items: center;">Effacer</a>
            @endif
        </form>
    </div>

    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        @forelse($supplierOrders as $sOrder)
            <div style="border: 1px solid var(--border-color); border-radius: var(--border-radius); background: rgba(0,0,0,0.15); padding: 1.5rem; display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
                
                <!-- Left: Order articles and customer details -->
                <div>
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed var(--border-color); padding-bottom: 10px; margin-bottom: 10px;">
                        <div>
                            <span style="font-weight: 700; color: var(--primary); font-size: 1.1rem;">{{ $sOrder->order->code }}</span>
                            <span style="font-size: 0.8rem; color: var(--text-secondary); margin-left: 10px;">Reçu le : {{ $sOrder->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <span class="badge badge-{{ $sOrder->status }}">
                            {{ $sOrder->status }}
                        </span>
                    </div>

                    <div style="margin-bottom: 15px; font-size: 0.9rem;">
                        <strong>Client :</strong> {{ $sOrder->order->customer->name }}<br>
                        <strong>Téléphone :</strong> {{ $sOrder->order->customer->phone }}<br>
                        <strong>Adresse :</strong> {{ $sOrder->order->customer->address ?? 'Boutique (Retrait sur place)' }}
                    </div>

                    <h4 style="font-size: 0.95rem; color: #fff; margin-bottom: 8px;">Articles à emballer :</h4>
                    <ul style="list-style: inside square; color: var(--text-secondary); font-size: 0.9rem; padding-left: 5px;">
                        @foreach($sOrder->order->items as $item)
                            <li>
                                <strong>[{{ $item->product_code }}]</strong> {{ $item->product_name }} — Qté : <strong style="color: #fff;">{{ $item->quantity }}</strong>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Right: Update Status logs -->
                <div style="border-left: 1px solid var(--border-color); padding-left: 1.5rem;">
                    <h4 style="font-size: 0.95rem; color: #fff; margin-bottom: 10px;">Mise à jour logistique</h4>
                    
                    <form action="{{ route('supplier.status', $sOrder->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label" style="font-size: 0.75rem;">Étape de livraison</label>
                            <select name="status" class="form-control" style="padding: 5px; font-size: 0.85rem;" required>
                                <option value="pending" {{ $sOrder->status == 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="preparing" {{ $sOrder->status == 'preparing' ? 'selected' : '' }}>En cours de préparation</option>
                                <option value="shipped" {{ $sOrder->status == 'shipped' ? 'selected' : '' }}>Expédié</option>
                                <option value="completed" {{ $sOrder->status == 'completed' ? 'selected' : '' }}>Livré & Terminé</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label" style="font-size: 0.75rem;">N° de suivi / Transporteur / Notes</label>
                            <input type="text" name="notes" class="form-control" style="padding: 5px; font-size: 0.85rem;" placeholder="Ex: AMANA EE9999999MA" value="{{ $sOrder->notes }}">
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm" style="width: 100%;">
                            Enregistrer <i class="fa-solid fa-floppy-disk"></i>
                        </button>
                    </form>
                </div>

            </div>
        @empty
            <div style="text-align: center; color: var(--text-secondary); padding: 3rem 0;">
                Aucune commande logistique trouvée avec ce filtre.
            </div>
        @endforelse
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $supplierOrders->links() }}
    </div>
</div>
@endsection
