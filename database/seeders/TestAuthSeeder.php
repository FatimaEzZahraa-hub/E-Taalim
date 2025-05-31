<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestAuthSeeder extends Seeder
{
    public function run(): void
    {
        // Supprimer l'utilisateur de test existant s'il existe
        DB::table('users')->where('email', 'test@e-taalim.com')->delete();

        // Créer un nouvel utilisateur de test
        DB::table('users')->insert([
            'name' => 'Test User',
            'email' => 'test@e-taalim.com',
            'password' => Hash::make('password123'),
            'role' => 'etudiant',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
} 