@extends('layouts.app')

@section('title', 'Détails Campagne - ' . $file->name)

@section('content')
<div class="header-bar">
    <div>
        <h1 class="page-title">Campagne : {{ $file->name }}</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Suivi de progression et rapports d'appels rédigés par l'agent {{ $file->agent->name }}</p>
    </div>
    <div>
        <a href="{{ route('prospects.index') }}" class="btn btn-secondary">
            Retour
        </a>
    </div>
</div>

<div class="glass-card">
    <h3 class="card-title">Liste des Prospects ({{ $file->prospects()->count() }})</h3>
    
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Téléphone</th>
                    <th>Date d'Appel</th>
                    <th>Statut</th>
                    <th>Notes d'Agent</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prospects as $prospect)
                    <tr>
                        <td style="font-weight: 600;">{{ $prospect->name ?: '-' }}</td>
                        <td style="font-family: monospace;">{{ $prospect->phone }}</td>
                        <td>{{ $prospect->called_at ? $prospect->called_at->format('d/m/Y H:i') : 'En attente' }}</td>
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
                            <span style="font-size: 0.85rem; font-style: italic; color: var(--text-secondary);">
                                {{ $prospect->notes ?: '-' }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $prospects->links() }}
    </div>
</div>
@endsection
