<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Cours; // ← Ajout nécessaire

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relation: un enseignant a plusieurs cours
    public function cours()
    {
        return $this->hasMany(Cours::class, 'user_id');
    }

    // Relation: un étudiant peut être inscrit à plusieurs cours
    public function coursInscrits()
    {
        return $this->belongsToMany(Cours::class, 'cours_etudiant', 'user_id', 'cours_id');
    }

    // Méthodes d'aide pour les rôles
    public function isAdmin() { return $this->role === 'admin'; }
    public function isTeacher() { return $this->role === 'teacher'; }
    public function isStudent() { return $this->role === 'student'; }
}
