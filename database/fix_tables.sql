-- Cru00e9ation de la table groupe_student si elle n'existe pas
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

-- Vu00e9rifier si la table users existe et ajouter la colonne role
ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `role` varchar(20) DEFAULT 'student';

-- Ajouter les colonnes niveau_id et groupe_id u00e0 la table users
ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `niveau_id` bigint(20) UNSIGNED NULL;
ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `groupe_id` bigint(20) UNSIGNED NULL;
