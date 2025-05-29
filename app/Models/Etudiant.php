<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $table = 'Etudiants';
    
    protected $fillable = [
        'utilisateur_id',
        'nom',
        'prenom',
        'telephone',
        'photo',
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }

    public function soumissions()
    {
        return $this->hasMany(Soumission::class, 'id_etudiant');
    }

    public function nomComplet()
    {
        return $this->prenom . ' ' . $this->nom;
    }
}
