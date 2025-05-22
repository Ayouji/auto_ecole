@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2>Gestion des Questions</h2>
            </div>
            <div class="col-md-6 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createQuestionModal">
                    <i class="bi bi-plus-circle"></i> Créer une Question
                </button>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="questionsTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Titre</th>
                                <th>Série</th>
                                <th>Choix</th>
                                <th>Audio</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($questions as $question)
                                <tr>
                                    <td>{{ $question->id }}</td>
                                    <td>{{ Str::limit($question->titre, 30) }}</td>
                                    <td>{{ $question->serie->title }}</td>
                                    <td>
                                        <span class="badge bg-{{ $question->is_multiple ? 'info' : 'primary' }}">
                                            {{ $question->is_multiple ? 'Multiple' : 'Unique' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($question->audio)
                                            <i class="bi bi-check-circle-fill text-success"></i>
                                        @else
                                            <i class="bi bi-x-circle-fill text-danger"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary edit-question-btn"
                                            data-id="{{ $question->id }}" data-bs-toggle="modal"
                                            data-bs-target="#editQuestionModal">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger delete-question-btn"
                                            data-id="{{ $question->id }}" data-title="{{ $question->titre }}"
                                            data-bs-toggle="modal" data-bs-target="#deleteQuestionModal">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer bg-white border-top py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing <span class="fw-semibold">{{ $questions->firstItem() }}</span> to <span
                                class="fw-semibold">{{ $questions->lastItem() }}</span> of <span
                                class="fw-semibold">{{ $questions->total() }}</span> entries
                        </div>
                        <div>
                            {{ $questions->onEachSide(1)->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.questions.create', ['series' => $series])
    @include('components.questions.edit')
    @include('components.questions.delete')

    {{-- @push('styles') --}}
    <style>
        .form-switch .form-check-input {
            width: 3em;
            height: 1.5em;
            cursor: pointer;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }
    </style>
    {{-- @endpush --}}

    {{-- @push('scripts') --}}
    <script>
        $(document).ready(function() {
            // Initialiser DataTable
            $('#questionsTable').DataTable({
                responsive: true,
                paging: false,
                info: false,
                searching: true,
                language: {
                    search: "Rechercher:",
                    zeroRecords: "Aucune question trouvée"
                },
                dom: '<"top"f>rt<"bottom"lip><"clear">'
            });

            // Charger les données pour l'édition
            $('.edit-question-btn').click(function() {
                const questionId = $(this).data('id');

                $.get(`/monitor/questions/${questionId}/edit`, function(data) {
                    $('#editQuestionModal').html(data);
                }).fail(function() {
                    alert('Erreur lors du chargement des données');
                });
            });

            // Toggle du statut de visibilité
            $('.toggle-status').change(function() {
                const questionId = $(this).data('id');
                const isVisible = $(this).is(':checked');

                $.ajax({
                    url: `/monitor/questions/${questionId}/toggle-status`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        is_visible: isVisible
                    },
                    success: function(response) {
                        toastr.success('Statut mis à jour avec succès');
                    },
                    error: function() {
                        toastr.error('Erreur lors de la mise à jour');
                        $(this).prop('checked', !isVisible);
                    }
                });
            });
        });
    </script>
    {{-- @endpush --}}
@endsection
