<?php

namespace App\Http\Controllers\Monitor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\SectionMedia;
use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Afficher la liste des cours
     */
    public function index(Request $request)
    {
        $query = Course::query()->withCount('sections');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $courses = $query->latest()->paginate(10);

        return view('monitor.courses.index', compact('courses'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $series = Serie::all();
        return view('monitor.courses.create', compact('series'));
    }

    /**
     * Enregistrer un nouveau cours
     */
    public function store(Request $request)
    {
        Log::info('Début de la création du cours', ['request_data' => $request->except(['content', 'pdf_file', 'cover_image'])]);

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'content' => 'required|string',
                'serie_id' => 'nullable|exists:series,id',
                'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'pdf_file' => 'nullable|file|mimes:pdf|max:10000',
            ]);

            Log::debug('Validation réussie', ['validated_data' => array_keys($validated)]);

            $courseData = [
                'title' => $validated['title'],
                'slug' => Str::slug($validated['title']),
                'description' => $validated['description'],
                'content' => $validated['content'],
                'serie_id' => $validated['serie_id'] ?? null,
                'is_active' => $request->has('is_active'),
                'user_id' => Auth::id(),
            ];

            // Traitement de l'image de couverture
            if ($request->hasFile('cover_image')) {
                $path = $request->file('cover_image')->store('courses/covers', 'public');
                $courseData['cover_image'] = $path;
                Log::debug('Fichier cover_image traité', ['path' => $path]);
            }

            // Traitement du fichier PDF
            if ($request->hasFile('pdf_file')) {
                $path = $request->file('pdf_file')->store('courses/pdfs', 'public');
                $courseData['pdf_file'] = $path;
                Log::debug('Fichier pdf_file traité', ['path' => $path]);
            }

            Log::debug('Données du cours à créer', ['course_data' => $courseData]);

            $course = Course::create($courseData);

            Log::info('Cours créé avec succès', ['course_id' => $course->id]);

            // Création d'une section par défaut si le contenu est fourni
            if (!empty($validated['content'])) {
                $section = $course->sections()->create([
                    'title' => 'Introduction',
                    'content' => $validated['content'],
                    'order' => 0,
                ]);
                Log::debug('Section par défaut créée', ['section_id' => $section->id]);
            }

            return redirect()->route('monitor.courses.edit', $course)
                ->with('success', 'Cours créé avec succès. Vous pouvez maintenant ajouter des sections.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du cours', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withInput()
                ->with('error', 'Une erreur est survenue lors de la création du cours: ' . $e->getMessage());
        }
    }

    /**
     * Afficher un cours spécifique
     */
    public function show(Course $course)
    {
        $course->load('sections.media', 'category');
        return view('monitor.courses.show', compact('course'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Course $course)
    {
        $categories = Serie::all();
        $course->load('sections.media');
        return view('monitor.courses.edit', compact('course', 'categories'));
    }

    /**
     * Mettre à jour un cours
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'serie_id' => 'nullable|exists:series,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'pdf_file' => 'nullable|mimes:pdf|max:10240',
            'sections' => 'nullable|array',
            'sections.*.id' => 'nullable|exists:course_sections,id',
            'sections.*.title' => 'required|string|max:255',
            'sections.*.content' => 'required|string',
            'sections.*.order' => 'required|integer|min:0',
            'sections.*.media' => 'nullable|array',
            'sections.*.media.*.id' => 'nullable|exists:section_media,id',
            'sections.*.media.*.title' => 'nullable|string|max:255',
            'sections.*.media.*.type' => 'nullable|string|in:image,video,audio,document',
            'sections.*.media.*.file' => 'nullable|file|max:20480',
            'sections.*.media.*.url' => 'nullable|url',
        ]);

        // Traitement de l'image de couverture
        if ($request->hasFile('cover_image')) {
            // Supprimer l'ancienne image si elle existe
            if ($course->cover_image) {
                Storage::disk('public')->delete($course->cover_image);
            }

            $path = $request->file('cover_image')->store('courses/covers', 'public');
            $course->cover_image = $path;
        }

        // Traitement du fichier PDF
        if ($request->hasFile('pdf_file')) {
            // Supprimer l'ancien fichier s'il existe
            if ($course->pdf_file) {
                Storage::disk('public')->delete($course->pdf_file);
            }

            $path = $request->file('pdf_file')->store('courses/pdfs', 'public');
            $course->pdf_file = $path;
        }

        // Mise à jour des informations du cours
        $course->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'description' => $validated['description'],
            'content' => $validated['content'],
            'serie_id' => $validated['serie_id'] ?? null,
            'is_active' => $request->has('is_active'),
        ]);

        // Traitement des sections
        if ($request->has('sections')) {
            $existingSectionIds = $course->sections->pluck('id')->toArray();
            $updatedSectionIds = [];

            foreach ($request->sections as $sectionData) {
                if (isset($sectionData['id'])) {
                    // Mise à jour d'une section existante
                    $section = CourseSection::find($sectionData['id']);
                    if ($section) {
                        $section->update([
                            'title' => $sectionData['title'],
                            'content' => $sectionData['content'],
                            'order' => $sectionData['order'],
                        ]);
                        $updatedSectionIds[] = $section->id;
                    }
                } else {
                    // Création d'une nouvelle section
                    $section = $course->sections()->create([
                        'title' => $sectionData['title'],
                        'content' => $sectionData['content'],
                        'order' => $sectionData['order'],
                    ]);
                    $updatedSectionIds[] = $section->id;
                }

                // Traitement des médias de la section
                if (isset($sectionData['media']) && isset($section)) {
                    $existingMediaIds = $section->media->pluck('id')->toArray();
                    $updatedMediaIds = [];

                    foreach ($sectionData['media'] as $mediaData) {
                        if (isset($mediaData['id'])) {
                            // Mise à jour d'un média existant
                            $media = SectionMedia::find($mediaData['id']);
                            if ($media) {
                                $media->update([
                                    'title' => $mediaData['title'] ?? $media->title,
                                    'type' => $mediaData['type'] ?? $media->type,
                                    'url' => $mediaData['url'] ?? $media->url,
                                ]);
                                $updatedMediaIds[] = $media->id;

                                // Mise à jour du fichier si nécessaire
                                $fileKey = "sections.{$sectionData['order']}.media.{$mediaData['id']}.file";
                                if (isset($mediaData['file']) && $request->hasFile($fileKey)) {
                                    $file = $request->file($fileKey);
                                    $path = $file->store('courses/media', 'public');

                                    // Supprimer l'ancien fichier
                                    if ($media->file_path) {
                                        Storage::disk('public')->delete($media->file_path);
                                    }

                                    $media->update(['file_path' => $path]);
                                }
                            }
                        } else if (isset($mediaData['file']) || isset($mediaData['url'])) {
                            // Création d'un nouveau média
                            $mediaAttributes = [
                                'title' => $mediaData['title'] ?? 'Sans titre',
                                'type' => $mediaData['type'] ?? 'document',
                                'url' => $mediaData['url'] ?? null,
                            ];

                            // Traitement du fichier
                            $fileKey = "sections.{$sectionData['order']}.media.new.file";
                            if (isset($mediaData['file']) && $request->hasFile($fileKey)) {
                                $file = $request->file($fileKey);
                                $path = $file->store('courses/media', 'public');
                                $mediaAttributes['file_path'] = $path;
                            }

                            $media = $section->media()->create($mediaAttributes);
                            $updatedMediaIds[] = $media->id;
                        }
                    }

                    // Supprimer les médias qui n'ont pas été mis à jour
                    $mediaToDelete = array_diff($existingMediaIds, $updatedMediaIds);
                    if (!empty($mediaToDelete)) {
                        $mediaToDeleteObjects = SectionMedia::whereIn('id', $mediaToDelete)->get();

                        foreach ($mediaToDeleteObjects as $media) {
                            if ($media->file_path) {
                                Storage::disk('public')->delete($media->file_path);
                            }
                            $media->delete();
                        }
                    }
                }
            }

            // Supprimer les sections qui n'ont pas été mises à jour
            $sectionsToDelete = array_diff($existingSectionIds, $updatedSectionIds);
            if (!empty($sectionsToDelete)) {
                $sectionsToDeleteObjects = CourseSection::whereIn('id', $sectionsToDelete)->get();

                foreach ($sectionsToDeleteObjects as $section) {
                    // Supprimer les médias associés
                    foreach ($section->media as $media) {
                        if ($media->file_path) {
                            Storage::disk('public')->delete($media->file_path);
                        }
                        $media->delete();
                    }
                    $section->delete();
                }
            }
        }

        return redirect()->route('monitor.courses.edit', $course)
            ->with('success', 'Cours mis à jour avec succès.');
    }

    /**
     * Supprimer un cours
     */
    public function destroy(Course $course)
    {
        // Supprimer les fichiers associés
        if ($course->cover_image) {
            Storage::disk('public')->delete($course->cover_image);
        }

        if ($course->pdf_file) {
            Storage::disk('public')->delete($course->pdf_file);
        }

        // Supprimer les sections et leurs médias
        foreach ($course->sections as $section) {
            foreach ($section->media as $media) {
                if ($media->file_path) {
                    Storage::disk('public')->delete($media->file_path);
                }
                $media->delete();
            }
            $section->delete();
        }

        $course->delete();

        return redirect()->route('monitor.courses.index')
            ->with('success', 'Cours supprimé avec succès.');
    }

    /**
     * Gérer l'upload d'images pour l'éditeur
     */
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');

            // Validation du fichier
            $validator = Validator::make(
                ['upload' => $file],
                ['upload' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048']
            );

            if ($validator->fails()) {
                return response()->json([
                    'error' => [
                        'message' => $validator->errors()->first('upload')
                    ]
                ], 400);
            }

            // Enregistrement du fichier
            $path = $file->store('courses/editor-images', 'public');
            $url = Storage::disk('public')->url($path);

            return response()->json([
                'url' => $url,
                'uploaded' => 1,
                'fileName' => $file->getClientOriginalName()
            ]);
        }

        return response()->json([
            'error' => [
                'message' => 'Aucun fichier n\'a été envoyé.'
            ]
        ], 400);
    }

    /**
     * Réorganiser les sections d'un cours
     */
    public function reorderSections(Request $request, Course $course)
    {
        $validated = $request->validate([
            'sections' => 'required|array',
            'sections.*' => 'exists:course_sections,id',
        ]);

        foreach ($validated['sections'] as $order => $sectionId) {
            CourseSection::where('id', $sectionId)->update(['order' => $order]);
        }

        return response()->json(['success' => true]);
    }
}
