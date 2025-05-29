<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soumission extends Model
{
    use HasFactory;

    protected $table = 'Soumissions';
    
    protected $fillable = [
        'id_etudiant',
        'id_travail_devoir',
        'fichier',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'id_etudiant');
    }

    public function travailDevoir()
    {
        return $this->belongsTo(TravailDevoir::class, 'id_travail_devoir');
    }
}
