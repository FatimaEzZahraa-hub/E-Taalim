<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Méthode 1: Utiliser le modèle Eloquent
try {
    echo "\nMéthode 1: Utiliser le modèle Eloquent\n";
    $niveaux = \App\Models\Niveau::where('actif', true)->get();
    foreach ($niveaux as $niveau) {
        echo "ID: {$niveau->id}, Nom: " . ($niveau->nom ?? 'NULL') . "\n";
    }
} catch (\Exception $e) {
    echo "Erreur avec la méthode 1: " . $e->getMessage() . "\n";
}

// Méthode 2: Utiliser Query Builder
try {
    echo "\nMéthode 2: Utiliser Query Builder\n";
    $niveaux = \Illuminate\Support\Facades\DB::table('niveaux')->where('actif', true)->get();
    foreach ($niveaux as $niveau) {
        echo "ID: {$niveau->id}, Nom: " . ($niveau->nom ?? 'NULL') . "\n";
    }
} catch (\Exception $e) {
    echo "Erreur avec la méthode 2: " . $e->getMessage() . "\n";
}

// Méthode 3: Utiliser une requête SQL brute
try {
    echo "\nMéthode 3: Utiliser une requête SQL brute\n";
    $niveaux = \Illuminate\Support\Facades\DB::select('SELECT * FROM niveaux WHERE actif = ?', [true]);
    foreach ($niveaux as $niveau) {
        echo "ID: {$niveau->id}, Nom: " . ($niveau->nom ?? 'NULL') . "\n";
    }
} catch (\Exception $e) {
    echo "Erreur avec la méthode 3: " . $e->getMessage() . "\n";
}

// Vérifier la structure de la table
try {
    echo "\nStructure de la table niveaux:\n";
    $columns = \Illuminate\Support\Facades\Schema::getColumnListing('niveaux');
    echo implode(", ", $columns) . "\n";
} catch (\Exception $e) {
    echo "Erreur lors de la récupération de la structure: " . $e->getMessage() . "\n";
}
