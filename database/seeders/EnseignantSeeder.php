<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Enseignant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EnseignantSeeder extends Seeder
{
    public function run(): void
    {
        // Créer l'utilisateur
        $user = User::create([
            'name' => 'Admin Enseignant',
            'email' => 'enseignant@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Créer l'enseignant associé
        Enseignant::create([
            'utilisateur_id' => $user->id,
            'nom' => 'Admin',
            'prenom' => 'Enseignant',
            'telephone' => '0612345678',
        ]);
    }
} 