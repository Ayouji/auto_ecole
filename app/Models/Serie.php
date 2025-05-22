<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $fillable = [
        'title',
        'description',
        'cover_image',
    ];
    public function questions() {
        return $this->hasMany(Question::class);
    }
}
