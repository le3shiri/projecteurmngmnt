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
        <div style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); border-radius: var(--border-radius); padding: 1.25rem; margin-bottom: 1.5rem;">
            <div class="form-group" style="margin-bottom: 1rem;">
                <label class="form-label" for="commission_agent" style="font-weight: 700;">
                    <i class="fa-solid fa-coins" style="color: var(--warning);"></i> Commission Par Défaut (DH par unité)
                </label>
                <input type="number" step="0.01" name="commission_agent" id="commission_agent" class="form-control" value="{{ old('commission_agent', $product->commission_agent) }}" min="0" required placeholder="Ex: 50.00">
                <small style="color: var(--text-secondary);">S'applique automatiquement aux agents qui n'ont pas de commission personnalisée.</small>
            </div>

            @if(isset($agents) && count($agents) > 0)
                <label class="form-label" style="font-weight: 700; margin-top: 1rem; display: block;">
                    <i class="fa-solid fa-user-gear" style="color: var(--primary);"></i> Commissions Particulières par Agent (Optionnel)
                </label>
                <p style="font-size: 0.82rem; color: var(--text-secondary); margin-bottom: 0.75rem;">
                    Saisissez le montant spécifique de la commission pour un agent (laissez vide pour utiliser la commission par défaut) :
                </p>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 10px;">
                    @foreach($agents as $ag)
                        @php
                            $existingCommission = $product->agentCommissions->firstWhere('agent_id', $ag->id);
                            $existingVal = $existingCommission ? $existingCommission->commission : '';
                        @endphp
                        <div style="background: rgba(0,0,0,0.2); padding: 8px 12px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.05);">
                            <label style="font-size: 0.85rem; font-weight: 600; color: var(--text-primary); display: block; margin-bottom: 4px;">
                                {{ $ag->name }}
                            </label>
                            <div style="display: flex; align-items: center; gap: 5px;">
                                <input type="number" step="0.01" name="agent_commissions[{{ $ag->id }}]" class="form-control" placeholder="Défaut ({{ number_format($product->commission_agent, 2) }} DH)" value="{{ old('agent_commissions.'.$ag->id, $existingVal) }}" min="0" style="padding: 4px 8px; font-size: 0.85rem;">
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
            @if($product->image)
                <div style="margin-bottom: 10px;">
                    <img src="{{ asset('public-storage/' . $product->image) }}" alt="Preview" style="height: 100px; border-radius: 8px; border: 1px solid var(--border-color);">
                </div>
            @endif
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
            <small style="color: var(--text-secondary); margin-top: 5px; display: block;">Format recommandé : JPG/PNG/WebP, Max 2MB. Laissez vide pour conserver l'image actuelle.</small>
        </div>

        <div class="form-group">
            <label class="form-label" for="fiche_technique"><i class="fa-solid fa-file-pdf" style="color: #ef4444;"></i> Fiche Technique (Pièce jointe)</label>
            @if($product->fiche_technique)
                <div style="margin-bottom: 10px; display: flex; align-items: center; justify-content: space-between; background: rgba(255,255,255,0.05); padding: 10px 14px; border-radius: 8px; border: 1px solid var(--border-color);">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <i class="fa-solid fa-file-pdf" style="font-size: 1.4rem; color: #ef4444;"></i>
                        <span style="font-size: 0.9rem; font-weight: 500;">Fiche technique actuelle</span>
                    </div>
                    <a href="{{ asset('public-storage/' . $product->fiche_technique) }}" target="_blank" class="btn btn-secondary btn-sm">
                        <i class="fa-solid fa-download"></i> Consulter / Télécharger
                    </a>
                </div>
            @endif
            <input type="file" name="fiche_technique" id="fiche_technique" class="form-control" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg,.webp">
            <small style="color: var(--text-secondary); margin-top: 5px; display: block;">Formats acceptés : PDF, Word, Images. Max 10MB. Laissez vide pour conserver le fichier actuel.</small>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
            Enregistrer les modifications <i class="fa-solid fa-floppy-disk"></i>
        </button>
    </form>
</div>
@endsection
