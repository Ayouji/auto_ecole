<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'title',
        'description',
        'time_limit',
        'passing_score',
        'is_published',
    ];
    
    // Relations avec les questions
    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exam_questions')
            ->withPivot('order')
            ->orderBy('pivot_order');
    }
    
    // Relations avec les tentatives
    public function attempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }
    
    // Vérifier si l'examen est publié
    public function isPublished()
    {
        return $this->is_published;
    }
    
    // Obtenir le nombre de questions
    public function getQuestionsCountAttribute()
    {
        return $this->questions()->count();
    }
}