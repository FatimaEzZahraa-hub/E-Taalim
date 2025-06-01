<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devoir extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associu00e9e au modu00e8le.
     *
     * @var string
     */
    protected $table = 'travaux_devoirs';

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titre',
        'description',
        'date_limite',
        'module_id',
        'cours_id',
        'enseignant_id',
        'points_max'
    ];

    /**
     * Relation avec le module
     */
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Relation avec le cours
     */
    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }

    /**
     * Relation avec l'enseignant
     */
    public function enseignant()
    {
        return $this->belongsTo(User::class, 'enseignant_id');
    }

    /**
     * Relation avec les soumissions
     */
    public function soumissions()
    {
        return $this->hasMany(Soumission::class);
    }
}
