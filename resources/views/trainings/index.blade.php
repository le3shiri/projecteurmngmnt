@extends('layouts.app')

@section('title', 'Espace Formation & Catalogues')

@section('content')
<div class="header-bar">
    <div>
        <h1 class="page-title">Formation & Catalogues Produits</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Accédez aux fiches techniques, argumentaires de vente et guides d'installation</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: {{ auth()->user()->hasPermission('manage_trainings') ? '1fr 2fr' : '1fr' }}; gap: 1.5rem;">
    
    @if(auth()->user()->hasPermission('manage_trainings'))
        <!-- Admin upload resource panel -->
        <div class="glass-card" style="margin: 0; align-self: start;">
            <h3 class="card-title">Ajouter une Ressource</h3>
            
            <form action="{{ route('trainings.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label class="form-label" for="title">Titre de la Ressource</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Ex: Catalogue Projecteurs Extérieurs 2026" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Description / Contenu</label>
                    <textarea name="description" id="description" rows="3" class="form-control" placeholder="Qu'est-ce que ce document contient ?"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="file">Fichier PDF / Catalogue (.pdf, .zip)</label>
                    <input type="file" name="file" id="file" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label" for="video_url">Lien Vidéo Explicative (Optionnel)</label>
                    <input type="url" name="video_url" id="video_url" class="form-control" placeholder="https://youtube.com/watch?v=...">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                    Publier la Ressource <i class="fa-solid fa-cloud-arrow-up"></i>
                </button>
            </form>
        </div>
    @endif

    <!-- Resource lists for agents -->
    <div class="glass-card" style="margin: 0;">
        <h3 class="card-title">Documentation & Vidéos Disponibles</h3>
        
        <div class="resource-list">
            @forelse($trainings as $training)
                <div class="resource-item">
                    <div style="max-width: 70%;">
                        <h4 style="color: #fff; font-size: 1.05rem; margin-bottom: 5px;">{{ $training->title }}</h4>
                        <p style="color: var(--text-secondary); font-size: 0.85rem; margin-bottom: 8px;">
                            {{ $training->description }}
                        </p>
                        <span style="font-size: 0.75rem; color: var(--text-secondary); display: block;">
                            Publié le : {{ $training->created_at->format('d/m/Y') }}
                        </span>
                    </div>

                    <div style="display: flex; gap: 8px; align-items: center;">
                        @if($training->file_path)
                            <button onclick="openPdfModal('{{ asset('public-storage/' . $training->file_path) }}', '{{ addslashes($training->title) }}')" class="btn btn-secondary btn-sm" style="background: rgba(212,175,55,0.1); color: var(--primary); border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 5px;">
                                <i class="fa-solid fa-file-pdf"></i> Ouvrir PDF
                            </button>
                        @endif

                        @if($training->video_url)
                            <a href="{{ $training->video_url }}" target="_blank" class="btn btn-secondary btn-sm" style="background: rgba(14,165,233,0.1); color: var(--info);">
                                <i class="fa-solid fa-video"></i> Tuto Vidéo
                            </a>
                        @endif

                        @if(auth()->user()->hasPermission('manage_trainings'))
                            <form action="{{ route('trainings.destroy', $training->id) }}" method="POST" onsubmit="return confirm('Supprimer cette ressource de formation ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div style="text-align: center; color: var(--text-secondary); padding: 3rem 0;">
                    <i class="fa-solid fa-graduation-cap" style="font-size: 3rem; color: var(--text-secondary); margin-bottom: 1rem; display: block;"></i>
                    Aucune ressource disponible pour le moment dans l'espace formation.
                </div>
            @endforelse
        </div>
    </div>

</div>

<!-- Modal PDF Reader -->
<div id="pdfModal" class="pdf-modal-backdrop" style="display: none;">
    <div class="pdf-modal-container glass-card">
        <div class="pdf-modal-header">
            <h3 id="pdfModalTitle" style="margin: 0; color: #fff; font-size: 1.15rem; font-weight: 600;">Lecteur PDF</h3>
            <div style="display: flex; gap: 10px; align-items: center;">
                <a id="pdfExternalLink" href="#" target="_blank" class="btn btn-secondary btn-sm" style="font-size: 0.8rem; padding: 5px 10px;">
                    <i class="fa-solid fa-external-link"></i> Plein Écran
                </a>
                <button onclick="closePdfModal()" class="pdf-modal-close-btn">&times;</button>
            </div>
        </div>
        <div class="pdf-modal-body">
            <iframe id="pdfFrame" src="" style="width: 100%; height: 100%; border: none; border-radius: 0 0 8px 8px;"></iframe>
        </div>
    </div>
</div>

<style>
    .pdf-modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .pdf-modal-backdrop.active {
        opacity: 1;
    }
    
    .pdf-modal-container {
        width: 90%;
        max-width: 1200px;
        height: 85%;
        margin: 0 !important;
        padding: 0 !important;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        transform: scale(0.95);
        transition: transform 0.3s ease;
    }
    
    .pdf-modal-backdrop.active .pdf-modal-container {
        transform: scale(1);
    }
    
    .pdf-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        background: rgba(30, 41, 59, 0.5);
        border-bottom: 1px solid var(--border-color);
    }
    
    .pdf-modal-close-btn {
        background: none;
        border: none;
        color: var(--text-secondary);
        font-size: 1.75rem;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 50%;
    }
    
    .pdf-modal-close-btn:hover {
        color: #fff;
        background: rgba(255, 255, 255, 0.1);
    }
    
    .pdf-modal-body {
        flex: 1;
        background: #0f172a;
    }
</style>

<script>
    function openPdfModal(url, title) {
        const modal = document.getElementById('pdfModal');
        const frame = document.getElementById('pdfFrame');
        const titleEl = document.getElementById('pdfModalTitle');
        const externalLink = document.getElementById('pdfExternalLink');
        
        titleEl.textContent = title;
        externalLink.href = url;
        frame.src = url;
        
        modal.style.display = 'flex';
        // Trigger reflow
        modal.offsetHeight;
        modal.classList.add('active');
        
        // Prevent background scrolling
        document.body.style.overflow = 'hidden';
    }
    
    function closePdfModal() {
        const modal = document.getElementById('pdfModal');
        const frame = document.getElementById('pdfFrame');
        
        modal.classList.remove('active');
        setTimeout(() => {
            modal.style.display = 'none';
            frame.src = '';
        }, 300);
        
        // Restore background scrolling
        document.body.style.overflow = '';
    }
    
    // Close modal on escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closePdfModal();
        }
    });
</script>
@endsection
