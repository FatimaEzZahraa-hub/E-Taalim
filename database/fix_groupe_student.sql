-- Script pour créer uniquement la table groupe_student

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
