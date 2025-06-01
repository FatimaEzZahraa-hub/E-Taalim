<?php
// Script pour lister les tables de la base de données

$host = 'localhost';
$dbname = 'plat';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connexion à la base de données réussie<br>";
    
    // Lister toutes les tables
    $stmt = $conn->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<br>Tables dans la base de données '$dbname':<br>";
    foreach ($tables as $table) {
        echo "- $table<br>";
    }
    
} catch(PDOException $e) {
    echo "<br>Erreur : " . $e->getMessage();
}

$conn = null;
?>
