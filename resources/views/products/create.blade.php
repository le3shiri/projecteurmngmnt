@extends('layouts.app')

@section('title', 'Créer un Produit')

@section('content')
<div class="header-bar">
    <div>
        <h1 class="page-title">Ajouter un Produit au Catalogue</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Définissez le code produit, le prix et le stock initial</p>
    </div>
    <div>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">
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

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="code">Code Produit / SKU</label>
                <input type="text" name="code" id="code" class="form-control" placeholder="Ex: GOBO-20W" value="{{ old('code') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="category_id">Catégorie</label>
                <select name="category_id" id="category_id" class="form-control">
                    <option value="">Sélectionner une catégorie</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="name">Nom du Produit</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Ex: Projecteur Logo LED 20W" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="description">Description Technique / Spécifications</label>
            <textarea name="description" id="description" rows="4" class="form-control" placeholder="Entrez les spécifications techniques (lumens, étanchéité IP, focale...)">{{ old('description') }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="price">Prix Vente Client (DH)</label>
                <input type="number" step="0.01" name="price" id="price" class="form-control" value="{{ old('price', '0.00') }}" min="0" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="prix_fournisseur">Prix Fournisseur (DH)</label>
                <input type="number" step="0.01" name="prix_fournisseur" id="prix_fournisseur" class="form-control" value="{{ old('prix_fournisseur', '0.00') }}" min="0" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="stock">Stock Initial</label>
                <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', '0') }}" min="0" required>
            </div>
        </div>

        @if(auth()->user()->isAdmin())
        <div class="form-group">
            <label class="form-label" for="commission_agent">Commission Agent (DH par unité vendue)</label>
            <input type="number" step="0.01" name="commission_agent" id="commission_agent" class="form-control" value="{{ old('commission_agent', '0.00') }}" min="0" required>
        </div>
        @endif

        <div class="form-group">
            <label class="form-label" for="image">Photo du Produit</label>
            <input type="file" name="image" id="image" class="form-control">
            <small style="color: var(--text-secondary); margin-top: 5px; display: block;">Format recommandé : JPG/PNG/WebP, Max 2MB.</small>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
            Enregistrer le produit <i class="fa-solid fa-check"></i>
        </button>
    </form>
</div>
@endsection
