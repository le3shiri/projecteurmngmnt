@extends('layouts.app')

@section('title', 'Gestion Clients')

@section('content')
<div class="header-bar">
    <div>
        <h1 class="page-title">Nos Clients</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Base de données des clients physiques et en ligne</p>
    </div>
    @if(auth()->user()->hasPermission('manage_customers'))
    <div>
        <a href="{{ route('customers.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-user-plus"></i> Nouveau Client
        </a>
    </div>
    @endif
</div>

<div class="glass-card">
    @php
        $perPageOptions = [15, 25, 50, 100, 150, 200];
        if (!in_array((int)$perPage, $perPageOptions)) {
            $perPageOptions[] = (int)$perPage;
            sort($perPageOptions);
        }
    @endphp

    <!-- Search & Filter Bar -->
    <form action="{{ route('customers.index') }}" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center; margin-bottom: 1.5rem;">
        <input type="text" name="search" class="form-control" placeholder="Rechercher par nom, téléphone, email..." value="{{ $search }}" style="max-width: 260px;">
        
        <input type="date" name="start_date" class="form-control" value="{{ $startDate ?? '' }}" style="max-width: 150px;" title="Date d'inscription début">
        <input type="date" name="end_date" class="form-control" value="{{ $endDate ?? '' }}" style="max-width: 150px;" title="Date d'inscription fin">

        <select name="sort" class="form-control" style="max-width: 210px;" onchange="this.form.submit()" title="Trier les clients">
            <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Plus récents d'abord</option>
            <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Plus anciens d'abord</option>
            <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>Nom (A → Z)</option>
            <option value="name_desc" {{ $sort === 'name_desc' ? 'selected' : '' }}>Nom (Z → A)</option>
        </select>

        <div style="display: flex; align-items: center; gap: 6px;">
            <label for="per_page" style="color: var(--text-secondary); font-size: 0.85rem; white-space: nowrap;">Afficher :</label>
            <select name="per_page" id="per_page" class="form-control" style="width: auto; min-width: 100px;" onchange="this.form.submit()" title="Nombre de lignes par page (jusqu'à 200)">
                @foreach($perPageOptions as $option)
                    <option value="{{ $option }}" {{ (int)$perPage === (int)$option ? 'selected' : '' }}>
                        {{ $option }} / page
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-secondary">
            <i class="fa-solid fa-magnifying-glass"></i> Filtrer
        </button>

        @if($search || $startDate || $endDate || $sort !== 'latest' || (int)$perPage !== 15)
            <a href="{{ route('customers.index') }}" class="btn btn-secondary" title="Réinitialiser tous les filtres">Effacer</a>
        @endif
    </form>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem; font-size: 0.85rem; color: var(--text-secondary);">
        <div>
            <i class="fa-solid fa-users"></i> Affichage de <strong>{{ $customers->firstItem() ?? 0 }}</strong> à <strong>{{ $customers->lastItem() ?? 0 }}</strong> sur <strong>{{ $customers->total() }}</strong> clients
        </div>
        <div>
            Page <strong>{{ $customers->currentPage() }}</strong> sur <strong>{{ $customers->lastPage() ?: 1 }}</strong>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>
                        <a href="{{ route('customers.index', array_merge(request()->query(), ['sort' => ($sort === 'name_asc' ? 'name_desc' : 'name_asc')])) }}" style="color: inherit; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                            Nom Complet
                            @if($sort === 'name_asc')
                                <i class="fa-solid fa-arrow-up-a-z" style="color: var(--primary);"></i>
                            @elseif($sort === 'name_desc')
                                <i class="fa-solid fa-arrow-down-z-a" style="color: var(--primary);"></i>
                            @else
                                <i class="fa-solid fa-sort" style="color: var(--text-secondary); opacity: 0.4;"></i>
                            @endif
                        </a>
                    </th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Entreprise</th>
                    <th>Adresse</th>
                    <th>
                        <a href="{{ route('customers.index', array_merge(request()->query(), ['sort' => ($sort === 'latest' ? 'oldest' : 'latest')])) }}" style="color: inherit; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;" title="Trier par date d'ajout">
                            Date d'ajout
                            @if($sort === 'latest')
                                <i class="fa-solid fa-arrow-down-wide-short" style="color: var(--primary);" title="Plus récents d'abord"></i>
                            @elseif($sort === 'oldest')
                                <i class="fa-solid fa-arrow-up-wide-short" style="color: var(--primary);" title="Plus anciens d'abord"></i>
                            @else
                                <i class="fa-solid fa-sort" style="color: var(--text-secondary); opacity: 0.4;"></i>
                            @endif
                        </a>
                    </th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td style="font-weight: 600;">
                            <a href="{{ route('customers.show', $customer->id) }}" style="color: var(--primary); text-decoration: none;">
                                {{ $customer->name }}
                            </a>
                        </td>
                        <td>{{ $customer->phone ?? '-' }}</td>
                        <td>{{ $customer->email ?? '-' }}</td>
                        <td>{{ $customer->company ?? '-' }}</td>
                        <td>{{ Str::limit($customer->address, 40) ?? '-' }}</td>
                        <td>
                            <span style="display: inline-flex; align-items: center; gap: 5px; color: var(--text-secondary); font-size: 0.85rem; white-space: nowrap;">
                                <i class="fa-regular fa-calendar"></i>
                                {{ $customer->created_at ? $customer->created_at->format('d/m/Y H:i') : '-' }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-secondary btn-sm" title="Consulter la fiche client">
                                    <i class="fa-solid fa-eye"></i> Fiche
                                </a>
                                @if(auth()->user()->hasPermission('manage_customers'))
                                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-secondary btn-sm" title="Modifier le client">
                                        <i class="fa-solid fa-pen-to-square"></i> Édit
                                    </a>
                                @endif
                                @if(auth()->user()->isAdmin())
                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce client ? Toutes ses données et commandes liées seront définitivement supprimées.');" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Supprimer le client">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-secondary); padding: 2rem 0;">
                            Aucun client trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination links -->
    <div style="margin-top: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
        <div style="font-size: 0.85rem; color: var(--text-secondary);">
            {{ $customers->total() }} client(s) au total
        </div>
        <div>
            {{ $customers->links() }}
        </div>
    </div>
</div>
@endsection
