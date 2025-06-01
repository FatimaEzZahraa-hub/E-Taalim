-- Ajouter la colonne meta_data u00e0 la table users pour stocker les informations suppleu00mentaires
ALTER TABLE `users` ADD COLUMN `meta_data` JSON NULL AFTER `groupe_id`;
