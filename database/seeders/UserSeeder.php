<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Créer un utilisateur étudiant
        DB::table('users')->insert([
            'name' => 'Étudiant Test',
            'email' => 'etudiant.test@e-taalim.com',
            'password' => Hash::make('password'),
            'role' => 'etudiant',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Créer un utilisateur enseignant
        DB::table('users')->insert([
            'name' => 'Enseignant Test',
            'email' => 'enseignant.test@e-taalim.com',
            'password' => Hash::make('password'),
            'role' => 'enseignant',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
} 