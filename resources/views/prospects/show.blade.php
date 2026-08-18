@extends('layouts.app')

@section('title', 'Liste & Historique Prospects - ' . $file->name)

@section('content')
<style>
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        padding: 1rem 1.25rem;
        display: flex;
        flex-direction: column;
    }

    .stat-val {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-top: 4px;
    }

    .stat-lbl {
        font-size: 0.8rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Custom Modal */
    .prospect-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.75);
        backdrop-filter: blur(5px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    .prospect-modal.active {
        display: flex;
    }

    .modal-box {
        background: #0f172a;
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        width: 100%;
        max-width: 500px;
        padding: 2rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
    }
</style>

<div class="header-bar">
    <div>
        <h1 class="page-title">Liste & Historique des Appels : {{ $file->name }}</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">
            Consultez les notes des échanges, modifiez le statut ou rappelez un prospect
            @if($file->agent) | Agent : <strong>{{ $file->agent->name }}</strong> @endif
        </p>
    </div>
    <div style="display: flex; gap: 10px;">
        <a href="{{ route('prospects.dialer', $file->id) }}" class="btn btn-primary">
            <i class="fa-solid fa-phone-flip"></i> Lancer Mode Dialer
        </a>
        <a href="{{ route('prospects.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<!-- Stats Header Cards -->
<div class="stats-row">
    <div class="stat-card">
        <span class="stat-lbl">Total Prospects</span>
        <span class="stat-val">{{ $stats['total'] }}</span>
    </div>
    <div class="stat-card">
        <span class="stat-lbl" style="color: var(--warning);">À Appeler</span>
        <span class="stat-val" style="color: var(--warning);">{{ $stats['pending'] }}</span>
    </div>
    <div class="stat-card">
        <span class="stat-lbl" style="color: var(--success);">Intéressés</span>
        <span class="stat-val" style="color: var(--success);">{{ $stats['interested'] }}</span>
    </div>
    <div class="stat-card">
        <span class="stat-lbl" style="color: var(--info);">Déjà Appelés</span>
        <span class="stat-val" style="color: var(--info);">{{ $stats['called'] }}</span>
    </div>
    <div class="stat-card">
        <span class="stat-lbl" style="color: var(--danger);">Non Intéressés</span>
        <span class="stat-val" style="color: var(--danger);">{{ $stats['not_interested'] }}</span>
    </div>
</div>

<!-- Search & Filter Bar -->
<div class="glass-card" style="padding: 1.25rem; margin-bottom: 1.5rem;">
    <form action="{{ route('prospects.show', $file->id) }}" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap;">
        <input type="text" name="search" class="form-control" placeholder="Rechercher par nom, téléphone ou note..." value="{{ $search ?? '' }}" style="max-width: 320px;">
        
        <select name="status" class="form-control" style="max-width: 220px;">
            <option value="">Tous les statuts</option>
            <option value="pending" {{ ($status ?? '') == 'pending' ? 'selected' : '' }}>À appeler (En attente)</option>
            <option value="interested" {{ ($status ?? '') == 'interested' ? 'selected' : '' }}>Intéressé</option>
            <option value="called" {{ ($status ?? '') == 'called' ? 'selected' : '' }}>Appelé (Sans réponse/autre)</option>
            <option value="not_interested" {{ ($status ?? '') == 'not_interested' ? 'selected' : '' }}>Pas intéressé</option>
            <option value="wrong_number" {{ ($status ?? '') == 'wrong_number' ? 'selected' : '' }}>Faux numéro</option>
        </select>

        <button type="submit" class="btn btn-secondary">
            <i class="fa-solid fa-filter"></i> Filtrer
        </button>

        @if($search || $status)
            <a href="{{ route('prospects.show', $file->id) }}" class="btn btn-secondary">Réinitialiser</a>
        @endif
    </form>
</div>

<!-- Prospects Table -->
<div class="glass-card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Téléphone</th>
                    <th>Dernier Appel</th>
                    <th>Statut Actuel</th>
                    <th style="width: 30%;">Notes d'Échange / Historique</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prospects as $prospect)
                    <tr>
                        <td style="font-weight: 600;">{{ $prospect->name ?: 'Anonyme' }}</td>
                        <td style="font-family: monospace;">
                            <a href="tel:{{ $prospect->phone }}" style="color: var(--primary); font-weight: bold; text-decoration: none;" title="Cliquer pour appeler">
                                <i class="fa-solid fa-phone" style="font-size: 0.8rem; margin-right: 4px;"></i> {{ $prospect->phone }}
                            </a>
                        </td>
                        <td>{{ $prospect->called_at ? $prospect->called_at->format('d/m/Y H:i') : '-' }}</td>
                        <td>
                            @if($prospect->status == 'pending')
                                <span class="badge badge-pending">À appeler</span>
                            @elseif($prospect->status == 'called')
                                <span class="badge badge-info">Appelé</span>
                            @elseif($prospect->status == 'interested')
                                <span class="badge badge-confirmed" style="background: rgba(16, 185, 129, 0.2); color: var(--success);">Intéressé</span>
                            @elseif($prospect->status == 'not_interested')
                                <span class="badge badge-cancelled">Pas intéressé</span>
                            @else
                                <span class="badge badge-cancelled" style="background: rgba(239, 68, 68, 0.3);">Faux numéro</span>
                            @endif
                        </td>
                        <td>
                            @if($prospect->notes)
                                <span style="font-size: 0.88rem; color: var(--text-primary); background: rgba(255,255,255,0.03); padding: 4px 8px; border-radius: 4px; display: block; border-left: 2px solid var(--primary);">
                                    {{ $prospect->notes }}
                                </span>
                            @else
                                <span style="font-size: 0.82rem; font-style: italic; color: var(--text-secondary);">Aucune note saisie</span>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" onclick='openRecallModal(@json($prospect))' title="Rappeler ou mettre à jour la note">
                                <i class="fa-solid fa-phone-volume"></i> Appeler / Qualifier
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-secondary); padding: 3rem 0;">
                            <i class="fa-solid fa-magnifying-glass" style="font-size: 2.5rem; opacity: 0.3; margin-bottom: 1rem; display: block;"></i>
                            Aucun prospect ne correspond à vos critères de recherche.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $prospects->links() }}
    </div>
