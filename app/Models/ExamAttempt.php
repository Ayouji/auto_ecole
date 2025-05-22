<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
    protected $fillable = [
        'user_id',
        'exam_id',
        'status',
        'score',
        'started_at',
        'completed_at',
    ];
    
    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];
    
    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Relation avec l'examen
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
    
    // Relation avec les réponses
    public function answers()
    {
        return $this->hasMany(ExamAnswer::class);
    }
    
    // Calculer le temps passé
    public function getDurationAttribute()
    {
        if (!$this->completed_at) {
            return null;
        }
        
        return $this->started_at->diffInMinutes($this->completed_at);
    }
    
    // Vérifier si l'examen est réussi
    public function getIsPassedAttribute()
    {
        if ($this->status !== 'completed') {
            return false;
        }
        
        return $this->score >= $this->exam->passing_score;
    }
}