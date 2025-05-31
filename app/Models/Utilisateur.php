<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Utilisateur extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'email', 'password', 'role'];
    protected $hidden = ['password', 'remember_token'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function etudiant()
    {
        return $this->hasOne(Etudiant::class, 'utilisateur_id');
    }
}
