<?php

namespace App\Http\Controllers\Monitor;

use App\Http\Controllers\Controller;
use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SerieController extends Controller
{
    /**
     * Afficher toutes les séries
     */
    public function index()
    {
        $series = Serie::withCount('questions')->latest()->paginate(12);
        return view('monitor.series.index', compact('series'));
    }

    /**
     * Enregistrer une nouvelle série
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('monitor.series.index')
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except('cover_image');
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        // Upload cover image if provided
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('series/covers', 'public');
            $data['cover_image'] = $path;
        }

        Serie::create($data);

        return redirect()->route('monitor.series.index')
            ->with('success', 'Série créée avec succès!');
    }

    /**
     * Afficher une série spécifique
     */
    
    public function show(Serie $serie)
    {
        $serie->load('questions');
        dd($serie->load('questions'));
        return view('monitor.series.show', compact('serie'));
    }

    /**
     * Mettre à jour une série
     */
    public function update(Request $request, Serie $serie)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('monitor.series.index')
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except('cover_image');
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        // Upload cover image if provided
        if ($request->hasFile('cover_image')) {
            // Supprimer l'ancienne image si elle existe
            if ($serie->cover_image) {
                Storage::disk('public')->delete($serie->cover_image);
            }
            
            $path = $request->file('cover_image')->store('series/covers', 'public');
            $data['cover_image'] = $path;
        }

        $serie->update($data);

        return redirect()->route('monitor.series.index')
            ->with('success', 'Série mise à jour avec succès!');
    }

    /**
     * Supprimer une série
     */
    public function destroy(Serie $serie)
    {
        // Supprimer l'image de couverture si elle existe
        if ($serie->cover_image) {
            Storage::disk('public')->delete($serie->cover_image);
        }
        
        // Supprimer la série
        $serie->delete();

        return redirect()->route('monitor.series.index')
            ->with('success', 'Série supprimée avec succès!');
    }
}