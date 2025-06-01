-- Ajouter la colonne role u00e0 la table users
ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `role` varchar(20) DEFAULT 'student';

-- Ajouter les colonnes niveau_id et groupe_id u00e0 la table users
ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `niveau_id` bigint(20) UNSIGNED NULL;
ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `groupe_id` bigint(20) UNSIGNED NULL;
