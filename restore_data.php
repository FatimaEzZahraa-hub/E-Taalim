<?php

// Script pour restaurer les données dans les tables de l'application E-Taalim
// Créé le 1 juin 2025

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "plat";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion à la base de données réussie<br>";

    // Début de la transaction
    $conn->beginTransaction();

    // 1. Insertion des utilisateurs (admin, enseignants, étudiants)
    echo "Insertion des utilisateurs...<br>";
    
    // Vider la table users
    $conn->exec("DELETE FROM users");
    
    // Administrateur
    $admin = $conn->prepare("INSERT INTO users (email, password, role, meta_data, initial_password, created_at, updated_at) 
                            VALUES (:email, :password, :role, :meta_data, :initial_password, NOW(), NOW())");
    
    $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
    $adminMetaData = json_encode([
        'prenom' => 'Admin',
        'nom' => 'E-Taalim',
        'telephone' => '0600000000',
        'photo' => 'admin.jpg',
        'active' => true
    ]);
    
    $admin->bindParam(':email', $adminEmail);
    $admin->bindParam(':password', $adminPassword);
    $admin->bindParam(':role', $adminRole);
    $admin->bindParam(':meta_data', $adminMetaData);
    $admin->bindParam(':initial_password', $adminInitialPassword);
    
    $adminEmail = 'admin@etaalim.ma';
    $adminRole = 'admin';
    $adminInitialPassword = 'admin123';
    $admin->execute();
    $adminId = $conn->lastInsertId();
    
    // Enseignants
    $teacher = $conn->prepare("INSERT INTO users (email, password, role, meta_data, initial_password, created_at, updated_at) 
                              VALUES (:email, :password, :role, :meta_data, :initial_password, NOW(), NOW())");
    
    $teacherPassword = password_hash('password123', PASSWORD_DEFAULT);
    $teacherRole = 'teacher';
    $teacherInitialPassword = 'password123';
    
    // Enseignant 1
    $teacherMetaData1 = json_encode([
        'prenom' => 'Mohammed',
        'nom' => 'Benani',
        'telephone' => '0600000001',
        'photo' => 'teacher1.jpg',
        'active' => true,
        'specialite' => 'Mathématiques'
    ]);
    
    $teacher->bindParam(':email', $teacherEmail);
    $teacher->bindParam(':password', $teacherPassword);
    $teacher->bindParam(':role', $teacherRole);
    $teacher->bindParam(':meta_data', $teacherMetaData);
    $teacher->bindParam(':initial_password', $teacherInitialPassword);
    
    $teacherEmail = 'prof.benani@etaalim.ma';
    $teacherMetaData = $teacherMetaData1;
    $teacher->execute();
    $teacher1Id = $conn->lastInsertId();
    
    // Enseignant 2
    $teacherMetaData2 = json_encode([
        'prenom' => 'Fatima',
        'nom' => 'Alaoui',
        'telephone' => '0600000002',
        'photo' => 'teacher2.jpg',
        'active' => true,
        'specialite' => 'Physique'
    ]);
    
    $teacherEmail = 'prof.alaoui@etaalim.ma';
    $teacherMetaData = $teacherMetaData2;
    $teacher->execute();
    $teacher2Id = $conn->lastInsertId();
    
    // Étudiants
    $student = $conn->prepare("INSERT INTO users (email, password, role, meta_data, initial_password, created_at, updated_at) 
                              VALUES (:email, :password, :role, :meta_data, :initial_password, NOW(), NOW())");
    
    $studentPassword = password_hash('password123', PASSWORD_DEFAULT);
    $studentRole = 'student';
    $studentInitialPassword = 'password123';
    
    // Étudiant 1
    $studentMetaData1 = json_encode([
        'prenom' => 'Ahmed',
        'nom' => 'Alami',
        'telephone' => '0600000003',
        'photo' => 'student1.jpg',
        'active' => true
    ]);
    
    $student->bindParam(':email', $studentEmail);
    $student->bindParam(':password', $studentPassword);
    $student->bindParam(':role', $studentRole);
    $student->bindParam(':meta_data', $studentMetaData);
    $student->bindParam(':initial_password', $studentInitialPassword);
    
    $studentEmail = 'ahmed.alami@etaalim.ma';
    $studentMetaData = $studentMetaData1;
    $student->execute();
    $student1Id = $conn->lastInsertId();
    
    // Étudiant 2
    $studentMetaData2 = json_encode([
        'prenom' => 'Salma',
        'nom' => 'Bennani',
        'telephone' => '0600000004',
        'photo' => 'student2.jpg',
        'active' => true
    ]);
    
    $studentEmail = 'salma.bennani@etaalim.ma';
    $studentMetaData = $studentMetaData2;
    $student->execute();
    $student2Id = $conn->lastInsertId();
    
    // 2. Insertion des niveaux
    echo "Insertion des niveaux...<br>";
    
    // Vider la table niveaux
    $conn->exec("DELETE FROM niveaux");
    
    $niveaux = [
        ['nom' => 'Première année', 'description' => 'Première année du cycle'],
        ['nom' => 'Deuxième année', 'description' => 'Deuxième année du cycle'],
        ['nom' => 'Troisième année', 'description' => 'Troisième année du cycle']
    ];
    
    $niveau = $conn->prepare("INSERT INTO niveaux (nom, description, created_at, updated_at) 
                             VALUES (:nom, :description, NOW(), NOW())");
    
    foreach ($niveaux as $n) {
        $niveau->bindParam(':nom', $n['nom']);
        $niveau->bindParam(':description', $n['description']);
        $niveau->execute();
    }
    
    // 3. Insertion des groupes
    echo "Insertion des groupes...<br>";
    
    // Vider la table groupes
    $conn->exec("DELETE FROM groupes");
    
    // Récupérer les IDs des niveaux
    $niveauxIds = $conn->query("SELECT id FROM niveaux ORDER BY id")->fetchAll(PDO::FETCH_COLUMN);
    
    $groupes = [
        ['nom' => 'Groupe A', 'description' => 'Premier groupe du niveau 1', 'niveau_id' => $niveauxIds[0]],
        ['nom' => 'Groupe B', 'description' => 'Second groupe du niveau 1', 'niveau_id' => $niveauxIds[0]],
        ['nom' => 'Groupe A', 'description' => 'Premier groupe du niveau 2', 'niveau_id' => $niveauxIds[1]],
        ['nom' => 'Groupe B', 'description' => 'Second groupe du niveau 2', 'niveau_id' => $niveauxIds[1]],
        ['nom' => 'Groupe A', 'description' => 'Premier groupe du niveau 3', 'niveau_id' => $niveauxIds[2]],
        ['nom' => 'Groupe B', 'description' => 'Second groupe du niveau 3', 'niveau_id' => $niveauxIds[2]]
    ];
    
    $groupe = $conn->prepare("INSERT INTO groupes (nom, description, niveau_id, created_at, updated_at) 
                             VALUES (:nom, :description, :niveau_id, NOW(), NOW())");
    
    $groupeIds = [];
    foreach ($groupes as $g) {
        $groupe->bindParam(':nom', $g['nom']);
        $groupe->bindParam(':description', $g['description']);
        $groupe->bindParam(':niveau_id', $g['niveau_id']);
        $groupe->execute();
        $groupeIds[] = $conn->lastInsertId();
    }
    
    // 4. Association des étudiants aux groupes
    echo "Association des étudiants aux groupes...<br>";
    
    // Vider la table groupe_student
    $conn->exec("DELETE FROM groupe_student");
    
    $groupeStudent = $conn->prepare("INSERT INTO groupe_student (groupe_id, user_id, created_at, updated_at) 
                                    VALUES (:groupe_id, :user_id, NOW(), NOW())");
    
    // Associer l'étudiant 1 au groupe 1
    $groupeStudent->bindParam(':groupe_id', $groupeIds[0]);
    $groupeStudent->bindParam(':user_id', $student1Id);
    $groupeStudent->execute();
    
    // Associer l'étudiant 2 au groupe 3
    $groupeStudent->bindParam(':groupe_id', $groupeIds[2]);
    $groupeStudent->bindParam(':user_id', $student2Id);
    $groupeStudent->execute();
    
    // 5. Insertion des modules
    echo "Insertion des modules...<br>";
    
    // Vider la table modules
    $conn->exec("DELETE FROM modules");
    
    $modules = [
        [
            'nom' => 'Mathématiques', 
            'description' => 'Module de mathématiques', 
            'code' => 'MATH101',
            'couleur' => '#3498db',
            'niveau_id' => $niveauxIds[0],
            'enseignant_id' => $teacher1Id,
            'actif' => 1
        ],
        [
            'nom' => 'Physique', 
            'description' => 'Module de physique', 
            'code' => 'PHYS101',
            'couleur' => '#e74c3c',
            'niveau_id' => $niveauxIds[0],
            'enseignant_id' => $teacher2Id,
            'actif' => 1
        ],
        [
            'nom' => 'Informatique', 
            'description' => 'Module d\'informatique', 
            'code' => 'INFO101',
            'couleur' => '#2ecc71',
            'niveau_id' => $niveauxIds[1],
            'enseignant_id' => $teacher1Id,
            'actif' => 1
        ],
        [
            'nom' => 'Langues', 
            'description' => 'Module de langues', 
            'code' => 'LANG101',
            'couleur' => '#f39c12',
            'niveau_id' => $niveauxIds[1],
            'enseignant_id' => $teacher2Id,
            'actif' => 1
        ]
    ];
    
    $module = $conn->prepare("INSERT INTO modules (nom, description, code, couleur, niveau_id, enseignant_id, actif, created_at, updated_at) 
                             VALUES (:nom, :description, :code, :couleur, :niveau_id, :enseignant_id, :actif, NOW(), NOW())");
    
    $moduleIds = [];
    foreach ($modules as $m) {
        $module->bindParam(':nom', $m['nom']);
        $module->bindParam(':description', $m['description']);
        $module->bindParam(':code', $m['code']);
        $module->bindParam(':couleur', $m['couleur']);
        $module->bindParam(':niveau_id', $m['niveau_id']);
        $module->bindParam(':enseignant_id', $m['enseignant_id']);
        $module->bindParam(':actif', $m['actif']);
        $module->execute();
        $moduleIds[] = $conn->lastInsertId();
    }
    
    // 6. Association des modules aux groupes
    echo "Association des modules aux groupes...<br>";
    
    // Vider la table module_groupe
    $conn->exec("DELETE FROM module_groupe");
    
    $moduleGroupe = $conn->prepare("INSERT INTO module_groupe (module_id, groupe_id, date_affectation, created_at, updated_at) 
                                   VALUES (:module_id, :groupe_id, CURDATE(), NOW(), NOW())");
    
    // Associer le module 1 (Mathématiques) aux groupes 1, 3 et 5
    $moduleGroupe->bindParam(':module_id', $moduleIds[0]);
    $moduleGroupe->bindParam(':groupe_id', $groupeId);
    
    $groupeId = $groupeIds[0];
    $moduleGroupe->execute();
    
    $groupeId = $groupeIds[2];
    $moduleGroupe->execute();
    
    $groupeId = $groupeIds[4];
    $moduleGroupe->execute();
    
    // Associer le module 2 (Physique) aux groupes 2, 4 et 6
    $moduleGroupe->bindParam(':module_id', $moduleIds[1]);
    
    $groupeId = $groupeIds[1];
    $moduleGroupe->execute();
    
    $groupeId = $groupeIds[3];
    $moduleGroupe->execute();
    
    $groupeId = $groupeIds[5];
    $moduleGroupe->execute();
    
    // 7. Insertion des cours
    echo "Insertion des cours...<br>";
    
    // Vider la table cours
    $conn->exec("DELETE FROM cours");
    
    $cours = [
        [
            'titre' => 'Algèbre linéaire', 
            'description' => 'Cours d\'algèbre linéaire pour les débutants', 
            'contenu' => 'Contenu du cours d\'algèbre linéaire',
            'niveau_id' => $niveauxIds[0],
            'enseignant_id' => $teacher1Id,
            'statut' => 'approuve'
        ],
        [
            'titre' => 'Mécanique quantique', 
            'description' => 'Introduction à la mécanique quantique', 
            'contenu' => 'Contenu du cours de mécanique quantique',
            'niveau_id' => $niveauxIds[1],
            'enseignant_id' => $teacher2Id,
            'statut' => 'approuve'
        ]
    ];
    
    $coursStmt = $conn->prepare("INSERT INTO cours (titre, description, contenu, niveau_id, enseignant_id, statut, created_at, updated_at) 
                                VALUES (:titre, :description, :contenu, :niveau_id, :enseignant_id, :statut, NOW(), NOW())");
    
    $coursIds = [];
    foreach ($cours as $c) {
        $coursStmt->bindParam(':titre', $c['titre']);
        $coursStmt->bindParam(':description', $c['description']);
        $coursStmt->bindParam(':contenu', $c['contenu']);
        $coursStmt->bindParam(':niveau_id', $c['niveau_id']);
        $coursStmt->bindParam(':enseignant_id', $c['enseignant_id']);
        $coursStmt->bindParam(':statut', $c['statut']);
        $coursStmt->execute();
        $coursIds[] = $conn->lastInsertId();
    }
    
    // 8. Insertion des devoirs
    echo "Insertion des devoirs...<br>";
    
    // Vider la table devoirs
    $conn->exec("DELETE FROM devoirs");
    
    $devoirs = [
        [
            'titre' => 'Devoir d\'algèbre', 
            'description' => 'Devoir sur les matrices', 
            'date_limite' => '2025-06-15',
            'cours_id' => $coursIds[0],
            'enseignant_id' => $teacher1Id
        ],
        [
            'titre' => 'Devoir de physique', 
            'description' => 'Devoir sur les ondes', 
            'date_limite' => '2025-06-20',
            'cours_id' => $coursIds[1],
            'enseignant_id' => $teacher2Id
        ]
    ];
    
    $devoir = $conn->prepare("INSERT INTO devoirs (titre, description, date_limite, cours_id, enseignant_id, created_at, updated_at) 
                             VALUES (:titre, :description, :date_limite, :cours_id, :enseignant_id, NOW(), NOW())");
    
    $devoirIds = [];
    foreach ($devoirs as $d) {
        $devoir->bindParam(':titre', $d['titre']);
        $devoir->bindParam(':description', $d['description']);
        $devoir->bindParam(':date_limite', $d['date_limite']);
        $devoir->bindParam(':cours_id', $d['cours_id']);
        $devoir->bindParam(':enseignant_id', $d['enseignant_id']);
        $devoir->execute();
        $devoirIds[] = $conn->lastInsertId();
    }
    
    // 9. Insertion des événements
    echo "Insertion des événements...<br>";
    
    // Vider la table evenements
    $conn->exec("DELETE FROM evenements");
    
    $evenements = [
        [
            'titre' => 'Réunion de rentrée', 
            'description' => 'Réunion de rentrée pour les nouveaux étudiants', 
            'date_debut' => '2025-09-01 10:00:00',
            'date_fin' => '2025-09-01 12:00:00',
            'created_by' => $adminId
        ],
        [
            'titre' => 'Conférence sur l\'IA', 
            'description' => 'Conférence sur l\'intelligence artificielle et ses applications', 
            'date_debut' => '2025-09-15 14:00:00',
            'date_fin' => '2025-09-15 16:00:00',
            'created_by' => $teacher1Id
        ]
    ];
    
    $evenement = $conn->prepare("INSERT INTO evenements (titre, description, date_debut, date_fin, created_by, created_at, updated_at) 
                               VALUES (:titre, :description, :date_debut, :date_fin, :created_by, NOW(), NOW())");
    
    $evenementIds = [];
    foreach ($evenements as $e) {
        $evenement->bindParam(':titre', $e['titre']);
        $evenement->bindParam(':description', $e['description']);
        $evenement->bindParam(':date_debut', $e['date_debut']);
        $evenement->bindParam(':date_fin', $e['date_fin']);
        $evenement->bindParam(':created_by', $e['created_by']);
        $evenement->execute();
        $evenementIds[] = $conn->lastInsertId();
    }
    
    // 10. Insertion des notifications
    echo "Insertion des notifications...<br>";
    
    // Vider la table notifications
    $conn->exec("DELETE FROM notifications");
    
    $notifications = [
        [
            'titre' => 'Bienvenue sur E-Taalim', 
            'message' => 'Bienvenue sur la plateforme E-Taalim. Nous sommes ravis de vous accueillir !', 
            'date_notification' => '2025-06-01 00:00:00',
            'lu' => 0,
            'user_id' => $adminId,
            'type' => 'information'
        ],
        [
            'titre' => 'Maintenance prévue', 
            'message' => 'Une maintenance du système est prévue le 5 juin 2025 de 22h à 23h. Le service sera indisponible pendant cette période.', 
            'date_notification' => '2025-06-01 10:00:00',
            'lu' => 0,
            'user_id' => $adminId,
            'type' => 'maintenance'
        ],
        [
            'titre' => 'Nouvel événement', 
            'message' => 'Un nouvel événement a été ajouté : Journée portes ouvertes le 1er septembre 2025.', 
            'date_notification' => '2025-06-01 11:00:00',
            'lu' => 0,
            'user_id' => $adminId,
            'type' => 'evenement'
        ],
        [
            'titre' => 'Mise à jour du système', 
            'message' => 'Le système a été mis à jour vers la version 2.0. De nouvelles fonctionnalités sont disponibles.', 
            'date_notification' => '2025-06-01 12:00:00',
            'lu' => 0,
            'user_id' => $adminId,
            'type' => 'information'
        ],
        [
            'titre' => 'Rappel : Examens', 
            'message' => 'Les examens finaux auront lieu du 10 au 20 décembre 2025. Préparez-vous dès maintenant !', 
            'date_notification' => '2025-06-01 13:00:00',
            'lu' => 0,
            'user_id' => $adminId,
            'type' => 'evenement'
        ]
    ];
    
    $notification = $conn->prepare("INSERT INTO notifications (titre, message, date_notification, lu, user_id, type, created_at, updated_at) 
                                   VALUES (:titre, :message, :date_notification, :lu, :user_id, :type, NOW(), NOW())");
    
    $notificationIds = [];
    foreach ($notifications as $n) {
        $notification->bindParam(':titre', $n['titre']);
        $notification->bindParam(':message', $n['message']);
        $notification->bindParam(':date_notification', $n['date_notification']);
        $notification->bindParam(':lu', $n['lu']);
        $notification->bindParam(':user_id', $n['user_id']);
        $notification->bindParam(':type', $n['type']);
        $notification->execute();
        $notificationIds[] = $conn->lastInsertId();
    }
    
    // 11. Insertion des relations notification_user
    echo "Insertion des relations notification_user...<br>";
    
    // Vider la table notification_user
    $conn->exec("DELETE FROM notification_user");
    
    $notificationUser = $conn->prepare("INSERT INTO notification_user (notification_id, user_id, created_at, updated_at) 
                                       VALUES (:notification_id, :user_id, NOW(), NOW())");
    
    // Associer les notifications à l'admin
    foreach ($notificationIds as $notificationId) {
        $notificationUser->bindParam(':notification_id', $notificationId);
        $notificationUser->bindParam(':user_id', $adminId);
        $notificationUser->execute();
    }
    
    // 12. Insertion des messages
    echo "Insertion des messages...<br>";
    
    // Vider la table messages
    $conn->exec("DELETE FROM messages");
    
    $messages = [
        [
            'sujet' => 'Question sur le cours', 
            'contenu' => 'Bonjour, j\'ai une question concernant le cours d\'algèbre. Pourriez-vous m\'éclaircir sur les matrices ?', 
            'expediteur_id' => $student1Id,
            'destinataire_id' => $teacher1Id,
            'lu' => 0
        ],
        [
            'sujet' => 'Réponse à votre question', 
            'contenu' => 'Bonjour, bien sûr. Les matrices sont des tableaux de nombres qui permettent de résoudre des systèmes d\'équations linéaires. N\'hésitez pas si vous avez d\'autres questions.', 
            'expediteur_id' => $teacher1Id,
            'destinataire_id' => $student1Id,
            'lu' => 0
        ],
        [
            'sujet' => 'Absence prévue', 
            'contenu' => 'Bonjour, je vous informe que je serai absent au prochain cours pour des raisons médicales. Pourriez-vous me communiquer les notes du cours ?', 
            'expediteur_id' => $student2Id,
            'destinataire_id' => $teacher2Id,
            'lu' => 0
        ]
    ];
    
    $message = $conn->prepare("INSERT INTO messages (sujet, contenu, expediteur_id, destinataire_id, lu, created_at, updated_at) 
                              VALUES (:sujet, :contenu, :expediteur_id, :destinataire_id, :lu, NOW(), NOW())");
    
    foreach ($messages as $m) {
        $message->bindParam(':sujet', $m['sujet']);
        $message->bindParam(':contenu', $m['contenu']);
        $message->bindParam(':expediteur_id', $m['expediteur_id']);
        $message->bindParam(':destinataire_id', $m['destinataire_id']);
        $message->bindParam(':lu', $m['lu']);
        $message->execute();
    }
    
    // Valider la transaction
    $conn->commit();
    
    echo "<br>Restauration des données terminée avec succès !";
    
} catch(PDOException $e) {
    // En cas d'erreur, annuler la transaction
    if ($conn) {
        $conn->rollBack();
    }
    echo "<br>Erreur : " . $e->getMessage();
}

$conn = null;
?>
