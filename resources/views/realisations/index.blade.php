@extends('layouts.app')

@section('title', 'Nos Réalisations')

@section('styles')
<style>
    /* ── Upload Panel ── */
    .upload-zone {
        border: 2px dashed var(--border-color);
        border-radius: 14px;
        padding: 2rem;
        text-align: center;
        transition: border-color 0.3s, background 0.3s;
        cursor: pointer;
        position: relative;
    }
    .upload-zone:hover, .upload-zone.drag-over {
        border-color: var(--primary);
        background: rgba(212,175,55,0.05);
    }
    .upload-zone input[type="file"] {
        position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
    }
    .upload-icon { font-size: 2.5rem; color: var(--primary); margin-bottom: 12px; }

    /* ── Gallery Grid ── */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.25rem;
        margin-top: 1.5rem;
    }
    .gallery-card {
        background: rgba(15,23,42,0.8);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        overflow: hidden;
        transition: transform 0.25s, box-shadow 0.25s;
        position: relative;
    }
    .gallery-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.4);
        border-color: var(--primary);
    }
    .gallery-media {
        width: 100%; height: 200px;
        object-fit: cover;
        display: block;
        background: #0a0f1a;
    }
    .gallery-video-wrap {
        position: relative; height: 200px; background: #0a0f1a;
        display: flex; align-items: center; justify-content: center;
    }
    .gallery-video-wrap video {
        width: 100%; height: 200px; object-fit: cover;
    }
    .play-overlay {
        position: absolute; inset: 0;
        display: flex; align-items: center; justify-content: center;
        background: rgba(0,0,0,0.4); transition: background 0.2s;
    }
    .gallery-video-wrap:hover .play-overlay { background: rgba(0,0,0,0.6); }
    .play-overlay i { font-size: 2.8rem; color: rgba(255,255,255,0.9); }
    .gallery-body { padding: 14px 16px; }
    .gallery-title {
        font-weight: 700; font-size: 0.95rem; color: var(--text-primary);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .gallery-desc {
        font-size: 0.8rem; color: var(--text-secondary); margin-top: 4px;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .gallery-meta {
        display: flex; align-items: center; gap: 8px; margin-top: 10px; flex-wrap: wrap;
    }
    .tag-badge {
        font-size: 0.72rem; padding: 3px 9px; border-radius: 20px;
        background: rgba(212,175,55,0.12); color: var(--primary);
        border: 1px solid rgba(212,175,55,0.3);
        font-weight: 600;
    }
    .type-badge {
        font-size: 0.72rem; padding: 3px 9px; border-radius: 20px; font-weight: 600;
    }
    .type-badge.image { background: rgba(59,130,246,0.15); color: #60a5fa; border: 1px solid rgba(59,130,246,0.3); }
    .type-badge.video { background: rgba(168,85,247,0.15); color: #c084fc; border: 1px solid rgba(168,85,247,0.3); }
    .gallery-actions { display: flex; gap: 6px; margin-top: 12px; }
    .gallery-uploader { font-size: 0.74rem; color: var(--text-secondary); margin-left: auto; }

    /* ── Filter Bar ── */
    .filter-bar {
        display: flex; gap: 10px; align-items: center; flex-wrap: wrap; margin-bottom: 0;
    }
    .filter-bar select, .filter-bar input {
        padding: 7px 12px; font-size: 0.85rem;
        background: rgba(15,23,42,0.8); border: 1px solid var(--border-color);
        color: var(--text-primary); border-radius: 8px; cursor: pointer;
    }

    /* ── Lightbox ── */
    .lightbox-overlay {
        display: none; position: fixed; inset: 0; z-index: 9999;
        background: rgba(0,0,0,0.92); align-items: center; justify-content: center;
    }
    .lightbox-overlay.active { display: flex; }
    .lightbox-inner {
        position: relative; max-width: 90vw; max-height: 90vh;
        display: flex; flex-direction: column; align-items: center; gap: 12px;
    }
    .lightbox-inner img, .lightbox-inner video {
        max-width: 90vw; max-height: 78vh; border-radius: 10px; object-fit: contain;
    }
    .lightbox-close {
        position: fixed; top: 20px; right: 24px; font-size: 2rem;
        color: #fff; cursor: pointer; opacity: 0.7; transition: opacity 0.2s;
        background: none; border: none; z-index: 10000;
    }
    .lightbox-close:hover { opacity: 1; }
    .lightbox-caption { color: #e5e7eb; font-size: 1rem; font-weight: 600; }

    /* ── Edit Modal ── */
    .modal-overlay {
        display: none; position: fixed; inset: 0; z-index: 8000;
        background: rgba(0,0,0,0.75); align-items: center; justify-content: center;
    }
    .modal-overlay.active { display: flex; }
    .modal-box {
        background: #0f1728; border: 1px solid var(--border-color); border-radius: 16px;
        padding: 2rem; width: 100%; max-width: 520px; position: relative;
    }
    .modal-close { position: absolute; top: 14px; right: 18px; font-size: 1.4rem; cursor: pointer; color: var(--text-secondary); }

    /* ── Empty State ── */
    .empty-gallery {
        text-align: center; padding: 4rem 1rem; color: var(--text-secondary);
        border: 2px dashed var(--border-color); border-radius: 14px; margin-top: 1.5rem;
    }
    .empty-gallery i { font-size: 3rem; margin-bottom: 1rem; display: block; opacity: 0.4; }
</style>
@endsection

@section('content')

{{-- ── Page Header ────────────────────────────────────────────────────────────── --}}
<div class="header-bar">
    <div>
        <h1 class="page-title"><i class="fa-solid fa-images" style="color: var(--primary);"></i> Nos Réalisations</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">
            Médiathèque interne — {{ $realisations->count() }} élément(s) archivé(s)
        </p>
    </div>
</div>

{{-- ── 2-Col Layout ────────────────────────────────────────────────────────────── --}}
<div style="display: grid; grid-template-columns: 340px 1fr; gap: 1.5rem; align-items: start;">

    {{-- Left: Upload Panel --}}
    <div style="position: sticky; top: 20px;">
        <div class="glass-card" style="margin: 0;">
            <h3 class="card-title"><i class="fa-solid fa-cloud-arrow-up" style="color: var(--primary);"></i> Ajouter une réalisation</h3>

            <form action="{{ route('realisations.store') }}" method="POST" enctype="multipart/form-data" id="upload-form">
                @csrf

                {{-- File drop zone --}}
                <div class="upload-zone" id="upload-zone">
                    <input type="file" name="file" id="file-input" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp,video/mp4,video/mov,video/avi,video/mkv,video/webm" required>
                    <i class="fa-solid fa-photo-film upload-icon"></i>
                    <div style="font-weight: 600; color: var(--text-primary); margin-bottom: 4px;">Glissez un fichier ici</div>
                    <div style="font-size: 0.8rem; color: var(--text-secondary);">ou cliquez pour sélectionner</div>
                    <div id="file-name-display" style="margin-top: 10px; font-size: 0.82rem; color: var(--primary); display: none; font-weight: 600;"></div>
                </div>

                {{-- Preview --}}
                <div id="upload-preview" style="display:none; margin-top: 12px; border-radius: 10px; overflow: hidden; border: 1px solid var(--border-color);">
                    <img id="preview-img" style="width:100%; max-height: 180px; object-fit:cover; display:none;">
                    <video id="preview-vid" controls style="width:100%; max-height: 180px; display:none;"></video>
                </div>

                <div class="form-group" style="margin-top: 1rem;">
                    <label class="form-label" for="title">Titre <span style="color: var(--danger);">*</span></label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Ex: Logo Marque X" required value="{{ old('title') }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="category">Catégorie</label>
                    <input type="text" name="category" id="category" class="form-control" placeholder="Ex: Logo, Affiche, Vidéo Pub…" list="category-list" value="{{ old('category') }}">
                    <datalist id="category-list">
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}">
                        @endforeach
                        <option value="Logo">
                        <option value="Affiche">
                        <option value="Vidéo Pub">
                        <option value="Identité Visuelle">
                        <option value="Réseaux Sociaux">
                        <option value="Packaging">
                    </datalist>
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Description (optionnel)</label>
                    <textarea name="description" id="description" class="form-control" rows="3" placeholder="Courte description du projet…">{{ old('description') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;" id="submit-btn">
                    <i class="fa-solid fa-upload"></i> Publier la réalisation
                </button>
            </form>

            {{-- Stats --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--border-color);">
                <div style="text-align: center;">
                    <div style="font-size: 1.8rem; font-weight: 800; color: var(--primary);">{{ $realisations->where('type','image')->count() }}</div>
                    <div style="font-size: 0.78rem; color: var(--text-secondary);"><i class="fa-solid fa-image"></i> Images</div>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 1.8rem; font-weight: 800; color: #c084fc;">{{ $realisations->where('type','video')->count() }}</div>
                    <div style="font-size: 0.78rem; color: var(--text-secondary);"><i class="fa-solid fa-film"></i> Vidéos</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right: Gallery --}}
    <div>
        {{-- Filter Bar --}}
        <div class="glass-card" style="margin: 0 0 0 0; padding: 14px 18px;">
            <form method="GET" action="{{ route('realisations.index') }}" style="display: contents;">
                <div class="filter-bar">
                    <select name="type" onchange="this.form.submit()">
                        <option value="">Tous les types</option>
                        <option value="image" {{ request('type') == 'image' ? 'selected' : '' }}>Images</option>
                        <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}>Vidéos</option>
                    </select>
                    <select name="category" onchange="this.form.submit()">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    @if(request('type') || request('category'))
                        <a href="{{ route('realisations.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fa-solid fa-xmark"></i> Réinitialiser
                        </a>
                    @endif
                    <span style="margin-left: auto; font-size: 0.82rem; color: var(--text-secondary);">
                        {{ $realisations->count() }} résultat(s)
                    </span>
                </div>
            </form>
        </div>

        {{-- Gallery Grid --}}
        @if($realisations->isEmpty())
            <div class="empty-gallery">
                <i class="fa-solid fa-images"></i>
                <div style="font-size: 1rem; font-weight: 600; margin-bottom: 4px;">Aucune réalisation pour le moment</div>
                <div style="font-size: 0.85rem;">Commencez par uploader une image ou une vidéo depuis le panneau de gauche.</div>
            </div>
        @else
            <div class="gallery-grid">
                @foreach($realisations as $item)
                    @php
                        $fileUrl = asset('public-storage/' . $item->file_path);
                    @endphp
                    <div class="gallery-card">

                        {{-- Media thumbnail --}}
                        @if($item->type === 'image')
                            <img src="{{ $fileUrl }}" alt="{{ $item->title }}" class="gallery-media"
                                 style="cursor: zoom-in;"
                                 onclick="openLightbox('{{ $fileUrl }}', '{{ addslashes($item->title) }}', 'image')">
                        @else
                            <div class="gallery-video-wrap" style="cursor: pointer;"
                                 onclick="openLightbox('{{ $fileUrl }}', '{{ addslashes($item->title) }}', 'video')">
                                <video src="{{ $fileUrl }}" preload="metadata" style="pointer-events: none;"></video>
                                <div class="play-overlay"><i class="fa-solid fa-circle-play"></i></div>
                            </div>
                        @endif

                        {{-- Body --}}
                        <div class="gallery-body">
                            <div class="gallery-title" title="{{ $item->title }}">{{ $item->title }}</div>
                            @if($item->description)
                                <div class="gallery-desc">{{ $item->description }}</div>
                            @endif
                            <div class="gallery-meta">
                                <span class="type-badge {{ $item->type }}">
                                    <i class="fa-solid {{ $item->type === 'video' ? 'fa-film' : 'fa-image' }}"></i>
                                    {{ $item->type === 'video' ? 'Vidéo' : 'Image' }}
                                </span>
                                @if($item->category)
                                    <span class="tag-badge">{{ $item->category }}</span>
                                @endif
                            </div>
                            <div style="display: flex; align-items: center; margin-top: 10px; gap: 6px;">
                                <span style="font-size: 0.73rem; color: var(--text-secondary);">
                                    <i class="fa-solid fa-user-circle"></i> {{ $item->uploader->name ?? '—' }}
                                    &bull; {{ $item->created_at->format('d/m/Y') }}
                                </span>
                            </div>
                            <div class="gallery-actions">
                                <a href="{{ $fileUrl }}" target="_blank" class="btn btn-secondary btn-sm" style="flex: 1;">
                                    <i class="fa-solid fa-expand"></i> Ouvrir
                                </a>
                                <a href="{{ route('realisations.download', $item->id) }}" class="btn btn-secondary btn-sm" title="Télécharger">
                                    <i class="fa-solid fa-download"></i>
                                </a>
                                @if(auth()->user()->isAdmin() || auth()->user()->hasPermission('manage_realisations'))
                                    <button type="button" class="btn btn-primary btn-sm"
                                            onclick="openEditModal({{ $item->id }}, '{{ addslashes($item->title) }}', '{{ addslashes($item->description ?? '') }}', '{{ addslashes($item->category ?? '') }}')">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <form action="{{ route('realisations.destroy', $item->id) }}" method="POST"
                                          onsubmit="return confirm('Supprimer définitivement « {{ addslashes($item->title) }} » ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>

{{-- ── Lightbox ─────────────────────────────────────────────────────────────── --}}
<div class="lightbox-overlay" id="lightbox" onclick="closeLightbox(event)">
    <button class="lightbox-close" onclick="closeLightboxBtn()">
        <i class="fa-solid fa-xmark"></i>
    </button>
    <div class="lightbox-inner" onclick="event.stopPropagation()">
        <img id="lb-img" src="" alt="" style="display:none;">
        <video id="lb-vid" controls style="display:none;"></video>
        <div style="display: flex; align-items: center; gap: 12px;">
            <div class="lightbox-caption" id="lb-caption"></div>
            <a id="lb-download" href="" download class="btn btn-primary btn-sm" style="white-space: nowrap;">
                <i class="fa-solid fa-download"></i> Télécharger
            </a>
        </div>
    </div>
</div>

{{-- ── Edit Modal ───────────────────────────────────────────────────────────── --}}
@if(auth()->user()->isAdmin() || auth()->user()->hasPermission('manage_realisations'))
<div class="modal-overlay" id="edit-modal" onclick="closeEditModal(event)">
    <div class="modal-box" onclick="event.stopPropagation()">
        <button class="modal-close" onclick="document.getElementById('edit-modal').classList.remove('active')">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <h3 class="card-title" style="margin-bottom: 1.2rem;"><i class="fa-solid fa-pen"></i> Modifier la réalisation</h3>
        <form id="edit-form" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label">Titre</label>
                <input type="text" name="title" id="edit-title" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Catégorie</label>
                <input type="text" name="category" id="edit-category" class="form-control" list="category-list">
            </div>
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" id="edit-description" class="form-control" rows="3"></textarea>
            </div>
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">
                    <i class="fa-solid fa-check"></i> Enregistrer
                </button>
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('edit-modal').classList.remove('active')">
                    Annuler
                </button>
            </div>
        </form>
    </div>
</div>
@endif

@endsection

@section('scripts')
<script>
    // ── File preview ────────────────────────────────────────────────────────────
    const fileInput   = document.getElementById('file-input');
    const zone        = document.getElementById('upload-zone');
    const previewWrap = document.getElementById('upload-preview');
    const previewImg  = document.getElementById('preview-img');
    const previewVid  = document.getElementById('preview-vid');
    const fileNameDisplay = document.getElementById('file-name-display');

    fileInput.addEventListener('change', () => {
        const file = fileInput.files[0];
        if (!file) return;
        fileNameDisplay.textContent = file.name;
        fileNameDisplay.style.display = 'block';
        const url = URL.createObjectURL(file);
        previewWrap.style.display = 'block';
        if (file.type.startsWith('image/')) {
            previewImg.src = url; previewImg.style.display = 'block';
            previewVid.style.display = 'none'; previewVid.src = '';
        } else {
            previewVid.src = url; previewVid.style.display = 'block';
            previewImg.style.display = 'none'; previewImg.src = '';
        }
    });

    zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('drag-over'); });
    zone.addEventListener('dragleave', () => zone.classList.remove('drag-over'));
    zone.addEventListener('drop', e => {
        e.preventDefault(); zone.classList.remove('drag-over');
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            fileInput.dispatchEvent(new Event('change'));
        }
    });

    // ── Lightbox ────────────────────────────────────────────────────────────────
    function openLightbox(src, caption, type) {
        const lb = document.getElementById('lightbox');
        const img = document.getElementById('lb-img');
        const vid = document.getElementById('lb-vid');
        document.getElementById('lb-caption').textContent = caption;
        document.getElementById('lb-download').href = src;
        document.getElementById('lb-download').setAttribute('download', caption);
        if (type === 'image') {
            img.src = src; img.style.display = 'block';
            vid.style.display = 'none'; vid.src = '';
        } else {
            vid.src = src; vid.style.display = 'block';
            img.style.display = 'none'; img.src = '';
        }
        lb.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox(e) {
        if (e.target === document.getElementById('lightbox')) closeLightboxBtn();
    }

    function closeLightboxBtn() {
        document.getElementById('lightbox').classList.remove('active');
        const vid = document.getElementById('lb-vid');
        vid.pause(); vid.src = '';
        document.getElementById('lb-img').src = '';
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeLightboxBtn();
    });

    // ── Edit Modal ──────────────────────────────────────────────────────────────
    function openEditModal(id, title, description, category) {
        document.getElementById('edit-title').value       = title;
        document.getElementById('edit-description').value = description;
        document.getElementById('edit-category').value    = category;
        document.getElementById('edit-form').action       = '/realisations/' + id;
        document.getElementById('edit-modal').classList.add('active');
    }

    function closeEditModal(e) {
        if (e.target === document.getElementById('edit-modal'))
            document.getElementById('edit-modal').classList.remove('active');
    }
</script>
@endsection
