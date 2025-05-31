<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    protected $table = 'Etudiants';
    protected $primaryKey = 'id';
    protected $fillable = ['utilisateur_id', 'nom', 'prenom', 'telephone', 'photo'];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }
}
