@extends('layouts.app')

@section('title', 'Modifier Produit')

@section('content')
<div class="header-bar">
    <div>
        <h1 class="page-title">Modifier Produit : {{ $product->name }}</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Mettez à jour la tarification et le niveau de stock disponible</p>
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

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="code">Code Produit / SKU</label>
                <input type="text" name="code" id="code" class="form-control" value="{{ old('code', $product->code) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="category_id">Catégorie</label>
                <select name="category_id" id="category_id" class="form-control">
                    <option value="">Sélectionner une catégorie</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="name">Nom du Produit</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="description">Description Technique / Spécifications</label>
            <textarea name="description" id="description" rows="4" class="form-control">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="price">Prix Vente Client (DH)</label>
                <input type="number" step="0.01" name="price" id="price" class="form-control" value="{{ old('price', $product->price) }}" min="0" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="prix_fournisseur">Prix Fournisseur (DH)</label>
                <input type="number" step="0.01" name="prix_fournisseur" id="prix_fournisseur" class="form-control" value="{{ old('prix_fournisseur', $product->prix_fournisseur) }}" min="0" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="stock">Stock Disponible</label>
                <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', $product->stock) }}" min="0" required>
            </div>
        </div>

        @if(auth()->user()->isAdmin())
        <div class="form-group">
            <label class="form-label" for="commission_agent">Commission Agent (DH par unité vendue)</label>
            <input type="number" step="0.01" name="commission_agent" id="commission_agent" class="form-control" value="{{ old('commission_agent', $product->commission_agent) }}" min="0" required>
        </div>
        @endif

        <div class="form-group">
            <label class="form-label" for="image">Photo du Produit</label>
            @if($product->image)
                <div style="margin-bottom: 10px;">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Preview" style="height: 100px; border-radius: 8px; border: 1px solid var(--border-color);">
                </div>
            @endif
            <input type="file" name="image" id="image" class="form-control">
            <small style="color: var(--text-secondary); margin-top: 5px; display: block;">Format recommandé : JPG/PNG/WebP, Max 2MB. Laissez vide pour conserver l'image actuelle.</small>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
            Enregistrer les modifications <i class="fa-solid fa-floppy-disk"></i>
        </button>
    </form>
</div>
@endsection
