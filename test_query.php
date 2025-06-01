<?php
// Script pour tester les requêtes SQL qui posaient problème

$host = 'localhost';
$dbname = 'plat';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connexion à la base de données réussie<br>";
    
    // Test 1: Compter les utilisateurs
    $stmt = $conn->query("SELECT COUNT(*) AS aggregate FROM utilisateurs");
    $count = $stmt->fetchColumn();
    echo "Nombre d'utilisateurs: $count<br>";
    
    // Test 2: Récupérer les statistiques du tableau de bord
    $students_count = $conn->query("
        SELECT COUNT(*) FROM utilisateurs
        JOIN roles ON utilisateurs.role_id = roles.id
        WHERE roles.nom = 'etudiant'
    ")->fetchColumn();
    echo "Nombre d'étudiants: $students_count<br>";
    
    $teachers_count = $conn->query("
        SELECT COUNT(*) FROM utilisateurs
        JOIN roles ON utilisateurs.role_id = roles.id
        WHERE roles.nom = 'enseignant'
    ")->fetchColumn();
    echo "Nombre d'enseignants: $teachers_count<br>";
    
    // Test 3: Vérifier si l'utilisateur avec ID 1 existe
    $stmt = $conn->query("SELECT id, email, name, meta_data FROM users WHERE id = 1 LIMIT 1");
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "Utilisateur ID 1 trouvé: {$user['email']} ({$user['name']})<br>";
        
        // Tester l'accès à meta_data
        $meta_data = json_decode($user['meta_data'], true);
        if ($meta_data) {
            echo "meta_data de l'utilisateur: " . print_r($meta_data, true) . "<br>";
        } else {
            echo "meta_data est null ou invalide<br>";
        }
    } else {
        echo "Utilisateur ID 1 non trouvé<br>";
    }
    
} catch(PDOException $e) {
    echo "<br>Erreur : " . $e->getMessage();
}

$conn = null;
echo "<br>Tests terminés !";
?>
