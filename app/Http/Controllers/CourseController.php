<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CourseController extends Controller
{
    /**
     * Afficher tous les cours
     */
    public function index()
    {
        $courses = Course::orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('monitor.courses.index', compact('courses'));
    }
    
    /**
     * Afficher le formulaire de création de cours
     */
    public function create()
    {
        return view('monitor.courses.create');
    }
    
    /**
     * Enregistrer un nouveau cours
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf_file' => 'nullable|mimes:pdf|max:10240',
            'active' => 'sometimes|boolean',
        ]);
        
        $data = $request->except(['cover_image', 'pdf_file']);
        $data['active'] = $request->has('active') ? 1 : 0;
        $data['slug'] = Str::slug($request->title);
        
        // Traiter l'image de couverture
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('courses/covers', 'public');
            $data['cover_image'] = $path;
        }
        
        // Traiter le fichier PDF
        if ($request->hasFile('pdf_file')) {
            $path = $request->file('pdf_file')->store('courses/pdfs', 'public');
            $data['pdf_path'] = $path;
        }
        
        Course::create($data);
        
        return redirect()->route('courses.index')
            ->with('success', 'Cours créé avec succès!');
    }
    
    /**
     * Afficher un cours spécifique
     */
    public function show($slug)
    {
        $course = Course::where('slug', $slug)
            ->firstOrFail();
            
        return view('components.courses.show', compact('course'));
    }
    
    /**
     * Afficher le formulaire d'édition de cours
     */
    public function edit(Course $course)
    {
        return view('components.courses.edit', compact('course'));
    }
    
    /**
     * Mettre à jour un cours
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf_file' => 'nullable|mimes:pdf|max:10240',
            'active' => 'sometimes|boolean',
        ]);
        
        $data = $request->except(['cover_image', 'pdf_file']);
        $data['active'] = $request->has('active') ? 1 : 0;
        
        // Mettre à jour le slug uniquement si le titre a changé
        if ($course->title !== $request->title) {
            $data['slug'] = Str::slug($request->title);
        }
        
        // Traiter l'image de couverture
        if ($request->hasFile('cover_image')) {
            // Supprimer l'ancienne image si elle existe
            if ($course->cover_image) {
                Storage::disk('public')->delete($course->cover_image);
            }
            
            $path = $request->file('cover_image')->store('courses/covers', 'public');
            $data['cover_image'] = $path;
        }
        
        // Traiter le fichier PDF
        if ($request->hasFile('pdf_file')) {
            // Supprimer l'ancien PDF s'il existe
            if ($course->pdf_path) {
                Storage::disk('public')->delete($course->pdf_path);
            }
            
            $path = $request->file('pdf_file')->store('courses/pdfs', 'public');
            $data['pdf_path'] = $path;
        }
        
        $course->update($data);
        
        return redirect()->route('courses.index')
            ->with('success', 'Cours mis à jour avec succès!');
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
        
        if ($course->pdf_path) {
            Storage::disk('public')->delete($course->pdf_path);
        }
        
        $course->delete();
        
        return redirect()->route('courses.index')
            ->with('success', 'Cours supprimé avec succès!');
    }

    /**
     * Gérer l'upload d'images pour l'éditeur de texte
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $path = $request->file('file')->store('courses/content-images', 'public');
        
        return response()->json([
            'location' => Storage::url($path)
        ]);
    }

    /**
     * Afficher un cours pour un élève
     */
    public function showForStudent(Course $course)
    {
        // Vérifier que le cours est actif
        if (!$course->is_active) {
            return redirect()->route('eleve.courses.index')
                ->with('error', 'Ce cours n\'est pas disponible actuellement.');
        }
        
        $course->load('sections.media', 'category');
        
        // Marquer le cours comme vu par l'élève (à implémenter si nécessaire)
        // $this->markCourseAsViewed($course);
        
        return view('eleve.courses.show', compact('course'));
    }
}