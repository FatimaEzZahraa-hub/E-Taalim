<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravailDevoir extends Model
{
    use HasFactory;

    protected $table = 'Travaux_Devoirs';
    
    protected $fillable = [
        'id_cours',
        'titre',
        'description',
        'fichier',
        'date_limite',
    ];

    protected $dates = [
        'date_limite',
    ];

    public function cours()
    {
        return $this->belongsTo(Cours::class, 'id_cours');
    }

    public function soumissions()
    {
        return $this->hasMany(Soumission::class, 'id_travail_devoir');
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class, 'travail_devoir_id');
    }
}
