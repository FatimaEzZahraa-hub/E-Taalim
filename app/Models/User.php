<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'niveau_id',
        'groupe_id',
        'meta_data',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    /**
     * Obtenir les groupes auxquels l'utilisateur est affecté
     */
    public function groupes()
    {
        return $this->belongsToMany(Groupe::class, 'groupe_student', 'user_id', 'groupe_id')
                    ->withPivot('date_affectation')
                    ->withTimestamps();
    }
    
    /**
     * Obtenir le niveau auquel l'utilisateur est affecté directement
     */
    public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }
    
    /**
     * Obtenir le groupe auquel l'utilisateur est affecté directement
     */
    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }
    
    /**
     * Vérifier si l'utilisateur est un étudiant
     */
    public function isStudent()
    {
        return $this->role === 'student';
    }
    
    /**
     * Vérifier si l'utilisateur est un enseignant
     */
    public function isTeacher()
    {
        return $this->role === 'teacher';
    }
    
    /**
     * Vérifier si l'utilisateur est un administrateur
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
