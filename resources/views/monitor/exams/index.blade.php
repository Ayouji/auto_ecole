@extends('layouts.app')

@section('title', 'Gestion des Examens')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Gestion des Examens</h1>
        <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Créer un examen</a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 text-left">Titre</th>
                    <th class="py-2 px-4 text-left">Durée (min)</th>
                    <th class="py-2 px-4 text-left">Score de passage</th>
                    <th class="py-2 px-4 text-left">Questions</th>
                    <th class="py-2 px-4 text-left">Statut</th>
                    <th class="py-2 px-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($exams as $exam)
                <tr>
                    <td class="py-2 px-4">{{ $exam->title }}</td>
                    <td class="py-2 px-4">{{ $exam->time_limit }}</td>
                    <td class="py-2 px-4">{{ $exam->passing_score }}%</td>
                    <td class="py-2 px-4">{{ $exam->questions_count }}</td>
                    <td class="py-2 px-4">
                        <span class="px-2 py-1 rounded text-xs {{ $exam->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $exam->is_published ? 'Publié' : 'Brouillon' }}
                        </span>
                    </td>
                    <td class="py-2 px-4 flex space-x-2">
                        <a href="#" class="text-blue-600 hover:text-blue-800">Éditer</a>
                        <a href="#" class="text-green-600 hover:text-green-800">Questions</a>
                        <a href="#" class="text-red-600 hover:text-red-800">Supprimer</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection