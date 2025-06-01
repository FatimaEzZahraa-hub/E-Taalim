<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    use HasFactory;

    protected $table = 'enseignants';
    
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

    public function cours()
    {
        return $this->hasMany(Cours::class, 'enseignant_id');
    }

    public function nomComplet()
    {
        return $this->prenom . ' ' . $this->nom;
    }
}
