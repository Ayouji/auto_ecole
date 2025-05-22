@extends('layouts.app')

@section('title', 'Tableau de bord Élève')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-6">Bienvenue, {{ Auth::user()->first_name }}</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-blue-100 p-4 rounded-lg shadow">
            <h3 class="font-bold text-blue-800">Séries disponibles</h3>
            <p class="text-2xl">{{ $stats['series_count'] }}</p>
            <a href="#" class="text-blue-600 hover:underline mt-2 inline-block">Voir toutes les séries</a>
        </div>
        
        <div class="bg-green-100 p-4 rounded-lg shadow">
            <h3 class="font-bold text-green-800">Cours disponibles</h3>
            <p class="text-2xl">{{ $stats['courses_count'] }}</p>
            <a href="#" class="text-green-600 hover:underline mt-2 inline-block">Voir tous les cours</a>
        </div>
        
        <div class="bg-yellow-100 p-4 rounded-lg shadow">
            <h3 class="font-bold text-yellow-800">Examens disponibles</h3>
            <p class="text-2xl">{{ $stats['exams_available'] }}</p>
            <a href="#" class="text-yellow-600 hover:underline mt-2 inline-block">Voir tous les examens</a>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gray-50 p-4 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Vos dernières tentatives d'examen</h2>
            @if($stats['recent_attempts']->count() > 0)
                <ul class="divide-y">
                    @foreach($stats['recent_attempts'] as $attempt)
                    <li class="py-2">
                        <div class="flex justify-between">
                            <span>{{ $attempt->exam->title }}</span>
                            <span class="{{ $attempt->is_passed ? 'text-green-600' : 'text-red-600' }}">
                                {{ $attempt->score }}%
                            </span>
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $attempt->completed_at->format('d/m/Y H:i') }}
                        </div>
                    </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">Vous n'avez pas encore passé d'examen.</p>
            @endif
        </div>
        
        <div class="bg-gray-50 p-4 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Cours recommandés</h2>
            @if($stats['recommended_courses']->count() > 0)
                <ul class="divide-y">
                    @foreach($stats['recommended_courses'] as $course)
                    <li class="py-2">
                        <a href="#" class="hover:text-blue-600">{{ $course->title }}</a>
                    </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">Aucun cours recommandé pour le moment.</p>
            @endif
        </div>
    </div>
</div>
@endsection