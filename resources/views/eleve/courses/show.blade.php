@extends('layouts.app')

@section('title', $course->title)

@section('styles')
<style>
    .course-header {
        position: relative;
        background-size: cover;
        background-position: center;
        height: 300px;
        color: white;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .course-header-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.8));
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 2rem;
    }
    
    .section-card {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }
    
    .section-card:hover {
        transform: translateY(-5px);
        border-left: 4px solid #0d6efd;
    }
    
    .section-content img {
        max-width: 100%;
        height: auto;
    }
    
    .progress-container {
        height: 8px;
        width: 100%;
        background-color: #e9ecef;
        border-radius: 4px;
        margin-bottom: 1rem;
    }
    
    .progress-bar {
        height: 100%;
        border-radius: 4px;
        background-color: #0d6efd;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <!-- En-tête du cours -->
    <div class="course-header mb-4" style="background-image: url('{{ $course->cover_image ? Storage::url($course->cover_image) : asset('images/default-course.jpg') }}')">
        <div class="course-header-overlay">
            <div class="d-flex justify-content-between align-items-end">
                <div>
                    <h1 class="display-5 fw-bold">{{ $course->title }}</h1>
                    @if($course->category)
                        <span class="badge bg-info fs-6 mb-2">{{ $course->category->title }}</span>
                    @endif
                </div>
                <div>
                    @if($course->pdf_file)
                        <a href="{{ Storage::url($course->pdf_file) }}" class="btn btn-light" target="_blank">
                            <i class="bi bi-file-earmark-pdf me-2"></i>Télécharger le PDF
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Contenu principal -->
        <div class="col-lg-8">
            <!-- Progression du cours -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Votre progression</h5>
                    <div class="progress-container">
                        <div class="progress-bar" style="width: 30%;"></div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">30% complété</span>
                        <span class="text-muted">{{ $course->sections->count() }} sections</span>
                    </div>
                </div>
            </div>
            
            <!-- Description du cours -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">À propos de ce cours</h5>
                    <p class="card-text">{{ $course->description }}</p>
                </div>
            </div>
            
            <!-- Sections du cours -->
            <h5 class="mb-3"><i class="bi bi-journal-text me-2"></i>Contenu du cours</h5>
            
            @if($course->sections->count() > 0)
                <div class="sections-list">
                    @foreach($course->sections as $index => $section)
                        <div class="card section-card mb-3 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0">
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        {{ $section->title }}
                                    </h5>
                                    <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#sectionContent{{ $section->id }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="sectionContent{{ $section->id }}">
                                        <i class="bi bi-chevron-down"></i>
                                    </button>
                                </div>
                                
                                <div class="collapse {{ $index === 0 ? 'show' : '' }}" id="sectionContent{{ $section->id }}">
                                    <div class="section-content mb-4">
                                        {!! $section->content !!}
                                    </div>
                                    
                                    @if($section->media->count() > 0)
                                        <h6 class="fw-bold mb-3"><i class="bi bi-paperclip me-2"></i>Ressources supplémentaires</h6>
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
                                                                <i class="bi bi-download me-1"></i>Télécharger
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>Aucune section n'est disponible pour ce cours.
                </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Carte d'information -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Informations du cours</h5>
                    
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary rounded-circle p-2 me-3 text-white">
                            <i class="bi bi-layers"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Sections</h6>
                            <p class="text-muted mb-0">{{ $course->sections->count() }} sections</p>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success rounded-circle p-2 me-3 text-white">
                            <i class="bi bi-clock"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Durée estimée</h6>
                            <p class="text-muted mb-0">2 heures</p>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-info rounded-circle p-2 me-3 text-white">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Dernière mise à jour</h6>
                            <p class="text-muted mb-0">{{ $course->updated_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 mt-4">
                        <button class="btn btn-success">
                            <i class="bi bi-check-circle me-2"></i>Marquer comme terminé
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Autres cours recommandés -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Cours recommandés</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <!-- Ici, vous pourriez ajouter une boucle pour afficher d'autres cours de la même catégorie -->
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center border-0 py-3">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('images/default-course.jpg') }}" alt="Cours" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0">Cours similaire 1</h6>
                                <small class="text-muted">5 sections</small>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center border-0 py-3">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('images/default-course.jpg') }}" alt="Cours" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0">Cours similaire 2</h6>
                                <small class="text-muted">3 sections</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Script pour marquer les sections comme complétées
    document.addEventListener('DOMContentLoaded', function() {
        // Ici, vous pourriez ajouter du code JavaScript pour gérer la progression
    });
</script>
@endsection