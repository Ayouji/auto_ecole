@extends('layouts.app')

@section('title', 'Modifier le cours')

@section('styles')
<!-- Inclure TinyMCE ou CKEditor -->
<script src="https://cdn.tiny.cloud/1/VOTRE_CLE_API/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
@endsection

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Modifier le cours: {{ $course->title }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Titre</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $course->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="content" class="form-label">Contenu du cours</label>
                            <textarea class="form-control editor @error('content') is-invalid @enderror" id="content" name="content" rows="15">{{ old('content', $course->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        @if($course->cover_image)
                        <div class="mb-3">
                            <label class="form-label">Image de couverture actuelle</label>
                            <div>
                                <img src="{{ Storage::url($course->cover_image) }}" alt="{{ $course->title }}" class="img-thumbnail" style="max-height: 200px;">
                            </div>
                        </div>
                        @endif
                        
                        <div class="mb-3">
                            <label for="cover_image" class="form-label">Nouvelle image de couverture</label>
                            <input type="file" class="form-control @error('cover_image') is-invalid @enderror" id="cover_image" name="cover_image">
                            @error('cover_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        @if($course->pdf_path)
                        <div class="mb-3">
                            <label class="form-label">Fichier PDF actuel</label>
                            <div>
                                <a href="{{ Storage::url($course->pdf_path) }}" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-file-pdf"></i> Voir le PDF
                                </a>
                            </div>
                        </div>
                        @endif
                        
                        <div class="mb-3">
                            <label for="pdf_file" class="form-label">Nouveau fichier PDF</label>
                            <input type="file" class="form-control @error('pdf_file') is-invalid @enderror" id="pdf_file" name="pdf_file">
                            @error('pdf_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="active" name="active" {{ $course->active ? 'checked' : '' }}>
                            <label class="form-check-label" for="active">Actif</label>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('courses.index') }}" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Initialisation de TinyMCE
    tinymce.init({
        selector: '.editor',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        height: 500,
        images_upload_url: '{{ route("courses.upload.image") }}', // Route pour l'upload d'images
        automatic_uploads: true,
        images_reuse_filename: true,
        file_picker_types: 'image',
        file_picker_callback: function (cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            
            input.onchange = function () {
                var file = this.files[0];
                
                var reader = new FileReader();
                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    
                    cb(blobInfo.blobUri(), { title: file.name });
                };
                reader.readAsDataURL(file);
            };
            
            input.click();
        }
    });
</script>
@endsection