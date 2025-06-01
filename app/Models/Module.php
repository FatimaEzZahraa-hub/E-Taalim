<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nom',
        'description',
        'code',
        'image',
        'couleur',
        'niveau_id',
        'enseignant_id',
        'actif'
    ];
    
    /**
     * Relation avec le niveau
     */
    public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }
    
    /**
     * Relation avec l'enseignant
     */
    public function enseignant()
    {
        return $this->belongsTo(User::class, 'enseignant_id');
    }
    
    /**
     * Relation avec les cours
     * Note: Cette relation devrait être many-to-many mais la table pivot n'existe pas encore.
     * Pour l'instant, nous retournons une relation vide pour éviter les erreurs.
     */
    public function cours()
    {
        // Retourne une relation vide mais valide pour éviter les erreurs
        return $this->hasMany(\App\Models\Cours::class, 'module_id')
                    ->whereRaw('1 = 0'); // Condition impossible pour qu'aucun enregistrement ne soit retourné
    }
    
    /**
     * Relation avec les devoirs
     */
    public function devoirs()
    {
        return $this->hasMany(Devoir::class);
    }
    
    /**
     * Relation avec les groupes (many-to-many)
     */
    public function groupes()
    {
        return $this->belongsToMany(Groupe::class, 'module_groupe')
                    ->withTimestamps();
    }
}
