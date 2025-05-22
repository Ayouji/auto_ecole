{{-- <i class="bi bi-pencil-square text-warning fs-5" data-bs-toggle="modal" data-bs-target="#editSeriesModal-{{ $serie->id }}"></i> --}}

<div class="modal fade" id="editSeriesModal-{{ $serie->id }}" tabindex="-1" aria-labelledby="editSeriesModalLabel-{{ $serie->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header bg-primary text-white" style="border-radius: 15px 15px 0 0;">
                <h5 class="modal-title" id="editSeriesModalLabel-{{ $serie->id }}">
                    <i class="fas fa-edit me-2"></i>Modifier la série
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <form action="{{ route('monitor.series.update', $serie->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label for="title-{{ $serie->id }}" class="form-label fw-bold">Titre de la série</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-heading"></i>
                            </span>
                            <input type="text" class="form-control" id="title-{{ $serie->id }}" name="title" required 
                                placeholder="Entrez le titre de la série" value="{{ old('title', $serie->title) }}">
                        </div>
                        @error('title')
                            <div class="text-danger mt-1 small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description-{{ $serie->id }}" class="form-label fw-bold">Description</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-align-left"></i>
                            </span>
                            <textarea class="form-control" id="description-{{ $serie->id }}" name="description" rows="3" 
                                placeholder="Entrez une description pour cette série">{{ old('description', $serie->description) }}</textarea>
                        </div>
                        @error('description')
                            <div class="text-danger mt-1 small">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($serie->cover_image)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Image actuelle</label>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('storage/' . $serie->cover_image) }}" alt="{{ $serie->title }}" 
                                class="img-thumbnail" style="height: 80px; width: auto;">
                            <div class="form-check ms-3">
                                <input class="form-check-input" type="checkbox" id="remove_image-{{ $serie->id }}" name="remove_image" value="1">
                                <label class="form-check-label" for="remove_image-{{ $serie->id }}">
                                    Supprimer l'image
                                </label>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="mb-4">
                        <label for="cover_image-{{ $serie->id }}" class="form-label fw-bold">
                            {{ $serie->cover_image ? 'Nouvelle image de couverture' : 'Image de couverture' }}
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-image"></i>
                            </span>
                            <input type="file" class="form-control" id="cover_image-{{ $serie->id }}" name="cover_image" 
                                accept="image/*">
                        </div>
                        <div class="form-text">Format recommandé: JPG, PNG. Max 2MB.</div>
                        @error('cover_image')
                            <div class="text-danger mt-1 small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active-{{ $serie->id }}" name="is_active" value="1" 
                            {{ old('is_active', $serie->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active-{{ $serie->id }}">Activer cette série</label>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-radius: 0 0 15px 15px;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Annuler
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>