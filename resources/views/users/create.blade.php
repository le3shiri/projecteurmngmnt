@extends('layouts.app')

@section('title', 'Créer un Utilisateur')

@section('content')
<style>
    .form-section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--primary);
        margin: 2rem 0 1rem 0;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid rgba(212, 175, 55, 0.15);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .form-section-title:first-of-type {
        margin-top: 0;
    }

    .file-upload-wrapper {
        position: relative;
        width: 100%;
        margin-top: 0.25rem;
    }

    .file-upload-input {
        width: 100%;
        height: 110px;
        opacity: 0;
        position: absolute;
        top: 0;
        left: 0;
        cursor: pointer;
        z-index: 2;
    }

    .file-upload-design {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 110px;
        border: 2px dashed rgba(212, 175, 55, 0.25);
        border-radius: var(--border-radius);
        background: rgba(15, 23, 42, 0.4);
        transition: var(--transition);
        color: var(--text-secondary);
        gap: 8px;
        text-align: center;
        padding: 10px;
    }

    .file-upload-wrapper:hover .file-upload-design {
        border-color: var(--primary);
        background: rgba(212, 175, 55, 0.05);
        color: var(--text-primary);
    }

    .file-upload-design i {
        font-size: 1.75rem;
        color: var(--primary);
        transition: var(--transition);
    }

    .file-upload-wrapper:hover .file-upload-design i {
        transform: translateY(-3px);
    }

    .file-upload-filename {
        font-size: 0.8rem;
        color: var(--success);
        font-weight: 500;
        display: none;
        align-items: center;
        justify-content: center;
        gap: 6px;
        background: rgba(16, 185, 129, 0.1);
        padding: 4px 10px;
        border-radius: 20px;
        border: 1px solid rgba(16, 185, 129, 0.2);
        max-width: 90%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>

<div class="header-bar">
    <div>
        <h1 class="page-title">Ajouter un Collaborateur</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Remplissez les détails pour créer un compte membre</p>
    </div>
    <div>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="glass-card" style="max-width: 750px; margin: 0 auto; padding: 2rem;">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="list-style: none;">
                @foreach ($errors->all() as $error)
                    <li><i class="fa-solid fa-circle-exclamation"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Section 1: Informations Personnelles -->
        <h3 class="form-section-title"><i class="fa-solid fa-user"></i> Informations Personnelles</h3>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="name">Nom Complet</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="Ex: Ahmed Alaoui" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="phone">Numéro de téléphone</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" placeholder="Ex: 0611223344">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="email">Adresse Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="Ex: contact@email.com" required>
        </div>

        <!-- Section 2: Rôle & Code d'accès -->
        <h3 class="form-section-title"><i class="fa-solid fa-shield-halved"></i> Rôle & Accès</h3>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="role">Rôle du collaborateur</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="agent" {{ old('role') == 'agent' ? 'selected' : '' }}>Agent Commercial</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="supplier" {{ old('role') == 'supplier' ? 'selected' : '' }}>Fournisseur (Préparateur)</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="access_code">Code d'accès personnalisé (Facultatif)</label>
                <input type="text" name="access_code" id="access_code" class="form-control" placeholder="Laisser vide pour auto-générer" value="{{ old('access_code') }}">
                <small style="color: var(--text-secondary); margin-top: 5px; display: block; font-size: 0.75rem;">Le code unique d'accès pour l'application agent (Ex: AGENT01).</small>
            </div>
        </div>

        <!-- Section 3: Agent Commercial Specific Fields -->
        <div id="agent_fields_group" style="display: none; background: rgba(212, 175, 55, 0.02); border: 1px dashed rgba(212, 175, 55, 0.15); padding: 1.5rem; border-radius: 8px; margin-bottom: 1.5rem; transition: var(--transition);">
            <h4 style="font-size: 1rem; color: var(--primary); margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-folder-open"></i> Informations & Documents Agent
            </h4>
            
            <div class="form-group" style="margin-bottom: 1.25rem;">
                <label class="form-label" for="cin">Numéro CIN</label>
                <input type="text" name="cin" id="cin" class="form-control" value="{{ old('cin') }}" placeholder="Ex: AB123456">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="cin_recto"><i class="fa-solid fa-id-card" style="color: var(--primary);"></i> CIN - Recto (Face Avant)</label>
                    <div class="file-upload-wrapper">
                        <input type="file" name="cin_recto" id="cin_recto" class="file-upload-input" onchange="updateFileName(this)" accept=".pdf,.jpg,.jpeg,.png,.webp">
                        <div class="file-upload-design">
                            <i class="fa-solid fa-id-card"></i>
                            <span style="font-size: 0.8rem;">Choisir ou glisser CNI Recto (PDF/Image)</span>
                            <span class="file-upload-filename"></span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="cin_verso"><i class="fa-solid fa-id-card" style="color: var(--primary);"></i> CIN - Verso (Face Arrière)</label>
                    <div class="file-upload-wrapper">
                        <input type="file" name="cin_verso" id="cin_verso" class="file-upload-input" onchange="updateFileName(this)" accept=".pdf,.jpg,.jpeg,.png,.webp">
                        <div class="file-upload-design">
                            <i class="fa-solid fa-id-card"></i>
                            <span style="font-size: 0.8rem;">Choisir ou glisser CNI Verso (PDF/Image)</span>
                            <span class="file-upload-filename"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group" style="margin-top: 1.25rem;">
                <label class="form-label" for="engagement_letter"><i class="fa-solid fa-file-contract" style="color: var(--primary);"></i> Lettre d'Engagement signée</label>
                <div class="file-upload-wrapper">
                    <input type="file" name="engagement_letter" id="engagement_letter" class="file-upload-input" onchange="updateFileName(this)" accept=".pdf,.jpg,.jpeg,.png,.webp">
                    <div class="file-upload-design">
                        <i class="fa-solid fa-file-contract"></i>
                        <span style="font-size: 0.8rem;">Choisir ou glisser la lettre d'engagement (PDF/Image)</span>
                        <span class="file-upload-filename"></span>
                    </div>
                </div>
            </div>
        </div>



        <button type="submit" class="btn btn-primary" style="width: 100%; height: 45px; font-size: 1rem; border-radius: 8px;">
            Créer le Collaborateur <i class="fa-solid fa-user-plus" style="margin-left: 5px;"></i>
        </button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function toggleAgentFields() {
        const role = document.getElementById('role').value;
        const agentGroup = document.getElementById('agent_fields_group');
        if (role === 'agent') {
            agentGroup.style.display = 'block';
        } else {
            agentGroup.style.display = 'none';
        }
    }

    function updateFileName(input) {
        const wrapper = input.closest('.file-upload-wrapper');
        const filenameSpan = wrapper.querySelector('.file-upload-filename');
        const designSpan = wrapper.querySelector('.file-upload-design span:not(.file-upload-filename)');
        const icon = wrapper.querySelector('.file-upload-design i');
        
        if (input.files && input.files.length > 0) {
            filenameSpan.innerHTML = `<i class="fa-solid fa-circle-check"></i> ${input.files[0].name}`;
            filenameSpan.style.display = 'inline-flex';
            designSpan.style.display = 'none';
            icon.style.color = 'var(--success)';
        } else {
            filenameSpan.style.display = 'none';
            designSpan.style.display = 'inline';
            icon.style.color = 'var(--primary)';
        }
    }

    document.getElementById('role').addEventListener('change', toggleAgentFields);
    document.addEventListener('DOMContentLoaded', toggleAgentFields);
</script>
@endsection
