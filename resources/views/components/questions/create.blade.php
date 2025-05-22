<div class="modal fade" id="createQuestionModal" tabindex="-1" aria-labelledby="createQuestionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="createQuestionModalLabel">
                    <i class="bi bi-question-circle me-2"></i>Créer une nouvelle question
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="questionForm" method="POST" action="{{ route('monitor.questions.store') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Série -->
                        <div class="col-12">
                            <div class="form-floating">
                                <select class="form-select" id="serie_id" name="serie_id" required>
                                    <option value="">Sélectionnez</option>
                                    {{-- @foreach ($series as $serie)
                                        <option value="{{ $serie->id }}">{{ $serie->title }}</option>
                                    @endforeach --}}
                                </select>
                                <label for="serie_id">Série</label>
                            </div>
                        </div>

                        <!-- Titre -->
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="titre" name="titre" required
                                    placeholder="Titre">
                                <label for="titre">Titre de la question</label>
                            </div>
                        </div>

                        <!-- Texte de la question -->
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" id="question_text" name="question_text" rows="3" placeholder="Texte de la question"
                                    style="height: 100px"></textarea>
                                <label for="question_text">Texte de la question (optionnel)</label>
                            </div>
                        </div>

                        <!-- Options de la question -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="bi bi-image me-2"></i>Image
                                    </h6>
                                    <div class="input-group">
                                        <input class="form-control" type="file" id="image" name="image"
                                            accept="image/*">
                                        <label class="input-group-text" for="image">
                                            <i class="bi bi-upload"></i>
                                        </label>
                                    </div>
                                    <div id="imagePreview" class="mt-2 text-center d-none">
                                        <img src="" alt="Aperçu" class="img-fluid img-thumbnail"
                                            style="max-height: 150px">
                                        <button type="button" class="btn btn-sm btn-outline-danger mt-1"
                                            id="removeImageBtn">
                                            <i class="bi bi-trash"></i> Supprimer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="bi bi-list-check me-2"></i>Type de question
                                    </h6>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="is_multiple"
                                            name="is_multiple" value="1">
                                        <label class="form-check-label" for="is_multiple">
                                            Question à choix multiple
                                        </label>
                                    </div>
                                    <small class="text-muted">Active cette option si plusieurs réponses peuvent être
                                        correctes</small>
                                </div>
                            </div>
                        </div>

                        <!-- Audio -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="bi bi-soundwave me-2"></i>Audio de la question
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="audio-management-container">
                                        <!-- Contrôles Audio -->
                                        <div class="audio-controls mb-3">
                                            <div class="btn-group w-100" role="group">
                                                <button type="button" class="btn btn-primary" id="recordAudioBtn">
                                                    <i class="bi bi-mic-fill me-1"></i> Enregistrer
                                                </button>
                                                <button type="button" class="btn btn-secondary" id="uploadAudioBtn">
                                                    <i class="bi bi-upload me-1"></i> Importer
                                                </button>
                                                <button type="button" class="btn btn-info text-white"
                                                    id="generateAudioBtn">
                                                    <i class="bi bi-robot me-1"></i> Générer
                                                </button>
                                            </div>
                                            <input type="file" id="audioFileInput" name="audio"
                                                accept="audio/*" class="d-none">
                                            <input type="hidden" id="audioPath" name="audio_path">
                                        </div>

                                        <!-- Prévisualisation Audio -->
                                        <div class="audio-preview-container bg-white rounded p-3 mb-3 shadow-sm"
                                            id="audioPreviewContainer" style="display: none;">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-file-earmark-music fs-3 me-3 text-primary"></i>
                                                    <div>
                                                        <div class="fw-bold" id="audioFileName">Audio généré</div>
                                                        <small class="text-muted" id="audioFileInfo">0:00</small>
                                                    </div>
                                                </div>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-success"
                                                        id="playAudioBtn">
                                                        <i class="bi bi-play-fill"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        id="removeAudioBtn">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="progress mt-2" style="height: 5px;">
                                                <div id="audioProgress" class="progress-bar bg-primary"
                                                    role="progressbar" style="width: 0%"></div>
                                            </div>
                                        </div>

                                        <!-- Statut -->
                                        <div id="recordingStatus" class="small text-muted">
                                            <i class="bi bi-info-circle me-1"></i>Prêt à enregistrer
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Choix de réponse -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">
                                        <i class="bi bi-check2-circle me-2"></i>Choix de réponse
                                    </h6>
                                    <button type="button" class="btn btn-sm btn-primary" id="addChoiceBtn">
                                        <i class="bi bi-plus-lg"></i> Ajouter
                                    </button>
                                </div>
                                <div class="card-body p-0">
                                    <div id="choicesList" class="choices-container">
                                        <!-- Les choix seront ajoutés ici dynamiquement -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-1"></i>Annuler
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de confirmation audio -->
<div class="modal fade" id="audioConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="bi bi-mic-fill me-2"></i>Confirmation audio
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Voulez-vous utiliser cet enregistrement audio?</p>
                <audio controls id="confirmAudioPlayer" class="w-100"></audio>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" id="rejectAudioBtn">
                    <i class="bi bi-arrow-repeat me-1"></i>Non, réessayer
                </button>
                <button type="button" class="btn btn-success" id="confirmAudioBtn">
                    <i class="bi bi-check-lg me-1"></i>Oui, utiliser
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de génération audio -->
<div class="modal fade" id="generateAudioModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="bi bi-robot me-2"></i>Générer l'audio
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Texte à convertir en audio</label>
                    <textarea class="form-control" id="textToSpeech" rows="5" placeholder="Entrez le texte à convertir en audio"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Voix</label>
                    <select class="form-select" id="voiceSelect">
                        <option value="fr-FR-DeniseNeural">Français - Femme (Denise)</option>
                        <option value="fr-FR-HenriNeural">Français - Homme (Henri)</option>
                        <option value="fr-FR-EloiseNeural">Français - Femme jeune (Eloise)</option>
                        <option value="en-US-AriaNeural">Anglais - Femme (Aria)</option>
                        <option value="en-US-GuyNeural">Anglais - Homme (Guy)</option>
                    </select>
                </div>
                <div class="alert alert-info small">
                    <i class="bi bi-info-circle me-1"></i> La génération audio peut prendre quelques secondes.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i>Annuler
                </button>
                <button type="button" class="btn btn-primary" id="generateAudioConfirmBtn">
                    <i class="bi bi-robot me-1"></i>Générer
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-dialog {
        max-width: 700px;
    }

    .modal-content {
        border: none;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .form-floating>.form-select,
    .form-floating>.form-control {
        border-radius: 8px;
    }

    .card {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #f8f9fa;
    }

    .btn-group {
        border-radius: 8px;
        overflow: hidden;
    }

    .btn {
        border-radius: 8px;
    }

    .btn-sm {
        border-radius: 6px;
    }

    .audio-management-container {
        transition: all 0.3s ease;
    }

    .audio-preview-container {
        transition: all 0.3s ease;
        border-radius: 8px;
    }

    #audioProgress {
        transition: width 0.1s linear;
    }

    .bi-file-earmark-music {
        min-width: 24px;
    }

    .choices-container {
        max-height: 400px;
        overflow-y: auto;
    }

    .choice-item {
        position: relative;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        padding: 15px;
        transition: all 0.2s ease;
    }

    .choice-item:hover {
        background-color: #f8f9fa;
    }

    .choice-item:last-child {
        border-bottom: none;
    }

    .choice-handle {
        cursor: move;
        color: #adb5bd;
    }

    .choice-handle:hover {
        color: #6c757d;
    }

    .choice-number {
        position: absolute;
        left: -10px;
        top: 50%;
        transform: translateY(-50%);
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background-color: #6c757d;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
    }

    .remove-choice-btn {
        transition: all 0.2s ease;
        opacity: 0;
    }

    .choice-item:hover .remove-choice-btn {
        opacity: 1;
    }

    .explanation-container {
        margin-top: 10px;
        padding-left: 15px;
        border-left: 3px solid #e9ecef;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .new-choice {
        animation: fadeIn 0.3s ease;
    }

    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        20%,
        60% {
            transform: translateX(-5px);
        }

        40%,
        80% {
            transform: translateX(5px);
        }
    }

    .shake {
        animation: shake 0.5s ease;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/recordrtc@5.6.2/RecordRTC.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variables globales
        let mediaRecorder;
        let audioChunks = [];
        let audioBlob;
        let audioUrl;
        let audioStream;
        let audioPlayer = new Audio();
        let isPlaying = false;
        let progressInterval;
        let audioContext;
        let analyser;
        let dataArray;
        let canvasContext;
        let animationId;

        // Initialisation des choix
        const choiceTemplate = (id) => `
        <div class="choice-item" data-id="${id}">
            <div class="d-flex align-items-center">
                <div class="me-3 choice-handle">
                    <i class="bi bi-grip-vertical fs-5"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-light">
                            <i class="bi bi-chat-left-text"></i>
                        </span>
                        <input type="text" class="form-control choice-text" name="choices[${id}][text]" placeholder="Texte du choix" required>
                        <div class="input-group-text bg-white">
                            <div class="form-check form-switch">
                                <input class="form-check-input choice-correct" type="checkbox" role="switch" name="choices[${id}][is_correct]" id="correct_${id}">
                                <label class="form-check-label" for="correct_${id}">Correct</label>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-danger remove-choice-btn">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;

        // Ajouter des choix initiaux
        for (let i = 0; i < 2; i++) {
            document.getElementById('choicesList').insertAdjacentHTML('beforeend', choiceTemplate(i));
        }

        // Compteur pour les nouveaux choix
        let choiceCounter = 2;

        // Gestion des choix
        document.getElementById('addChoiceBtn').addEventListener('click', function() {
            const newChoice = document.createElement('div');
            newChoice.innerHTML = choiceTemplate(choiceCounter);
            newChoice.firstElementChild.classList.add('new-choice');
            document.getElementById('choicesList').appendChild(newChoice.firstElementChild);
            choiceCounter++;

            // Scroll to the new choice
            const choicesList = document.getElementById('choicesList');
            choicesList.scrollTop = choicesList.scrollHeight;
        });

        // Suppression des choix
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-choice-btn') || e.target.closest(
                    '.remove-choice-btn')) {
                const choiceItem = e.target.closest('.choice-item');
                const choicesList = document.getElementById('choicesList');

                if (choicesList.children.length > 2) {
                    // Animation de suppression
                    choiceItem.style.opacity = '0';
                    choiceItem.style.height = choiceItem.offsetHeight + 'px';
                    choiceItem.style.overflow = 'hidden';

                    setTimeout(() => {
                        choiceItem.style.height = '0';
                        choiceItem.style.padding = '0';
                        choiceItem.style.margin = '0';

                        setTimeout(() => {
                            choiceItem.remove();
                            updateChoiceNumbers();
                        }, 200);
                    }, 200);
                } else {
                    // Animation pour indiquer qu'on ne peut pas supprimer
                    choiceItem.classList.add('shake');
                    setTimeout(() => {
                        choiceItem.classList.remove('shake');
                    }, 500);

                    // Toast de notification
                    const toastHTML = `
                    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1060">
                        <div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    Une question doit avoir au moins 2 choix.
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                `;

                    document.body.insertAdjacentHTML('beforeend', toastHTML);
                    const toastElement = document.body.lastElementChild.querySelector('.toast');
                    const toast = new bootstrap.Toast(toastElement, {
                        delay: 3000
                    });
                    toast.show();

                    // Supprimer le toast après qu'il soit caché
                    toastElement.addEventListener('hidden.bs.toast', function() {
                        toastElement.parentElement.remove();
                    });
                }
            }
        });

        // Mise à jour des numéros de choix
        function updateChoiceNumbers() {
            const choices = document.querySelectorAll('.choice-item');
            choices.forEach((choice, index) => {
                const choiceId = index;
                choice.dataset.id = choiceId;

                // Mettre à jour les attributs name
                choice.querySelector('.choice-text').name = `choices[${choiceId}][text]`;
                choice.querySelector('.choice-correct').name = `choices[${choiceId}][is_correct]`;
                choice.querySelector('.choice-correct').id = `correct_${choiceId}`;
                choice.querySelector('.form-check-label').setAttribute('for', `correct_${choiceId}`);
                choice.querySelector('textarea').name = `explanations[${choiceId}][text]`;
            });
        }

        // Prévisualisation de l'image
        document.getElementById('image').addEventListener('change', function() {
            const preview = document.getElementById('imagePreview');
            const img = preview.querySelector('img');

            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    preview.classList.remove('d-none');
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Suppression de l'image
        document.getElementById('removeImageBtn').addEventListener('click', function() {
            document.getElementById('image').value = '';
            document.getElementById('imagePreview').classList.add('d-none');
        });

        // Initialisation de l'audio
        function initAudioContext() {
            if (!audioContext) {
                audioContext = new(window.AudioContext || window.webkitAudioContext)();
                analyser = audioContext.createAnalyser();
                analyser.fftSize = 256;
                const bufferLength = analyser.frequencyBinCount;
                dataArray = new Uint8Array(bufferLength);
            }
        }

        // Enregistrement audio
        document.getElementById('recordAudioBtn').addEventListener('click', async function() {
            try {
                updateStatus('Enregistrement en cours...', 'text-primary');
                disableAudioControls(true);

                audioChunks = [];
                audioStream = await navigator.mediaDevices.getUserMedia({
                    audio: true
                });
                initAudioContext();

                const source = audioContext.createMediaStreamSource(audioStream);
                source.connect(analyser);

                mediaRecorder = new MediaRecorder(audioStream);

                mediaRecorder.ondataavailable = event => {
                    audioChunks.push(event.data);
                };

                mediaRecorder.onstop = async () => {
                    audioBlob = new Blob(audioChunks, {
                        type: 'audio/wav'
                    });
                    audioUrl = URL.createObjectURL(audioBlob);

                    document.getElementById('confirmAudioPlayer').src = audioUrl;
                    new bootstrap.Modal(document.getElementById('audioConfirmModal'))
                        .show();

                    updateStatus('Enregistrement terminé. Confirmez l\'audio.',
                        'text-success');
                    disableAudioControls(false);

                    if (audioStream) {
                        audioStream.getTracks().forEach(track => track.stop());
                    }
                };

                mediaRecorder.start();

                // Arrêt automatique après 30 secondes
                setTimeout(() => {
                    if (mediaRecorder && mediaRecorder.state === 'recording') {
                        mediaRecorder.stop();
                    }
                }, 30000);

            } catch (error) {
                console.error('Erreur d\'enregistrement:', error);
                updateStatus('Erreur: ' + error.message, 'text-danger');
                disableAudioControls(false);
            }
        });

        // Importation audio
        document.getElementById('uploadAudioBtn').addEventListener('click', function() {
            document.getElementById('audioFileInput').click();
        });

        document.getElementById('audioFileInput').addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                audioUrl = URL.createObjectURL(file);
                audioBlob = file;

                document.getElementById('confirmAudioPlayer').src = audioUrl;
                new bootstrap.Modal(document.getElementById('audioConfirmModal')).show();

                updateStatus('Fichier importé. Confirmez l\'audio.', 'text-success');
            }
        });

        // Génération audio
        document.getElementById('generateAudioBtn').addEventListener('click', function() {
            const text = document.getElementById('question_text').value || document.getElementById(
                'titre').value;
            document.getElementById('textToSpeech').value = text;
            new bootstrap.Modal(document.getElementById('generateAudioModal')).show();
        });

        document.getElementById('generateAudioConfirmBtn').addEventListener('click', async function() {
            const text = document.getElementById('textToSpeech').value;
            const voice = document.getElementById('voiceSelect').value;
            const btn = this;

            if (!text) {
                alert('Veuillez entrer un texte à convertir');
                return;
            }

            btn.disabled = true;
            btn.innerHTML =
                '<span class="spinner-border spinner-border-sm" role="status"></span> Génération...';

            try {
                const response = await fetch('{{ route('monitor.questions.generate.tts') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        text,
                        voice
                    })
                });

                const data = await response.json();

                if (data.success) {
                    audioUrl = data.audio_url;
                    audioBlob = await fetch(audioUrl).then(r => r.blob());

                    updateAudioPreview('Audio généré', formatDuration(data.duration));
                    bootstrap.Modal.getInstance(document.getElementById('generateAudioModal'))
                        .hide();
                } else {
                    throw new Error(data.message || 'Erreur de génération');
                }
            } catch (error) {
                console.error('Erreur:', error);
                updateStatus('Erreur: ' + error.message, 'text-danger');
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-robot"></i> Générer';
            }
        });

        // Confirmation audio
        document.getElementById('confirmAudioBtn').addEventListener('click', async function() {
            if (audioBlob) {
                const formData = new FormData();
                formData.append('audio', audioBlob, 'audio.wav');

                try {
                    const response = await fetch('{{ route('monitor.questions.store.audio') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success) {
                        document.getElementById('audioPath').value = data.path;
                        updateAudioPreview('Audio enregistré', formatDuration(data.duration));
                        bootstrap.Modal.getInstance(document.getElementById('audioConfirmModal'))
                            .hide();
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                    updateStatus('Erreur: ' + error.message, 'text-danger');
                }
            }
        });

        // Rejet audio
        document.getElementById('rejectAudioBtn').addEventListener('click', function() {
            audioUrl = null;
            audioBlob = null;
            updateStatus('Prêt à enregistrer', 'text-muted');
            document.getElementById('audioPreviewContainer').style.display = 'none';
            bootstrap.Modal.getInstance(document.getElementById('audioConfirmModal')).hide();
        });

        // Lecture audio
        document.getElementById('playAudioBtn').addEventListener('click', function() {
            if (!audioUrl) return;

            if (isPlaying) {
                stopAudioPlayback();
            } else {
                startAudioPlayback();
            }
        });

        // Suppression audio
        document.getElementById('removeAudioBtn').addEventListener('click', function() {
            stopAudioPlayback();
            audioUrl = null;
            audioBlob = null;
            document.getElementById('audioPath').value = '';
            document.getElementById('audioPreviewContainer').style.display = 'none';
            updateStatus('Prêt à enregistrer', 'text-muted');
        });

        // Fonctions utilitaires
        function startAudioPlayback() {
            audioPlayer.src = audioUrl;
            audioPlayer.play();
            isPlaying = true;
            document.getElementById('playAudioBtn').innerHTML = '<i class="bi bi-pause-fill"></i>';

            // Mise à jour de la barre de progression
            progressInterval = setInterval(() => {
                const percent = (audioPlayer.currentTime / audioPlayer.duration) * 100;
                document.getElementById('audioProgress').style.width = percent + '%';

                if (audioPlayer.ended) {
                    stopAudioPlayback();
                }
            }, 100);
        }

        function stopAudioPlayback() {
            audioPlayer.pause();
            audioPlayer.currentTime = 0;
            clearInterval(progressInterval);
            isPlaying = false;
            document.getElementById('playAudioBtn').innerHTML = '<i class="bi bi-play-fill"></i>';
            document.getElementById('audioProgress').style.width = '0%';
        }

        function updateAudioPreview(name, duration) {
            document.getElementById('audioFileName').textContent = name;
            document.getElementById('audioFileInfo').textContent = duration;
            document.getElementById('audioPreviewContainer').style.display = 'block';
            updateStatus('Audio prêt', 'text-success');
        }

        function updateStatus(message, textClass) {
            const statusElement = document.getElementById('recordingStatus');
            statusElement.innerHTML = `<i class="bi bi-info-circle me-1"></i>${message}`;
            statusElement.className = 'small ' + textClass;
        }

        function disableAudioControls(disabled) {
            const controls = ['recordAudioBtn', 'uploadAudioBtn', 'generateAudioBtn'];
            controls.forEach(id => {
                document.getElementById(id).disabled = disabled;
            });
        }

        function formatDuration(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
        }

        // Implémentation du drag & drop pour réorganiser les choix
        let draggedItem = null;

        document.addEventListener('mousedown', function(e) {
            if (e.target.classList.contains('choice-handle') || e.target.closest('.choice-handle')) {
                draggedItem = e.target.closest('.choice-item');
                draggedItem.classList.add('dragging');

                // Créer un clone pour l'effet visuel
                const clone = draggedItem.cloneNode(true);
                clone.classList.add('drag-clone');
                clone.style.position = 'absolute';
                clone.style.zIndex = '1000';
                clone.style.width = draggedItem.offsetWidth + 'px';
                clone.style.opacity = '0.8';
                clone.style.pointerEvents = 'none';
                document.body.appendChild(clone);

                // Position initiale
                updateClonePosition(e, clone);

                // Empêcher le comportement par défaut
                e.preventDefault();
            }
        });

        document.addEventListener('mousemove', function(e) {
            if (draggedItem) {
                // Mettre à jour la position du clone
                const clone = document.querySelector('.drag-clone');
                if (clone) {
                    updateClonePosition(e, clone);
                }

                // Logique pour déterminer l'emplacement
                const choicesList = document.getElementById('choicesList');
                const choices = Array.from(choicesList.querySelectorAll('.choice-item:not(.dragging)'));

                let nextElement = null;

                for (const choice of choices) {
                    const box = choice.getBoundingClientRect();
                    const offset = e.clientY - box.top - box.height / 2;

                    if (offset < 0) {
                        nextElement = choice;
                        break;
                    }
                }

                // Insérer l'élément
                if (nextElement) {
                    choicesList.insertBefore(draggedItem, nextElement);
                } else {
                    choicesList.appendChild(draggedItem);
                }
            }
        });

        document.addEventListener('mouseup', function() {
            if (draggedItem) {
                draggedItem.classList.remove('dragging');
                draggedItem = null;

                // Supprimer le clone
                const clone = document.querySelector('.drag-clone');
                if (clone) {
                    clone.remove();
                }

                // Mettre à jour les numéros
                updateChoiceNumbers();
            }
        });

        function updateClonePosition(e, clone) {
            clone.style.left = e.pageX - clone.offsetWidth / 2 + 'px';
            clone.style.top = e.pageY - 30 + 'px';
        }

        // Gestion du formulaire avec validation et feedback
        document.getElementById('questionForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Validation basique avant envoi
            const titre = document.getElementById('titre').value.trim();
            const serie = document.getElementById('serie_id').value;
            const choices = document.querySelectorAll('.choice-text');
            const correctChoices = document.querySelectorAll('.choice-correct:checked');

            if (!titre) {
                showToast('Veuillez entrer un titre pour la question', 'danger');
                return;
            }

            if (!serie) {
                showToast('Veuillez sélectionner une série', 'danger');
                return;
            }

            if (choices.length < 2) {
                showToast('Ajoutez au moins deux choix de réponse', 'danger');
                return;
            }

            if (correctChoices.length < 1) {
                showToast('Sélectionnez au moins une réponse correcte', 'danger');
                return;
            }

            // Vérifier que tous les choix ont du texte
            let emptyChoices = false;
            choices.forEach(choice => {
                if (!choice.value.trim()) {
                    emptyChoices = true;
                }
            });

            if (emptyChoices) {
                showToast('Tous les choix doivent contenir du texte', 'danger');
                return;
            }

            // Tout est bon, on peut envoyer
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML =
                '<span class="spinner-border spinner-border-sm" role="status"></span> Enregistrement...';

            fetch(this.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('Question créée avec succès!', 'success');
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 1000);
                    } else {
                        throw new Error(data.message || 'Erreur lors de l\'enregistrement');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    showToast(error.message, 'danger');
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="bi bi-save me-1"></i>Enregistrer';
                });
        });

        function showToast(message, type) {
            const toastHTML = `
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 1060">
                <div class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        `;

            document.body.insertAdjacentHTML('beforeend', toastHTML);
            const toastElement = document.body.lastElementChild.querySelector('.toast');
            const toast = new bootstrap.Toast(toastElement, {
                delay: 3000
            });
            toast.show();

            // Supprimer le toast après qu'il soit caché
            toastElement.addEventListener('hidden.bs.toast', function() {
                toastElement.parentElement.remove();
            });
        }
    });
</script>
