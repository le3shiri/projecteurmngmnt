@extends('layouts.app')

@section('title', 'Suivi de Prospection')

@section('content')
<div class="header-bar">
    <div>
        <h1 class="page-title">Prospection Téléphonique (Admin)</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Injectez des listes de numéros à appeler et suivez la progression des agents en temps réel</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem;">
    <!-- Upload Form -->
    <div class="glass-card" style="margin: 0; align-self: start;">
        <h3 class="card-title">Injecter un fichier de prospects</h3>
        
        <form action="{{ route('prospects.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label" for="name">Nom de la Campagne</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Ex: Prospects Casa Centre" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="agent_id">Assigner à l'Agent</label>
                <select name="agent_id" id="agent_id" class="form-control" required>
                    <option value="">-- Sélectionner l'agent --</option>
                    @foreach($agents as $agent)
                        <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="file">Fichier CSV (.csv)</label>
                <input type="file" name="file" id="file" class="form-control" accept=".csv" required>
                <small style="color: var(--text-secondary); margin-top: 5px; display: block;">Structure CSV requise : Colonne 1 = Nom, Colonne 2 = Téléphone. Sans entête.</small>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                Importer et Assigner <i class="fa-solid fa-upload"></i>
            </button>
        </form>
    </div>

    <!-- Files Table logs -->
    <div class="glass-card" style="margin: 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; margin-bottom: 1.5rem;">
            <h3 class="card-title" style="margin: 0;">Suivi des Campagnes Actives</h3>
            
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
                        <th>Agent</th>
                        <th>Total Prospects</th>
                        <th>Progression</th>
                        <th>Date Import</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($files as $file)
                        <tr>
                            <td style="font-weight: 600;">
                                <a href="{{ route('prospects.show', $file->id) }}" style="color: var(--primary); text-decoration: none;">
                                    {{ $file->name }}
                                </a>
                            </td>
                            <td>{{ $file->agent->name }}</td>
                            <td>{{ $file->prospects_count }} prospects</td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="background: rgba(255,255,255,0.05); width: 100px; height: 6px; border-radius: 3px; overflow: hidden;">
                                        <div style="width: {{ $file->progress }}%; background: var(--primary); height: 100%;"></div>
                                    </div>
                                    <span style="font-size: 0.8rem; font-weight: 600; min-width: 35px;">{{ $file->progress }}%</span>
                                </div>
                            </td>
                            <td>{{ $file->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <a href="{{ route('prospects.show', $file->id) }}" class="btn btn-secondary btn-sm">
                                        <i class="fa-solid fa-eye"></i> Suivi
                                    </a>
                                    <form action="{{ route('prospects.destroyFile', $file->id) }}" method="POST" onsubmit="return confirm('Voulez-vous supprimer cette campagne de prospection ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: var(--text-secondary); padding: 3rem 0;">
                                Aucun fichier de prospects importé pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
