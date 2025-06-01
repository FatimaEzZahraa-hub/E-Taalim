<?php
// Script pour ajouter la colonne date_affectation à la table groupe_student

$host = 'localhost';
$dbname = 'plat';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connexion à la base de données réussie<br>";
    
    // Vérifier si la colonne existe déjà
    $stmt = $conn->query("SHOW COLUMNS FROM groupe_student LIKE 'date_affectation'");
    $column_exists = $stmt->fetchColumn();
    
    if (!$column_exists) {
        // Ajouter la colonne date_affectation
        $sql = "ALTER TABLE groupe_student ADD COLUMN date_affectation DATE NULL AFTER groupe_id";
        $conn->exec($sql);
        echo "Colonne date_affectation ajoutée avec succès à la table groupe_student<br>";
        
        // Mettre à jour les enregistrements existants avec la date actuelle
        $sql = "UPDATE groupe_student SET date_affectation = CURDATE()";
        $conn->exec($sql);
        echo "Tous les enregistrements ont été mis à jour avec la date actuelle<br>";
    } else {
        echo "La colonne date_affectation existe déjà dans la table groupe_student<br>";
    }
    
} catch(PDOException $e) {
    echo "<br>Erreur : " . $e->getMessage();
}

$conn = null;
echo "<br>Opération terminée !";
?>
