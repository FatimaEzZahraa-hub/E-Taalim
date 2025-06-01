<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nom',
        'niveau_id',
        'description',
        'capacite',
        'actif'
    ];
    
    /**
     * Obtenir le niveau auquel appartient ce groupe
     */
    public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }
    
    /**
     * Obtenir les u00e9tudiants de ce groupe
     */
    public function etudiants()
    {
        return $this->belongsToMany(User::class, 'groupe_student', 'groupe_id', 'user_id')
                    ->withPivot('date_affectation')
                    ->withTimestamps();
    }
}
