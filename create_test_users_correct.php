<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// Fonction pour cru00e9er un utilisateur dans la table users
function createUser($name, $email, $role, $meta_data = []) {
    // Vu00e9rifier si l'utilisateur existe du00e9ju00e0
    $exists = DB::table('users')->where('email', $email)->exists();
    
    if (!$exists) {
        try {
            // Cru00e9er un nouvel utilisateur dans la table users
            $userId = DB::table('users')->insertGetId([
                'name' => $name,
                'email' => $email,
                'role' => $role,
                'password' => Hash::make('password123'),
                'meta_data' => json_encode($meta_data),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            echo ucfirst($role) . " '{$name}' cru00e9u00e9 avec l'ID: {$userId}\n";
            return $userId;
        } catch (\Exception $e) {
            echo "Erreur lors de la cru00e9ation de l'utilisateur: {$e->getMessage()}\n";
            return null;
        }
    } else {
        echo "L'utilisateur avec l'email '{$email}' existe du00e9ju00e0\n";
        return null;
    }
}

// Cru00e9ation d'un nouvel u00e9tudiant
$newStudentId = createUser(
    'Alami Ahmed', // name
    'ahmed.alami@etaalim.ma', // email
    'student', // role
    [
        'telephone' => '0600000000',
        'adresse' => 'Casablanca, Maroc',
        'date_naissance' => '2000-01-01'
    ] // meta_data
);

// Cru00e9ation d'un nouvel enseignant
$newTeacherId = createUser(
    'Benani Mohammed', // name
    'prof.benani@etaalim.ma', // email
    'teacher', // role
    [
        'telephone' => '0600000001',
        'specialite' => 'Mathu00e9matiques',
        'grade' => 'Docteur',
        'bio' => 'Enseignant de mathu00e9matiques avec 10 ans d\'expu00e9rience'
    ] // meta_data
);

// Création de plusieurs utilisateurs supplémentaires

// Étudiants
createUser(
    'Tazi Karim', 
    'karim.tazi@etaalim.ma', 
    'student', 
    [
        'telephone' => '0611223344',
        'adresse' => 'Rabat, Maroc',
        'date_naissance' => '2001-05-15'
    ]
);

createUser(
    'Benkirane Salma', 
    'salma.benkirane@etaalim.ma', 
    'student', 
    [
        'telephone' => '0622334455',
        'adresse' => 'Casablanca, Maroc',
        'date_naissance' => '2002-03-20'
    ]
);

createUser(
    'Ouazzani Youssef', 
    'youssef.ouazzani@etaalim.ma', 
    'student', 
    [
        'telephone' => '0633445566',
        'adresse' => 'Marrakech, Maroc',
        'date_naissance' => '2000-11-10'
    ]
);

// Enseignants
createUser(
    'Alaoui Fatima', 
    'fatima.alaoui@etaalim.ma', 
    'teacher', 
    [
        'telephone' => '0644556677',
        'specialite' => 'Physique',
        'grade' => 'Professeure',
        'bio' => 'Enseignante de physique avec 8 ans d\'expérience'
    ]
);

createUser(
    'Benjelloun Hassan', 
    'hassan.benjelloun@etaalim.ma', 
    'teacher', 
    [
        'telephone' => '0655667788',
        'specialite' => 'Informatique',
        'grade' => 'Maître de conférences',
        'bio' => 'Spécialiste en développement web et intelligence artificielle'
    ]
);

// Administrateur
createUser(
    'Admin Principal', 
    'admin@etaalim.ma', 
    'admin', 
    [
        'telephone' => '0666778899',
        'poste' => 'Directeur',
        'departement' => 'Administration'
    ]
);

echo "\nOpu00e9ration terminu00e9e avec succu00e8s!\n";
echo "Rafraichissez la page pour voir les nouveaux utilisateurs dans la liste.\n";
