@extends('layouts.app')

@section('title', 'Mes Appels Prospects')

@section('content')
<div class="header-bar">
    <div>
        <h1 class="page-title">Mes Fichiers Prospects</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Consultez les fichiers de prospects assignés par l'administration et lancez vos appels journaliers</p>
    </div>
</div>

<div class="glass-card">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; margin-bottom: 1.5rem;">
        <h3 class="card-title" style="margin: 0;">Fichiers assignés</h3>
        
        <form action="{{ route('prospects.index') }}" method="GET" style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
            <input type="date" name="start_date" class="form-control" value="{{ $startDate ?? '' }}" style="max-width: 140px; height: 32px; padding: 2px 8px; font-size: 0.85rem;" title="Date début">
            <input type="date" name="end_date" class="form-control" value="{{ $endDate ?? '' }}" style="max-width: 140px; height: 32px; padding: 2px 8px; font-size: 0.85rem;" title="Date fin">
            <button type="submit" class="btn btn-secondary btn-sm" style="height: 32px; padding: 0 10px; font-size: 0.85rem;">Filtrer</button>
            @if($startDate || $endDate)
                <a href="{{ route('prospects.index') }}" class="btn btn-secondary btn-sm" style="height: 32px; padding: 0 10px; font-size: 0.85rem; display: flex; align-items: center;">Effacer</a>
            @endif
        </form>
    </div>
    
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Campagne</th>
                    <th>Date d'assignation</th>
                    <th>Total numéros</th>
                    <th>Progression</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($files as $file)
                    <tr>
                        <td style="font-weight: 600;">{{ $file->name }}</td>
                        <td>{{ $file->created_at->format('d/m/Y') }}</td>
                        <td>{{ $file->prospects_count }} prospects</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="background: rgba(255,255,255,0.05); width: 120px; height: 6px; border-radius: 3px; overflow: hidden;">
                                    <div style="width: {{ $file->progress }}%; background: var(--primary); height: 100%;"></div>
                                </div>
                                <span style="font-size: 0.8rem; font-weight: 600;">{{ $file->progress }}%</span>
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                <a href="{{ route('prospects.dialer', $file->id) }}" class="btn btn-primary btn-sm" title="Lancer le Dialer Automatique">
                                    <i class="fa-solid fa-phone"></i> Mode Dialer
                                </a>
                                <a href="{{ route('prospects.show', $file->id) }}" class="btn btn-secondary btn-sm" title="Voir la liste complète et l'historique des appels">
                                    <i class="fa-solid fa-list-check"></i> Liste & Historique
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--text-secondary); padding: 3rem 0;">
                            <i class="fa-solid fa-phone-slash" style="font-size: 3rem; color: var(--text-secondary); margin-bottom: 1rem; display: block;"></i>
                            Aucun fichier de prospect ne vous est assigné pour le moment.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
