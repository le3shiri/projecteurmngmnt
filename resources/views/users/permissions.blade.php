@extends('layouts.app')

@section('title', 'Gestion des Permissions')

@section('content')
<style>
    /* Tab controls */
    .role-tabs {
        display: flex;
        gap: 12px;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 10px;
    }
    .role-tab-btn {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
        padding: 10px 20px;
        border-radius: var(--border-radius);
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .role-tab-btn:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #fff;
    }
    .role-tab-btn.active {
        background: var(--primary);
        border-color: var(--primary);
        color: #000;
    }

    /* Permission Card Grid */
    .permission-modules-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 1.5rem;
    }
    @media (max-width: 768px) {
        .permission-modules-grid {
            grid-template-columns: 1fr;
        }
    }

    .permission-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    .permission-item:last-child {
        border-bottom: none;
    }

    /* Switch toggle styles */
    .switch {
        position: relative;
        display: inline-block;
        width: 46px;
        height: 24px;
    }
    .switch input { 
        opacity: 0;
        width: 0;
        height: 0;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(255, 255, 255, 0.1);
        transition: .3s ease;
        border-radius: 24px;
        border: 1px solid var(--border-color);
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 3px;
        bottom: 3px;
        background-color: #fff;
        transition: .3s ease;
        border-radius: 50%;
    }
    input:checked + .slider {
        background-color: var(--primary);
        border-color: var(--primary);
    }
    input:checked + .slider:before {
        transform: translateX(22px);
        background-color: #000;
    }
</style>

<div class="header-bar">
    <div>
        <h1 class="page-title">Configuration des Rôles & Permissions</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Définissez précisément les accès pour les Agents et les Fournisseurs. Les administrateurs disposent d'un contrôle total.</p>
    </div>
</div>

@if(session('success'))
    <div style="background: rgba(46, 204, 113, 0.2); border: 1px solid var(--success); color: #fff; padding: 15px; border-radius: var(--border-radius); margin-bottom: 1.5rem;">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('permissions.update') }}" method="POST">
    @csrf

    <!-- Role Selection Tabs -->
    <div class="role-tabs">
        <button type="button" class="role-tab-btn active" onclick="switchRoleTab(event, 'agent')">
            <i class="fa-solid fa-user-tie"></i> Agent Commercial
        </button>
        <button type="button" class="role-tab-btn" onclick="switchRoleTab(event, 'supplier')">
            <i class="fa-solid fa-truck"></i> Fournisseur (Supplier)
        </button>
    </div>

    <!-- Actions Panel -->
    <div class="glass-card" style="margin-bottom: 1.5rem; padding: 1.25rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <div>
            <h3 id="active-role-title" style="margin: 0; color: #fff; font-size: 1.25rem; font-weight: 700;">Configuration : Agent Commercial</h3>
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-floppy-disk"></i> Enregistrer les modifications
        </button>
    </div>

    <!-- Agent Permissions Panel -->
    <div id="role-panel-agent" class="role-panel">
        <div class="permission-modules-grid">
            @foreach($modules as $moduleName => $permissions)
                <div class="glass-card" style="margin: 0; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <h4 style="margin: 0 0 15px 0; color: var(--primary); font-weight: 700; border-bottom: 1px solid var(--border-color); padding-bottom: 10px; display: flex; align-items: center; gap: 10px;">
                            <i class="fa-solid fa-layer-group"></i> {{ $moduleName }}
                        </h4>
                        <div>
                            @foreach($permissions as $key => $description)
                                <div class="permission-item">
                                    <div style="max-width: 80%;">
                                        <div style="font-weight: 600; color: #fff; font-size: 0.95rem;">{{ $description }}</div>
                                        <code style="font-size: 0.75rem; color: var(--text-secondary);">{{ $key }}</code>
                                    </div>
                                    <div>
                                        <label class="switch">
                                            <input type="checkbox" name="permissions[agent][]" value="{{ $key }}" 
                                                {{ in_array($key, $currentPermissions['agent'] ?? []) ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Supplier Permissions Panel -->
    <div id="role-panel-supplier" class="role-panel" style="display: none;">
        <div class="permission-modules-grid">
            @foreach($modules as $moduleName => $permissions)
                <div class="glass-card" style="margin: 0; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <h4 style="margin: 0 0 15px 0; color: var(--primary); font-weight: 700; border-bottom: 1px solid var(--border-color); padding-bottom: 10px; display: flex; align-items: center; gap: 10px;">
                            <i class="fa-solid fa-layer-group"></i> {{ $moduleName }}
                        </h4>
                        <div>
                            @foreach($permissions as $key => $description)
                                <div class="permission-item">
                                    <div style="max-width: 80%;">
                                        <div style="font-weight: 600; color: #fff; font-size: 0.95rem;">{{ $description }}</div>
                                        <code style="font-size: 0.75rem; color: var(--text-secondary);">{{ $key }}</code>
                                    </div>
                                    <div>
                                        <label class="switch">
                                            <input type="checkbox" name="permissions[supplier][]" value="{{ $key }}" 
                                                {{ in_array($key, $currentPermissions['supplier'] ?? []) ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div style="margin-top: 2rem; display: flex; justify-content: flex-end;">
        <button type="submit" class="btn btn-primary" style="padding: 12px 30px;">
            <i class="fa-solid fa-floppy-disk"></i> Enregistrer les modifications
        </button>
    </div>
</form>

<script>
    function switchRoleTab(event, role) {
        // Toggle tab buttons
        document.querySelectorAll('.role-tab-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        event.currentTarget.classList.add('active');

        // Toggle role panels
        document.querySelectorAll('.role-panel').forEach(panel => {
            panel.style.display = 'none';
        });
        document.getElementById('role-panel-' + role).style.display = 'block';

        // Update active title text
        const titleText = role === 'agent' ? 'Configuration : Agent Commercial' : 'Configuration : Fournisseur';
        document.getElementById('active-role-title').innerText = titleText;
    }
</script>
@endsection
