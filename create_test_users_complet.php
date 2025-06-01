<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// Fonction pour créer un étudiant
function createStudent($nom, $prenom, $email) {
    // Vérifier si l'utilisateur existe déjà
    $exists = DB::table('utilisateurs')->where('email', $email)->exists();
    
    if (!$exists) {
        // Récupérer l'ID du rôle étudiant
        $roleId = DB::table('roles')->where('nom', 'etudiant')->value('id');
        if (!$roleId) {
            // Si le rôle n'existe pas, le créer
            $roleId = DB::table('roles')->insertGetId([
                'nom' => 'etudiant',
                'description' => 'Rôle pour les étudiants',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Transaction pour garantir l'intégrité des données
        DB::beginTransaction();
        
        try {
            // Créer un nouvel utilisateur dans la table utilisateurs
            $userId = DB::table('utilisateurs')->insertGetId([
                'email' => $email,
                'mot_de_passe' => Hash::make('password123'),
                'role_id' => $roleId,
                'statut' => 'actif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Créer l'étudiant dans la table etudiants
            DB::table('etudiants')->insert([
                'utilisateur_id' => $userId,
                'nom' => $nom,
                'prenom' => $prenom,
                'telephone' => '0600000000', // Valeur par défaut
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            DB::commit();
            echo "Étudiant '{$nom} {$prenom}' créé avec l'ID: {$userId}\n";
            return $userId;
        } catch (\Exception $e) {
            DB::rollBack();
            echo "Erreur lors de la création de l'étudiant: {$e->getMessage()}\n";
            return null;
        }
    } else {
        echo "L'utilisateur avec l'email '{$email}' existe déjà\n";
        return null;
    }
}

// Fonction pour créer un enseignant
function createTeacher($nom, $prenom, $email, $specialite = 'Informatique', $grade = 'Professeur') {
    // Vérifier si l'utilisateur existe déjà
    $exists = DB::table('utilisateurs')->where('email', $email)->exists();
    
    if (!$exists) {
        // Récupérer l'ID du rôle enseignant
        $roleId = DB::table('roles')->where('nom', 'enseignant')->value('id');
        if (!$roleId) {
            // Si le rôle n'existe pas, le créer
            $roleId = DB::table('roles')->insertGetId([
                'nom' => 'enseignant',
                'description' => 'Rôle pour les enseignants',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Transaction pour garantir l'intégrité des données
        DB::beginTransaction();
        
        try {
            // Créer un nouvel utilisateur dans la table utilisateurs
            $userId = DB::table('utilisateurs')->insertGetId([
                'email' => $email,
                'mot_de_passe' => Hash::make('password123'),
                'role_id' => $roleId,
                'statut' => 'actif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Créer l'enseignant dans la table enseignants
            DB::table('enseignants')->insert([
                'utilisateur_id' => $userId,
                'nom' => $nom,
                'prenom' => $prenom,
                'telephone' => '0600000000', // Valeur par défaut
                'specialite' => $specialite,
                'grade' => $grade,
                'bio' => 'Enseignant de ' . $specialite,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            DB::commit();
            echo "Enseignant '{$nom} {$prenom}' créé avec l'ID: {$userId}\n";
            return $userId;
        } catch (\Exception $e) {
            DB::rollBack();
            echo "Erreur lors de la création de l'enseignant: {$e->getMessage()}\n";
            return null;
        }
    } else {
        echo "L'utilisateur avec l'email '{$email}' existe déjà\n";
        return null;
    }
}

// Création d'un nouvel étudiant
$newStudentId = createStudent('Alami', 'Ahmed', 'ahmed.alami@etaalim.ma');

// Création d'un nouvel enseignant
$newTeacherId = createTeacher('Benani', 'Mohammed', 'prof.benani@etaalim.ma', 'Mathématiques', 'Docteur');

// Vous pouvez ajouter d'autres utilisateurs ici
// Par exemple:
// createStudent('Nom', 'Prénom', 'email@etaalim.ma');
// createTeacher('Nom', 'Prénom', 'email@etaalim.ma', 'Spécialité', 'Grade');

echo "\nOpération terminée avec succès!\n";
echo "Rafraichissez la page pour voir les nouveaux utilisateurs dans la liste.\n";
