@extends('layouts.app')

@section('title', $course->title)

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">{{ $course->title }}</h1>
                <div>
                    <a href="{{ route('monitor.courses.edit', $course) }}" class="btn btn-primary me-2">
                        <i class="bi bi-pencil-square me-1"></i>Modifier
                    </a>
                    <a href="{{ route('monitor.courses.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Retour à la liste
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Contenu principal du cours -->
        <div class="col-lg-8">
            <!-- Carte d'aperçu du cours -->
            <div class="card mb-4 border-0 shadow-sm">
                @if($course->cover_image)
                <div class="position-relative">
                    <img src="{{ Storage::url($course->cover_image) }}" alt="{{ $course->title }}" class="card-img-top" style="height: 250px; object-fit: cover;">
                    <div class="position-absolute bottom-0 start-0 w-100 p-3" style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
                        <h2 class="text-white mb-0">{{ $course->title }}</h2>
                    </div>
                </div>
                @endif
                <div class="card-body">
                    <div class="mb-4">
                        <h5 class="card-title">Description</h5>
                        <p class="card-text">{{ $course->description }}</p>
                    </div>
                    
                    <div class="course-sections">
                        <h5 class="card-title d-flex align-items-center">
                            <i class="bi bi-list-ul me-2"></i>Contenu du cours
                        </h5>
                        
                        @if($course->sections->count() > 0)
                            <div class="accordion accordion-flush" id="courseSections">
                                @foreach($course->sections as $index => $section)
                                    <div class="accordion-item border mb-2 rounded">
                                        <h2 class="accordion-header" id="heading{{ $section->id }}">
                                            <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }} fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $section->id }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $section->id }}">
                                                <i class="bi bi-book me-2"></i>{{ $section->title }}
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $section->id }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $section->id }}" data-bs-parent="#courseSections">
                                            <div class="accordion-body">
                                                <div class="section-content mb-4">
                                                    {!! $section->content !!}
                                                </div>
                                                
                                                @if($section->media->count() > 0)
                                                    <div class="section-media">
                                                        <h6 class="fw-bold"><i class="bi bi-paperclip me-2"></i>Médias associés</h6>
                                                        <div class="row g-3">
                                                            @foreach($section->media as $media)
                                                                <div class="col-md-4">
                                                                    <div class="card h-100 border-0 shadow-sm">
                                                                        @if($media->type == 'image')
                                                                            <img src="{{ Storage::url($media->file_path) }}" class="card-img-top" alt="{{ $media->title }}" style="height: 120px; object-fit: cover;">
                                                                        @elseif($media->type == 'video')
                                                                            <div class="ratio ratio-16x9">
                                                                                <iframe src="{{ $media->file_path }}" title="{{ $media->title }}" allowfullscreen></iframe>
                                                                            </div>
                                                                        @elseif($media->type == 'document')
                                                                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 120px;">
                                                                                <i class="bi bi-file-earmark-text display-4"></i>
                                                                            </div>
                                                                        @endif
                                                                        <div class="card-body">
                                                                            <h6 class="card-title">{{ $media->title }}</h6>
                                                                            <a href="{{ Storage::url($media->file_path) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                                                                <i class="bi bi-eye me-1"></i>Voir
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>Aucune section n'a été créée pour ce cours.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar avec informations et actions -->
        <div class="col-lg-4">
            <!-- Informations du cours -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0"><i class="bi bi-info-circle me-2"></i>Informations</h5>
                </div>
                <div class="card-body">
                    @if($course->pdf_file)
                    <div class="mb-3 text-center">
                        <a href="{{ Storage::url($course->pdf_file) }}" class="btn btn-outline-primary w-100" target="_blank">
                            <i class="bi bi-file-earmark-pdf me-2"></i>Télécharger le PDF du cours
                        </a>
                    </div>
                    <hr>
                    @endif
                    
                    <div class="mb-3">
                        <h6 class="text-muted mb-1"><i class="bi bi-tag me-2"></i>Catégorie</h6>
                        @if($course->category)
                            <span class="badge bg-info">{{ $course->category->title }}</span>
                        @else
                            <span class="badge bg-secondary">Non catégorisé</span>
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted mb-1"><i class="bi bi-layers me-2"></i>Nombre de sections</h6>
                        <p class="mb-0 fw-bold">{{ $course->sections->count() }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted mb-1"><i class="bi bi-calendar-plus me-2"></i>Créé le</h6>
                        <p class="mb-0">{{ $course->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted mb-1"><i class="bi bi-calendar-check me-2"></i>Dernière mise à jour</h6>
                        <p class="mb-0">{{ $course->updated_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    
                    <div class="mb-0">
                        <h6 class="text-muted mb-1"><i class="bi bi-toggle-on me-2"></i>Statut</h6>
                        @if($course->is_active)
                            <span class="badge bg-success">Actif</span>
                        @else
                            <span class="badge bg-danger">Inactif</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0"><i class="bi bi-gear me-2"></i>Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('monitor.courses.edit', $course) }}" class="btn btn-primary">
                            <i class="bi bi-pencil-square me-2"></i>Modifier le cours
                        </a>
                        
                        <form action="" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-{{ $course->is_active ? 'warning' : 'success' }} w-100">
                                <i class="bi bi-toggle-{{ $course->is_active ? 'off' : 'on' }} me-2"></i>
                                {{ $course->is_active ? 'Désactiver' : 'Activer' }} le cours
                            </button>
                        </form>
                        
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="bi bi-trash me-2"></i>Supprimer le cours
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer ce cours ? Cette action est irréversible.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('monitor.courses.destroy', $course) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection