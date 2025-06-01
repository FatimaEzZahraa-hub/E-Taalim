<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class RestoreDataSeeder extends Seeder
{
    /**
     * Restaure les données essentielles pour l'application E-Taalim.
     *
     * @return void
     */
    public function run()
    {
        // Création des utilisateurs
        $this->createUsers();
        
        // Création des niveaux et groupes
        $this->createNiveauxEtGroupes();
        
        // Création des cours
        $this->createCours();
        
        // Création des événements
        $this->createEvenements();
        
        // Création des notifications
        $this->createNotifications();
        
        // Création des messages
        $this->createMessages();
    }
    
    private function createUsers()
    {
        // Vérifier si les utilisateurs existent déjà
        if (DB::table('users')->count() > 0) {
            return;
        }
        
        // Administrateur
        DB::table('users')->insert([
            'email' => 'admin@etaalim.ma',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'meta_data' => json_encode([
                'prenom' => 'Admin',
                'nom' => 'Principal',
                'telephone' => '0600000000',
                'photo' => null,
                'active' => true
            ]),
            'initial_password' => 'password123',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        // Enseignants
        DB::table('users')->insert([
            'email' => 'prof.benani@etaalim.ma',
            'password' => Hash::make('password123'),
            'role' => 'teacher',
            'meta_data' => json_encode([
                'prenom' => 'Mohammed',
                'nom' => 'Benani',
                'telephone' => '0600000001',
                'specialite' => 'Mathématiques',
                'photo' => null,
                'active' => true
            ]),
            'initial_password' => 'password123',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('users')->insert([
            'email' => 'prof.alaoui@etaalim.ma',
            'password' => Hash::make('password123'),
            'role' => 'teacher',
            'meta_data' => json_encode([
                'prenom' => 'Fatima',
                'nom' => 'Alaoui',
                'telephone' => '0600000002',
                'specialite' => 'Sciences',
                'photo' => null,
                'active' => true
            ]),
            'initial_password' => 'password123',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        // Étudiants
        DB::table('users')->insert([
            'email' => 'ahmed.alami@etaalim.ma',
            'password' => Hash::make('password123'),
            'role' => 'student',
            'meta_data' => json_encode([
                'prenom' => 'Ahmed',
                'nom' => 'Alami',
                'telephone' => '0600000003',
                'photo' => null,
                'active' => true
            ]),
            'initial_password' => 'password123',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('users')->insert([
            'email' => 'sara.bennani@etaalim.ma',
            'password' => Hash::make('password123'),
            'role' => 'student',
            'meta_data' => json_encode([
                'prenom' => 'Sara',
                'nom' => 'Bennani',
                'telephone' => '0600000004',
                'photo' => null,
                'active' => true
            ]),
            'initial_password' => 'password123',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
    
    private function createNiveauxEtGroupes()
    {
        // Vérifier si les niveaux existent déjà
        if (DB::table('niveaux')->count() > 0) {
            return;
        }
        
        // Niveaux
        $niveau1Id = DB::table('niveaux')->insertGetId([
            'nom' => 'Première année',
            'description' => 'Première année du cycle',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        $niveau2Id = DB::table('niveaux')->insertGetId([
            'nom' => 'Deuxième année',
            'description' => 'Deuxième année du cycle',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        // Groupes
        $groupe1Id = DB::table('groupes')->insertGetId([
            'nom' => 'Groupe A',
            'description' => 'Premier groupe de la première année',
            'niveau_id' => $niveau1Id,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        $groupe2Id = DB::table('groupes')->insertGetId([
            'nom' => 'Groupe B',
            'description' => 'Deuxième groupe de la première année',
            'niveau_id' => $niveau1Id,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        $groupe3Id = DB::table('groupes')->insertGetId([
            'nom' => 'Groupe A',
            'description' => 'Premier groupe de la deuxième année',
            'niveau_id' => $niveau2Id,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        // Assigner des étudiants aux groupes
        $etudiants = DB::table('users')->where('role', 'student')->get();
        
        foreach ($etudiants as $index => $etudiant) {
            DB::table('groupe_student')->insert([
                'user_id' => $etudiant->id,
                'groupe_id' => $index % 2 == 0 ? $groupe1Id : $groupe2Id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
    
    private function createCours()
    {
        // Vérifier si les cours existent déjà
        if (DB::table('cours')->count() > 0) {
            return;
        }
        
        $enseignants = DB::table('users')->where('role', 'teacher')->get();
        $niveaux = DB::table('niveaux')->get();
        
        if (count($enseignants) > 0 && count($niveaux) > 0) {
            // Cours pour le premier enseignant
            DB::table('cours')->insert([
                'titre' => 'Introduction aux mathématiques',
                'description' => 'Cours d\'introduction aux concepts mathématiques de base',
                'contenu' => 'Contenu du cours d\'introduction aux mathématiques...',
                'enseignant_id' => $enseignants[0]->id,
                'niveau_id' => $niveaux[0]->id,
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            DB::table('cours')->insert([
                'titre' => 'Algèbre linéaire',
                'description' => 'Cours d\'algèbre linéaire pour débutants',
                'contenu' => 'Contenu du cours d\'algèbre linéaire...',
                'enseignant_id' => $enseignants[0]->id,
                'niveau_id' => $niveaux[1]->id,
                'statut' => 'en_attente',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            // Cours pour le deuxième enseignant si disponible
            if (count($enseignants) > 1) {
                DB::table('cours')->insert([
                    'titre' => 'Sciences naturelles',
                    'description' => 'Introduction aux sciences naturelles',
                    'contenu' => 'Contenu du cours de sciences naturelles...',
                    'enseignant_id' => $enseignants[1]->id,
                    'niveau_id' => $niveaux[0]->id,
                    'statut' => 'approuve',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
    
    private function createEvenements()
    {
        // Vérifier si les événements existent déjà
        if (DB::table('evenements')->count() > 0) {
            return;
        }
        
        $admin = DB::table('users')->where('role', 'admin')->first();
        
        if ($admin) {
            DB::table('evenements')->insert([
                'titre' => 'Réunion de rentrée',
                'description' => 'Réunion de présentation pour la nouvelle année scolaire',
                'date_debut' => Carbon::now()->addDays(5)->setTime(10, 0),
                'date_fin' => Carbon::now()->addDays(5)->setTime(12, 0),
                'created_by' => $admin->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            DB::table('evenements')->insert([
                'titre' => 'Journée portes ouvertes',
                'description' => 'Journée de découverte de l\'établissement pour les nouveaux étudiants',
                'date_debut' => Carbon::now()->addDays(15)->setTime(9, 0),
                'date_fin' => Carbon::now()->addDays(15)->setTime(17, 0),
                'created_by' => $admin->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
    
    private function createNotifications()
    {
        // Vérifier si les notifications existent déjà
        if (DB::table('notifications')->count() > 0) {
            return;
        }
        
        // Notifications générales
        DB::table('notifications')->insert([
            'titre' => 'Bienvenue sur E-Taalim',
            'message' => 'Bienvenue sur la plateforme E-Taalim. Nous sommes ravis de vous accueillir !',
            'date_notification' => Carbon::now()->subDays(2),
            'lu' => false,
            'user_id' => null, // Notification pour tous les utilisateurs
            'type' => 'information',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('notifications')->insert([
            'titre' => 'Maintenance prévue',
            'message' => 'Une maintenance du système est prévue ce weekend. La plateforme sera indisponible pendant quelques heures.',
            'date_notification' => Carbon::now()->subDay(),
            'lu' => false,
            'user_id' => null, // Notification pour tous les utilisateurs
            'type' => 'maintenance',
            'date_expiration' => Carbon::now()->addDays(5),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        // Notifications pour les événements
        $evenements = DB::table('evenements')->get();
        $users = DB::table('users')->get();
        
        foreach ($evenements as $evenement) {
            foreach ($users as $user) {
                DB::table('notifications')->insert([
                    'titre' => 'Nouvel événement : ' . $evenement->titre,
                    'message' => 'Un nouvel événement a été créé : ' . $evenement->titre . '. Date : ' . $evenement->date_debut,
                    'date_notification' => Carbon::now(),
                    'lu' => false,
                    'user_id' => $user->id,
                    'type' => 'evenement',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
    
    private function createMessages()
    {
        // Vérifier si les messages existent déjà
        if (DB::table('messages')->count() > 0) {
            return;
        }
        
        $users = DB::table('users')->get();
        
        if (count($users) >= 2) {
            // Message entre admin et enseignant
            $admin = DB::table('users')->where('role', 'admin')->first();
            $enseignant = DB::table('users')->where('role', 'teacher')->first();
            
            if ($admin && $enseignant) {
                DB::table('messages')->insert([
                    'expediteur_id' => $admin->id,
                    'destinataire_id' => $enseignant->id,
                    'sujet' => 'Bienvenue dans l\'équipe',
                    'contenu' => 'Bonjour et bienvenue dans l\'équipe pédagogique. N\'hésitez pas à me contacter si vous avez des questions.',
                    'lu' => false,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                
                DB::table('messages')->insert([
                    'expediteur_id' => $enseignant->id,
                    'destinataire_id' => $admin->id,
                    'sujet' => 'Re: Bienvenue dans l\'équipe',
                    'contenu' => 'Merci pour votre accueil. Je suis ravi de rejoindre l\'équipe.',
                    'lu' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            
            // Message entre enseignant et étudiant
            $etudiant = DB::table('users')->where('role', 'student')->first();
            
            if ($enseignant && $etudiant) {
                DB::table('messages')->insert([
                    'expediteur_id' => $enseignant->id,
                    'destinataire_id' => $etudiant->id,
                    'sujet' => 'Informations sur le cours',
                    'contenu' => 'Bonjour, je vous informe que le cours de demain aura lieu comme prévu. N\'oubliez pas d\'apporter vos documents.',
                    'lu' => false,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
