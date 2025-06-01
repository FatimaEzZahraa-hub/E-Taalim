<?php
// Script pour examiner et corriger la table messages

$host = 'localhost';
$dbname = 'plat';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connexion à la base de données réussie<br>";
    
    // Examiner la structure de la table messages
    $stmt = $conn->query("DESCRIBE messages");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<br>Structure actuelle de la table 'messages':<br>";
    $hasDateEnvoi = false;
    
    foreach ($columns as $column) {
        echo "- {$column['Field']} ({$column['Type']})<br>";
        if ($column['Field'] === 'date_envoi') {
            $hasDateEnvoi = true;
        }
    }
    
    // Ajouter la colonne date_envoi si elle n'existe pas
    if (!$hasDateEnvoi) {
        echo "<br>La colonne 'date_envoi' est manquante. Ajout en cours...<br>";
        
        try {
            $sql = "ALTER TABLE messages ADD COLUMN date_envoi TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
            $conn->exec($sql);
            echo "Colonne 'date_envoi' ajoutée avec succès à la table 'messages'<br>";
            
            // Mettre à jour les enregistrements existants avec la date actuelle
            $sql = "UPDATE messages SET date_envoi = NOW() WHERE date_envoi IS NULL";
            $stmt = $conn->exec($sql);
            echo "Enregistrements existants mis à jour avec la date actuelle<br>";
        } catch(PDOException $e) {
            echo "Erreur lors de l'ajout de la colonne 'date_envoi' : " . $e->getMessage() . "<br>";
        }
    } else {
        echo "<br>La colonne 'date_envoi' existe déjà dans la table 'messages'<br>";
    }
    
    // Vérifier si d'autres colonnes importantes sont présentes
    $requiredColumns = [
        'contenu' => 'TEXT',
        'lu' => 'TINYINT(1) DEFAULT 0',
        'objet' => 'VARCHAR(255)'
    ];
    
    foreach ($requiredColumns as $columnName => $columnType) {
        $columnExists = false;
        
        foreach ($columns as $column) {
            if ($column['Field'] === $columnName) {
                $columnExists = true;
                break;
            }
        }
        
        if (!$columnExists) {
            echo "<br>La colonne '$columnName' est manquante. Ajout en cours...<br>";
            
            try {
                $sql = "ALTER TABLE messages ADD COLUMN $columnName $columnType";
                $conn->exec($sql);
                echo "Colonne '$columnName' ajoutée avec succès à la table 'messages'<br>";
            } catch(PDOException $e) {
                echo "Erreur lors de l'ajout de la colonne '$columnName' : " . $e->getMessage() . "<br>";
            }
        }
    }
    
    // Afficher la structure mise à jour
    $stmt = $conn->query("DESCRIBE messages");
    $updatedColumns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<br>Structure mise à jour de la table 'messages':<br>";
    foreach ($updatedColumns as $column) {
        echo "- {$column['Field']} ({$column['Type']})<br>";
    }
    
} catch(PDOException $e) {
    echo "<br>Erreur de connexion : " . $e->getMessage();
}

$conn = null;
echo "<br>Opération terminée !";
?>
