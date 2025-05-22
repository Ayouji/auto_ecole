{{-- <i class="bi bi-trash text-danger fs-5" data-bs-toggle="modal" data-bs-target="#deleteSeriesModal-{{ $serie->id }}"></i> --}}

<div class="modal fade" id="deleteSeriesModal-{{ $serie->id }}" tabindex="-1" aria-labelledby="deleteSeriesModalLabel-{{ $serie->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header bg-danger text-white" style="border-radius: 15px 15px 0 0;">
                <h5 class="modal-title" id="deleteSeriesModalLabel-{{ $serie->id }}">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirmation de suppression
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                    <h4>Êtes-vous sûr de vouloir supprimer cette série ?</h4>
                    <p class="text-muted">Cette action est irréversible et supprimera toutes les questions associées.</p>
                </div>
                
                <div class="alert alert-warning d-flex" role="alert">
                    <i class="fas fa-info-circle fa-lg me-3 mt-1"></i>
                    <div>
                        <strong>Série à supprimer :</strong> {{ $serie->title }}
                        @if($serie->description)
                            <br><small>{{ \Illuminate\Support\Str::limit($serie->description, 100) }}</small>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light" style="border-radius: 0 0 15px 15px;">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Annuler
                </button>
                <form action="{{ route('monitor.series.destroy', $serie->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt me-1"></i>Confirmer la suppression
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>