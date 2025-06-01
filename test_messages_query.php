<?php
// Script pour tester la requête SQL qui posait problème

$host = 'localhost';
$dbname = 'plat';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connexion à la base de données réussie<br>";
    
    // Exécuter la requête qui posait problème
    $sql = "SELECT messages.*, 
                  expediteur.email as expediteur_email, 
                  destinataire.email as destinataire_email 
           FROM messages 
           INNER JOIN utilisateurs as expediteur ON messages.id_expediteur = expediteur.id 
           INNER JOIN utilisateurs as destinataire ON messages.id_destinataire = destinataire.id 
           ORDER BY date_envoi DESC 
           LIMIT 5";
    
    $stmt = $conn->query($sql);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<br>Requête exécutée avec succès !<br>";
    
    // Afficher les résultats
    if (count($messages) > 0) {
        echo "<br>Messages récupérés (" . count($messages) . ") :<br>";
        foreach ($messages as $index => $message) {
            echo "<br>Message #" . ($index + 1) . ":<br>";
            echo "- De: " . $message['expediteur_email'] . "<br>";
            echo "- À: " . $message['destinataire_email'] . "<br>";
            echo "- Objet: " . ($message['objet'] ?? $message['sujet'] ?? 'Sans objet') . "<br>";
            echo "- Date: " . $message['date_envoi'] . "<br>";
            echo "- Lu: " . ($message['lu'] ? 'Oui' : 'Non') . "<br>";
        }
    } else {
        echo "<br>Aucun message trouvé. Créons quelques messages de test...<br>";
        
        // Vérifier si des utilisateurs existent
        $stmt = $conn->query("SELECT id, email FROM utilisateurs LIMIT 2");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($users) >= 2) {
            // Créer quelques messages de test
            try {
                // Vérifier la structure exacte de la table messages
                $stmt = $conn->query("DESCRIBE messages");
                $columns = [];
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $columns[$row['Field']] = $row;
                }
                
                // Construire la requête d'insertion en fonction des colonnes disponibles
                $fields = [];
                $placeholders = [];
                $params = [];
                
                // Données de base pour le message 1
                $messageData = [
                    'objet' => 'Bienvenue sur E-Taalim',
                    'contenu' => 'Bonjour et bienvenue sur la plateforme E-Taalim. Nous sommes ravis de vous compter parmi nos utilisateurs.',
                    'lu' => 0,
                    'date_envoi' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                
                // Ajouter les champs d'expéditeur et destinataire selon la structure
                if (isset($columns['id_expediteur'])) {
                    $messageData['id_expediteur'] = $users[0]['id'];
                }
                if (isset($columns['id_destinataire'])) {
                    $messageData['id_destinataire'] = $users[1]['id'];
                }
                if (isset($columns['expediteur_id'])) {
                    $messageData['expediteur_id'] = $users[0]['id'];
                }
                if (isset($columns['destinataire_id'])) {
                    $messageData['destinataire_id'] = $users[1]['id'];
                }
                if (isset($columns['sujet']) && !isset($messageData['objet'])) {
                    $messageData['sujet'] = 'Bienvenue sur E-Taalim';
                }
                
                // Construire la requête SQL
                foreach ($messageData as $field => $value) {
                    if (isset($columns[$field])) {
                        $fields[] = $field;
                        $placeholders[] = ":$field";
                        $params[$field] = $value;
                    }
                }
                
                $sql = "INSERT INTO messages (" . implode(", ", $fields) . ") VALUES (" . implode(", ", $placeholders) . ")";
                $stmt = $conn->prepare($sql);
                $stmt->execute($params);
                
                // Message 2 (inverser expéditeur et destinataire)
                $messageData['objet'] = 'Re: Bienvenue sur E-Taalim';
                $messageData['contenu'] = 'Merci pour votre message de bienvenue. Je suis heureux de rejoindre la plateforme.';
                $messageData['lu'] = 1;
                
                // Échanger expéditeur et destinataire
                if (isset($messageData['id_expediteur'])) {
                    $messageData['id_expediteur'] = $users[1]['id'];
                }
                if (isset($messageData['id_destinataire'])) {
                    $messageData['id_destinataire'] = $users[0]['id'];
                }
                if (isset($messageData['expediteur_id'])) {
                    $messageData['expediteur_id'] = $users[1]['id'];
                }
                if (isset($messageData['destinataire_id'])) {
                    $messageData['destinataire_id'] = $users[0]['id'];
                }
                
                // Mettre à jour les paramètres
                foreach ($messageData as $field => $value) {
                    if (isset($columns[$field])) {
                        $params[$field] = $value;
                    }
                }
                
                $stmt = $conn->prepare($sql);
                $stmt->execute($params);
                
                echo "Messages de test créés avec succès !<br>";
            } catch(PDOException $e) {
                echo "Erreur lors de la création des messages de test : " . $e->getMessage() . "<br>";
            }
            
            // Réexécuter la requête de sélection (pas la requête d'insertion)
            $selectSql = "SELECT messages.*, 
                  expediteur.email as expediteur_email, 
                  destinataire.email as destinataire_email 
           FROM messages 
           INNER JOIN utilisateurs as expediteur ON messages.id_expediteur = expediteur.id 
           INNER JOIN utilisateurs as destinataire ON messages.id_destinataire = destinataire.id 
           ORDER BY date_envoi DESC 
           LIMIT 5";
            
            $stmt = $conn->query($selectSql);
            $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "<br>Messages récupérés après création (" . count($messages) . ") :<br>";
            foreach ($messages as $index => $message) {
                echo "<br>Message #" . ($index + 1) . ":<br>";
                echo "- De: " . $message['expediteur_email'] . "<br>";
                echo "- À: " . $message['destinataire_email'] . "<br>";
                echo "- Objet: " . ($message['objet'] ?? $message['sujet'] ?? 'Sans objet') . "<br>";
                echo "- Date: " . $message['date_envoi'] . "<br>";
                echo "- Lu: " . ($message['lu'] ? 'Oui' : 'Non') . "<br>";
            }
        } else {
            echo "Pas assez d'utilisateurs pour créer des messages de test.<br>";
        }
    }
    
} catch(PDOException $e) {
    echo "<br>Erreur : " . $e->getMessage();
}

$conn = null;
echo "<br>Test terminé !";
?>
