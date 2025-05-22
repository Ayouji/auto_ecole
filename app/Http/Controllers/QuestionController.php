<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\Categorie;
use App\Models\Question;
use App\Models\Choice; // Ajout de l'import
use App\Models\Serie;
use App\Services\TTSService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    // Afficher la liste des questions
    public function index()
    {
        $questions = Question::with(['serie', 'choices'])
            ->latest()
            ->paginate(10);

        $series = Serie::all(); // Ajoutez cette ligne

        return view('components.questions.index', compact('questions', 'series'));
    }

    // Basculer le statut de visibilité
    public function toggleStatus(Request $request, Question $question)
    {
        $request->validate([
            'is_visible' => 'required|boolean'
        ]);

        $question->update([
            'is_visible' => $request->is_visible
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Statut mis à jour avec succès'
        ]);
    }

    // Afficher le formulaire de création (via modal)
    public function create()
    {
        $series = Serie::all();
        // dd($series);
        return view('components.questions.create', compact('series'));
    }
  public function show(Question $question)
{
    // Charger les choix triés par 'order'
    $question->load(['choices' => function($query) {
        $query->orderBy('order');
    }]);

    // Récupérer les questions précédente et suivante
    $previousQuestion = Question::where('order', '<', $question->order)
        ->orderBy('order', 'desc')
        ->first();

    $nextQuestion = Question::where('order', '>', $question->order)
        ->orderBy('order', 'asc')
        ->first();

    return view('questions.show', [
        'question' => $question,
        'previousQuestion' => $previousQuestion,
        'nextQuestion' => $nextQuestion
    ]);
}


    public function store(Request $request)
    {
        $request->validate([
            'serie_id' => 'required|exists:series,id',
            'titre' => 'required|string|max:255',
            'question_text' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'audio' => 'nullable|file|mimes:mp3,wav|max:5120',
            'is_multiple' => 'boolean',
            'choices' => 'required|array|min:2',
            'choices.*.text' => 'required|string',
            'choices.*.is_correct' => 'boolean',
            'explanations' => 'nullable|array',
            'explanations.*.text' => 'nullable|string',
        ]);

        // Enregistrer la question
        $question = new Question($request->only([
            'serie_id',
            'titre',
            'question_text',
            'is_multiple'
        ]));

        // Gérer l'image et l'audio
        if ($request->hasFile('image')) {
            $question->image = $request->file('image')->store('questions/images', 'public');
        }

        if ($request->hasFile('audio')) {
            $question->audio = $request->file('audio')->store('questions/audio', 'public');
        }

        $question->save();

        // Enregistrer les choix avec les lettres A, B, C, D...
        $letters = ['A', 'B', 'C', 'D', 'E', 'F']; // Vous pouvez étendre si nécessaire
        foreach ($request->choices as $index => $choiceData) {
            $choice = new Choice([
                'letter' => $letters[$index] ?? chr(65 + $index), // A, B, C, etc.
                'choice_text' => $choiceData['text'],
                'is_correct' => $choiceData['is_correct'] ?? false,
                'order' => $index
            ]);
            $question->choices()->save($choice);

            // Enregistrer les explications si elles existent
            if (isset($request->explanations[$index]['text'])) {
                $explanation = new AnswerExplanation([
                    'explanation' => $request->explanations[$index]['text'],
                ]);
                $choice->explanation()->save($explanation);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Question créée avec succès',
            'redirect' => route('monitor.questions.index')
        ]);
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'serie_id' => 'required|exists:series,id',
            'titre' => 'required|string|max:255',
            'question_text' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'audio' => 'nullable|file|mimes:mp3,wav|max:5120',
            'is_multiple' => 'boolean',
            'choices' => 'required|array|min:2',
            'choices.*.text' => 'required|string',
            'choices.*.is_correct' => 'boolean',
            'explanations' => 'nullable|array',
            'explanations.*.text' => 'nullable|string',
        ]);

        // Mettre à jour la question
        $question->fill($request->only([
            'serie_id',
            'titre',
            'question_text',
            'is_multiple'
        ]));

        // Gérer l'image et l'audio
        if ($request->hasFile('image')) {
            if ($question->image) Storage::disk('public')->delete($question->image);
            $question->image = $request->file('image')->store('questions/images', 'public');
        }

        if ($request->hasFile('audio')) {
            if ($question->audio) Storage::disk('public')->delete($question->audio);
            $question->audio = $request->file('audio')->store('questions/audio', 'public');
        }

        $question->save();

        // Supprimer les anciens choix
        $question->choices()->delete();

        // Enregistrer les nouveaux choix avec les lettres
        $letters = ['A', 'B', 'C', 'D', 'E', 'F'];
        foreach ($request->choices as $index => $choiceData) {
            $choice = new Choice([
                'letter' => $letters[$index] ?? chr(65 + $index), // A, B, C, etc.
                'choice_text' => $choiceData['text'],
                'is_correct' => $choiceData['is_correct'] ?? false,
                'order' => $index
            ]);
            $question->choices()->save($choice);

            // Enregistrer les explications si elles existent
            if (isset($request->explanations[$index]['text'])) {
                $explanation = new AnswerExplanation([
                    'explanation' => $request->explanations[$index]['text'],
                ]);
                $choice->explanation()->save($explanation);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Question mise à jour avec succès',
            'redirect' => route('monitor.questions.index')
        ]);
    }
    // Supprimer une question (via modal de confirmation)
    public function destroy(Question $question)
    {
        if ($question->image) Storage::disk('public')->delete($question->image);
        if ($question->audio) Storage::disk('public')->delete($question->audio);

        $question->delete();

        return response()->json([
            'success' => true,
            'message' => 'Question supprimée avec succès'
        ]);
    }


    public function storeAudio(Request $request)
    {
        $request->validate([
            'audio' => 'required|file|mimes:mp3,wav|max:5120',
        ]);

        $path = $request->file('audio')->store('questions/audio', 'public');
        $duration = $this->getAudioDuration(Storage::disk('public')->path($path));

        return response()->json([
            'success' => true,
            'path' => $path,
            'url' => Storage::disk('public')->url($path),
            'duration' => $duration
        ]);
    }


    private function getAudioDuration($filePath)
    {
        try {
            $getID3 = new \getID3();
            $fileInfo = $getID3->analyze($filePath);
            return $fileInfo['playtime_seconds'] ?? 0;
        } catch (\Exception $e) {
            return 0;
        }
    }
    protected $ttsService;

    public function __construct(TTSService $ttsService)
    {
        $this->ttsService = $ttsService;
    }

    public function generateTTS(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:5000',
            'voice' => 'required|string'
        ]);

        $result = $this->ttsService->generateAudio(
            $request->input('text'),
            $request->input('voice'),
            'questions/audios'
        );

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 400);
        }

        return response()->json([
            'success' => true,
            'audio_url' => $result['url'],
            'duration' => $result['duration']
        ]);
    }
}
