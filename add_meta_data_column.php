<?php
// Script pour ajouter la colonne meta_data u00e0 la table users

// Connexion u00e0 la base de donnu00e9es en utilisant les informations de .env
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = $_ENV['DB_HOST'] ?? 'localhost';
$database = $_ENV['DB_DATABASE'] ?? 'e_taalim';
$username = $_ENV['DB_USERNAME'] ?? 'root';
$password = $_ENV['DB_PASSWORD'] ?? '';

try {
    // Connexion u00e0 la base de donnu00e9es
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Vu00e9rifier si la colonne existe du00e9ju00e0
    $checkColumnSql = "SHOW COLUMNS FROM `users` LIKE 'meta_data'";
    $stmt = $pdo->query($checkColumnSql);
    
    if ($stmt->rowCount() == 0) {
        // La colonne n'existe pas, on l'ajoute
        $sql = "ALTER TABLE `users` ADD COLUMN `meta_data` JSON NULL AFTER `groupe_id`";
        $pdo->exec($sql);
        echo "La colonne 'meta_data' a u00e9tu00e9 ajouti00e9e avec succu00e8s u00e0 la table 'users'.\n";
    } else {
        echo "La colonne 'meta_data' existe du00e9ju00e0 dans la table 'users'.\n";
    }
    
} catch (PDOException $e) {
    echo "Erreur lors de l'exu00e9cution de la requ00eate SQL : " . $e->getMessage() . "\n";
}

echo "Opu00e9ration terminu00e9e.\n";
