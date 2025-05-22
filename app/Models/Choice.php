<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    protected $fillable = [
    'question_id',
    'letter', 
    'choice_text',
    'is_correct',
    'order'
];
}
