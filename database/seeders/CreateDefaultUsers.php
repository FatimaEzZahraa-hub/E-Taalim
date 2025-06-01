<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Enseignant;
use App\Models\Etudiant;
use Illuminate\Support\Facades\Hash;

class CreateDefaultUsers extends Seeder
{
    public function run()
    {
        // Créer l'enseignant
        $enseignantUser = User::create([
            'name' => 'Admin Enseignant',
            'email' => 'enseignant@example.com',
            'password' => Hash::make('password123'),
        ]);

        Enseignant::create([
            'utilisateur_id' => $enseignantUser->id,
            'nom' => 'Admin',
            'prenom' => 'Enseignant',
            'telephone' => '0612345678',
        ]);

        // Créer un étudiant
        $etudiantUser = User::create([
            'name' => 'Test Etudiant',
            'email' => 'etudiant@example.com',
            'password' => Hash::make('password123'),
        ]);

        Etudiant::create([
            'utilisateur_id' => $etudiantUser->id,
            'nom' => 'Test',
            'prenom' => 'Etudiant',
            'telephone' => '0612345679',
        ]);
    }
}