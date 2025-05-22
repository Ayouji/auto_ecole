@extends('layouts.app')

@section('title', 'Examen: ' . $exam->title)

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">{{ $exam->title }}</h1>
        <div class="text-xl font-mono" id="timer">{{ $exam->time_limit }}:00</div>
    </div>
    
    <div class="mb-6 bg-yellow-50 p-4 rounded-lg">
        <p class="font-bold">Instructions:</p>
        <ul class="list-disc pl-5 mt-2">
            <li>Vous avez {{ $exam->time_limit }} minutes pour compléter cet examen.</li>
            <li>Score de passage: {{ $exam->passing_score }}%</li>
            <li>Nombre de questions: {{ $questions->count() }}</li>
        </ul>
    </div>
    
    <form method="POST" action="#" id="exam-form">
        @csrf
        <input type="hidden" name="exam_attempt_id" value="{{ $attempt->id }}">
        
        @foreach($questions as $index => $question)
        <div class="mb-8 p-4 bg-gray-50 rounded-lg">
            <div class="flex items-start mb-4">
                <span class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center mr-3">{{ $index + 1 }}</span>
                <div>
                    <h3 class="text-lg font-bold">{{ $question->titre }}</h3>
                    <p>{{ $question->question_text }}</p>
                    
                    @if($question->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $question->image) }}" alt="Question image" class="max-w-full h-auto rounded">
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="ml-11">
                <div class="space-y-2">
                    @foreach($question->choices as $choice)
                    <div class="flex items-center">
                        <input type="radio" 
                               name="answers[{{ $question->id }}]" 
                               id="choice_{{ $choice->id }}" 
                               value="{{ $choice->id }}"
                               class="mr-2">
                        <label for="choice_{{ $choice->id }}" class="cursor-pointer">
                            <span class="font-bold mr-2">{{ $choice->letter }}.</span>
                            {{ $choice->choice_text }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
        
        <div class="mt-6 text-center">
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                Terminer l'examen
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Timer pour l'examen
    document.addEventListener('DOMContentLoaded', function() {
        let timeLimit = {{ $exam->time_limit * 60 }};
        const timerElement = document.getElementById('timer');
        
        const timer = setInterval(function() {
            timeLimit--;
            
            const minutes = Math.floor(timeLimit / 60);
            const seconds = timeLimit % 60;
            
            timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            if (timeLimit <= 0) {
                clearInterval(timer);
                document.getElementById('exam-form').submit();
            }
        }, 1000);
    });
</script>
@endpush
@endsection