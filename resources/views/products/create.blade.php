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
        <div style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); border-radius: var(--border-radius); padding: 1.25rem; margin-bottom: 1.5rem;">
            <div class="form-group" style="margin-bottom: 1rem;">
                <label class="form-label" for="commission_agent" style="font-weight: 700;">
                    <i class="fa-solid fa-coins" style="color: var(--warning);"></i> Commission Par Défaut (DH par unité)
                </label>
                <input type="number" step="0.01" name="commission_agent" id="commission_agent" class="form-control" value="{{ old('commission_agent', '0.00') }}" min="0" required placeholder="Ex: 50.00">
                <small style="color: var(--text-secondary);">S'applique automatiquement aux agents qui n'ont pas de commission personnalisée.</small>
            </div>

            @if(isset($agents) && count($agents) > 0)
                <label class="form-label" style="font-weight: 700; margin-top: 1rem; display: block;">
                    <i class="fa-solid fa-user-gear" style="color: var(--primary);"></i> Commissions Particulières par Agent (Optionnel)
                </label>
                <p style="font-size: 0.82rem; color: var(--text-secondary); margin-bottom: 0.75rem;">
                    Définissez un montant spécifique pour chaque agent si sa commission diffère sur ce produit :
                </p>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 10px;">
                    @foreach($agents as $ag)
                        <div style="background: rgba(0,0,0,0.2); padding: 8px 12px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.05);">
                            <label style="font-size: 0.85rem; font-weight: 600; color: var(--text-primary); display: block; margin-bottom: 4px;">
                                {{ $ag->name }}
                            </label>
                            <div style="display: flex; align-items: center; gap: 5px;">
                                <input type="number" step="0.01" name="agent_commissions[{{ $ag->id }}]" class="form-control" placeholder="Défaut" value="{{ old('agent_commissions.'.$ag->id) }}" min="0" style="padding: 4px 8px; font-size: 0.85rem;">
                                <span style="font-size: 0.8rem; color: var(--text-secondary);">DH</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        @endif

        <div class="form-group">
            <label class="form-label" for="image"><i class="fa-solid fa-image" style="color: var(--primary);"></i> Photo du Produit</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
            <small style="color: var(--text-secondary); margin-top: 5px; display: block;">Format recommandé : JPG/PNG/WebP, Max 2MB.</small>
        </div>

        <div class="form-group">
            <label class="form-label" for="fiche_technique"><i class="fa-solid fa-file-pdf" style="color: #ef4444;"></i> Fiche Technique (Pièce jointe PDF / Doc)</label>
            <input type="file" name="fiche_technique" id="fiche_technique" class="form-control" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg,.webp">
            <small style="color: var(--text-secondary); margin-top: 5px; display: block;">Joints acceptés : PDF, Word, Images. Max 10MB.</small>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
            Enregistrer le produit <i class="fa-solid fa-check"></i>
        </button>
    </form>
</div>
@endsection
