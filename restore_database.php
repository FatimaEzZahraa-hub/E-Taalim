<?php

/**
 * Script de restauration de la base de données E-Taalim
 * Ce script exécute toutes les migrations et remplit la base de données avec des données initiales
 */

// Charger l'application Laravel
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

echo "=== Script de restauration de la base de données E-Taalim ===\n\n";

try {
    // Vérifier la connexion à la base de données
    DB::connection()->getPdo();
    echo "✓ Connexion à la base de données établie avec succès.\n";
    
    // Supprimer toutes les tables existantes
    echo "Suppression des tables existantes...\n";
    Schema::disableForeignKeyConstraints();
    
    $tables = DB::select('SHOW TABLES');
    $dbName = DB::connection()->getDatabaseName();
    $tableColumn = "Tables_in_$dbName";
    
    foreach ($tables as $table) {
        Schema::drop($table->$tableColumn);
        echo "  - Table {$table->$tableColumn} supprimée.\n";
    }
    
    Schema::enableForeignKeyConstraints();
    echo "✓ Toutes les tables ont été supprimées.\n\n";
    
    // Exécuter les migrations
    echo "Exécution des migrations...\n";
    Artisan::call('migrate', ['--force' => true]);
    echo Artisan::output();
    echo "✓ Migrations exécutées avec succès.\n\n";
    
    // Exécuter le seeder personnalisé
    echo "Remplissage de la base de données avec les données initiales...\n";
    Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\RestoreDataSeeder', '--force' => true]);
    echo Artisan::output();
    echo "✓ Données initiales ajoutées avec succès.\n\n";
    
    echo "=== Restauration de la base de données terminée avec succès ===\n";
    echo "Vous pouvez maintenant accéder à l'application E-Taalim.\n";
    echo "Identifiants administrateur : admin@etaalim.ma / password123\n";
    
} catch (\Exception $e) {
    echo "❌ Erreur lors de la restauration de la base de données : " . $e->getMessage() . "\n";
    exit(1);
}
