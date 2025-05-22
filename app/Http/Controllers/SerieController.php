<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SerieController extends Controller
{
    public function index()
    {
        $series = Serie::latest()->paginate(12);
        return view('components.series.index', compact('series'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('components.series.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'sometimes|boolean',
        ]);

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
        return view('components.series.show', compact('serie'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Serie $serie)
    {
        return view('components.series.edit', compact('serie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Serie $serie)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'sometimes|boolean',
        ]);

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
     * Remove the specified resource from storage.
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
