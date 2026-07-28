@extends('layouts.app')

@section('title', 'Modifier Client')

@section('content')
<div class="header-bar">
    <div>
        <h1 class="page-title">Modifier Client : {{ $customer->name }}</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Mettez à jour les coordonnées du client</p>
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

    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label" for="name">Nom Complet</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $customer->name) }}" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="phone">Téléphone</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $customer->phone) }}">
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Adresse Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $customer->email) }}">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="company">Entreprise / Société</label>
            <input type="text" name="company" id="company" class="form-control" value="{{ old('company', $customer->company) }}">
        </div>

        <div class="form-group">
            <label class="form-label" for="address">Adresse de livraison</label>
            <textarea name="address" id="address" rows="3" class="form-control">{{ old('address', $customer->address) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="notes">Notes Internes / Observations</label>
            <textarea name="notes" id="notes" rows="3" class="form-control">{{ old('notes', $customer->notes) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%;">
            Enregistrer les modifications <i class="fa-solid fa-floppy-disk"></i>
        </button>
    </form>
</div>
@endsection
