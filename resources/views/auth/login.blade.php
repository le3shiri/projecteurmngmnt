@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: radial-gradient(circle, #1e293b 0%, #0f172a 100%); width: 100%;">
    <div class="glass-card login-card" style="margin: 0;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <i class="fa-solid fa-circle-notch fa-spin" style="font-size: 2.5rem; color: var(--primary); margin-bottom: 1rem;"></i>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: #fff;">ProjetEUR CRM</h2>
            <p style="color: var(--text-secondary); font-size: 0.85rem; margin-top: 5px;">Portail d'accès collaboratif</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger" style="padding: 0.75rem; font-size: 0.85rem;">
                <ul style="list-style: none;">
                    @foreach ($errors->all() as $error)
                        <li><i class="fa-solid fa-triangle-exclamation"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <!-- Access Code Login -->
            <div id="login-code-group">
                <div class="form-group">
                    <label class="form-label" for="access_code" style="text-align: center; display: block; margin-bottom: 0.75rem;">Entrez votre code d'accès unique</label>
                    <input type="text" name="access_code" id="access_code" class="form-control" placeholder="Ex: AGENT88A" style="text-align: center; letter-spacing: 2px; font-weight: 700; text-transform: uppercase;" required autofocus>
                </div>
            </div>

            <div class="form-group" style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 1.5rem;">
                <input type="checkbox" name="remember" id="remember" style="accent-color: var(--primary);">
                <label for="remember" style="font-size: 0.85rem; color: var(--text-secondary); cursor: pointer;">Se souvenir de moi</label>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem; padding: 0.8rem;">
                Se connecter <i class="fa-solid fa-right-to-bracket"></i>
            </button>
        </form>
    </div>
</div>
@endsection
