{{-- @extends('layouts.app')

@section('content') --}}
<div class="modal fade" id="editQuestionModal" tabindex="-1" aria-labelledby="editQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editQuestionModalLabel">Modifier la question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editQuestionForm" method="POST" action="{{ route('monitor.questions.update', $question->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_serie_id" class="form-label">Série</label>
                        <select class="form-select" id="edit_serie_id" name="serie_id" required>
                            @foreach($series as $serie)
                                <option value="{{ $serie->id }}" {{ $question->serie_id == $serie->id ? 'selected' : '' }}>{{ $serie->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_titre" class="form-label">Titre de la question</label>
                        <input type="text" class="form-control" id="edit_titre" name="titre" value="{{ $question->titre }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_question_text" class="form-label">Texte de la question (optionnel)</label>
                        <textarea class="form-control" id="edit_question_text" name="question_text" rows="3">{{ $question->question_text }}</textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_image" class="form-label">Image (optionnel)</label>
                            <input class="form-control" type="file" id="edit_image" name="image" accept="image/*">
                            @if($question->image)
                                <div class="mt-2">
                                    <img src="{{ Storage::disk('public')->url($question->image) }}" alt="Image de la question" class="img-thumbnail" style="max-height: 100px;">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image" value="1">
                                        <label class="form-check-label" for="remove_image">
                                            Supprimer l'image
                                        </label>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Type de question</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="edit_is_multiple" name="is_multiple" value="1" {{ $question->is_multiple ? 'checked' : '' }}>
                                <label class="form-check-label" for="edit_is_multiple">
                                    Question à choix multiple
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Audio de la question</label>
                        <div class="audio-upload-container">
                            <div class="btn-group w-100" role="group">
                                <button type="button" class="btn btn-outline-primary" id="editRecordAudioBtn">
                                    <i class="bi bi-mic-fill"></i> Enregistrer
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="editUploadAudioBtn">
                                    <i class="bi bi-upload"></i> Importer
                                </button>
                                <button type="button" class="btn btn-outline-success" id="editPlayAudioBtn" {{ $question->audio ? '' : 'disabled' }}>
                                    <i class="bi bi-play-fill"></i> Écouter
                                </button>
                            </div>
                            <input type="file" id="editAudioFileInput" name="audio" accept="audio/*" class="d-none">
                            <input type="hidden" id="editAudioPath" name="audio_path" value="{{ $question->audio }}">
                            <div class="mt-2 audio-visualizer" id="editAudioVisualizer"></div>
                            <div id="editRecordingStatus" class="small text-muted mt-1">
                                @if($question->audio)
                                    <i class="bi bi-check-circle-fill text-success"></i> Audio existant
                                @else
                                    Prêt à enregistrer
                                @endif
                            </div>
                            @if($question->audio)
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="remove_audio" name="remove_audio" value="1">
                                    <label class="form-check-label" for="remove_audio">
                                        Supprimer l'audio
                                    </label>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="choices-container mb-3">
                        <label class="form-label">Choix de réponse</label>
                        <div id="editChoicesList">
                            @foreach($question->choices as $index => $choice)
                                <div class="choice-item" data-choice-id="{{ $index }}">
                                    <div class="d-flex align-items-center mb-2">
                                        <input type="text" class="form-control choice-text" name="choices[{{ $index }}][text]" value="{{ $choice->text }}" placeholder="Texte du choix" required>
                                        <div class="form-check ms-3">
                                            <input class="form-check-input choice-correct" type="checkbox" name="choices[{{ $index }}][is_correct]" id="edit_correct_{{ $index }}" {{ $choice->is_correct ? 'checked' : '' }}>
                                            <label class="form-check-label" for="edit_correct_{{ $index }}">Correct</label>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-danger ms-2 remove-choice-btn">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    <div class="explanation-container">
                                        <label class="form-label small">Explication (optionnel)</label>
                                        <textarea class="form-control form-control-sm" name="explanations[{{ $index }}][text]" placeholder="Explication si ce choix est sélectionné">{{ $choice->explanation->explanation ?? '' }}</textarea>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="editAddChoiceBtn">
                            <i class="bi bi-plus"></i> Ajouter un choix
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de confirmation audio -->
<div class="modal fade" id="editAudioConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmation audio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Voulez-vous utiliser cet enregistrement audio?</p>
                <audio controls id="editConfirmAudioPlayer" class="w-100"></audio>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="editRejectAudioBtn">Non, réessayer</button>
                <button type="button" class="btn btn-primary" id="editConfirmAudioBtn">Oui, utiliser</button>
            </div>
        </div>
    </div>
</div>
{{-- @endsection --}}

{{-- @push('styles') --}}
<style>
    .audio-visualizer {
        height: 50px;
        background-color: #f8f9fa;
        border-radius: 4px;
        overflow: hidden;
    }
    .choice-item {
        background-color: #f8f9fa;
        border-radius: 4px;
        padding: 10px;
        margin-bottom: 10px;
    }
    .explanation-container {
        margin-top: 10px;
        padding-left: 20px;
        border-left: 3px solid #dee2e6;
    }
</style>
{{-- @endpush --}}

{{-- @push('scripts') --}}
<script src="https://cdn.jsdelivr.net/npm/recordrtc@5.6.2/RecordRTC.min.js"></script>
<script>
$(document).ready(function() {
    // Variables pour l'enregistrement audio
    let mediaRecorder;
    let audioChunks = [];
    let audioBlob;
    let audioUrl;
    let audioStream;
    
    // Template pour un choix de réponse
    const choiceTemplate = (id) => `
        <div class="choice-item" data-choice-id="${id}">
            <div class="d-flex align-items-center mb-2">
                <input type="text" class="form-control choice-text" name="choices[${id}][text]" placeholder="Texte du choix" required>
                <div class="form-check ms-3">
                    <input class="form-check-input choice-correct" type="checkbox" name="choices[${id}][is_correct]" id="edit_correct_${id}">
                    <label class="form-check-label" for="edit_correct_${id}">Correct</label>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger ms-2 remove-choice-btn">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
            <div class="explanation-container">
                <label class="form-label small">Explication (optionnel)</label>
                <textarea class="form-control form-control-sm" name="explanations[${id}][text]" placeholder="Explication si ce choix est sélectionné"></textarea>
            </div>
        </div>
    `;
    
    // Compteur pour les nouveaux choix
    let choiceCounter = {{ $question->choices->count() }};
    
    // Ajouter un nouveau choix
    $('#editAddChoiceBtn').click(function() {
        $('#editChoicesList').append(choiceTemplate(choiceCounter)));
        choiceCounter++;
    });
    
    // Supprimer un choix
    $(document).on('click', '.remove-choice-btn', function() {
        if ($('#editChoicesList').children().length > 2) {
            $(this).closest('.choice-item').remove();
        } else {
            alert('Une question doit avoir au moins 2 choix.');
        }
    });
    
    // Enregistrement audio
    $('#editRecordAudioBtn').click(async function() {
        try {
            $('#editRecordingStatus').text('Enregistrement en cours...');
            $('#editRecordAudioBtn').prop('disabled', true);
            $('#editPlayAudioBtn').prop('disabled', true);
            
            audioChunks = [];
            audioStream = await navigator.mediaDevices.getUserMedia({ audio: true });
            mediaRecorder = new MediaRecorder(audioStream);
            
            mediaRecorder.ondataavailable = event => {
                audioChunks.push(event.data);
            };
            
            mediaRecorder.onstop = async () => {
                audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                audioUrl = URL.createObjectURL(audioBlob);
                
                // Afficher l'audio dans le modal de confirmation
                $('#editConfirmAudioPlayer').attr('src', audioUrl);
                const audioConfirmModal = new bootstrap.Modal(document.getElementById('editAudioConfirmModal'));
                audioConfirmModal.show();
                
                $('#editRecordingStatus').text('Enregistrement terminé. Confirmez l\'audio.');
                $('#editPlayAudioBtn').prop('disabled', false);
                $('#editRecordAudioBtn').prop('disabled', false);
            };
            
            mediaRecorder.start();
            setTimeout(() => {
                mediaRecorder.stop();
                audioStream.getTracks().forEach(track => track.stop());
            }, 10000); // Enregistrement de 10 secondes max
        } catch (error) {
            console.error('Erreur d\'enregistrement:', error);
            $('#editRecordingStatus').text('Erreur: ' + error.message);
            $('#editRecordAudioBtn').prop('disabled', false);
        }
    });
    
    // Importer un fichier audio
    $('#editUploadAudioBtn').click(function() {
        $('#editAudioFileInput').click();
    });
    
    $('#editAudioFileInput').change(function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            audioUrl = URL.createObjectURL(file);
            
            // Afficher l'audio dans le modal de confirmation
            $('#editConfirmAudioPlayer').attr('src', audioUrl);
            const audioConfirmModal = new bootstrap.Modal(document.getElementById('editAudioConfirmModal'));
            audioConfirmModal.show();
            
            $('#editRecordingStatus').text('Fichier audio importé. Confirmez l\'audio.');
            $('#editPlayAudioBtn').prop('disabled', false);
        }
    });
    
    // Écouter l'audio existant ou enregistré/importé
    $('#editPlayAudioBtn').click(function() {
        const existingAudioUrl = '{{ $question->audio ? Storage::disk('public')->url($question->audio) : '' }}';
        const audioToPlay = audioUrl || existingAudioUrl;
        
        if (audioToPlay) {
            const audio = new Audio(audioToPlay);
            audio.play();
        }
    });
    
    // Confirmer l'audio
    $('#editConfirmAudioBtn').click(async function() {
        if (audioBlob) {
            // Convertir Blob en File pour l'upload
            const audioFile = new File([audioBlob], 'enregistrement.wav', { type: 'audio/wav' });
            
            // Envoyer le fichier au serveur
            const formData = new FormData();
            formData.append('audio', audioFile);
            
            try {
                const response = await fetch('{{ route("monitor.questions.store.audio") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    $('#editAudioPath').val(data.path);
                    $('#editRecordingStatus').html('<i class="bi bi-check-circle-fill text-success"></i> Audio enregistré avec succès');
                    $('#remove_audio').prop('checked', false);
                    
                    // Fermer le modal de confirmation
                    const audioConfirmModal = bootstrap.Modal.getInstance(document.getElementById('editAudioConfirmModal'));
                    audioConfirmModal.hide();
                } else {
                    throw new Error(data.message || 'Erreur lors de l\'enregistrement');
                }
            } catch (error) {
                console.error('Erreur:', error);
                $('#editRecordingStatus').text('Erreur: ' + error.message);
            }
        }
    });
    
    // Rejeter l'audio
    $('#editRejectAudioBtn').click(function() {
        audioUrl = null;
        audioBlob = null;
        $('#editRecordingStatus').text('Prêt à enregistrer');
        $('#editPlayAudioBtn').prop('disabled', {{ $question->audio ? 'false' : 'true' }});
        
        const audioConfirmModal = bootstrap.Modal.getInstance(document.getElementById('editAudioConfirmModal'));
        audioConfirmModal.hide();
    });
    
    // Soumission du formulaire
    $('#editQuestionForm').submit(function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    window.location.href = response.redirect;
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                let errorMessage = 'Une erreur est survenue. Veuillez vérifier les champs.';
                
                if (errors) {
                    errorMessage = Object.values(errors).join('\n');
                }
                
                alert(errorMessage);
            }
        });
    });
});
</script>
{{-- @endpush --}}