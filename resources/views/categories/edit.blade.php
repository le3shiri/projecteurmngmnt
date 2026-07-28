@extends('layouts.app')

@section('title', 'Modifier la Catégorie')

@section('content')
<div class="header-bar">
    <div>
        <h1 class="page-title">Modifier la Catégorie</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Mettez à jour les informations de la catégorie : {{ $category->name }}</p>
    </div>
    <div>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="glass-card" style="max-width: 500px; margin: 0 auto;">
    @if ($errors->any())
        <div class="alert alert-danger" style="margin-bottom: 1rem; padding: 10px 15px;">
            <ul style="list-style: none; margin: 0; padding: 0;">
                @foreach ($errors->all() as $error)
                    <li><i class="fa-solid fa-circle-exclamation"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label" for="name">Nom de la Catégorie</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="description">Description</label>
            <textarea name="description" id="description" rows="4" class="form-control">{{ old('description', $category->description) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
            Enregistrer les modifications <i class="fa-solid fa-floppy-disk"></i>
        </button>
    </form>
</div>
@endsection
