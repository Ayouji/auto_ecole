<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_section_id',
        'type',
        'file_path',
        'title',
        'order',
    ];

    public function section()
    {
        return $this->belongsTo(CourseSection::class, 'course_section_id');
    }
}