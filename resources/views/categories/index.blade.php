@extends('layouts.app')

@section('title', 'Gestion des Catégories')

@section('content')
<div class="header-bar">
    <div>
        <h1 class="page-title">Catégories de Produits</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Organisez et classez vos projecteurs et accessoires</p>
    </div>
</div>

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
                    @forelse($categories as $cat)
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
        
        @if ($errors->any())
            <div class="alert alert-danger" style="margin-bottom: 1rem; padding: 10px 15px;">
                <ul style="list-style: none; margin: 0; padding: 0;">
                    @foreach ($errors->all() as $error)
                        <li><i class="fa-solid fa-circle-exclamation"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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
@endsection
