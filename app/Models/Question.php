<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'serie_id',
        'titre',
        'question_text',
        'image',
        'audio',
        'is_visible',
        'is_multiple',
    ];

    public function serie()
    {
        return $this->belongsTo(Serie::class);
    }
    public function choices()
    {
        return $this->hasMany(Choice::class);
    }
}
