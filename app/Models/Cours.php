<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'user_id',
    ];

    // Relation vers l’enseignant
    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relation vers les étudiants inscrits
    public function etudiants()
    {
        return $this->belongsToMany(User::class, 'cours_etudiant');
    }
}
