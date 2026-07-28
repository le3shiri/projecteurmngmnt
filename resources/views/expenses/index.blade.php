@extends('layouts.app')

@section('title', 'Suivi des Dépenses')

@section('content')
<div class="header-bar">
    <div>
        <h1 class="page-title">Frais & Dépenses d'Exploitation</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Consignez toutes vos dépenses (matières premières, marketing, logistique, loyer...)</p>
    </div>
    <div>
        <a href="{{ route('expenses.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-wallet"></i> Enregistrer Dépense
        </a>
    </div>
</div>

<div class="glass-card">
    <!-- Filter Panel -->
    <form action="{{ route('expenses.index') }}" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 1.5rem;">
        <input type="text" name="search" class="form-control" placeholder="Rechercher par libellé..." value="{{ $search }}" style="max-width: 250px;">
        
        <select name="category" class="form-control" style="max-width: 200px;">
            <option value="">Toutes les catégories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>

        <input type="date" name="start_date" class="form-control" value="{{ $startDate ?? '' }}" style="max-width: 160px;" title="Date début">
        <input type="date" name="end_date" class="form-control" value="{{ $endDate ?? '' }}" style="max-width: 160px;" title="Date fin">

        <button type="submit" class="btn btn-secondary">
            Filtrer
        </button>

        @if($search || $category || $startDate || $endDate)
            <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Effacer</a>
        @endif
    </form>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Libellé / Titre</th>
                    <th>Catégorie</th>
                    <th>Montant</th>
                    <th>Description</th>
                    <th>Enregistré par</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expenses as $expense)
                    <tr>
                        <td>{{ $expense->date->format('d/m/Y') }}</td>
                        <td style="font-weight: 600;">{{ $expense->title }}</td>
                        <td>
                            <span class="badge badge-info">{{ $expense->category }}</span>
                        </td>
                        <td style="font-weight: 700; color: var(--danger);">{{ number_format($expense->amount, 2, ',', ' ') }} DH</td>
                        <td>{{ $expense->description ?? '-' }}</td>
                        <td>{{ $expense->creator->name ?? 'Système' }}</td>
                        <td>
                            <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" onsubmit="return confirm('Voulez-vous supprimer cette dépense ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-trash-can"></i> Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-secondary); padding: 3rem 0;">
                            <i class="fa-solid fa-wallet" style="font-size: 3rem; color: var(--text-secondary); margin-bottom: 1rem; display: block;"></i>
                            Aucune dépense enregistrée.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="margin-top: 1.5rem;">
        {{ $expenses->links() }}
    </div>
</div>
@endsection
