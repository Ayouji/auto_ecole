@extends('layouts.app')

@section('title', 'Gestion des Cours')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Gestion des Cours</h1>
                <a href="{{ route('monitor.courses.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>Nouveau Cours
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="card-title mb-0">Liste des Cours</h5>
                        </div>
                        <div class="col-md-6">
                            <form action="{{ route('monitor.courses.index') }}" method="GET" class="d-flex">
                                <input type="text" name="search" class="form-control me-2" placeholder="Rechercher..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="bi bi-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($courses->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Titre</th>
                                        <th>Catégorie</th>
                                        <th>Sections</th>
                                        <th>Statut</th>
                                        <th>Dernière mise à jour</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($courses as $course)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($course->cover_image)
                                                        <img src="{{ Storage::url($course->cover_image) }}" alt="{{ $course->title }}" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                            <i class="bi bi-book text-secondary"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0">{{ $course->title }}</h6>
                                                        <small class="text-muted">{{ Str::limit($course->description, 50) }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($course->category)
                                                    <span class="badge bg-info">{{ $course->category->name }}</span>
                                                @else
                                                    <span class="badge bg-secondary">Non catégorisé</span>
                                                @endif
                                            </td>
                                            <td>{{ $course->sections_count ?? $course->sections->count() }}</td>
                                            <td>
                                                <span class="badge {{ $course->is_active ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $course->is_active ? 'Actif' : 'Inactif' }}
                                                </span>
                                            </td>
                                            <td>{{ $course->updated_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('monitor.courses.show', $course) }}" class="btn btn-outline-primary" title="Voir">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('monitor.courses.edit', $course) }}" class="btn btn-outline-secondary" title="Modifier">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-danger" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#deleteModal{{ $course->id }}" 
                                                            title="Supprimer">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                                
                                                <!-- Modal de confirmation de suppression -->
                                                <div class="modal fade" id="deleteModal{{ $course->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $course->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteModalLabel{{ $course->id }}">Confirmer la suppression</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Êtes-vous sûr de vouloir supprimer le cours <strong>{{ $course->title }}</strong> ? Cette action est irréversible.
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                                <form action="{{ route('monitor.courses.destroy', $course) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            {{ $courses->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <img src="{{ asset('images/empty-state.svg') }}" alt="Aucun cours" class="img-fluid mb-3" style="max-height: 200px;">
                            <h5>Aucun cours trouvé</h5>
                            <p class="text-muted">Commencez par créer votre premier cours en cliquant sur le bouton "Nouveau Cours".</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection