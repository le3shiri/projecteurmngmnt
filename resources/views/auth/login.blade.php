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

        <!-- Login Tabs Toggle -->
        <div class="login-tab-nav">
            <div id="tab-code-btn" class="login-tab active" onclick="switchTab('code')">Code d'accès</div>
            <div id="tab-email-btn" class="login-tab" onclick="switchTab('email')">Email / Mot de passe</div>
        </div>

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <!-- Option 1: Access Code Login -->
            <div id="login-code-group">
                <div class="form-group">
                    <label class="form-label" for="access_code">Entrez votre code d'accès unique</label>
                    <input type="text" name="access_code" id="access_code" class="form-control" placeholder="Ex: AGENT88A" style="text-align: center; letter-spacing: 2px; font-weight: 700; text-transform: uppercase;">
                </div>
            </div>

            <!-- Option 2: Email Password Login -->
            <div id="login-email-group" style="display: none;">
                <div class="form-group">
                    <label class="form-label" for="email">Adresse Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="exemple@mail.com">
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Mot de passe</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="******">
                </div>
            </div>

            <div class="form-group" style="display: flex; align-items: center; gap: 8px; margin-top: 1.5rem;">
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

@section('scripts')
<script>
    function switchTab(type) {
        const tabCodeBtn = document.getElementById('tab-code-btn');
        const tabEmailBtn = document.getElementById('tab-email-btn');
        const codeGroup = document.getElementById('login-code-group');
        const emailGroup = document.getElementById('login-email-group');
        
        const codeInput = document.getElementById('access_code');
        const emailInput = document.getElementById('email');
        const passInput = document.getElementById('password');

        if (type === 'code') {
            tabCodeBtn.classList.add('active');
            tabEmailBtn.classList.remove('active');
            codeGroup.style.display = 'block';
            emailGroup.style.display = 'none';
            
            // clear inputs for valid submission
            emailInput.value = '';
            passInput.value = '';
        } else {
            tabEmailBtn.classList.add('active');
            tabCodeBtn.classList.remove('active');
            emailGroup.style.display = 'block';
            codeGroup.style.display = 'none';
            
            // clear code input
            codeInput.value = '';
        }
    }
</script>
@endsection
