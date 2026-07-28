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
    <!-- Search Bar -->
    <form action="{{ route('customers.index') }}" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 1.5rem;">
        <input type="text" name="search" class="form-control" placeholder="Rechercher par nom, téléphone, email..." value="{{ $search }}" style="max-width: 280px;">
        
        <input type="date" name="start_date" class="form-control" value="{{ $startDate ?? '' }}" style="max-width: 160px;" title="Date d'inscription début">
        <input type="date" name="end_date" class="form-control" value="{{ $endDate ?? '' }}" style="max-width: 160px;" title="Date d'inscription fin">

        <button type="submit" class="btn btn-secondary">
            <i class="fa-solid fa-magnifying-glass"></i> Filtrer
        </button>
        @if($search || $startDate || $endDate)
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">Effacer</a>
        @endif
    </form>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Nom Complet</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Entreprise</th>
                    <th>Adresse</th>
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
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-secondary btn-sm">
                                    <i class="fa-solid fa-eye"></i> Fiche
                                </a>
                                @if(auth()->user()->hasPermission('manage_customers'))
                                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-secondary btn-sm">
                                        <i class="fa-solid fa-pen-to-square"></i> Édit
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-secondary); padding: 2rem 0;">
                            Aucun client trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination links -->
    <div style="margin-top: 1.5rem;">
        {{ $customers->links() }}
    </div>
</div>
@endsection
