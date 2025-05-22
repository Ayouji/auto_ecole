@extends('layouts.app')

@section('title', 'Modifier le Cours')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Modifier le Cours</h1>
                <div>
                    <a href="{{ route('monitor.courses.show', $course) }}" class="btn btn-info me-2">
                        <i class="bi bi-eye me-1"></i>Aperçu
                    </a>
                    <a href="{{ route('monitor.courses.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Retour à la liste
                    </a>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('monitor.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Informations générales du cours -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informations générales</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Titre du cours <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $course->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $course->description) }}</textarea>
                            @error('description')
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
                    </div>
                </div>
                
                <!-- Contenu du cours -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Contenu du cours</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror">{{ old('content', $course->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Paramètres du cours -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Paramètres</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Catégorie</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                <option value="">Sélectionner une catégorie</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $course->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        @if($course->pdf_file)
                        <div class="mb-3">
                            <label class="form-label">Fichier PDF actuel</label>
                            <div>
                                <a href="{{ Storage::url($course->pdf_file) }}" target="_blank" class="btn btn-sm btn-info">
                                    <i class="bi bi-file-pdf"></i> Voir le PDF
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
                        
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ old('is_active', $course->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Cours actif</label>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>Enregistrer les modifications
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sections du cours -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Sections du cours</h5>
                        <button type="button" class="btn btn-sm btn-success" id="add-section">
                            <i class="bi bi-plus-circle me-1"></i>Ajouter une section
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="sections-container">
                            @forelse($course->sections as $index => $section)
                                <div class="section-item card mb-4">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">Section {{ $index + 1 }}</h6>
                                        <div class="section-actions">
                                            <button type="button" class="btn btn-sm btn-outline-danger remove-section">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary move-section-up" {{ $index == 0 ? 'disabled' : '' }}>
                                                <i class="bi bi-arrow-up"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary move-section-down" {{ $index == $course->sections->count() - 1 ? 'disabled' : '' }}>
                                                <i class="bi bi-arrow-down"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <input type="hidden" name="sections[{{ $index }}][id]" value="{{ $section->id }}">
                                        <input type="hidden" name="sections[{{ $index }}][order]" value="{{ $index }}" class="section-order">
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Titre de la section</label>
                                            <input type="text" class="form-control" name="sections[{{ $index }}][title]" value="{{ $section->title }}" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Contenu de la section</label>
                                            <textarea class="form-control section-editor" name="sections[{{ $index }}][content]" rows="5" id="section-editor-{{ $index }}">{{ $section->content }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>Aucune section n'a été créée pour ce cours. Utilisez le bouton "Ajouter une section" pour commencer.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Template pour les nouvelles sections -->
<template id="section-template">
    <div class="section-item card mb-4">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Nouvelle section</h6>
            <div class="section-actions">
                <button type="button" class="btn btn-sm btn-outline-danger remove-section">
                    <i class="bi bi-trash"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary move-section-up">
                    <i class="bi bi-arrow-up"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary move-section-down">
                    <i class="bi bi-arrow-down"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <input type="hidden" name="sections[__INDEX__][order]" value="__INDEX__" class="section-order">
            
            <div class="mb-3">
                <label class="form-label">Titre de la section</label>
                <input type="text" class="form-control" name="sections[__INDEX__][title]" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Contenu de la section</label>
                <textarea class="form-control section-editor" name="sections[__INDEX__][content]" rows="5" id="section-editor-__INDEX__"></textarea>
            </div>
        </div>
    </div>
</template>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/super-build/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Configuration de l'éditeur principal
        CKEDITOR.ClassicEditor.create(document.getElementById("content"), {
            toolbar: {
                items: [
                    'exportPDF','exportWord', '|',
                    'findAndReplace', 'selectAll', '|',
                    'heading', '|',
                    'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                    'bulletedList', 'numberedList', 'todoList', '|',
                    'outdent', 'indent', '|',
                    'undo', 'redo',
                    '-',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                    'alignment', '|',
                    'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                    'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                    'textPartLanguage', '|',
                    'sourceEditing'
                ],
                shouldNotGroupWhenFull: true
            },
            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true
                }
            },
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraphe', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Titre 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Titre 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Titre 3', class: 'ck-heading_heading3' },
                    { model: 'heading4', view: 'h4', title: 'Titre 4', class: 'ck-heading_heading4' },
                    { model: 'heading5', view: 'h5', title: 'Titre 5', class: 'ck-heading_heading5' },
                    { model: 'heading6', view: 'h6', title: 'Titre 6', class: 'ck-heading_heading6' }
                ]
            },
            placeholder: 'Commencez à rédiger le contenu de votre cours ici...',
            fontFamily: {
                options: [
                    'default',
                    'Arial, Helvetica, sans-serif',
                    'Courier New, Courier, monospace',
                    'Georgia, serif',
                    'Lucida Sans Unicode, Lucida Grande, sans-serif',
                    'Tahoma, Geneva, sans-serif',
                    'Times New Roman, Times, serif',
                    'Trebuchet MS, Helvetica, sans-serif',
                    'Verdana, Geneva, sans-serif'
                ],
                supportAllValues: true
            },
            fontSize: {
                options: [ 10, 12, 14, 'default', 18, 20, 22 ],
                supportAllValues: true
            },
            htmlSupport: {
                allow: [
                    {
                        name: /.*/,
                        attributes: true,
                        classes: true,
                        styles: true
                    }
                ]
            },
            htmlEmbed: {
                showPreviews: true
            },
            link: {
                decorators: {
                    addTargetToExternalLinks: true,
                    defaultProtocol: 'https://',
                    toggleDownloadable: {
                        mode: 'manual',
                        label: 'Téléchargeable',
                        attributes: {
                            download: 'file'
                        }
                    }
                }
            },
            image: {
                toolbar: [
                    'imageTextAlternative',
                    'toggleImageCaption',
                    'imageStyle:inline',
                    'imageStyle:block',
                    'imageStyle:side',
                    'linkImage'
                ],
                upload: {
                    types: ['jpeg', 'png', 'gif', 'jpg', 'webp']
                }
            },
            simpleUpload: {
                uploadUrl: '{{ route("monitor.upload.image") }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            table: {
                contentToolbar: [
                    'tableColumn',
                    'tableRow',
                    'mergeTableCells',
                    'tableCellProperties',
                    'tableProperties'
                ]
            },
            removePlugins: [
                'CKBox',
                'CKFinder',
                'EasyImage',
                'RealTimeCollaborativeComments',
                'RealTimeCollaborativeTrackChanges',
                'RealTimeCollaborativeRevisionHistory',
                'PresenceList',
                'Comments',
                'TrackChanges',
                'TrackChangesData',
                'RevisionHistory',
                'Pagination',
                'WProofreader',
                'MathType',
                'SlashCommand',
                'Template',
                'DocumentOutline',
                'FormatPainter',
                'TableOfContents'
            ]
        })
        .catch(error => {
            console.error(error);
        });
        
        // Initialiser les éditeurs de section existants
        document.querySelectorAll('.section-editor').forEach((element, index) => {
            initSectionEditor(element);
        });
        
        // Gestion de l'ajout de sections
        let sectionCount = {{ $course->sections->count() }};
        const sectionsContainer = document.getElementById('sections-container');
        const sectionTemplate = document.getElementById('section-template').innerHTML;
        
        document.getElementById('add-section').addEventListener('click', function() {
            const newSectionHtml = sectionTemplate.replace(/__INDEX__/g, sectionCount);
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = newSectionHtml;
            const newSection = tempDiv.firstElementChild;
            
            setTimeout(() => {
                const newEditors = document.querySelectorAll('.editor:not(.ck-editor)');
                newEditors.forEach(editor => {
                    ClassicEditor
                        .create(editor, {
                            toolbar: {
                                items: [
                                    'heading', '|',
                                    'bold', 'italic', 'strikethrough', 'underline', 'code', 'removeFormat', '|',
                                    'bulletedList', 'numberedList', '|',
                                    'outdent', 'indent', '|',
                                    'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', '|',
                                    'undo', 'redo'
                                ]
                            },
                            image: {
                                toolbar: [
                                    'imageTextAlternative',
                                    'imageStyle:inline',
                                    'imageStyle:block',
                                    'imageStyle:side'
                                ],
                                upload: {
                                    types: ['jpeg', 'png', 'gif', 'jpg', 'webp']
                                }
                            },
                            simpleUpload: {
                                uploadUrl: '{{ route("monitor.upload.image") }}',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Erreur lors de l\'initialisation du nouvel éditeur', error);
                        });
                });
            }, 100);
        });
    });
</script>
@endpush