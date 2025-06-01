<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Groupe;

class Niveau extends Model
{
    use HasFactory;
    
    protected $table = 'niveaux';
    
    protected $fillable = [
        'nom',
        'description',
        'actif'
    ];
    
    /**
     * Obtenir les groupes associés à ce niveau
     */
    public function groupes()
    {
        return $this->hasMany(Groupe::class);
    }
}
