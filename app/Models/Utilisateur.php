<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Utilisateur extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'Utilisateurs';

    protected $fillable = [
        'email',
        'mot_de_passe',
        'role_id',
    ];

    protected $hidden = [
        'mot_de_passe',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function enseignant()
    {
        return $this->hasOne(Enseignant::class, 'utilisateur_id');
    }

    public function etudiant()
    {
        return $this->hasOne(Etudiant::class, 'utilisateur_id');
    }

    public function administrateur()
    {
        return $this->hasOne(Administrateur::class, 'utilisateur_id');
    }

    public function profil()
    {
        return $this->hasOne(Profil::class, 'id_utilisateur');
    }

    public function evenements()
    {
        return $this->hasMany(Evenement::class, 'created_by');
    }

    public function messagesEnvoyes()
    {
        return $this->hasMany(Message::class, 'id_expediteur');
    }

    public function messagesRecus()
    {
        return $this->hasMany(Message::class, 'id_destinataire');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class, 'utilisateur_id');
    }

    public function estEnseignant()
    {
        return $this->role_id == 2 || $this->role->nom == 'enseignant';
    }
}

