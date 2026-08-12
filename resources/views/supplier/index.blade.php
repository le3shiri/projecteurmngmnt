@extends('layouts.app')

@section('title', 'Logistique & Préparation Fournisseur')

@section('content')
<style>
    .supplier-card {
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        background: rgba(15, 23, 42, 0.5);
        padding: 1.5rem;
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
        transition: var(--transition);
    }
    .supplier-card:hover {
        border-color: rgba(212, 175, 55, 0.3);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }
    @media (max-width: 992px) {
        .supplier-card {
            grid-template-columns: 1fr;
        }
    }
    .status-badge-pending {
        background: rgba(234, 179, 8, 0.15);
        color: #facc15;
        border: 1px solid rgba(234, 179, 8, 0.3);
    }
    .status-badge-preparing {
        background: rgba(59, 130, 246, 0.15);
        color: #60a5fa;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }
    .status-badge-shipped {
        background: rgba(168, 85, 247, 0.15);
        color: #c084fc;
        border: 1px solid rgba(168, 85, 247, 0.3);
    }
    .status-badge-completed {
        background: rgba(34, 197, 94, 0.15);
        color: #4ade80;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }
</style>

<div class="header-bar">
    <div>
        <h1 class="page-title"><i class="fa-solid fa-truck-ramp-box" style="color: var(--primary);"></i> File d'Attente Fournisseur (Préparation)</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Toutes les commandes confirmées apparaissent ici en temps réel pour préparation et expédition.</p>
    </div>
</div>

<div class="glass-card">
    <!-- Filter options & Date Filter -->
    <div style="display: flex; justify-content: space-between; align-items: center; gap: 15px; flex-wrap: wrap; margin-bottom: 1.5rem;">
        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
            <a href="{{ route('supplier.index') }}" class="btn {{ !$status ? 'btn-primary' : 'btn-secondary' }} btn-sm">
                Tous <span style="opacity: 0.8; margin-left: 4px;">({{ $counts['all'] ?? 0 }})</span>
            </a>
            <a href="{{ route('supplier.index', ['status' => 'pending']) }}" class="btn {{ $status == 'pending' ? 'btn-primary' : 'btn-secondary' }} btn-sm">
                <i class="fa-solid fa-clock"></i> En attente <span style="opacity: 0.8; margin-left: 4px;">({{ $counts['pending'] ?? 0 }})</span>
            </a>
            <a href="{{ route('supplier.index', ['status' => 'preparing']) }}" class="btn {{ $status == 'preparing' ? 'btn-primary' : 'btn-secondary' }} btn-sm">
                <i class="fa-solid fa-box-open"></i> En préparation <span style="opacity: 0.8; margin-left: 4px;">({{ $counts['preparing'] ?? 0 }})</span>
            </a>
            <a href="{{ route('supplier.index', ['status' => 'shipped']) }}" class="btn {{ $status == 'shipped' ? 'btn-primary' : 'btn-secondary' }} btn-sm">
                <i class="fa-solid fa-truck-fast"></i> Expédié <span style="opacity: 0.8; margin-left: 4px;">({{ $counts['shipped'] ?? 0 }})</span>
            </a>
            <a href="{{ route('supplier.index', ['status' => 'completed']) }}" class="btn {{ $status == 'completed' ? 'btn-primary' : 'btn-secondary' }} btn-sm">
                <i class="fa-solid fa-circle-check"></i> Livré <span style="opacity: 0.8; margin-left: 4px;">({{ $counts['completed'] ?? 0 }})</span>
            </a>
        </div>

        <form action="{{ route('supplier.index') }}" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
            @if($status)
                <input type="hidden" name="status" value="{{ $status }}">
            @endif
            <input type="date" name="start_date" class="form-control" value="{{ $startDate ?? '' }}" style="max-width: 150px; height: 34px; padding: 2px 8px; font-size: 0.85rem;" title="Date début">
            <input type="date" name="end_date" class="form-control" value="{{ $endDate ?? '' }}" style="max-width: 150px; height: 34px; padding: 2px 8px; font-size: 0.85rem;" title="Date fin">
            <button type="submit" class="btn btn-secondary btn-sm" style="height: 34px; padding: 0 12px; font-size: 0.85rem;">Filtrer</button>
            @if($startDate || $endDate)
                <a href="{{ route('supplier.index', $status ? ['status' => $status] : []) }}" class="btn btn-secondary btn-sm" style="height: 34px; padding: 0 10px; font-size: 0.85rem; display: flex; align-items: center;">Effacer</a>
            @endif
        </form>
    </div>

    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        @forelse($supplierOrders as $sOrder)
            @php
                $order = $sOrder->order;
            @endphp
            <div class="supplier-card">
                
                <!-- Left: Order articles and customer details -->
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed var(--border-color); padding-bottom: 10px; margin-bottom: 12px; flex-wrap: wrap; gap: 10px;">
                        <div>
                            <span style="font-weight: 700; color: var(--primary); font-size: 1.15rem; font-family: monospace;">{{ $order->code }}</span>
                            <span style="font-size: 0.8rem; color: var(--text-secondary); margin-left: 10px;">
                                <i class="fa-solid fa-calendar-day"></i> Reçu : {{ $sOrder->created_at ? $sOrder->created_at->format('d/m/Y H:i') : $order->created_at->format('d/m/Y H:i') }}
                            </span>
                        </div>
                        <span class="badge status-badge-{{ $sOrder->status }}" style="padding: 5px 12px; border-radius: 20px; font-weight: 600; text-transform: uppercase; font-size: 0.78rem;">
                            @if($sOrder->status === 'pending')
                                En attente
                            @elseif($sOrder->status === 'preparing')
                                En cours de préparation
                            @elseif($sOrder->status === 'shipped')
                                Expédié
                            @else
                                Livré & Terminé
                            @endif
                        </span>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 15px; background: rgba(255,255,255,0.02); padding: 12px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.05);">
                        <div style="font-size: 0.9rem;">
                            <div style="color: var(--text-secondary); font-size: 0.75rem; text-transform: uppercase; font-weight: 600; margin-bottom: 4px;">Informations Client</div>
                            <strong style="color: #fff;">{{ $order->customer->name }}</strong><br>
                            <span style="color: var(--primary);"><i class="fa-solid fa-phone"></i> {{ $order->customer->phone ?? 'Sans téléphone' }}</span><br>
                            <span style="color: var(--text-secondary); font-size: 0.85rem;"><i class="fa-solid fa-location-dot"></i> {{ $order->customer->address ?? 'Retrait en boutique' }}</span>
                        </div>

                        <div style="font-size: 0.9rem;">
                            <div style="color: var(--text-secondary); font-size: 0.75rem; text-transform: uppercase; font-weight: 600; margin-bottom: 4px;">Date de Livraison Prévue</div>
                            @if($order->delivery_date)
                                <div style="color: var(--warning); font-weight: 700;">
                                    <i class="fa-solid fa-truck-ramp-box"></i> {{ \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y') }}
                                </div>
                            @else
                                <span style="color: var(--text-secondary);">Non spécifiée</span>
                            @endif
                            @if($order->agent)
                                <div style="margin-top: 6px; font-size: 0.8rem; color: var(--text-secondary);">
                                    Agent : <strong style="color: #fff;">{{ $order->agent->name }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>

                    <h4 style="font-size: 0.95rem; color: #fff; margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-boxes-packing" style="color: var(--primary);"></i> Articles à préparer / emballer :
                    </h4>
                    <div style="background: rgba(0,0,0,0.2); border-radius: 8px; padding: 10px 14px; border: 1px solid var(--border-color);">
                        <ul style="list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 8px;">
                            @foreach($order->items as $item)
                                <li style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.04); padding-bottom: 6px;">
                                    <div>
                                        <code style="background: rgba(212,175,55,0.15); color: var(--primary); padding: 2px 6px; border-radius: 4px; font-size: 0.8rem;">{{ $item->product_code }}</code>
                                        <span style="font-weight: 600; color: #fff; margin-left: 6px;">{{ $item->product_name }}</span>
                                    </div>
                                    <div style="background: rgba(255,255,255,0.1); padding: 2px 10px; border-radius: 12px; font-weight: 700; color: #fff; font-size: 0.85rem;">
                                        Qté : {{ $item->quantity }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Custom Logo Preview/Download if attached -->
                    @if($order->logo_path)
                        <div style="margin-top: 12px; background: rgba(212, 175, 55, 0.08); border: 1px dashed var(--primary); padding: 10px 14px; border-radius: 8px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <i class="fa-solid fa-file-image" style="font-size: 1.8rem; color: var(--primary);"></i>
                                <div>
                                    <div style="font-weight: 700; font-size: 0.9rem; color: #fff;">Logo Personnalisé Client</div>
                                    <div style="font-size: 0.78rem; color: var(--text-secondary);">Image fournie pour l'impression / gravure de la lentille (Gobo)</div>
                                </div>
                            </div>
                            <a href="{{ asset('public-storage/' . $order->logo_path) }}" target="_blank" class="btn btn-primary btn-sm" style="font-size: 0.8rem;">
                                <i class="fa-solid fa-download"></i> Voir / Télécharger Logo
                            </a>
                        </div>
                    @endif

                    @if($order->notes)
                        <div style="margin-top: 10px; font-size: 0.85rem; color: var(--text-secondary); background: rgba(255,255,255,0.02); padding: 8px 12px; border-radius: 6px;">
                            <strong style="color: var(--warning);"><i class="fa-solid fa-circle-info"></i> Instructions particulières :</strong> {{ $order->notes }}
                        </div>
                    @endif
                </div>

                <!-- Right: Update Status & Tracking -->
                <div style="border-left: 1px solid var(--border-color); padding-left: 1.5rem; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <h4 style="font-size: 0.95rem; color: #fff; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-truck-fast" style="color: var(--primary);"></i> Traitement Logistique
                        </h4>
                        
                        <form action="{{ route('supplier.status', $sOrder->id) }}" method="POST">
                            @csrf
                            <div class="form-group" style="margin-bottom: 1rem;">
                                <label class="form-label" style="font-size: 0.78rem;">Statut de Préparation</label>
                                <select name="status" class="form-control" style="padding: 8px; font-size: 0.88rem;" required>
                                    <option value="pending" {{ $sOrder->status == 'pending' ? 'selected' : '' }}>En attente</option>
                                    <option value="preparing" {{ $sOrder->status == 'preparing' ? 'selected' : '' }}>En cours de préparation</option>
                                    <option value="shipped" {{ $sOrder->status == 'shipped' ? 'selected' : '' }}>Expédié (En cours d'acheminement)</option>
                                    <option value="completed" {{ $sOrder->status == 'completed' ? 'selected' : '' }}>Livré & Terminé</option>
                                </select>
                            </div>

                            <div class="form-group" style="margin-bottom: 1rem;">
                                <label class="form-label" style="font-size: 0.78rem;">N° de Suivi / Transporteur / Remarques</label>
                                <input type="text" name="notes" class="form-control" style="padding: 8px; font-size: 0.88rem;" placeholder="Ex: AMANA N° EE123456789MA" value="{{ $sOrder->notes }}">
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm" style="width: 100%; height: 38px; font-weight: 600;">
                                Enregistrer le Statut <i class="fa-solid fa-floppy-disk" style="margin-left: 5px;"></i>
                            </button>
                        </form>
                    </div>

                    <div style="margin-top: 1.5rem; border-top: 1px dashed var(--border-color); padding-top: 1rem; display: flex; justify-content: space-between; align-items: center;">
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-secondary btn-sm" style="width: 100%; text-align: center;">
                            <i class="fa-solid fa-file-invoice"></i> Voir Fiche Commande Complexe
                        </a>
                    </div>
                </div>

            </div>
        @empty
            <div style="text-align: center; color: var(--text-secondary); padding: 4rem 1rem;" class="glass-card">
                <i class="fa-solid fa-box-open" style="font-size: 3rem; color: var(--text-secondary); opacity: 0.4; margin-bottom: 1rem;"></i>
                <h3 style="color: #fff; font-size: 1.1rem; margin-bottom: 5px;">Aucune commande dans cette catégorie</h3>
                <p style="font-size: 0.9rem; color: var(--text-secondary);">Les nouvelles commandes confirmées apparaîtront automatiquement ici dès qu'une vente est validée.</p>
            </div>
        @endforelse
    </div>

    @if($supplierOrders->hasPages())
        <div style="margin-top: 1.5rem;">
            {{ $supplierOrders->links() }}
        </div>
    @endif
</div>
@endsection
