<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'date_naissance',
        'numero_etudiant',
        'classe_id',
    ];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    // Accesseur pour le nom complet
    public function getNomCompletAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }
}
