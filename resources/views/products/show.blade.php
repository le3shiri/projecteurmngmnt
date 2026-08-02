@extends('layouts.app')

@section('title', 'Fiche Produit : ' . $product->name)

@section('content')
<style>
    .product-show-container {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 2rem;
        margin-top: 1rem;
    }

    @media (max-width: 768px) {
        .product-show-container {
            grid-template-columns: 1fr;
        }
    }

    .show-image-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 350px;
        position: relative;
        overflow: hidden;
    }

    .show-image-card img {
        max-width: 100%;
        max-height: 400px;
        object-fit: contain;
        border-radius: 8px;
        transition: transform 0.3s ease;
    }

    .show-image-card img:hover {
        transform: scale(1.03);
    }

    .pricing-details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1.25rem;
        margin: 1.5rem 0;
    }

    .price-box {
        background: rgba(15, 23, 42, 0.4);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        gap: 6px;
        transition: var(--transition);
        position: relative;
    }

    .price-box:hover {
        border-color: rgba(212, 175, 55, 0.2);
        transform: translateY(-2px);
    }

    .price-box.retail {
        border-left: 4px solid var(--primary);
    }

    .price-box.supplier {
        border-left: 4px solid var(--info);
    }

    .price-box.commission {
        border-left: 4px solid var(--success);
    }

    .price-box-label {
        font-size: 0.8rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .price-box-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    .tech-details-list {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border-color);
    }

    .tech-details-item {
        display: flex;
        justify-content: space-between;
        font-size: 0.95rem;
    }

    .tech-details-label {
        color: var(--text-secondary);
        font-weight: 500;
    }

    .tech-details-value {
        color: var(--text-primary);
        font-weight: 600;
    }
</style>

<div class="header-bar">
    <div>
        <h1 class="page-title">{{ $product->name }}</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Réf: <span style="color: var(--primary); font-family: monospace; font-weight: bold; font-size: 1rem;">{{ $product->code }}</span></p>
    </div>
    <div>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Retour au Catalogue
        </a>
    </div>
</div>

<div class="product-show-container">
    <!-- Left Column: Image -->
    <div class="show-image-card glass-card">
        @if($product->image)
            <img src="{{ asset('public-storage/' . $product->image) }}" alt="{{ $product->name }}">
        @else
            <div style="text-align: center; color: var(--text-secondary);">
                <i class="fa-solid fa-image" style="font-size: 5rem; opacity: 0.3; margin-bottom: 1rem; display: block;"></i>
                <span>Aucune image disponible</span>
            </div>
        @endif
    </div>

    <!-- Right Column: Details -->
    <div class="glass-card" style="display: flex; flex-direction: column; justify-content: space-between; padding: 2rem;">
        <div>
            <!-- Status Badge & Category -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <span class="badge badge-info" style="background: rgba(14, 165, 233, 0.1); color: var(--info);">
                    <i class="fa-solid fa-tags" style="margin-right: 5px;"></i> {{ $product->category ?? 'Non catégorisé' }}
                </span>
                
                @if($product->stock <= 0)
                    <span class="badge badge-cancelled"><i class="fa-solid fa-circle-xmark"></i> Rupture de Stock</span>
                @elseif($product->stock <= 5)
                    <span class="badge badge-pending"><i class="fa-solid fa-triangle-exclamation"></i> Niveau Critique ({{ $product->stock }})</span>
                @else
                    <span class="badge badge-confirmed" style="background: rgba(16, 185, 129, 0.1); color: var(--success);">
                        <i class="fa-solid fa-circle-check"></i> {{ $product->stock }} En Stock
                    </span>
                @endif
            </div>

            <!-- Description -->
            <div style="margin-bottom: 1.5rem;">
                <h3 style="font-size: 1.1rem; color: var(--text-primary); margin-bottom: 0.5rem; font-weight: 600;">Description</h3>
                <p style="color: var(--text-secondary); line-height: 1.6; font-size: 0.95rem;">
                    {{ $product->description ?: 'Aucune description fournie pour ce produit.' }}
                </p>
            </div>

            <!-- Pricing Boxes -->
            <h3 style="font-size: 1.1rem; color: var(--text-primary); margin-bottom: 0.75rem; font-weight: 600;">Structure de Tarification</h3>
            <div class="pricing-details-grid">
                <!-- Retail Price -->
                <div class="price-box retail">
                    <span class="price-box-label">Prix de Vente Public</span>
                    <span class="price-box-value">{{ number_format($product->price, 2, ',', ' ') }} <span style="font-size: 0.9rem; font-weight: 500;">DH</span></span>
                </div>

                <!-- Supplier Price (Admin/Supplier only) -->
                @if(auth()->user()->hasPermission('manage_products'))
                    <div class="price-box supplier">
                        <span class="price-box-label">Prix Fournisseur (Achat)</span>
                        <span class="price-box-value">{{ number_format($product->prix_fournisseur ?? 0, 2, ',', ' ') }} <span style="font-size: 0.9rem; font-weight: 500;">DH</span></span>
                    </div>
                @endif

                <!-- Commission Rate (Admin only) -->
                @if(auth()->user()->isAdmin())
                    <div class="price-box commission">
                        <span class="price-box-label">Commission Agent Fixe</span>
                        <span class="price-box-value" style="color: var(--success);">+{{ number_format($product->commission_agent ?? 0, 2, ',', ' ') }} <span style="font-size: 0.9rem; font-weight: 500;">DH</span></span>
                    </div>
                @endif
            </div>

            <!-- Technical details list -->
            <ul class="tech-details-list">
                <li class="tech-details-item">
                    <span class="tech-details-label">Date d'enregistrement</span>
                    <span class="tech-details-value">{{ $product->created_at ? $product->created_at->format('d/m/Y à H:i') : '-' }}</span>
                </li>
                <li class="tech-details-item">
                    <span class="tech-details-label">Dernière mise à jour</span>
                    <span class="tech-details-value">{{ $product->updated_at ? $product->updated_at->format('d/m/Y à H:i') : '-' }}</span>
                </li>
            </ul>
        </div>

        <!-- Management Actions -->
        @if(auth()->user()->hasPermission('manage_products'))
            <div style="display: flex; gap: 10px; border-top: 1px solid var(--border-color); margin-top: 2rem; padding-top: 1.5rem;">
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary" style="flex: 1; height: 40px; border-radius: 8px;">
                    <i class="fa-solid fa-pen-to-square"></i> Modifier la Fiche
                </a>

                @if(auth()->user()->hasPermission('delete_products'))
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Supprimer définitivement ce produit du catalogue ?')" style="display: flex; flex: 1;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="width: 100%; height: 40px; border-radius: 8px;">
                            <i class="fa-solid fa-trash-can" style="margin-right: 5px;"></i> Retirer du catalogue
                        </button>
                    </form>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
