@extends('layouts.dashboard')

@section('dashboard-content')
<div class="card">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-layer-group me-2"></i> Série: {{ $serie->title }}</h5>
        <a href="{{ route('eleve.series.index') }}" class="btn btn-light btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Retour aux séries
        </a>
    </div>
    
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-4">
                @if($serie->cover_image)
                    <img src="{{ asset('storage/' . $serie->cover_image) }}" class="img-fluid rounded" alt="{{ $serie->title }}">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 200px;">
                        <i class="fas fa-layer-group fa-4x text-secondary"></i>
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <h3>{{ $serie->title }}</h3>
                <p>{{ $serie->description }}</p>
                <div class="d-flex align-items-center">
                    <span class="badge bg-primary me-2">{{ $serie->questions->count() }} questions</span>
                </div>
                
                <div class="mt-4">
                    <button type="button" class="btn btn-success btn-lg" id="startSerieBtn">
                        <i class="fas fa-play me-2"></i> Commencer l'entraînement
                    </button>
                </div>
            </div>
        </div>
        
        <div class="card mt-3" id="questionContainer" style="display: none;">
            <div class="card-header bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Question <span id="currentQuestionNum">1</span>/<span id="totalQuestions">{{ $serie->questions->count() }}</span></h5>
                    <div>
                        <span id="timer" class="badge bg-secondary">00:00</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="questionContent"></div>
                
                <div id="questionImage" class="text-center my-3" style="display: none;">
                    <img src="" alt="Question Image" class="img-fluid rounded" style="max-height: 300px;">
                </div>
                
                <div id="questionAudio" class="text-center my-3" style="display: none;">
                    <audio controls class="w-100">
                        <source src="" type="audio/mpeg">
                        Votre navigateur ne supporte pas l'élément audio.
                    </audio>
                </div>
                
                <div class="mt-4">
                    <div id="choicesContainer" class="list-group"></div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" id="prevQuestionBtn" disabled>
                    <i class="fas fa-arrow-left me-1"></i> Précédent
                </button>
                <button type="button" class="btn btn-primary" id="nextQuestionBtn">
                    Suivant <i class="fas fa-arrow-right ms-1"></i>
                </button>
                <button type="button" class="btn btn-success" id="finishBtn" style="display: none;">
                    Terminer <i class="fas fa-check ms-1"></i>
                </button>
            </div>
        </div>
        
        <div class="card mt-3" id="resultContainer" style="display: none;">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Résultats</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <h3>Votre score</h3>
                    <div class="display-4 fw-bold" id="scoreDisplay">0/0</div>
                    <div class="progress mt-3">
                        <div class="progress-bar bg-success" id="scoreProgressBar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <h5>Détails des réponses</h5>
                    <div id="questionsReview"></div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button type="button" class="btn btn-primary me-2" id="restartBtn">
                    <i class="fas fa-redo me-1"></i> Recommencer
                </button>
                <a href="{{ route('eleve.series.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list me-1"></i> Toutes les séries
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Données des questions
        const questions = @json($serie->questions);
        let currentQuestionIndex = 0;
        let userAnswers = [];
        let startTime = null;
        let timerInterval = null;
        
        // Éléments DOM
        const startSerieBtn = document.getElementById('startSerieBtn');
        const questionContainer = document.getElementById('questionContainer');
        const resultContainer = document.getElementById('resultContainer');
        const currentQuestionNum = document.getElementById('currentQuestionNum');
        const totalQuestions = document.getElementById('totalQuestions');
        const questionContent = document.getElementById('questionContent');
        const questionImage = document.getElementById('questionImage');
        const questionAudio = document.getElementById('questionAudio');
        const choicesContainer = document.getElementById('choicesContainer');
        const prevQuestionBtn = document.getElementById('prevQuestionBtn');
        const nextQuestionBtn = document.getElementById('nextQuestionBtn');
        const finishBtn = document.getElementById('finishBtn');
        
        // Initialisation
        startSerieBtn.addEventListener('click', startSerie);
        prevQuestionBtn.addEventListener('click', showPreviousQuestion);
        nextQuestionBtn.addEventListener('click', showNextQuestion);
        finishBtn.addEventListener('click', showResults);
        document.getElementById('restartBtn').addEventListener('click', startSerie);
        
        // Démarrer la série
        function startSerie() {
            startSerieBtn.style.display = 'none';
            questionContainer.style.display = 'block';
            resultContainer.style.display = 'none';
            
            currentQuestionIndex = 0;
            userAnswers = Array(questions.length).fill(null);
            
            showQuestion(currentQuestionIndex);
            startTimer();
        }
        
        // Afficher une question
        function showQuestion(index) {
            const question = questions[index];
            
            currentQuestionNum.textContent = index + 1;
            questionContent.innerHTML = `<p class="fs-5">${question.content}</p>`;
            
            // Afficher l'image si disponible
            if (question.image_path) {
                questionImage.style.display = 'block';
                questionImage.querySelector('img').src = `/storage/${question.image_path}`;
            } else {
                questionImage.style.display = 'none';
            }
            
            // Afficher l'audio si disponible
            if (question.audio_path) {
                questionAudio.style.display = 'block';
                questionAudio.querySelector('audio source').src = `/storage/${question.audio_path}`;
                questionAudio.querySelector('audio').load();
            } else {
                questionAudio.style.display = 'none';
            }
            
            // Afficher les choix
            choicesContainer.innerHTML = '';
            question.choices.forEach((choice, choiceIndex) => {
                const isSelected = userAnswers[index] === choiceIndex;
                
                const choiceElement = document.createElement('button');
                choiceElement.className = `list-group-item list-group-item-action d-flex align-items-center ${isSelected ? 'active' : ''}`;
                choiceElement.innerHTML = `
                    <div class="me-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="choice" id="choice${choiceIndex}" ${isSelected ? 'checked' : ''}>
                            <label class="form-check-label" for="choice${choiceIndex}"></label>
                        </div>
                    </div>
                    <div>${choice.content}</div>
                `;
                
                choiceElement.addEventListener('click', () => {
                    userAnswers[index] = choiceIndex;
                    
                    // Mettre à jour l'UI
                    choicesContainer.querySelectorAll('.list-group-item').forEach(item => {
                        item.classList.remove('active');
                        item.querySelector('input').checked = false;
                    });
                    
                    choiceElement.classList.add('active');
                    choiceElement.querySelector('input').checked = true;
                });
                
                choicesContainer.appendChild(choiceElement);
            });
            
            // Mettre à jour les boutons de navigation
            prevQuestionBtn.disabled = index === 0;
            
            if (index === questions.length - 1) {
                nextQuestionBtn.style.display = 'none';
                finishBtn.style.display = 'block';
            } else {
                nextQuestionBtn.style.display = 'block';
                finishBtn.style.display = 'none';
            }
        }
        
        // Afficher la question précédente
        function showPreviousQuestion() {
            if (currentQuestionIndex > 0) {
                currentQuestionIndex--;
                showQuestion(currentQuestionIndex);
            }
        }
        
        // Afficher la question suivante
        function showNextQuestion() {
            if (currentQuestionIndex < questions.length - 1) {
                currentQuestionIndex++;
                showQuestion(currentQuestionIndex);
            }
        }
        
        // Démarrer le chronomètre
        function startTimer() {
            startTime = new Date();
            
            const timerElement = document.getElementById('timer');
            
            clearInterval(timerInterval);
            timerInterval = setInterval(() => {
                const elapsedTime = Math.floor((new Date() - startTime) / 1000);
                const minutes = Math.floor(elapsedTime / 60).toString().padStart(2, '0');
                const seconds = (elapsedTime % 60).toString().padStart(2, '0');
                
                timerElement.textContent = `${minutes}:${seconds}`;
            }, 1000);
        }
        
        // Afficher les résultats
        function showResults() {
            clearInterval(timerInterval);
            
            questionContainer.style.display = 'none';
            resultContainer.style.display = 'block';
            
            // Calculer le score
            let correctAnswers = 0;
            
            questions.forEach((question, index) => {
                const userAnswerIndex = userAnswers[index];
                
                if (userAnswerIndex !== null) {
                    const