@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-layer-group me-2"></i> Gestion des séries</h5>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createSerieModal">
            <i class="fas fa-plus me-1"></i> Nouvelle série
        </button>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($series->isEmpty())
            <div class="alert alert-info">
                Aucune série n'a été créée pour le moment.
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($series as $serie)
                <div class="col">
                    <div class="card h-100 {{ $serie->is_active ? 'border-success' : 'border-secondary' }}">
                        @if($serie->cover_image)
                            <img src="{{ asset('storage/' . $serie->cover_image) }}" class="card-img-top" alt="{{ $serie->title }}" style="height: 160px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 160px;">
                                <i class="fas fa-layer-group fa-3x text-secondary"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $serie->title }}</h5>
                            <p class="card-text small">{{ Str::limit($serie->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge {{ $serie->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $serie->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                <small class="text-muted">{{ $serie->questions_count ?? 0 }} questions</small>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent d-flex justify-content-between">
                            <button type="button" class="btn btn-sm btn-outline-primary edit-serie-btn" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editSerieModal" 
                                    data-serie-id="{{ $serie->id }}"
                                    data-serie-title="{{ $serie->title }}"
                                    data-serie-description="{{ $serie->description }}"
                                    data-serie-is-active="{{ $serie->is_active }}"
                                    data-serie-cover="{{ $serie->cover_image }}">
                                <i class="fas fa-edit"></i> Modifier
                            </button>
                            <a href="{{ route('monitor.series.show', $serie) }}" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-eye"></i> Voir
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger delete-serie-btn" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteSerieModal"
                                    data-serie-id="{{ $serie->id }}"
                                    data-serie-title="{{ $serie->title }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $series->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Création -->
<div class="modal fade" id="createSerieModal" tabindex="-1" aria-labelledby="createSerieModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('monitor.series.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="createSerieModalLabel">Créer une nouvelle série</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Titre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="cover_image" class="form-label">Image de couverture</label>
                        <input type="file" class="form-control @error('cover_image') is-invalid @enderror" id="cover_image" name="cover_image">
                        <small class="form-text text-muted">Formats acceptés: JPG, PNG, GIF. Max: 2MB</small>
                        @error('cover_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                        <label class="form-check-label" for="is_active">Activer cette série</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Créer la série</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Modification -->
<div class="modal fade" id="editSerieModal" tabindex="-1" aria-labelledby="editSerieModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editSerieForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editSerieModalLabel">Modifier la série</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_title" class="form-label">Titre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="edit_title" name="title" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="edit_description" name="description" rows="4"></textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <div id="current_cover_container" class="mb-2">
                            <label class="form-label">Image actuelle</label>
                            <div id="current_cover_preview" class="mb-2" style="max-width: 200px;"></div>
                        </div>
                        
                        <label for="edit_cover_image" class="form-label">Nouvelle image de couverture</label>
                        <input type="file" class="form-control @error('cover_image') is-invalid @enderror" id="edit_cover_image" name="cover_image">
                        <small class="form-text text-muted">Laissez vide pour conserver l'image actuelle. Formats acceptés: JPG, PNG, GIF. Max: 2MB</small>
                        @error('cover_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="edit_is_active" name="is_active">
                        <label class="form-check-label" for="edit_is_active">Activer cette série</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Suppression -->
<div class="modal fade" id="deleteSerieModal" tabindex="-1" aria-labelledby="deleteSerieModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteSerieForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteSerieModalLabel">Confirmer la suppression</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer la série <strong id="delete_serie_title"></strong> ?</p>
                    <p class="text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Cette action est irréversible et supprimera également toutes les questions associées.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion du modal d'édition
        const editButtons = document.querySelectorAll('.edit-serie-btn');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const serieId = this.getAttribute('data-serie-id');
                const serieTitle = this.getAttribute('data-serie-title');
                const serieDescription = this.getAttribute('data-serie-description');
                const serieIsActive = this.getAttribute('data-serie-is-active');
                const serieCover = this.getAttribute('data-serie-cover');
                
                // Mise à jour du formulaire
                document.getElementById('editSerieForm').action = `/monitor/series/${serieId}`;
                document.getElementById('edit_title').value = serieTitle;
                document.getElementById('edit_description').value = serieDescription;
                document.getElementById('edit_is_active').checked = serieIsActive === '1';
                
                // Affichage de l'image actuelle
                const coverPreview = document.getElementById('current_cover_preview');
                const coverContainer = document.getElementById('current_cover_container');
                
                if (serieCover) {
                    coverContainer.style.display = 'block';
                    coverPreview.innerHTML = `<img src="/storage/${serieCover}" class="img-fluid rounded" alt="${serieTitle}">`;
                } else {
                    coverContainer.style.display = 'none';
                }
            });
        });
        
        // Gestion du modal de suppression
        const deleteButtons = document.querySelectorAll('.delete-serie-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const serieId = this.getAttribute('data-serie-id');
                const serieTitle = this.getAttribute('data-serie-title');
                
                // Mise à jour du formulaire
                document.getElementById('deleteSerieForm').action = `/monitor/series/${serieId}`;
                document.getElementById('delete_serie_title').textContent = serieTitle;
            });
        });
    });
</script>
@endsection