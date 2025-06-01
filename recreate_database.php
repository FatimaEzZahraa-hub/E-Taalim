<?php

/**
 * Script de recréation des tables essentielles pour E-Taalim
 * Ce script va créer directement les tables sans passer par les migrations Laravel
 */

// Charger l'application Laravel
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

echo "=== Script de recréation des tables E-Taalim ===\n\n";

try {
    // Vérifier la connexion à la base de données
    DB::connection()->getPdo();
    echo "✓ Connexion à la base de données établie avec succès.\n";
    
    // Désactiver les contraintes de clés étrangères
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    
    // Supprimer les tables existantes si elles existent
    $tablesToDrop = [
        'users', 'notifications', 'notification_user', 'evenements', 
        'cours', 'messages', 'niveaux', 'groupes', 'groupe_student',
        'devoirs', 'soumissions', 'complaints'
    ];
    
    foreach ($tablesToDrop as $table) {
        try {
            DB::statement("DROP TABLE IF EXISTS {$table}");
            echo "  - Table {$table} supprimée (si elle existait).\n";
        } catch (\Exception $e) {
            echo "  - Erreur lors de la suppression de la table {$table}: " . $e->getMessage() . "\n";
        }
    }
    
    // Réactiver les contraintes de clés étrangères
    DB::statement('SET FOREIGN_KEY_CHECKS=1');
    echo "✓ Nettoyage des tables terminé.\n\n";
    
    // Créer la table users
    echo "Création de la table users...\n";
    DB::statement("
        CREATE TABLE `users` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `email` varchar(255) NOT NULL,
            `password` varchar(255) NOT NULL,
            `role` varchar(50) NOT NULL,
            `meta_data` json DEFAULT NULL,
            `initial_password` varchar(255) DEFAULT NULL,
            `remember_token` varchar(100) DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `users_email_unique` (`email`) USING HASH
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Table users créée.\n";
    
    // Créer la table notifications
    echo "Création de la table notifications...\n";
    DB::statement("
        CREATE TABLE `notifications` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `titre` varchar(255) NOT NULL,
            `message` text NOT NULL,
            `date_notification` datetime NOT NULL,
            `lu` tinyint(1) NOT NULL DEFAULT 0,
            `user_id` bigint(20) UNSIGNED DEFAULT NULL,
            `type` varchar(50) NOT NULL DEFAULT 'information',
            `date_expiration` datetime DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `notifications_user_id_foreign` (`user_id`),
            CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Table notifications créée.\n";
    
    // Créer la table notification_user pour les notifications lues
    echo "Création de la table notification_user...\n";
    DB::statement("
        CREATE TABLE `notification_user` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `notification_id` bigint(20) UNSIGNED NOT NULL,
            `user_id` bigint(20) UNSIGNED NOT NULL,
            `read_at` timestamp NULL DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `notification_user_notification_id_foreign` (`notification_id`),
            KEY `notification_user_user_id_foreign` (`user_id`),
            CONSTRAINT `notification_user_notification_id_foreign` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`id`) ON DELETE CASCADE,
            CONSTRAINT `notification_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Table notification_user créée.\n";
    
    // Créer la table evenements
    echo "Création de la table evenements...\n";
    DB::statement("
        CREATE TABLE `evenements` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `titre` varchar(255) NOT NULL,
            `description` text NOT NULL,
            `date_debut` datetime NOT NULL,
            `date_fin` datetime NOT NULL,
            `created_by` bigint(20) UNSIGNED NOT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `evenements_created_by_foreign` (`created_by`),
            CONSTRAINT `evenements_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Table evenements créée.\n";
    
    // Créer la table messages
    echo "Création de la table messages...\n";
    DB::statement("
        CREATE TABLE `messages` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `expediteur_id` bigint(20) UNSIGNED NOT NULL,
            `destinataire_id` bigint(20) UNSIGNED NOT NULL,
            `sujet` varchar(255) NOT NULL,
            `contenu` text NOT NULL,
            `lu` tinyint(1) NOT NULL DEFAULT 0,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `messages_expediteur_id_foreign` (`expediteur_id`),
            KEY `messages_destinataire_id_foreign` (`destinataire_id`),
            CONSTRAINT `messages_expediteur_id_foreign` FOREIGN KEY (`expediteur_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
            CONSTRAINT `messages_destinataire_id_foreign` FOREIGN KEY (`destinataire_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Table messages créée.\n";
    
    // Ajouter des utilisateurs de test
    echo "\nAjout des utilisateurs de test...\n";
    
    // Administrateur
    $adminId = DB::table('users')->insertGetId([
        'email' => 'admin@etaalim.ma',
        'password' => Hash::make('password123'),
        'role' => 'admin',
        'meta_data' => json_encode([
            'prenom' => 'Admin',
            'nom' => 'Principal',
            'telephone' => '0600000000',
            'photo' => null,
            'active' => true
        ]),
        'initial_password' => 'password123',
        'created_at' => now(),
        'updated_at' => now()
    ]);
    echo "  - Administrateur créé (ID: {$adminId}).\n";
    
    // Enseignant
    $teacherId = DB::table('users')->insertGetId([
        'email' => 'prof.benani@etaalim.ma',
        'password' => Hash::make('password123'),
        'role' => 'teacher',
        'meta_data' => json_encode([
            'prenom' => 'Mohammed',
            'nom' => 'Benani',
            'telephone' => '0600000001',
            'specialite' => 'Mathématiques',
            'photo' => null,
            'active' => true
        ]),
        'initial_password' => 'password123',
        'created_at' => now(),
        'updated_at' => now()
    ]);
    echo "  - Enseignant créé (ID: {$teacherId}).\n";
    
    // Étudiant
    $studentId = DB::table('users')->insertGetId([
        'email' => 'ahmed.alami@etaalim.ma',
        'password' => Hash::make('password123'),
        'role' => 'student',
        'meta_data' => json_encode([
            'prenom' => 'Ahmed',
            'nom' => 'Alami',
            'telephone' => '0600000003',
            'photo' => null,
            'active' => true
        ]),
        'initial_password' => 'password123',
        'created_at' => now(),
        'updated_at' => now()
    ]);
    echo "  - Étudiant créé (ID: {$studentId}).\n";
    
    // Ajouter des notifications de test
    echo "\nAjout des notifications de test...\n";
    
    // Notification 1 (non lue)
    $notif1Id = DB::table('notifications')->insertGetId([
        'titre' => 'Bienvenue sur E-Taalim',
        'message' => 'Bienvenue sur la plateforme E-Taalim. Nous sommes ravis de vous accueillir !',
        'date_notification' => Carbon::now()->subDays(2),
        'lu' => false,
        'user_id' => null, // Pour tous les utilisateurs
        'type' => 'information',
        'created_at' => now(),
        'updated_at' => now()
    ]);
    echo "  - Notification 1 créée (ID: {$notif1Id}).\n";
    
    // Notification 2 (non lue)
    $notif2Id = DB::table('notifications')->insertGetId([
        'titre' => 'Maintenance prévue',
        'message' => 'Une maintenance du système est prévue ce weekend. La plateforme sera indisponible pendant quelques heures.',
        'date_notification' => Carbon::now()->subDay(),
        'lu' => false,
        'user_id' => null, // Pour tous les utilisateurs
        'type' => 'maintenance',
        'date_expiration' => Carbon::now()->addDays(5),
        'created_at' => now(),
        'updated_at' => now()
    ]);
    echo "  - Notification 2 créée (ID: {$notif2Id}).\n";
    
    // Notification 3 (lue)
    $notif3Id = DB::table('notifications')->insertGetId([
        'titre' => 'Mise à jour des fonctionnalités',
        'message' => 'De nouvelles fonctionnalités ont été ajoutées à la plateforme. Découvrez-les dès maintenant !',
        'date_notification' => Carbon::now()->subDays(5),
        'lu' => true,
        'user_id' => null, // Pour tous les utilisateurs
        'type' => 'information',
        'created_at' => now(),
        'updated_at' => now()
    ]);
    echo "  - Notification 3 créée (ID: {$notif3Id}).\n";
    
    // Ajouter des événements de test
    echo "\nAjout des événements de test...\n";
    
    $event1Id = DB::table('evenements')->insertGetId([
        'titre' => 'Réunion de rentrée',
        'description' => 'Réunion de présentation pour la nouvelle année scolaire',
        'date_debut' => Carbon::now()->addDays(5)->setTime(10, 0),
        'date_fin' => Carbon::now()->addDays(5)->setTime(12, 0),
        'created_by' => $adminId,
        'created_at' => now(),
        'updated_at' => now()
    ]);
    echo "  - Événement 1 créé (ID: {$event1Id}).\n";
    
    $event2Id = DB::table('evenements')->insertGetId([
        'titre' => 'Journée portes ouvertes',
        'description' => 'Journée de découverte de l\'établissement pour les nouveaux étudiants',
        'date_debut' => Carbon::now()->addDays(15)->setTime(9, 0),
        'date_fin' => Carbon::now()->addDays(15)->setTime(17, 0),
        'created_by' => $adminId,
        'created_at' => now(),
        'updated_at' => now()
    ]);
    echo "  - Événement 2 créé (ID: {$event2Id}).\n";
    
    // Ajouter des messages de test
    echo "\nAjout des messages de test...\n";
    
    $message1Id = DB::table('messages')->insertGetId([
        'expediteur_id' => $adminId,
        'destinataire_id' => $teacherId,
        'sujet' => 'Bienvenue dans l\'équipe',
        'contenu' => 'Bonjour et bienvenue dans l\'équipe pédagogique. N\'hésitez pas à me contacter si vous avez des questions.',
        'lu' => false,
        'created_at' => now(),
        'updated_at' => now()
    ]);
    echo "  - Message 1 créé (ID: {$message1Id}).\n";
    
    $message2Id = DB::table('messages')->insertGetId([
        'expediteur_id' => $teacherId,
        'destinataire_id' => $adminId,
        'sujet' => 'Re: Bienvenue dans l\'équipe',
        'contenu' => 'Merci pour votre accueil. Je suis ravi de rejoindre l\'équipe.',
        'lu' => true,
        'created_at' => now(),
        'updated_at' => now()
    ]);
    echo "  - Message 2 créé (ID: {$message2Id}).\n";
    
    echo "\n=== Recréation de la base de données terminée avec succès ===\n";
    echo "Vous pouvez maintenant accéder à l'application E-Taalim.\n";
    echo "Identifiants administrateur : admin@etaalim.ma / password123\n";
    
} catch (\Exception $e) {
    echo "❌ Erreur lors de la recréation de la base de données : " . $e->getMessage() . "\n";
    exit(1);
}
