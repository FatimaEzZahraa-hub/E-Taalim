<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// Fonction pour cru00e9er un utilisateur
function createUser($name, $email, $role) {
    // Vu00e9rifier si l'utilisateur existe du00e9ju00e0
    $exists = DB::table('users')->where('email', $email)->exists();
    
    if (!$exists) {
        $userId = DB::table('users')->insertGetId([
            'name' => $name,
            'email' => $email,
            'role' => $role,
            'password' => Hash::make('password123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        echo ucfirst($role) . " '{$name}' cru00e9u00e9 avec l'ID: {$userId}\n";
        return $userId;
    } else {
        echo "L'utilisateur avec l'email '{$email}' existe du00e9ju00e0\n";
        return null;
    }
}

// Cru00e9ation d'un nouvel u00e9tudiant
$newStudentId = createUser('Ahmed Alami', 'ahmed@etaalim.ma', 'student');

// Cru00e9ation d'un nouvel enseignant
$newTeacherId = createUser('Prof Informatique', 'prof.info@etaalim.ma', 'teacher');

// Vous pouvez ajouter d'autres utilisateurs ici en appelant la fonction createUser
// Par exemple:
// createUser('Nom Complet', 'email@etaalim.ma', 'student'); // Pour un u00e9tudiant
// createUser('Nom Complet', 'email@etaalim.ma', 'teacher'); // Pour un enseignant

echo "\nOpu00e9ration terminu00e9e avec succu00e8s!\n";
echo "Rafraichissez la page pour voir les nouveaux utilisateurs dans la liste.\n";

