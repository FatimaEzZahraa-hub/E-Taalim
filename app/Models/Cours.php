<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;

    protected $table = 'Cours';
    
    protected $fillable = [
        'titre',
        'description',
        'fichier',
        'enseignant_id',
    ];

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class, 'enseignant_id');
    }

    public function travauxDevoirs()
    {
        return $this->hasMany(TravailDevoir::class, 'id_cours');
    }

    public function examens()
    {
        return $this->hasMany(Examen::class, 'id_cours');
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class, 'cours_id');
    }
}
