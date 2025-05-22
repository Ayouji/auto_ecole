<?php

namespace App\Http\Controllers\Eleve;

use App\Http\Controllers\Controller;
use App\Models\Serie;
use Illuminate\Http\Request;

class SerieController extends Controller
{
    /**
     * Afficher toutes les séries actives
     */
    public function index()
    {
        $series = Serie::where('is_active', true)
            ->latest()
            ->paginate(12);
            
        return view('eleve.series.index', compact('series'));
    }

    /**
     * Afficher une série spécifique
     */
    public function show(Serie $serie)
    {
        // Vérifier que la série est active
        if (!$serie->is_active) {
            return redirect()->route('eleve.series.index')
                ->with('error', 'Cette série n\'est pas disponible actuellement.');
        }
        
        $serie->load('questions');
        
        return view('eleve.series.show', compact('serie'));
    }
}