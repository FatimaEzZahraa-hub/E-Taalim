<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;

    protected $table = 'Cours';
    
    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titre',
        'description',
        'fichier',
        'enseignant_id',
    ];

    /**
     * Relation avec l'enseignant
     */
    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class, 'enseignant_id');
    }


    /**
     * Relation avec les modules
     * Note: Cette relation devrait être many-to-many mais la table pivot n'existe pas encore.
     * Pour l'instant, nous retournons une relation vide pour éviter les erreurs.
     */
    public function modules()
    {
        // Retourne une relation vide mais valide pour éviter les erreurs
        return $this->belongsToMany(\App\Models\Module::class, 'cours_module', 'cours_id', 'module_id')
                    ->whereRaw('1 = 0'); // Condition impossible pour qu'aucun enregistrement ne soit retourné
    }

    /**
     * Relation avec les travaux et devoirs
     */
    public function travauxDevoirs()
    {
        return $this->hasMany(TravailDevoir::class, 'id_cours');
    }

    /**
     * Relation avec les examens
     */
    public function examens()
    {
        return $this->hasMany(Examen::class, 'id_cours');
    }

    /**
     * Relation avec les commentaires
     */
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class, 'cours_id');
    
    }
}
