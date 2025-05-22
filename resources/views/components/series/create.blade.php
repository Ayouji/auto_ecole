{{-- <div class="mb-3">
    <button id="openCreateCategoriesModal" style="
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background-color 0.2s;
    " data-bs-toggle="modal" data-bs-target="#createSeriesModal">Créer</button>
</div> --}}

<div class="modal fade" id="createSeriesModal" tabindex="-1" aria-labelledby="createSeriesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header bg-primary text-white" style="border-radius: 15px 15px 0 0;">
                <h5 class="modal-title" id="createSeriesModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Créer une nouvelle série
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <form action="{{ route('monitor.series.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label for="title" class="form-label fw-bold">Titre de la série</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-heading"></i>
                            </span>
                            <input type="text" class="form-control" id="title" name="title" required 
                                placeholder="Entrez le titre de la série" value="{{ old('title') }}">
                        </div>
                        @error('title')
                            <div class="text-danger mt-1 small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-bold">Description</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-align-left"></i>
                            </span>
                            <textarea class="form-control" id="description" name="description" rows="3" 
                                placeholder="Entrez une description pour cette série">{{ old('description') }}</textarea>
                        </div>
                        @error('description')
                            <div class="text-danger mt-1 small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="cover_image" class="form-label fw-bold">Image de couverture</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-image"></i>
                            </span>
                            <input type="file" class="form-control" id="cover_image" name="cover_image" 
                                accept="image/*">
                        </div>
                        <div class="form-text">Format recommandé: JPG, PNG. Max 2MB.</div>
                        @error('cover_image')
                            <div class="text-danger mt-1 small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                        <label class="form-check-label" for="is_active">Activer cette série</label>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-radius: 0 0 15px 15px;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Annuler
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>