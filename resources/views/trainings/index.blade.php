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
                            <a href="{{ asset('storage/' . $training->file_path) }}" target="_blank" class="btn btn-secondary btn-sm" style="background: rgba(212,175,55,0.1); color: var(--primary);">
                                <i class="fa-solid fa-file-pdf"></i> Ouvrir PDF
                            </a>
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
@endsection
