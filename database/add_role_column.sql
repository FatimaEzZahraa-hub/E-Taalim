-- Ajouter la colonne 'role' u00e0 la table users
ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `role` enum('admin', 'teacher', 'student') DEFAULT 'student' AFTER `email`;

-- Ajouter les colonnes niveau_id et groupe_id u00e0 la table users
ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `niveau_id` bigint(20) UNSIGNED NULL AFTER `role`;
ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `groupe_id` bigint(20) UNSIGNED NULL AFTER `niveau_id`;

-- Ajouter les contraintes de clu00e9 u00e9trangu00e8re
ALTER TABLE `users` ADD CONSTRAINT `users_niveau_id_foreign` FOREIGN KEY (`niveau_id`) REFERENCES `niveaux` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE `users` ADD CONSTRAINT `users_groupe_id_foreign` FOREIGN KEY (`groupe_id`) REFERENCES `groupes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
