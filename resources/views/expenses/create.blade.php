@extends('layouts.app')

@section('title', 'Enregistrer une Dépense')

@section('content')
<div class="header-bar">
    <div>
        <h1 class="page-title">Saisir des Frais</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Ajoutez le montant et la catégorie de dépenses pour la comptabilité analytique</p>
    </div>
    <div>
        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="glass-card" style="max-width: 600px; margin: 0 auto;">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="list-style: none;">
                @foreach ($errors->all() as $error)
                    <li><i class="fa-solid fa-circle-exclamation"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('expenses.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label" for="title">Titre / Objet de la dépense</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Ex: Achat matières premières projecteurs, Loyer boutique..." value="{{ old('title') }}" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="category">Catégorie de charge</label>
                <select name="category" id="category" class="form-control" required>
                    <option value="Achat stock" {{ old('category') == 'Achat stock' ? 'selected' : '' }}>Achat stock & composants</option>
                    <option value="Marketing" {{ old('category') == 'Marketing' ? 'selected' : '' }}>Marketing & Publicité (Facebook Ads...)</option>
                    <option value="Logistique" {{ old('category') == 'Logistique' ? 'selected' : '' }}>Logistique & Expéditions (Amana, Aramex...)</option>
                    <option value="Loyer et charges" {{ old('category') == 'Loyer et charges' ? 'selected' : '' }}>Loyer boutique et électricité</option>
                    <option value="Salaires et commissions" {{ old('category') == 'Salaires et commissions' ? 'selected' : '' }}>Salaires et commissions</option>
                    <option value="Autres" {{ old('category') == 'Autres' ? 'selected' : '' }}>Autres charges</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="amount">Montant déboursé (DH)</label>
                <input type="number" step="0.01" name="amount" id="amount" class="form-control" placeholder="0.00" value="{{ old('amount') }}" min="0.01" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="date">Date de décaissement</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="description">Détails complémentaires / Justification (Facultatif)</label>
            <textarea name="description" id="description" rows="3" class="form-control" placeholder="Notes additionnelles...">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
            Enregistrer la Dépense <i class="fa-solid fa-check"></i>
        </button>
    </form>
</div>
@endsection
