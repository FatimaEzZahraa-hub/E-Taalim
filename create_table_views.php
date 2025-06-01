<?php
// Script pour créer des vues SQL permettant d'utiliser les anciens noms de tables

$host = 'localhost';
$dbname = 'plat';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connexion à la base de données réussie<br>";
    
    // Vérifier si la vue 'utilisateurs' existe déjà
    $stmt = $conn->query("SHOW TABLES LIKE 'utilisateurs'");
    $tableExists = $stmt->rowCount() > 0;
    
    if (!$tableExists) {
        // Vérifier la structure de la table 'users'
        $stmt = $conn->query("DESCRIBE users");
        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        // Vérifier si la table 'users' a une colonne 'role_id'
        $hasRoleId = in_array('role_id', $columns);
        
        // Si 'users' n'a pas de colonne 'role_id', nous devons créer une vue qui gère cette différence
        if (!$hasRoleId) {
            // Créer une vue 'utilisateurs' qui mappe 'role' à 'role_id'
            $sql = "CREATE OR REPLACE VIEW utilisateurs AS 
                   SELECT id, email, name, password as mot_de_passe, 
                   CASE 
                     WHEN role = 'admin' THEN 1
                     WHEN role = 'enseignant' THEN 2
                     WHEN role = 'etudiant' THEN 3
                     ELSE 4
                   END as role_id,
                   role, meta_data, initial_password, remember_token, created_at, updated_at
                   FROM users";
        } else {
            // Créer une vue simple qui renomme juste la table
            $sql = "CREATE OR REPLACE VIEW utilisateurs AS SELECT * FROM users";
        }
        
        $conn->exec($sql);
        echo "Vue 'utilisateurs' créée avec succès<br>";
    } else {
        echo "La vue ou table 'utilisateurs' existe déjà<br>";
    }
    
    // Vérifier si la table 'roles' existe
    $stmt = $conn->query("SHOW TABLES LIKE 'roles'");
    $rolesExists = $stmt->rowCount() > 0;
    
    if (!$rolesExists) {
        // Créer une table 'roles' de base
        $sql = "CREATE TABLE IF NOT EXISTS roles (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nom VARCHAR(50) NOT NULL,
            description VARCHAR(255),
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL
        )";
        $conn->exec($sql);
        
        // Insérer les rôles de base
        $sql = "INSERT INTO roles (id, nom, description) VALUES 
            (1, 'admin', 'Administrateur du système'),
            (2, 'enseignant', 'Enseignant'),
            (3, 'etudiant', 'Étudiant'),
            (4, 'autre', 'Autre rôle')";
        $conn->exec($sql);
        
        echo "Table 'roles' créée et remplie avec succès<br>";
    } else {
        echo "La table 'roles' existe déjà<br>";
    }
    
    // Vérifier si la table 'messages' existe
    $stmt = $conn->query("SHOW TABLES LIKE 'messages'");
    $messagesExists = $stmt->rowCount() > 0;
    
    if ($messagesExists) {
        // Vérifier si la colonne id_expediteur existe
        $stmt = $conn->query("SHOW COLUMNS FROM messages LIKE 'id_expediteur'");
        $hasExpColumn = $stmt->rowCount() > 0;
        
        if (!$hasExpColumn) {
            // Ajouter la colonne id_expediteur
            try {
                $sql = "ALTER TABLE messages ADD COLUMN id_expediteur INT";
                $conn->exec($sql);
                echo "Colonne id_expediteur ajoutée à la table 'messages'<br>";
            } catch(PDOException $e) {
                echo "Erreur lors de l'ajout de la colonne id_expediteur : " . $e->getMessage() . "<br>";
            }
        } else {
            echo "La colonne id_expediteur existe déjà dans la table 'messages'<br>";
        }
        
        // Vérifier si la colonne id_destinataire existe
        $stmt = $conn->query("SHOW COLUMNS FROM messages LIKE 'id_destinataire'");
        $hasDestColumn = $stmt->rowCount() > 0;
        
        if (!$hasDestColumn) {
            // Ajouter la colonne id_destinataire
            try {
                $sql = "ALTER TABLE messages ADD COLUMN id_destinataire INT";
                $conn->exec($sql);
                echo "Colonne id_destinataire ajoutée à la table 'messages'<br>";
            } catch(PDOException $e) {
                echo "Erreur lors de l'ajout de la colonne id_destinataire : " . $e->getMessage() . "<br>";
            }
        } else {
            echo "La colonne id_destinataire existe déjà dans la table 'messages'<br>";
        }
    } else {
        echo "La table 'messages' n'existe pas<br>";
    }
    
} catch(PDOException $e) {
    echo "<br>Erreur : " . $e->getMessage();
}

$conn = null;
echo "<br>Opération terminée !";
?>
