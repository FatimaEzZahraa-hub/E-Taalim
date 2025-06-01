<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

// Vérifier si la table users existe
if (Schema::hasTable('users')) {
    echo "La table 'users' existe.\n";
    
    // Récupérer les colonnes de la table users
    $columns = Schema::getColumnListing('users');
    echo "Colonnes de la table 'users':\n";
    print_r($columns);
    
    // Vérifier si la colonne initial_password existe
    if (Schema::hasColumn('users', 'initial_password')) {
        echo "La colonne 'initial_password' existe dans la table 'users'.\n";
    } else {
        echo "La colonne 'initial_password' n'existe PAS dans la table 'users'.\n";
        echo "Création de la colonne 'initial_password'...\n";
        
        // Ajouter la colonne initial_password si elle n'existe pas
        Schema::table('users', function($table) {
            $table->string('initial_password')->nullable();
        });
        
        echo "Colonne 'initial_password' ajoutée avec succès.\n";
    }
    
    // Afficher les utilisateurs et leurs mots de passe initiaux
    echo "\nListe des utilisateurs et leurs mots de passe initiaux:\n";
    $users = DB::table('users')->select('id', 'name', 'email', 'role', 'initial_password')->get();
    
    foreach ($users as $user) {
        echo "ID: {$user->id}, Nom: {$user->name}, Email: {$user->email}, Rôle: {$user->role}, Mot de passe initial: " . ($user->initial_password ? $user->initial_password : 'Non disponible') . "\n";
    }
    
    // Afficher quelques utilisateurs pour vérifier
    $users = DB::table('users')->limit(5)->get();
    echo "\nExemples d'utilisateurs:\n";
    foreach ($users as $user) {
        echo "ID: {$user->id}, Email: {$user->email}, Role: {$user->role}\n";
    }
} else {
    echo "La table 'users' n'existe pas.\n";
}
