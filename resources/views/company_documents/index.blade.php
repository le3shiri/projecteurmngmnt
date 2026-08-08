@extends('layouts.app')

@section('title', 'Documents Importants de la Société')

@section('content')
<style>
    .docs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-top: 1.5rem;
    }

    .doc-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .doc-card:hover {
        transform: translateY(-3px);
        border-color: rgba(212, 175, 55, 0.3);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4);
    }

    .doc-icon-box {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-bottom: 1rem;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid var(--border-color);
    }

    .doc-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        word-break: break-word;
    }

    .doc-desc {
        font-size: 0.85rem;
        color: var(--text-secondary);
        line-height: 1.5;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .doc-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.8rem;
        color: var(--text-secondary);
        padding-top: 0.75rem;
        border-top: 1px dashed var(--border-color);
        margin-top: 0.75rem;
    }

    /* Modal Backdrop */
    .custom-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.75);
        backdrop-filter: blur(5px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    .custom-modal.active {
        display: flex;
    }

    .modal-content {
        background: #0f172a;
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        width: 100%;
        max-width: 550px;
        padding: 2rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
        position: relative;
    }
</style>

<div class="header-bar">
    <div>
        <h1 class="page-title">Documents Importants (Société)</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Coffre-fort numérique des documents officiels, juridiques et financiers de l'entreprise</p>
    </div>
    @if(auth()->user()->hasPermission('manage_documents'))
    <div>
        <button type="button" class="btn btn-primary" onclick="openAddModal()">
            <i class="fa-solid fa-cloud-arrow-up"></i> Ajouter un Document
        </button>
    </div>
    @endif
</div>

@if ($errors->any())
    <div class="alert alert-danger" style="margin-bottom: 1.5rem;">
        <ul style="list-style: none; margin: 0; padding: 0;">
            @foreach ($errors->all() as $error)
                <li><i class="fa-solid fa-circle-exclamation"></i> {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Filters Bar -->
<div class="glass-card" style="padding: 1.25rem; margin-bottom: 1.5rem;">
    <form action="{{ route('company_documents.index') }}" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap;">
        <input type="text" name="search" class="form-control" placeholder="Rechercher par titre ou description..." value="{{ $search }}" style="max-width: 300px;">
        
        <select name="category" class="form-control" style="max-width: 230px;">
            <option value="">Toutes les catégories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-secondary">
            <i class="fa-solid fa-filter"></i> Filtrer
        </button>

        @if($search || $category)
            <a href="{{ route('company_documents.index') }}" class="btn btn-secondary">Réinitialiser</a>
        @endif
    </form>
</div>

<!-- Documents Grid -->
<div class="docs-grid">
    @forelse($documents as $doc)
        <div class="doc-card">
            <div>
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div class="doc-icon-box" style="color: {{ $doc->icon_color }}; border-color: {{ $doc->icon_color }}40;">
                        <i class="fa-solid {{ $doc->icon }}"></i>
                    </div>
                    <span class="badge badge-info" style="font-size: 0.75rem; background: rgba(14, 165, 233, 0.1); color: var(--info);">
                        {{ $doc->category }}
                    </span>
                </div>

                <h3 class="doc-title" title="{{ $doc->title }}">{{ $doc->title }}</h3>
                <p class="doc-desc">{{ $doc->description ?: 'Aucune note ou description spécifique pour ce document.' }}</p>
            </div>

            <div>
                <div class="doc-meta">
                    <span><i class="fa-solid fa-hard-drive"></i> {{ $doc->formatted_size }}</span>
                    <span><i class="fa-solid fa-calendar-day"></i> {{ $doc->created_at->format('d/m/Y') }}</span>
                </div>

                <div style="display: flex; gap: 8px; margin-top: 1rem;">
                    <!-- Read / Consulter -->
                    <a href="{{ asset('public-storage/' . $doc->file_path) }}" target="_blank" class="btn btn-primary btn-sm" style="flex: 1; justify-content: center;" title="Consulter le document">
                        <i class="fa-solid fa-eye"></i> Lire / Ouvrir
                    </a>

                    @if(auth()->user()->hasPermission('manage_documents'))
                        <!-- Edit Button -->
                        <button type="button" class="btn btn-secondary btn-sm" onclick='openEditModal(@json($doc))' title="Modifier">
                            <i class="fa-solid fa-pen"></i>
                        </button>

                        <!-- Delete Button -->
                        <form action="{{ route('company_documents.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce document officiel ?')" style="display: inline-flex;">
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
        <div style="grid-column: 1 / -1; text-align: center; color: var(--text-secondary); padding: 4rem 0;" class="glass-card">
            <i class="fa-solid fa-folder-open" style="font-size: 3.5rem; opacity: 0.3; margin-bottom: 1rem; display: block;"></i>
            <h3>Aucun document trouvé</h3>
            <p style="font-size: 0.9rem; margin-top: 5px;">Ajoutez des contrats, attestations ou pièces justificatives de la société.</p>
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div style="margin-top: 2rem;">
    {{ $documents->links() }}
</div>

<!-- Modal: Add Document -->
<div id="addDocumentModal" class="custom-modal">
    <div class="modal-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--text-primary);"><i class="fa-solid fa-file-circle-plus" style="color: var(--primary);"></i> Ajouter un Document Officiel</h2>
            <button type="button" onclick="closeAddModal()" style="background: none; border: none; color: var(--text-secondary); font-size: 1.2rem; cursor: pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="{{ route('company_documents.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label" for="add_title">Titre du Document <span style="color: #ef4444;">*</span></label>
                <input type="text" name="title" id="add_title" class="form-control" placeholder="Ex: Registre de Commerce (RC) 2026" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="add_category">Catégorie</label>
                <select name="category" id="add_category" class="form-control">
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="add_description">Notes / Description (Optionnel)</label>
                <textarea name="description" id="add_description" rows="3" class="form-control" placeholder="Précisez des détails, date d'échéance, référence..."></textarea>
            </div>

            <div class="form-group">
                <label class="form-label" for="add_file">Fichier Joint (Document / Pièce) <span style="color: #ef4444;">*</span></label>
                <input type="file" name="file" id="add_file" class="form-control" required accept=".pdf,.doc,.docx,.xls,.xlsx,.csv,.jpg,.jpeg,.png,.webp,.zip,.rar">
                <small style="color: var(--text-secondary); margin-top: 5px; display: block;">Formats acceptés : PDF, Word, Excel, Image, Zip. Max 25MB.</small>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 1.5rem;">
                <button type="button" onclick="closeAddModal()" class="btn btn-secondary" style="flex: 1;">Annuler</button>
                <button type="submit" class="btn btn-primary" style="flex: 1;">Enregistrer & Transférer <i class="fa-solid fa-check"></i></button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Document -->
<div id="editDocumentModal" class="custom-modal">
    <div class="modal-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--text-primary);"><i class="fa-solid fa-pen-to-square" style="color: var(--primary);"></i> Modifier le Document</h2>
            <button type="button" onclick="closeEditModal()" style="background: none; border: none; color: var(--text-secondary); font-size: 1.2rem; cursor: pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="editDocumentForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="edit_title">Titre du Document <span style="color: #ef4444;">*</span></label>
                <input type="text" name="title" id="edit_title" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="edit_category">Catégorie</label>
                <select name="category" id="edit_category" class="form-control">
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="edit_description">Notes / Description</label>
                <textarea name="description" id="edit_description" rows="3" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label class="form-label" for="edit_file">Remplacer le Fichier Joint (Optionnel)</label>
                <input type="file" name="file" id="edit_file" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx,.csv,.jpg,.jpeg,.png,.webp,.zip,.rar">
                <small style="color: var(--text-secondary); margin-top: 5px; display: block;">Laissez vide si vous ne souhaitez pas remplacer le fichier actuel.</small>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 1.5rem;">
                <button type="button" onclick="closeEditModal()" class="btn btn-secondary" style="flex: 1;">Annuler</button>
                <button type="submit" class="btn btn-primary" style="flex: 1;">Mettre à jour <i class="fa-solid fa-floppy-disk"></i></button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    function openAddModal() {
        document.getElementById('addDocumentModal').classList.add('active');
    }

    function closeAddModal() {
        document.getElementById('addDocumentModal').classList.remove('active');
    }

    function openEditModal(doc) {
        var form = document.getElementById('editDocumentForm');
        form.action = "{{ url('company-documents') }}/" + doc.id;
        
        document.getElementById('edit_title').value = doc.title;
        document.getElementById('edit_category').value = doc.category || 'Autre';
        document.getElementById('edit_description').value = doc.description || '';

        document.getElementById('editDocumentModal').classList.add('active');
    }

    function closeEditModal() {
        document.getElementById('editDocumentModal').classList.remove('active');
    }

    // Close modals when clicking backdrop
    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('custom-modal')) {
            e.target.classList.remove('active');
        }
    });
</script>
@endsection
@endsection
