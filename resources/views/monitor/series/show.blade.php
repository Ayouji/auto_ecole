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

    .create-button {
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 10px 16px;
        border-radius: 8px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
        cursor: pointer;
    }

    .create-button:hover {
        background-color: #0c7cd5;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(30, 144, 255, 0.3);
    }

    .questions-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 20px;
        margin-top: 2rem;
    }

    .question-card {
        animation: fadeInUp 0.5s ease forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    .question-link {
        text-decoration: none;
        display: block;
    }

    .question-number {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(145deg, #f0f0f0, #d7d7d7);
        color: var(--dark-text);
        border-radius: 50%;
        font-size: 1.6rem;
        font-weight: 700;
        box-shadow: 5px 5px 15px #d1d1d1, -5px -5px 15px #ffffff;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .question-number::before {
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.8), transparent 70%);
        opacity: 0.6;
    }

    .question-number:hover {
        background: linear-gradient(145deg, #e8e8e8, #d0d0d0);
        color: var(--primary-color);
        transform: translateY(-5px);
        box-shadow: 7px 7px 20px #c3c3c3, -7px -7px 20px #ffffff;
    }

    .question-number::after {
        content: "";
        position: absolute;
        bottom: -2px;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 4px;
        background: var(--primary-color);
        transition: var(--transition);
        border-radius: 3px;
    }

    .question-number:hover::after {
        width: 40%;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        background-color: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        margin-top: 2rem;
    }

    .empty-icon {
        font-size: 4rem;
        color: #d0d0d0;
        margin-bottom: 1rem;
    }

    /* Nouvelles classes pour l'affichage de la série */
    .serie-header {
        background-color: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .serie-header::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    }

    .serie-title {
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 0.5rem;
    }

    .serie-description {
        color: var(--muted-text);
        margin-bottom: 1.5rem;
    }

    .serie-stats {
        display: flex;
        gap: 2rem;
        margin-top: 1.5rem;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: var(--primary-light);
        color: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .stat-info h4 {
        font-size: 0.9rem;
        color: var(--muted-text);
        margin-bottom: 0.2rem;
    }

    .stat-info p {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--dark-text);
        margin: 0;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .questions-container {
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            gap: 15px;
        }

        .question-number {
            width: 70px;
            height: 70px;
            font-size: 1.4rem;
        }
        
        .serie-stats {
            flex-direction: column;
            gap: 1rem;
        }
    }
</style>
<div class="container py-5">
    <!-- En-tête de la série -->
    <div class="serie-header">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h1 class="serie-title">{{ $serie->title }}</h1>
                <p class="serie-description">{{ $serie->description }}</p>
            </div>
            <a href="{{ route('monitor.series.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour aux séries
            </a>
        </div>
        
        <div class="serie-stats">
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-question"></i>
                </div>
                <div class="stat-info">
                    <h4>Questions</h4>
                    <p>{{ $questions->count() }}</p>
                </div>
            </div>
            
            <div class="stat-item">
                <div class="stat-icon" style="background-color: var(--secondary-light); color: var(--secondary-color);">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h4>Temps estimé</h4>
                    <p>{{ $questions->count() * 2 }} minutes</p>
                </div>
            </div>
            
            <div class="stat-item">
                <div class="stat-icon" style="background-color: #fff3cd; color: #ffc107;">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-info">
                    <h4>Difficulté</h4>
                    <p>{{ $serie->difficulty ?? 'Moyenne' }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title mb-0">Liste des questions</h2>
        <button type="button" class="create-button" data-bs-toggle="modal" data-bs-target="#createQuestionModal">
            <i class="fas fa-plus"></i> Ajouter une question
        </button>
    </div>
    
    @if($questions->isNotEmpty())
        <div class="questions-container">
            @foreach($questions as $index => $question)
                <div class="question-card" style="animation-delay: {{ 0.05 * $index }}s;">
                    <a href="{{ route('monitor.questions.show', $question->id) }}" class="question-link">
                        <div class="question-number">{{ $loop->iteration }}</div>
                    </a>
                </div>
            @endforeach
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $questions->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-question-circle"></i>
            </div>
            <h3 class="text-muted">Aucune question disponible</h3>
            <p class="text-muted">Cette série ne contient pas encore de questions</p>
            <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#createQuestionModal">
                <i class="fas fa-plus me-2"></i>Ajouter votre première question
            </button>
        </div>
    @endif
</div>

@include('components.questions.create')

@endsection