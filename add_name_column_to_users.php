<?php
// Script pour ajouter la colonne name à la table users et la remplir avec les données de meta_data

$host = 'localhost';
$dbname = 'plat';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connexion à la base de données réussie<br>";
    
    // Vérifier si la colonne existe déjà
    $stmt = $conn->query("SHOW COLUMNS FROM users LIKE 'name'");
    $column_exists = $stmt->fetchColumn();
    
    if (!$column_exists) {
        // Ajouter la colonne name
        $sql = "ALTER TABLE users ADD COLUMN name VARCHAR(255) NULL AFTER email";
        $conn->exec($sql);
        echo "Colonne name ajoutée avec succès à la table users<br>";
        
        // Récupérer tous les utilisateurs
        $stmt = $conn->query("SELECT id, meta_data FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Mettre à jour la colonne name avec les données de meta_data
        $updateStmt = $conn->prepare("UPDATE users SET name = :name WHERE id = :id");
        
        $count = 0;
        foreach ($users as $user) {
            $meta_data = json_decode($user['meta_data'], true);
            
            // Si meta_data est un tableau et contient prenom et nom
            if (is_array($meta_data) && isset($meta_data['prenom']) && isset($meta_data['nom'])) {
                $name = $meta_data['prenom'] . ' ' . $meta_data['nom'];
            } 
            // Si meta_data est un objet et contient prenom et nom
            else if (is_object($meta_data) && isset($meta_data->prenom) && isset($meta_data->nom)) {
                $name = $meta_data->prenom . ' ' . $meta_data->nom;
            }
            // Sinon, utiliser un nom par défaut basé sur l'email
            else {
                $parts = explode('@', $user['email']);
                $name = $parts[0];
            }
            
            $updateStmt->bindParam(':name', $name);
            $updateStmt->bindParam(':id', $user['id']);
            $updateStmt->execute();
            $count++;
        }
        
        echo "Mise à jour de la colonne name pour $count utilisateurs<br>";
    } else {
        echo "La colonne name existe déjà dans la table users<br>";
    }
    
} catch(PDOException $e) {
    echo "<br>Erreur : " . $e->getMessage();
}

$conn = null;
echo "<br>Opération terminée !";
?>
