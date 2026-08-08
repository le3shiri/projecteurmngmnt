@extends('layouts.app')

@section('title', 'Catalogue & Stocks')

@section('content')
<div class="header-bar">
    <div>
        <h1 class="page-title">Catalogue Produits</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Consultez les fiches techniques, tarifs et niveaux de stock des projecteurs</p>
    </div>
    @if(auth()->user()->hasPermission('manage_products'))
    <div>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Ajouter un Produit
        </a>
    </div>
    @endif
</div>

<!-- Filters Bar -->
<div class="glass-card" style="padding: 1.25rem; margin-bottom: 1.5rem;">
    <form action="{{ route('products.index') }}" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap;">
        <input type="text" name="search" class="form-control" placeholder="Rechercher par nom ou code..." value="{{ $search }}" style="max-width: 250px;">
        
        <select name="category" class="form-control" style="max-width: 200px;">
            <option value="">Toutes les catégories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ $category == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-secondary">
            Filtrer
        </button>

        @if($search || $category)
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Réinitialiser</a>
        @endif
    </form>
</div>

<!-- Products Grid -->
<div class="catalog-grid">
    @forelse($products as $product)
        <div class="product-card" style="{{ $product->stock <= 5 ? 'border-color: rgba(239, 68, 68, 0.4);' : '' }}">
            <div class="product-image">
                <a href="{{ route('products.show', $product->id) }}" style="display: block; width: 100%; height: 100%;">
                    @if($product->image)
                        <img src="{{ asset('public-storage/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        <i class="fa-solid fa-image product-placeholder"></i>
                    @endif
                </a>
            </div>

            <div class="product-details">
                <span class="product-code">Code: {{ $product->code }}</span>
                <h4 class="product-name">
                    <a href="{{ route('products.show', $product->id) }}" style="color: inherit; text-decoration: none; transition: var(--transition);">
                        {{ $product->name }}
                    </a>
                </h4>
                <p style="color: var(--text-secondary); font-size: 0.85rem; margin-bottom: 1.25rem;">
                    {{ Str::limit($product->description, 80) }}
                </p>

                <div class="product-stock">
                    <div>
                        <span class="product-price">{{ number_format($product->price, 2, ',', ' ') }} DH</span>
                        @if(auth()->user()->hasPermission('manage_products'))
                            <div style="font-size: 0.85rem; color: var(--text-secondary); margin-top: 3px;">
                                <i class="fa-solid fa-truck"></i> Fournisseur: {{ number_format($product->prix_fournisseur ?? 0, 2, ',', ' ') }} DH
                            </div>
                        @endif
                        @if(auth()->user()->isAdmin())
                            <div style="font-size: 0.85rem; color: var(--text-secondary); margin-top: 3px;">
                                <i class="fa-solid fa-coins"></i> Commission: {{ number_format($product->commission_agent ?? 0, 2, ',', ' ') }} DH
                            </div>
                        @endif
                    </div>
                    
                    @if($product->stock <= 0)
                        <span class="badge badge-cancelled">Rupture</span>
                    @elseif($product->stock <= 5)
                        <span class="badge badge-pending">Critique ({{ $product->stock }})</span>
                    @else
                        <span class="badge badge-confirmed" style="background: rgba(16, 185, 129, 0.1); color: var(--success);">{{ $product->stock }} En stock</span>
                    @endif
                </div>

                <div style="display: flex; gap: 8px; border-top: 1px solid var(--border-color); margin-top: 1rem; padding-top: 1rem;">
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary btn-sm" style="flex: 1;" title="Voir Détails">
                        <i class="fa-solid fa-eye"></i> Détails
                    </a>
                    @if($product->fiche_technique)
                        <a href="{{ asset('public-storage/' . $product->fiche_technique) }}" target="_blank" class="btn btn-secondary btn-sm" title="Fiche Technique PDF">
                            <i class="fa-solid fa-file-pdf" style="color: #ef4444;"></i> Fiche
                        </a>
                    @endif
                    @if(auth()->user()->hasPermission('manage_products'))
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-secondary btn-sm" title="Modifier">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                    @endif
                    @if(auth()->user()->hasPermission('delete_products'))
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Supprimer ce produit du catalogue ?')" style="display: inline-flex;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div style="grid-column: 1 / -1; text-align: center; color: var(--text-secondary); padding: 4rem 0;">
            <i class="fa-solid fa-boxes-stacked" style="font-size: 3rem; color: var(--text-secondary); margin-bottom: 1rem; display: block;"></i>
            Aucun produit trouvé dans le catalogue.
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div style="margin-top: 2rem;">
    {{ $products->links() }}
</div>
@endsection
