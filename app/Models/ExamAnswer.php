<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamAnswer extends Model
{
    protected $fillable = [
        'exam_attempt_id',
        'question_id',
        'choice_id',
        'is_correct',
    ];
    
    // Relation avec la tentative d'examen
    public function attempt()
    {
        return $this->belongsTo(ExamAttempt::class, 'exam_attempt_id');
    }
    
    // Relation avec la question
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    
    // Relation avec le choix
    public function choice()
    {
        return $this->belongsTo(Choice::class);
    }
}