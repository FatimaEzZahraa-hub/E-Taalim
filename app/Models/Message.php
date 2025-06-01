<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sujet',
        'contenu',
        'id_expediteur',
        'id_destinataire',
        'lu',
    ];

    public function expediteur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_expediteur');
    }

    public function destinataire()
    {
        return $this->belongsTo(Utilisateur::class, 'id_destinataire');
    }
}
