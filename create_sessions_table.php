<?php
// Script pour créer la table sessions avec la structure correcte pour Laravel

$host = 'localhost';
$dbname = 'plat';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connexion à la base de données réussie<br>";
    
    // Supprimer la table sessions existante
    $conn->exec("DROP TABLE IF EXISTS sessions");
    
    // Créer la nouvelle table sessions avec la structure correcte pour Laravel
    $sql = "CREATE TABLE sessions (
        id VARCHAR(255) NOT NULL,
        user_id BIGINT UNSIGNED NULL,
        ip_address VARCHAR(45) NULL,
        user_agent TEXT NULL,
        payload TEXT NOT NULL,
        last_activity INT NOT NULL,
        PRIMARY KEY(id(191))
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $conn->exec($sql);
    echo "Table sessions créée avec succès<br>";
    
} catch(PDOException $e) {
    echo "<br>Erreur : " . $e->getMessage();
}

$conn = null;
echo "<br>Opération terminée !";
?>
