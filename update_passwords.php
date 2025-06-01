<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// Mot de passe par défaut à définir pour tous les utilisateurs
$defaultPassword = 'Password123';

// Mettre à jour tous les utilisateurs qui n'ont pas de mot de passe initial
$updatedCount = DB::table('users')
    ->whereNull('initial_password')
    ->update([
        'password' => Hash::make($defaultPassword),
        'initial_password' => $defaultPassword,
        'updated_at' => now()
    ]);

echo "Mise à jour terminée. $updatedCount utilisateurs ont été mis à jour avec le mot de passe par défaut: $defaultPassword\n";

// Afficher les utilisateurs mis à jour
$users = DB::table('users')
    ->select('id', 'name', 'email', 'role', 'initial_password')
    ->get();

echo "\nListe des utilisateurs et leurs mots de passe initiaux:\n";
foreach ($users as $user) {
    echo "ID: {$user->id}, Nom: {$user->name}, Email: {$user->email}, Rôle: {$user->role}, Mot de passe initial: " . 
         ($user->initial_password ? $user->initial_password : 'Non disponible') . "\n";
}
