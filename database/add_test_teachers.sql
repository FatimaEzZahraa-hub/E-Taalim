-- Script pour ajouter des enseignants de test

-- Vu00e9rifier si le ru00f4le 'enseignant' existe, sinon le cru00e9er
INSERT INTO roles (nom, description, created_at, updated_at)
SELECT 'enseignant', 'Ru00f4le pour les enseignants', NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM roles WHERE nom = 'enseignant');

-- Ru00e9cupu00e9rer l'ID du ru00f4le enseignant
SET @role_id = (SELECT id FROM roles WHERE nom = 'enseignant');

-- Ajouter des utilisateurs enseignants
INSERT INTO utilisateurs (email, password, role_id, created_at, updated_at)
VALUES 
('prof.math@e-taalim.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', @role_id, NOW(), NOW()),
('prof.physique@e-taalim.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', @role_id, NOW(), NOW()),
('prof.francais@e-taalim.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', @role_id, NOW(), NOW()),
('prof.arabe@e-taalim.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', @role_id, NOW(), NOW()),
('prof.info@e-taalim.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', @role_id, NOW(), NOW());

-- Ru00e9cupu00e9rer les IDs des utilisateurs cru00e9u00e9s
SET @user_id1 = (SELECT id FROM utilisateurs WHERE email = 'prof.math@e-taalim.com');
SET @user_id2 = (SELECT id FROM utilisateurs WHERE email = 'prof.physique@e-taalim.com');
SET @user_id3 = (SELECT id FROM utilisateurs WHERE email = 'prof.francais@e-taalim.com');
SET @user_id4 = (SELECT id FROM utilisateurs WHERE email = 'prof.arabe@e-taalim.com');
SET @user_id5 = (SELECT id FROM utilisateurs WHERE email = 'prof.info@e-taalim.com');

-- Ajouter les informations des enseignants
INSERT INTO enseignants (utilisateur_id, nom, prenom, telephone, specialite, created_at, updated_at)
VALUES 
(@user_id1, 'Alaoui', 'Mohammed', '0600000001', 'Mathu00e9matiques', NOW(), NOW()),
(@user_id2, 'Bennani', 'Ahmed', '0600000002', 'Physique', NOW(), NOW()),
(@user_id3, 'Chaoui', 'Fatima', '0600000003', 'Franu00e7ais', NOW(), NOW()),
(@user_id4, 'Doukkali', 'Karim', '0600000004', 'Arabe', NOW(), NOW()),
(@user_id5, 'El Fassi', 'Samira', '0600000005', 'Informatique', NOW(), NOW());
