@extends('layouts.app')

@section('title', 'Gestion d\'Équipe')

@section('content')
<div class="header-bar">
    <div>
        <h1 class="page-title">Équipe & Agents Commerciaux</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Configurez les commissions et générez les codes d'accès uniques</p>
    </div>
    <div>
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-user-plus"></i> Ajouter un Membre
        </a>
    </div>
</div>

<div class="glass-card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Rôle</th>
                    <th>Code d'accès</th>
                    <th>CIN & Documents</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td style="font-weight: 600;">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge badge-confirmed">Admin</span>
                            @elseif($user->role === 'media_buyer')
                                <span class="badge" style="background: rgba(168, 85, 247, 0.15); color: #c084fc;">Media Buyer</span>
                            @elseif($user->role === 'supplier')
                                <span class="badge badge-info">Fournisseur</span>
                            @else
                                <span class="badge badge-pending">Agent</span>
                            @endif
                        </td>
                        <td style="font-family: monospace; font-weight: bold; color: var(--primary); letter-spacing: 1px;">
                            {{ $user->access_code }}
                        </td>
                        <td>
                            @if($user->isAgent())
                                <div style="font-weight: 500;">{{ $user->cin ?? 'Non défini' }}</div>
                                <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-top: 5px; font-size: 0.82rem;">
                                    @php
                                        $recto = $user->cin_recto_path ?: $user->cin_card_path;
                                    @endphp
                                    @if($recto)
                                        <a href="{{ asset('public-storage/' . $recto) }}" target="_blank" title="Carte Nationale (Recto)" style="color: var(--primary); display: inline-flex; align-items: center; gap: 3px;">
                                            <i class="fa-solid fa-id-card"></i> Recto
                                        </a>
                                    @else
                                        <span style="color: var(--text-secondary); opacity: 0.5;" title="CNI Recto manquante">
                                            <i class="fa-solid fa-id-card"></i> R-
                                        </span>
                                    @endif

                                    @if($user->cin_verso_path)
                                        <a href="{{ asset('public-storage/' . $user->cin_verso_path) }}" target="_blank" title="Carte Nationale (Verso)" style="color: var(--primary); display: inline-flex; align-items: center; gap: 3px;">
                                            <i class="fa-solid fa-id-card"></i> Verso
                                        </a>
                                    @else
                                        <span style="color: var(--text-secondary); opacity: 0.5;" title="CNI Verso manquante">
                                            <i class="fa-solid fa-id-card"></i> V-
                                        </span>
                                    @endif
                                    
                                    @if($user->engagement_letter_path)
                                        <a href="{{ asset('public-storage/' . $user->engagement_letter_path) }}" target="_blank" title="Lettre d'Engagement" style="color: var(--primary); display: inline-flex; align-items: center; gap: 3px;">
                                            <i class="fa-solid fa-file-signature"></i> Contrat
                                        </a>
                                    @else
                                        <span style="color: var(--text-secondary); opacity: 0.5;" title="Lettre d'Engagement manquante">
                                            <i class="fa-solid fa-file-signature"></i> -
                                        </span>
                                    @endif
                                </div>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{ $user->is_active ? 'confirmed' : 'cancelled' }}">
                                {{ $user->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-secondary btn-sm">
                                    <i class="fa-solid fa-pen-to-square"></i> Modifier
                                </a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('users.toggle', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-{{ $user->is_active ? 'danger' : 'success' }} btn-sm">
                                            <i class="fa-solid fa-power-off"></i> {{ $user->is_active ? 'Désactiver' : 'Activer' }}
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
