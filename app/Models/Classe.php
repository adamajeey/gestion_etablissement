<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'niveau',
        'capacite',
        'description',
    ];

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }

    public function cours()
    {
        return $this->belongsToMany(Cours::class, 'cours_classe');
    }

    public function emploisDuTemps()
    {
        return $this->hasMany(EmploiDuTemps::class);
    }
}
