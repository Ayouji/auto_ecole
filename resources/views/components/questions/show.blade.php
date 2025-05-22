@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Question counter -->
            <div class="text-center mb-3">
                <div class="d-inline-block bg-primary text-white px-4 py-2 rounded-pill">
                    <strong>Question {{ $question->order }}</strong>
                </div>
            </div>
            
            <!-- Question content -->
            <div class="card shadow-sm">
                <!-- Question image if available -->
                @if($question->image)
                <div class="question-image bg-light p-3 text-center">
                    <img src="{{ asset('storage/'.$question->image) }}" alt="Question image" class="img-fluid rounded">
                </div>
                @endif
                
                <!-- Question text -->
                <div class="card-body">
                    <h4 class="question-title mb-4">{{ $question->titre }}</h4>
                    <div class="question-content mb-4">
                        {!! $question->question_text !!}
                    </div>
                    
                    <!-- Audio controls if available -->
                    @if($question->audio)
                    <div class="audio-controls mb-4 text-center">
                        <audio controls class="w-100">
                            <source src="{{ asset('storage/'.$question->audio) }}" type="audio/mpeg">
                            Votre navigateur ne supporte pas l'élément audio.
                        </audio>
                    </div>
                    @endif
                    
                    <!-- Answer choices -->
                    <form action="{{ route('questions.submit', $question->id) }}" method="POST">
                        @csrf
                        <div class="question-choices row">
                            @foreach($question->choices->sortBy('order') as $index => $choice)
                                <div class="col-md-6 mb-3">
                                    <div class="choice-container border rounded p-3 @if(old('answer') == $choice->id) border-primary @endif">
                                        <div class="form-check m-0">
                                            @if($question->is_multiple)
                                                <input class="form-check-input" type="checkbox" name="answers[]" 
                                                    id="choice-{{ $choice->id }}" value="{{ $choice->id }}"
                                                    {{ in_array($choice->id, old('answers', [])) ? 'checked' : '' }}>
                                            @else
                                                <input class="form-check-input" type="radio" name="answer" 
                                                    id="choice-{{ $choice->id }}" value="{{ $choice->id }}"
                                                    {{ old('answer') == $choice->id ? 'checked' : '' }}>
                                            @endif
                                            
                                            <label class="form-check-label w-100" for="choice-{{ $choice->id }}">
                                                <div class="d-flex align-items-center">
                                                    <div class="choice-letter bg-light rounded-circle d-flex align-items-center justify-content-center me-2" 
                                                        style="width: 30px; height: 30px;">
                                                        <strong>{{ $choice->letter }}</strong>
                                                    </div>
                                                    <div>{{ $choice->choice_text }}</div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Validation button -->
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary px-5 py-2">
                                Valider la réponse
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Navigation controls -->
            <div class="d-flex justify-content-between mt-4">
                @if($previousQuestion)
                    <a href="{{ route('questions.show', $previousQuestion->id) }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i> Question précédente
                    </a>
                @else
                    <div></div>
                @endif
                
                @if($nextQuestion)
                    <a href="{{ route('questions.show', $nextQuestion->id) }}" class="btn btn-outline-primary ms-auto">
                        Question suivante <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                @else
                    <a href="{{ route('quiz.results') }}" class="btn btn-success ms-auto">
                        Voir les résultats <i class="fas fa-chart-bar ms-2"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
{{-- @endsection

@push('styles') --}}
<style>
    .choice-container {
        transition: all 0.2s ease;
        cursor: pointer;
        background-color: #f8f9fa;
    }
    
    .choice-container:hover {
        border-color: #0d6efd !important;
        background-color: #e9f0ff;
    }
    
    .form-check-input:checked + .form-check-label .choice-container {
        border-color: #0d6efd !important;
        background-color: #e9f0ff;
    }
    
    .choice-letter {
        transition: all 0.2s ease;
    }
    
    .form-check-input:checked + .form-check-label .choice-letter {
        background-color: #0d6efd !important;
        color: white;
    }
    
    .question-title {
        color: #2c3e50;
        font-weight: 600;
    }
    
    .question-content {
        font-size: 1.1rem;
        line-height: 1.6;
    }
</style>
{{-- @endpush

@push('scripts') --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Make the entire choice container clickable
        document.querySelectorAll('.choice-container').forEach(function(container) {
            container.addEventListener('click', function(e) {
                // Ne pas déclencher si on clique sur un lien ou un bouton
                if (e.target.tagName === 'A' || e.target.tagName === 'BUTTON') return;
                
                const input = this.querySelector('input[type="radio"], input[type="checkbox"]');
                if (input) {
                    if (input.type === 'radio') {
                        // Désélectionner tous les autres radios
                        document.querySelectorAll(`input[name="${input.name}"]`).forEach(radio => {
                            radio.checked = false;
                            radio.dispatchEvent(new Event('change'));
                        });
                        input.checked = true;
                    } else {
                        input.checked = !input.checked;
                    }
                    
                    // Trigger change event
                    input.dispatchEvent(new Event('change'));
                }
            });
        });
    });
</script>
@endpush