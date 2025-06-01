<?php
// Script pour vérifier et corriger les problèmes liés aux utilisateurs null

$host = 'localhost';
$dbname = 'plat';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connexion à la base de données réussie<br>";
    
    // 1. Vérifier si l'administrateur existe (ID 1)
    $stmt = $conn->query("SELECT * FROM users WHERE id = 1");
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$admin) {
        echo "L'administrateur (ID 1) n'existe pas. Recherche d'un administrateur existant...<br>";
        
        // Vérifier si un administrateur existe déjà avec un autre ID
        $stmt = $conn->query("SELECT * FROM users WHERE role = 'admin' LIMIT 1");
        $existingAdmin = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($existingAdmin) {
            echo "Un administrateur existe déjà avec l'ID {$existingAdmin['id']}. Mise à jour de l'ID...<br>";
            
            // Mettre à jour l'ID de l'administrateur existant à 1
            try {
                // Désactiver temporairement les contraintes de clé étrangère
                $conn->exec("SET FOREIGN_KEY_CHECKS = 0");
                
                // Mettre à jour l'ID
                $updateStmt = $conn->prepare("UPDATE users SET id = 1 WHERE id = :old_id");
                $updateStmt->bindParam(':old_id', $existingAdmin['id']);
                $updateStmt->execute();
                
                // Réactiver les contraintes de clé étrangère
                $conn->exec("SET FOREIGN_KEY_CHECKS = 1");
                
                echo "ID de l'administrateur mis à jour avec succès.<br>";
            } catch (PDOException $e) {
                echo "Erreur lors de la mise à jour de l'ID : " . $e->getMessage() . "<br>";
            }
        } else {
            echo "Aucun administrateur existant trouvé. Création d'un nouvel administrateur...<br>";
            
            // Générer un email unique
            $baseEmail = 'admin@etaalim.ma';
            $email = $baseEmail;
            $counter = 1;
            
            // Vérifier si l'email existe déjà
            $checkStmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
            $checkStmt->bindParam(':email', $email);
            $checkStmt->execute();
            
            while ($checkStmt->fetchColumn() > 0) {
                $email = str_replace('@', $counter . '@', $baseEmail);
                $counter++;
                $checkStmt->bindParam(':email', $email);
                $checkStmt->execute();
            }
            
            // Créer un administrateur par défaut
            $metaData = [
                'prenom' => 'Admin',
                'nom' => 'Système',
                'telephone' => '',
                'photo' => '',
                'active' => 1
            ];
            
            $stmt = $conn->prepare("INSERT INTO users (id, email, name, password, role, meta_data, created_at, updated_at) 
                                   VALUES (1, :email, :name, :password, :role, :meta_data, NOW(), NOW())");
            
            $name = 'Admin Système';
            $password = password_hash('admin123', PASSWORD_DEFAULT);
            $role = 'admin';
            $meta_data = json_encode($metaData);
            
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':meta_data', $meta_data);
            
            $stmt->execute();
            echo "Administrateur créé avec succès (email: $email, mot de passe: admin123)<br>";
        }
    } else {
        echo "L'administrateur (ID 1) existe déjà.<br>";
    }
    
    // 2. Vérifier si tous les utilisateurs ont un meta_data valide
    $stmt = $conn->query("SELECT id, email, meta_data FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $updateStmt = $conn->prepare("UPDATE users SET meta_data = :meta_data WHERE id = :id");
    
    $count = 0;
    foreach ($users as $user) {
        $meta_data = json_decode($user['meta_data'], true);
        
        // Si meta_data est null ou n'est pas un tableau valide
        if ($meta_data === null || !is_array($meta_data)) {
            $count++;
            
            // Créer un meta_data par défaut
            $defaultMetaData = [
                'prenom' => '',
                'nom' => '',
                'telephone' => '',
                'photo' => '',
                'active' => 1
            ];
            
            // Extraire le nom d'utilisateur de l'email pour le prénom par défaut
            $emailParts = explode('@', $user['email']);
            $defaultMetaData['prenom'] = $emailParts[0];
            
            $meta_data_json = json_encode($defaultMetaData);
            
            $updateStmt->bindParam(':meta_data', $meta_data_json);
            $updateStmt->bindParam(':id', $user['id']);
            $updateStmt->execute();
            
            echo "Correction du meta_data pour l'utilisateur {$user['email']} (ID: {$user['id']})<br>";
        }
    }
    
    echo "Correction terminée. $count utilisateurs ont été mis à jour avec un meta_data valide.<br>";
    
} catch(PDOException $e) {
    echo "<br>Erreur : " . $e->getMessage();
}

$conn = null;
echo "<br>Opération terminée !";
?>
