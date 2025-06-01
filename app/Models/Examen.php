<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    use HasFactory;

    protected $table = 'Examens';
    
    protected $fillable = [
        'id_cours',
        'titre',
        'description',
        'fichier',
        'date_exam',
    ];

    protected $dates = [
        'date_exam',
    ];

    public function cours()
    {
        return $this->belongsTo(Cours::class, 'id_cours');
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class, 'examen_id');
    }
}
