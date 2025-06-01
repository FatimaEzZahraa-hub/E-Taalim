<?php
// Script pour examiner et corriger la table niveaux

$host = 'localhost';
$dbname = 'plat';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connexion à la base de données réussie<br>";
    
    // Examiner la structure de la table niveaux
    $stmt = $conn->query("DESCRIBE niveaux");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<br>Structure actuelle de la table 'niveaux':<br>";
    $hasActif = false;
    
    foreach ($columns as $column) {
        echo "- {$column['Field']} ({$column['Type']})<br>";
        if ($column['Field'] === 'actif') {
            $hasActif = true;
        }
    }
    
    // Ajouter la colonne actif si elle n'existe pas
    if (!$hasActif) {
        echo "<br>La colonne 'actif' est manquante. Ajout en cours...<br>";
        
        try {
            $sql = "ALTER TABLE niveaux ADD COLUMN actif TINYINT(1) NOT NULL DEFAULT 1";
            $conn->exec($sql);
            echo "Colonne 'actif' ajoutée avec succès à la table 'niveaux'<br>";
            
            // Mettre à jour tous les niveaux existants pour les activer par défaut
            $sql = "UPDATE niveaux SET actif = 1";
            $stmt = $conn->exec($sql);
            echo "Tous les niveaux existants ont été activés par défaut<br>";
        } catch(PDOException $e) {
            echo "Erreur lors de l'ajout de la colonne 'actif' : " . $e->getMessage() . "<br>";
        }
    } else {
        echo "<br>La colonne 'actif' existe déjà dans la table 'niveaux'<br>";
    }
    
    // Vérifier si la table contient des données
    $stmt = $conn->query("SELECT COUNT(*) FROM niveaux");
    $count = $stmt->fetchColumn();
    
    echo "<br>Nombre de niveaux dans la table: $count<br>";
    
    if ($count == 0) {
        echo "<br>La table 'niveaux' est vide. Ajout de quelques niveaux par défaut...<br>";
        
        // Ajouter quelques niveaux par défaut
        $niveaux = [
            ['nom' => 'Primaire', 'description' => 'Niveau primaire (6-11 ans)'],
            ['nom' => 'Collège', 'description' => 'Niveau collège (12-15 ans)'],
            ['nom' => 'Lycée', 'description' => 'Niveau lycée (16-18 ans)'],
            ['nom' => 'Supérieur', 'description' => 'Niveau enseignement supérieur']
        ];
        
        $sql = "INSERT INTO niveaux (nom, description, actif) VALUES (:nom, :description, 1)";
        $stmt = $conn->prepare($sql);
        
        foreach ($niveaux as $niveau) {
            $stmt->execute([
                'nom' => $niveau['nom'],
                'description' => $niveau['description']
            ]);
        }
        
        echo "Niveaux par défaut ajoutés avec succès<br>";
    }
    
    // Tester la requête qui posait problème
    echo "<br>Test de la requête qui posait problème:<br>";
    
    try {
        $stmt = $conn->query("SELECT id, nom, description FROM niveaux WHERE actif = 1");
        $niveaux = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "Requête exécutée avec succès !<br>";
        echo "Nombre de niveaux actifs: " . count($niveaux) . "<br>";
        
        foreach ($niveaux as $niveau) {
            echo "- {$niveau['nom']}: {$niveau['description']}<br>";
        }
    } catch(PDOException $e) {
        echo "Erreur lors de l'exécution de la requête: " . $e->getMessage() . "<br>";
    }
    
    // Afficher la structure mise à jour
    $stmt = $conn->query("DESCRIBE niveaux");
    $updatedColumns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<br>Structure mise à jour de la table 'niveaux':<br>";
    foreach ($updatedColumns as $column) {
        echo "- {$column['Field']} ({$column['Type']})<br>";
    }
    
} catch(PDOException $e) {
    echo "<br>Erreur de connexion : " . $e->getMessage();
}

$conn = null;
echo "<br>Opération terminée !";
?>
