<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;

    protected $table = 'Commentaires';
    
    protected $fillable = [
        'contenu',
        'utilisateur_id',
        'cours_id',
        'travail_devoir_id',
        'examen_id',
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }

    public function cours()
    {
        return $this->belongsTo(Cours::class, 'cours_id');
    }

    public function travailDevoir()
    {
        return $this->belongsTo(TravailDevoir::class, 'travail_devoir_id');
    }

    public function examen()
    {
        return $this->belongsTo(Examen::class, 'examen_id');
    }
}
