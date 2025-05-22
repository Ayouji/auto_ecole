<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

class TTSService
{
    public function generateAudio(string $text, string $voice, string $outputPath): array
    {
        try {
            // Vérifier si le texte n'est pas vide
            if (empty(trim($text))) {
                throw new \Exception("Le texte à synthétiser ne peut pas être vide.");
            }

            // Créer un fichier temporaire pour le texte
            $tempTextFile = tempnam(sys_get_temp_dir(), 'tts_text_');
            file_put_contents($tempTextFile, $text);

            // Créer un fichier temporaire pour la sortie audio
            $tempAudioFile = tempnam(sys_get_temp_dir(), 'tts_audio_') . '.mp3';

            // Construire la commande edge-tts
            $command = [
                'edge-tts',
                '--text', file_get_contents($tempTextFile),
                '--voice', $voice,
                '--write-media', $tempAudioFile,
                '--rate', '+10%'
            ];

            // Exécuter la commande
            $process = new Process($command);
            $process->setTimeout(60);
            $process->run();

            // Vérifier les erreurs
            if (!$process->isSuccessful()) {
                throw new \Exception("Erreur lors de la génération audio: " . $process->getErrorOutput());
            }

            // Vérifier si le fichier audio a été créé
            if (!file_exists($tempAudioFile)) {
                throw new \Exception("Le fichier audio n'a pas été généré.");
            }

            // Déplacer le fichier vers le stockage Laravel
            $finalPath = Storage::putFile('public/audios', new \Illuminate\Http\File($tempAudioFile));

            // Nettoyer les fichiers temporaires
            unlink($tempTextFile);
            unlink($tempAudioFile);

            return [
                'success' => true,
                'path' => $finalPath,
                'url' => Storage::url($finalPath),
                'duration' => $this->getAudioDuration(Storage::path($finalPath))
            ];

        } catch (\Exception $e) {
            // Nettoyer les fichiers temporaires en cas d'erreur
            if (isset($tempTextFile) && file_exists($tempTextFile)) {
                unlink($tempTextFile);
            }
            if (isset($tempAudioFile) && file_exists($tempAudioFile)) {
                unlink($tempAudioFile);
            }

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    protected function getAudioDuration(string $filePath): float
    {
        try {
            $getID3 = new \getID3();
            $fileInfo = $getID3->analyze($filePath);
            return $fileInfo['playtime_seconds'] ?? 0;
        } catch (\Exception $e) {
            return 0;
        }
    }
}