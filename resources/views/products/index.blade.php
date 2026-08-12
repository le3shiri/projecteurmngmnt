@extends('layouts.app')

@section('title', 'Gestion des Produits & Catégories')

@section('content')
<div class="header-bar">
    <div>
        <h1 class="page-title">Gestion des Produits</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Consultez vos produits, ajustez les stocks et gérez vos catégories d'articles</p>
    </div>
    @if(auth()->user()->hasPermission('manage_products'))
    <div>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Nouveau Produit
        </a>
    </div>
    @endif
</div>

<!-- Tabs Navigation Bar -->
<div style="display: flex; gap: 10px; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.75rem;">
    <button type="button" id="tab-btn-products" class="btn {{ $activeTab == 'products' ? 'btn-primary' : 'btn-secondary' }}" onclick="switchTab('products')" style="display: flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-boxes-stacked"></i> Catalogue Produits ({{ $products->total() }})
    </button>
    @if(auth()->user()->hasPermission('manage_categories'))
    <button type="button" id="tab-btn-categories" class="btn {{ $activeTab == 'categories' ? 'btn-primary' : 'btn-secondary' }}" onclick="switchTab('categories')" style="display: flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-folder-tree"></i> Catégories ({{ count($categoriesWithCount) }})
    </button>
    @endif
</div>

<!-- TAB 1: PRODUCTS CATALOG -->
<div id="tab-content-products" style="display: {{ $activeTab == 'products' ? 'block' : 'none' }};">
    <!-- Filters Bar -->
    <div class="glass-card" style="padding: 1.25rem; margin-bottom: 1.5rem;">
        <form action="{{ route('products.index') }}" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap;">
            <input type="hidden" name="tab" value="products">
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
</div>

<!-- TAB 2: CATEGORIES MANAGEMENT -->
@if(auth()->user()->hasPermission('manage_categories'))
<div id="tab-content-categories" style="display: {{ $activeTab == 'categories' ? 'block' : 'none' }};">
    <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 1.5rem; align-items: start;">
        <!-- List panel -->
        <div class="glass-card" style="margin: 0;">
            <h3 class="card-title" style="margin-bottom: 1.25rem;">Catégories Existantes</h3>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nom de la catégorie</th>
                            <th>Description</th>
                            <th style="text-align: center;">Produits Associés</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categoriesWithCount as $cat)
                            <tr>
                                <td style="font-weight: 600; color: #fff;">{{ $cat->name }}</td>
                                <td style="color: var(--text-secondary); font-size: 0.9rem;">{{ Str::limit($cat->description, 50) ?: 'Aucune description' }}</td>
                                <td style="text-align: center;">
                                    <span class="badge badge-info" style="background: rgba(14, 165, 233, 0.1); color: var(--info); font-size: 0.8rem;">
                                        {{ $cat->products_count }} produit(s)
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                        <a href="{{ route('categories.edit', $cat->id) }}" class="btn btn-secondary btn-sm" title="Modifier">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ? Les produits associés ne seront pas supprimés.')" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--text-secondary); padding: 3rem 0;">
                                    <i class="fa-solid fa-folder-open" style="font-size: 3rem; color: var(--text-secondary); margin-bottom: 1rem; display: block;"></i>
                                    Aucune catégorie enregistrée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create panel -->
        <div class="glass-card" style="margin: 0;">
            <h3 class="card-title" style="margin-bottom: 1.25rem;">Créer une Catégorie</h3>
            
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="name">Nom de la Catégorie</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Ex: Extérieur IP67" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Description</label>
                    <textarea name="description" id="description" rows="4" class="form-control" placeholder="Description de la catégorie de produits...">{{ old('description') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                    Ajouter la Catégorie <i class="fa-solid fa-plus"></i>
                </button>
            </form>
        </div>
    </div>
</div>
@endif

@endsection

@section('scripts')
<script>
    function switchTab(tab) {
        document.getElementById('tab-content-products').style.display = tab === 'products' ? 'block' : 'none';
        const catTab = document.getElementById('tab-content-categories');
        if (catTab) {
            catTab.style.display = tab === 'categories' ? 'block' : 'none';
        }

        const btnProd = document.getElementById('tab-btn-products');
        const btnCat = document.getElementById('tab-btn-categories');

        if (tab === 'products') {
            btnProd.classList.remove('btn-secondary');
            btnProd.classList.add('btn-primary');
            if (btnCat) {
                btnCat.classList.remove('btn-primary');
                btnCat.classList.add('btn-secondary');
            }
        } else {
            if (btnCat) {
                btnCat.classList.remove('btn-secondary');
                btnCat.classList.add('btn-primary');
            }
            btnProd.classList.remove('btn-primary');
            btnProd.classList.add('btn-secondary');
        }

        const url = new URL(window.location);
        url.searchParams.set('tab', tab);
        window.history.pushState({}, '', url);
    }
</script>
@endsection
