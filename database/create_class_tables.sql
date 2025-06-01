-- Script SQL pour créer les tables nécessaires pour la gestion des classes

-- Vérifier d'abord quelles tables existent
SHOW TABLES;

-- Création de la table niveaux sans contraintes
CREATE TABLE IF NOT EXISTS `niveaux` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` text,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Création de la table groupes sans contraintes
CREATE TABLE IF NOT EXISTS `groupes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `niveau_id` bigint(20) UNSIGNED NOT NULL,
  `description` text,
  `capacite` int(11) DEFAULT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `groupes_niveau_id_foreign` (`niveau_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Création de la table pivot groupe_student sans contraintes
CREATE TABLE IF NOT EXISTS `groupe_student` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `groupe_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date_affectation` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `groupe_student_groupe_id_foreign` (`groupe_id`),
  KEY `groupe_student_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Vérifier si la table users existe
SHOW TABLES LIKE 'users';

-- Vérifier si la table utilisateurs existe
SHOW TABLES LIKE 'utilisateurs';

-- Ajout des colonnes nécessaires à la table users ou utilisateurs (selon celle qui existe)
-- Décommentez la section appropriée après avoir vérifié quelle table existe

-- Pour la table users
-- ALTER TABLE `users`
-- ADD COLUMN IF NOT EXISTS `role` enum('admin', 'teacher', 'student') DEFAULT 'student' AFTER `email`,
-- ADD COLUMN IF NOT EXISTS `niveau_id` bigint(20) UNSIGNED NULL AFTER `role`,
-- ADD COLUMN IF NOT EXISTS `groupe_id` bigint(20) UNSIGNED NULL AFTER `niveau_id`;

-- Pour la table utilisateurs
-- ALTER TABLE `utilisateurs`
-- ADD COLUMN IF NOT EXISTS `role` enum('admin', 'teacher', 'student') DEFAULT 'student' AFTER `email`,
-- ADD COLUMN IF NOT EXISTS `niveau_id` bigint(20) UNSIGNED NULL AFTER `role`,
-- ADD COLUMN IF NOT EXISTS `groupe_id` bigint(20) UNSIGNED NULL AFTER `niveau_id`;

-- Ajout des contraintes de clé étrangère (à exécuter après avoir créé toutes les tables et colonnes)
-- Décommentez ces lignes après avoir vérifié que toutes les tables existent

-- ALTER TABLE `groupes`
-- ADD CONSTRAINT `groupes_niveau_id_foreign` FOREIGN KEY (`niveau_id`) REFERENCES `niveaux` (`id`) ON DELETE CASCADE;

-- Pour la table users
-- ALTER TABLE `users`
-- ADD CONSTRAINT `users_niveau_id_foreign` FOREIGN KEY (`niveau_id`) REFERENCES `niveaux` (`id`) ON DELETE SET NULL,
-- ADD CONSTRAINT `users_groupe_id_foreign` FOREIGN KEY (`groupe_id`) REFERENCES `groupes` (`id`) ON DELETE SET NULL;

-- Pour la table utilisateurs
-- ALTER TABLE `utilisateurs`
-- ADD CONSTRAINT `utilisateurs_niveau_id_foreign` FOREIGN KEY (`niveau_id`) REFERENCES `niveaux` (`id`) ON DELETE SET NULL,
-- ADD CONSTRAINT `utilisateurs_groupe_id_foreign` FOREIGN KEY (`groupe_id`) REFERENCES `groupes` (`id`) ON DELETE SET NULL;

-- Pour la table groupe_student avec users
-- ALTER TABLE `groupe_student`
-- ADD CONSTRAINT `groupe_student_groupe_id_foreign` FOREIGN KEY (`groupe_id`) REFERENCES `groupes` (`id`) ON DELETE CASCADE,
-- ADD CONSTRAINT `groupe_student_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

-- Pour la table groupe_student avec utilisateurs
-- ALTER TABLE `groupe_student`
-- ADD CONSTRAINT `groupe_student_groupe_id_foreign` FOREIGN KEY (`groupe_id`) REFERENCES `groupes` (`id`) ON DELETE CASCADE,
-- ADD CONSTRAINT `groupe_student_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE;
