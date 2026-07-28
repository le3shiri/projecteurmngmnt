@extends('layouts.app')

@section('title', 'Dialer Prospection - ' . $file->name)

@section('content')
<div class="header-bar">
    <div>
        <h1 class="page-title">Session d'Appel : {{ $file->name }}</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Traitez les numéros un par un. Les résultats sont enregistrés instantanément</p>
    </div>
    <div>
        <a href="{{ route('prospects.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-circle-xmark"></i> Quitter la session
        </a>
    </div>
</div>

<!-- Dialer UI Container -->
<div class="dialer-container">
    
    <!-- Progression bar -->
    <div class="glass-card" style="margin-bottom: 1.5rem; padding: 1.25rem;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 5px; font-size: 0.85rem;">
            <span>Progression de la campagne</span>
            <strong>{{ $called }} / {{ $total }} Prospects appelés ({{ $total > 0 ? round(($called/$total)*100) : 0 }}%)</strong>
        </div>
        <div style="background: rgba(255,255,255,0.05); height: 8px; border-radius: 4px; overflow: hidden; margin-bottom: 8px;">
            <div style="width: {{ $total > 0 ? ($called/$total)*100 : 0 }}%; background: var(--primary); height: 100%;"></div>
        </div>
        <div style="font-size: 0.8rem; color: var(--success);">
            <i class="fa-solid fa-heart"></i> {{ $interested }} Prospect(s) intéressé(s) trouvé(s) !
        </div>
    </div>

    @if($currentProspect)
        <div class="glass-card" style="margin: 0; text-align: center; padding: 2.5rem 2rem;">
            <span style="font-size: 0.8rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">PROSPECT ACTUEL</span>
            
            <h2 style="font-size: 1.8rem; margin: 0.5rem 0 1.5rem; color: #fff;">
                {{ $currentProspect->name ?: 'Prospect Anonyme' }}
            </h2>

            <!-- Big Click to Call Phone Button -->
            <div style="margin: 2rem 0;">
                <a href="tel:{{ $currentProspect->phone }}" class="btn btn-primary" style="font-size: 1.5rem; padding: 1rem 2rem; border-radius: 50px; display: inline-flex; width: 100%; justify-content: center; max-width: 320px; box-shadow: 0 4px 20px rgba(212,175,55,0.25);">
                    <i class="fa-solid fa-phone-flip"></i> Appeler : {{ $currentProspect->phone }}
                </a>
                <small style="display: block; color: var(--text-secondary); margin-top: 8px;">Cliquez pour lancer l'appel sur votre appareil</small>
            </div>

            <!-- Qualification Form -->
            <form action="{{ route('prospects.update', $currentProspect->id) }}" method="POST" style="text-align: left; border-top: 1px solid var(--border-color); padding-top: 1.5rem; margin-top: 2rem;">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="status">Résultat de l'Appel</label>
                    <select name="status" id="status" class="form-control" required style="font-size: 1rem; padding: 10px;">
                        <option value="called">Appelé (Pas de réponse, répondeur...)</option>
                        <option value="interested">Intéressé (Souhaite un devis/catalogue)</option>
                        <option value="not_interested">Pas intéressé (Refus catégorique)</option>
                        <option value="wrong_number">Faux numéro / Numéro invalide</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="notes">Notes d'appel / Compte rendu</label>
                    <textarea name="notes" id="notes" rows="3" class="form-control" placeholder="Renseignez l'échange (ex: Rappeler demain à 14h, intéressé par projecteur 50W...)"></textarea>
                </div>

                <button type="submit" class="btn btn-success" style="width: 100%; padding: 0.9rem; font-size: 1rem;">
                    Valider et Passer au suivant <i class="fa-solid fa-chevron-right"></i>
                </button>
            </form>
        </div>
    @else
        <!-- Completed campain splash -->
        <div class="glass-card" style="margin: 0; text-align: center; padding: 4rem 2rem;">
            <i class="fa-solid fa-circle-check" style="font-size: 4rem; color: var(--success); margin-bottom: 1.5rem;"></i>
            <h2 style="color: #fff; margin-bottom: 10px;">Campagne Terminée !</h2>
            <p style="color: var(--text-secondary); margin-bottom: 2rem;">Tous les prospects de ce fichier ont été appelés et qualifiés.</p>
            <a href="{{ route('prospects.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-left-long"></i> Retourner à mes fichiers
            </a>
        </div>
    @endif

</div>
@endsection
