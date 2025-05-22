@extends('layouts.app')

@section('content')
@php
    use Illuminate\Support\Facades\Storage;
@endphp
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    :root {
        --primary-color: #1e90ff;
        --primary-light: #e6f2ff;
        --secondary-color: #4CAF50;
        --secondary-light: #ebf7ec;
        --light-bg: #f8f9fa;
        --dark-text: #333;
        --muted-text: #6c757d;
        --border-radius: 12px;
        --box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        --transition: all 0.3s ease;
    }

    .page-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 1.5rem;
        position: relative;
        padding-bottom: 0.5rem;
    }

    .page-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: var(--primary-color);
        border-radius: 2px;
    }

    .series-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .series-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        overflow: hidden;
        transition: var(--transition);
        border: 1px solid rgba(0,0,0,0.05);
        height: 100%;
        display: flex;
        flex-direction: column;
        cursor: pointer;
    }

    .series-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
    }

    .card-link {
        text-decoration: none;
        color: inherit;
        display: block;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .card-link:hover .card-title {
        color: var(--primary-color);
    }

    .card-header {
        background: linear-gradient(45deg, var(--primary-color), #4dabff);
        color: white;
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .card-header::before {
        content: "";
        position: absolute;
        top: -15px;
        right: -15px;
        background: rgba(255,255,255,0.15);
        width: 100px;
        height: 100px;
        border-radius: 50%;
    }

    .card-header::after {
        content: "";
        position: absolute;
        bottom: -25px;
        left: -25px;
        background: rgba(255,255,255,0.1);
        width: 80px;
        height: 80px;
        border-radius: 50%;
    }

    .card-icon {
        font-size: 2rem;
        margin-bottom: 0.8rem;
        position: relative;
        z-index: 1;
    }

    .card-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 0.2rem;
        position: relative;
        z-index: 1;
    }

    .card-desc {
        font-size: 0.9rem;
        opacity: 0.9;
        margin-bottom: 0;
        position: relative;
        z-index: 1;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-content {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .stats-container {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }

    .stats-item {
        display: flex;
        align-items: center;
        background: var(--primary-light);
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 0.85rem;
        color: var(--primary-color);
        font-weight: 500;
        margin-right: 10px;
    }

    .stats-item i {
        margin-right: 6px;
    }

    .card-status {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
        margin-top: auto;
    }

    .status-active {
        background: var(--secondary-light);
        color: var(--secondary-color);
    }

    .status-inactive {
        background: #fff1f1;
        color: #e74c3c;
    }

    .card-footer {
        padding: 1rem 1.5rem;
        background: #fafafa;
        border-top: 1px solid rgba(0,0,0,0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-actions {
        display: flex;
        gap: 10px;
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: var(--transition);
        background: white;
        border: 1px solid rgba(0,0,0,0.1);
        color: var(--dark-text);
        z-index: 10;
        position: relative;
    }

    .btn-icon:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .create-button {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: var(--border-radius);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
    }

    .create-button:hover {
        background: #0c7cd5;
        transform: translateY(-2px);
    }

    .badge-questions {
        background: var(--primary-light);
        color: var(--primary-color);
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .series-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }
    }

    @media (max-width: 576px) {
        .series-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .series-card {
        animation: fadeIn 0.4s ease-out;
        animation-fill-mode: backwards;
    }

    .series-grid .series-card:nth-child(1) { animation-delay: 0.1s; }
    .series-grid .series-card:nth-child(2) { animation-delay: 0.2s; }
    .series-grid .series-card:nth-child(3) { animation-delay: 0.3s; }
    .series-grid .series-card:nth-child(4) { animation-delay: 0.4s; }
    .series-grid .series-card:nth-child(5) { animation-delay: 0.5s; }
    /* and so on... */
</style>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title mb-0">Séries d'apprentissage</h1>
        <button type="button" class="create-button" data-bs-toggle="modal" data-bs-target="#createSeriesModal">
            <i class="fas fa-plus"></i> Nouvelle série
        </button>
    </div>

    <div class="series-grid">
        @foreach ($series as $serie)
            <div class="series-card">
                <a href="{{route('monitor.sereis')}}" class="card-link">
                    <div class="card-header" style="background-image: url('{{ $serie->cover_image ? Storage::url($serie->cover_image) : 'https://via.placeholder.com/300x150' }}'); background-size: cover; background-position: center;">
                        <div class="card-icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h3 class="card-title">{{ $serie->title }}</h3>
                        <p class="card-desc">{{ $serie->description ?? 'Aucune description disponible' }}</p>
                    </div>
                    <div class="card-content">
                        <div class="stats-container">
                            <div class="stats-item">
                                <i class="fas fa-question-circle"></i>
                                {{ $serie->questions->count() }} Questions
                            </div>
                        </div>
                        
                        <div class="card-status {{ $serie->is_active ? 'status-active' : 'status-inactive' }}">
                            <i class="fas {{ $serie->is_active ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                            {{ $serie->is_active ? 'Actif' : 'Inactif' }}
                        </div>
                    </div>
                </a>
                <div class="card-footer">
                    <span class="text-muted small">Créé le {{ $serie->created_at->format('d/m/Y') }}</span>
                    <div class="card-actions">
                        <button class="btn-icon" data-bs-toggle="modal" data-bs-target="#editSeriesModal-{{ $serie->id }}" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-icon" data-bs-toggle="modal" data-bs-target="#deleteSeriesModal-{{ $serie->id }}" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($series->isEmpty())
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-folder-open fa-3x text-muted"></i>
            </div>
            <h3 class="text-muted">Aucune série disponible</h3>
            <p class="text-muted">Commencez par créer une nouvelle série d'apprentissage</p>
        </div>
    @endif

    <div class="d-flex justify-content-center mt-4">
        {{ $series->links('pagination::bootstrap-4') }}
    </div>
</div>

@include('components.series.create')
@include('components.series.edit')
@include('components.series.delete')

<script>
    // Empêcher les clics sur les boutons d'action de déclencher le lien parent
    document.addEventListener('DOMContentLoaded', function() {
        const actionButtons = document.querySelectorAll('.card-actions button');
        actionButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
            });
        });
    });
</script>

@endsection