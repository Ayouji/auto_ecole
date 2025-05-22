<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role', // 'moniteur' ou 'eleve'
        'profile_image',
        'active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    // Vérifier si l'utilisateur est un moniteur
    public function isMoniteur()
    {
        return $this->role === 'moniteur';
    }
    
    // Vérifier si l'utilisateur est un élève
    public function isEleve()
    {
        return $this->role === 'eleve';
    }
    
    // Relations avec les examens passés (pour les élèves)
    public function examAttempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }
}
