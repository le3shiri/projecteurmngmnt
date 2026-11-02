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
                <span style="font-size: 0.8rem; color: var(--text-secondary); display: block;">ICE Client</span>
                <span style="font-weight: 500;">{{ $customer->ice ?? 'Non spécifié' }}</span>
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

        @if(auth()->user()->isAdmin())
            <div style="border-top: 1px solid var(--border-color); padding-top: 15px; margin-top: 15px;">
                <h4 style="color: var(--primary); font-size: 0.95rem; margin-bottom: 10px; display: flex; align-items: center; justify-content: space-between;">
                    <span><i class="fa-solid fa-crown"></i> Espace Privilège Client</span>
                    <span class="badge" style="background: rgba(212, 175, 55, 0.15); color: var(--primary); font-size: 0.7rem;">Admin</span>
                </h4>

                @if($customer->hasDeliveredOrder())
                    @php $vipLink = $customer->latestDiscountLink; @endphp

                    @if($vipLink)
                        <div style="background: rgba(0, 0, 0, 0.25); border: 1px solid var(--border-color); border-radius: 8px; padding: 10px; margin-bottom: 10px;">
                            <div style="font-size: 0.78rem; color: var(--text-secondary); margin-bottom: 4px;">Remise active actuelle :</div>
                            <div style="font-size: 1.05rem; font-weight: 700; color: #10b981; margin-bottom: 6px;">
                                -{{ (int)$vipLink->getCurrentDiscountRate() }}% de réduction
                                @if($vipLink->isInitialPeriodActive())
                                    <span style="font-size: 0.72rem; color: var(--warning); font-weight: 500;">(Offre 11% : encore {{ $vipLink->getRemainingDays() }} j)</span>
                                @else
                                    <span style="font-size: 0.72rem; color: var(--text-secondary); font-weight: 500;">(Permanente à vie)</span>
                                @endif
                            </div>
                            <div style="font-size: 0.75rem; color: var(--text-secondary); margin-bottom: 6px;">
                                Lien catalogue réservé à ce client :
                            </div>
                            <div style="display: flex; gap: 6px; align-items: center;">
                                <input type="text" id="vip-link-input" class="form-control" value="{{ $vipLink->getUrl() }}" readonly style="font-size: 0.72rem; padding: 5px 8px; font-family: monospace;">
                                <button type="button" class="btn btn-secondary btn-sm" onclick="copyVipLink()" title="Copier le lien">
                                    <i class="fa-regular fa-copy"></i>
                                </button>
                                <a href="{{ $vipLink->getUrl() }}" target="_blank" class="btn btn-secondary btn-sm" title="Ouvrir le catalogue client">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </a>
                            </div>
                            <div id="copy-feedback" style="display: none; font-size: 0.72rem; color: #10b981; margin-top: 4px;">
                                <i class="fa-solid fa-check"></i> Lien copié dans le presse-papier !
                            </div>
                        </div>

                        <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                            @php
                                $waText = rawurlencode("Bonjour " . $customer->name . ",\n\nSuite à la livraison de votre projecteur, nous avons le plaisir de vous offrir un accès exclusif à notre catalogue avec -11% de réduction sur toutes vos commandes pendant 10 jours, puis -5% permanent à vie :\n" . $vipLink->getUrl());
                            @endphp
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $customer->phone ?? '') }}?text={{ $waText }}" target="_blank" class="btn btn-secondary btn-sm" style="flex: 1; text-align: center; color: #25d366; font-size: 0.78rem;">
                                <i class="fa-brands fa-whatsapp"></i> Envoyer WhatsApp
                            </a>

                            <form action="{{ route('customers.vip_link.generate', $customer->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="regenerate" value="1">
                                <button type="submit" class="btn btn-secondary btn-sm" style="font-size: 0.75rem; color: var(--text-secondary);" title="Régénérer un nouveau lien">
                                    <i class="fa-solid fa-rotate-right"></i>
                                </button>
                            </form>
                        </div>
                    @else
                        <p style="font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 10px;">
                            Ce client a reçu un projecteur. Vous pouvez générer son lien catalogue exclusif avec <strong>-11% pendant 10 jours</strong> puis <strong>-5% à vie</strong>.
                        </p>
                        <form action="{{ route('customers.vip_link.generate', $customer->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm" style="width: 100%;">
                                <i class="fa-solid fa-wand-magic-sparkles"></i> Générer le lien exclusif (-11% / -5%)
                            </button>
                        </form>
                    @endif
                @else
                    <div style="font-size: 0.8rem; color: var(--text-secondary); background: rgba(0,0,0,0.2); padding: 8px 10px; border-radius: 6px; border: 1px dashed var(--border-color);">
                        <i class="fa-solid fa-circle-info" style="color: var(--warning); margin-right: 4px;"></i>
                        Le lien fidélité sera débloqué dès qu'une commande sera au statut <strong>Livrée</strong> pour ce client.
                    </div>
                @endif
            </div>
        @endif
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
                                @php $computedRemaining = max(0, (float)$order->total - (float)($order->advance_cash + $order->advance_transfer)); @endphp
                                @if($computedRemaining > 0)
                                    <span style="color: var(--warning); font-weight: 600;">{{ number_format($computedRemaining, 2, ',', ' ') }} DH</span>
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

@section('scripts')
<script>
function copyVipLink() {
    const input = document.getElementById('vip-link-input');
    if (!input) return;
    input.select();
    input.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(input.value).then(() => {
        const feedback = document.getElementById('copy-feedback');
        if (feedback) {
            feedback.style.display = 'block';
            setTimeout(() => { feedback.style.display = 'none'; }, 3000);
        }
    });
}
</script>
@endsection
