@extends('layouts.app')

@section('title', 'Nouveau Client')

@section('content')
<div class="header-bar">
    <div>
        <h1 class="page-title">Ajouter un Client</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Créez un nouveau profil pour l'associer aux commandes</p>
    </div>
    <div>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">
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

    <form action="{{ route('customers.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label" for="name">Nom Complet</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="phone">Téléphone</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Adresse Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="company">Entreprise / Société (Facultatif)</label>
            <input type="text" name="company" id="company" class="form-control" value="{{ old('company') }}">
        </div>

        <div class="form-group">
            <label class="form-label" for="address">Adresse de livraison</label>
            <textarea name="address" id="address" rows="3" class="form-control">{{ old('address') }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="notes">Notes Internes / Observations</label>
            <textarea name="notes" id="notes" rows="3" class="form-control">{{ old('notes') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
            Créer la fiche client <i class="fa-solid fa-check"></i>
        </button>
    </form>
</div>
@endsection
