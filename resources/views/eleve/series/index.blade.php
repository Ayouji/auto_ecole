@extends('layouts.dashboard')

@section('dashboard-content')
<div class="card">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0"><i class="fas fa-layer-group me-2"></i> Séries d'entraînement</h5>
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
                Aucune série d'entraînement n'est disponible pour le moment.
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($series as $serie)
                <div class="col">
                    <div class="card h-100">
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
                            <div class="d-flex justify-content-end align-items-center">
                                <small class="text-muted">{{ $serie->questions->count() }} questions</small>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent text-center">
                            <a href="{{ route('eleve.series.show', $serie) }}" class="btn btn-success">
                                <i class="fas fa-play me-1"></i> Commencer
                            </a>
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
@endsection