</div>

<!-- Modal: Recall & Qualify Prospect -->
<div id="recallProspectModal" class="prospect-modal">
    <div class="modal-box">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--text-primary); margin: 0;">
                <i class="fa-solid fa-headset" style="color: var(--primary);"></i> Fiche Prospect & Rappel
            </h3>
            <button type="button" onclick="closeRecallModal()" style="background: none; border: none; color: var(--text-secondary); font-size: 1.2rem; cursor: pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div style="text-align: center; background: rgba(15, 23, 42, 0.8); border: 1px solid var(--border-color); border-radius: var(--border-radius); padding: 1.25rem; margin-bottom: 1.5rem;">
            <span style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase;">Nom du prospect</span>
            <h4 id="modal_prospect_name" style="font-size: 1.3rem; margin: 4px 0 12px; color: #fff;"></h4>
            
            <a id="modal_call_btn" href="#" class="btn btn-primary" style="width: 100%; justify-content: center; font-size: 1.1rem; padding: 10px;">
                <i class="fa-solid fa-phone-flip"></i> Lancer l'appel : <span id="modal_prospect_phone"></span>
            </a>
        </div>

        <form id="recallProspectForm" method="POST">
            @csrf
            <input type="hidden" name="redirect_back" value="1">

            <div class="form-group">
                <label class="form-label" for="modal_status">Statut de la Qualification</label>
                <select name="status" id="modal_status" class="form-control" required>
                    <option value="pending">À appeler (En attente / À relancer)</option>
                    <option value="called">Appelé (Pas de réponse, répondeur...)</option>
                    <option value="interested">Intéressé (Souhaite un devis / catalogue)</option>
                    <option value="not_interested">Pas intéressé (Refus)</option>
                    <option value="wrong_number">Faux numéro / Invalide</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="modal_notes">Notes d'appel / Compte rendu de l'échange</label>
                <textarea name="notes" id="modal_notes" rows="4" class="form-control" placeholder="Notez le détail de la conversation, le créneau de rappel souhaité..."></textarea>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 1.5rem;">
                <button type="button" onclick="closeRecallModal()" class="btn btn-secondary" style="flex: 1;">Annuler</button>
                <button type="submit" class="btn btn-success" style="flex: 1;">Enregistrer la Note <i class="fa-solid fa-check"></i></button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    function openRecallModal(prospect) {
        var form = document.getElementById('recallProspectForm');
        form.action = "{{ url('prospects') }}/" + prospect.id + "/update";

        document.getElementById('modal_prospect_name').innerText = prospect.name || 'Anonyme';
        document.getElementById('modal_prospect_phone').innerText = prospect.phone;
        document.getElementById('modal_call_btn').href = "tel:" + prospect.phone;

        document.getElementById('modal_status').value = prospect.status || 'pending';
        document.getElementById('modal_notes').value = prospect.notes || '';

        document.getElementById('recallProspectModal').classList.add('active');
    }

    function closeRecallModal() {
        document.getElementById('recallProspectModal').classList.remove('active');
    }

    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('prospect-modal')) {
            e.target.classList.remove('active');
        }
    });
</script>
@endsection
@endsection
