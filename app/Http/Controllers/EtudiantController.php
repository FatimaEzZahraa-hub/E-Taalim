<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class EtudiantController extends Controller
{
    /**
     * Affiche le tableau de bord de l'étudiant
     */
    /**
     * Méthode privée pour générer un étudiant fictif de test
     */
    private function getEtudiantTest()
    {
        $etudiant = new \stdClass();
        $etudiant->id = 1;
        $etudiant->nom = 'Étudiant';
        $etudiant->prenom = 'Test';
        $etudiant->code = 'E12345';
        $etudiant->email = 'etudiant.test@etaalim.edu';
        $etudiant->classe = 'ID-2A';
        $etudiant->filiere = 'Informatique et Développement';
        $etudiant->niveau = 'Licence 2';
        $etudiant->date_naissance = '2003-05-15';
        $etudiant->telephone = '0600000000';
        $etudiant->adresse = '123 Rue de l\'Université, Casablanca';
        $etudiant->photo = 'avatar-default.jpg';
        return $etudiant;
    }

    /**
     * Générer des messages fictifs pour le démo
     */
    private function getMessagesFictifs()
    {
        $messages = [];
        
        $expediteurs = [
            (object) ['id' => 1, 'nom' => 'Martin', 'prenom' => 'Sophie', 'role' => 'Enseignant', 'photo' => 'prof-1.jpg'],
            (object) ['id' => 2, 'nom' => 'Dubois', 'prenom' => 'Marc', 'role' => 'Enseignant', 'photo' => 'prof-2.jpg'],
            (object) ['id' => 3, 'nom' => 'Admin', 'prenom' => 'Systeme', 'role' => 'Administration', 'photo' => 'admin.jpg']
        ];
        
        $sujets = [
            'Consignes pour le devoir de programmation',
            'Absence au dernier cours',
            'Information importante sur l\'examen final',
            'Changement d\'horaire pour le cours du 10 juin',
            'Résultats des partiels'
        ];
        
        $contenus = [
            'Bonjour, veuillez trouver ci-joint les consignes détaillées pour le devoir de programmation à rendre pour le 15 juin.',
            'Bonjour, j\'ai noté votre absence au dernier cours. Y a-t-il eu un problème particulier ?',
            'Bonjour à tous, veuillez noter que l\'examen final aura lieu dans l\'amphithéâtre A et non en salle informatique comme prévu initialement.',
            'Suite à un impratif, le cours du 10 juin sera décalé à 14h au lieu de 10h. Merci de votre compréhension.',
            'Les résultats des partiels sont disponibles dans votre espace personnel. N\'hésitez pas à me contacter pour toute question.'
        ];
        
        for ($i = 1; $i <= 12; $i++) {
            $message = new \stdClass();
            $message->id = $i;
            $message->sujet = $sujets[($i - 1) % count($sujets)];
            $message->contenu = $contenus[($i - 1) % count($contenus)];
            $message->date_envoi = Carbon::now()->subDays(rand(1, 15));
            $message->date = Carbon::now()->subDays(rand(1, 15));
            $message->expediteur = $expediteurs[($i - 1) % count($expediteurs)];
            $message->lu = ($i % 3 == 0) ? false : true;
            $message->pieces_jointes = [];
            
            // Ajouter des pièces jointes à certains messages
            if ($i % 4 == 0) {
                $message->pieces_jointes = [
                    (object) ['id' => 1, 'nom' => 'consignes_devoir.pdf', 'taille' => '1.2 MB', 'type' => 'application/pdf'],
                    (object) ['id' => 2, 'nom' => 'exemple_code.zip', 'taille' => '4.5 MB', 'type' => 'application/zip']
                ];
            } elseif ($i % 5 == 0) {
                $message->pieces_jointes = [
                    (object) ['id' => 3, 'nom' => 'planning_examens.pdf', 'taille' => '0.8 MB', 'type' => 'application/pdf']
                ];
            }
            
            $messages[] = $message;
        }
        
        return $messages;
    }

    /**
     * Affiche le tableau de bord de l'étudiant
     */
    public function dashboard()
    {
        // Récupérer l'étudiant fictif
        $etudiant = $this->getEtudiantTest();
        
        // Statistiques pour le tableau de bord
        $stats = [
            'cours' => 6,
            'devoirs_en_attente' => 3,
            'examens_a_venir' => 2,
            'messages_non_lus' => 4
        ];
        
        // Événements à venir
        $evenements = [
            (object) ['id' => 1, 'titre' => 'Examen de Programmation Web', 'date' => now()->addDays(5)->format('Y-m-d'), 'heure' => '09:00', 'type' => 'examen'],
            (object) ['id' => 2, 'titre' => 'Remise du projet final', 'date' => now()->addDays(10)->format('Y-m-d'), 'heure' => '23:59', 'type' => 'devoir'],
            (object) ['id' => 3, 'titre' => 'Conférence IA et Éducation', 'date' => now()->addDays(7)->format('Y-m-d'), 'heure' => '14:00', 'type' => 'evenement']
        ];
        
        // Devoirs récents
        $devoirs = [
            (object) ['id' => 1, 'titre' => 'TP Bases de données', 'date_limite' => now()->addDays(2), 'cours' => 'Bases de données', 'statut' => 'en_attente'],
            (object) ['id' => 2, 'titre' => 'Projet JavaScript', 'date_limite' => now()->addDay(), 'cours' => 'Programmation Web', 'statut' => 'en_attente'],
            (object) ['id' => 3, 'titre' => 'Exercices d\'algorithmique', 'date_limite' => now()->subDay(), 'cours' => 'Algorithmique', 'statut' => 'en_retard']
        ];
        
        return view('etudiant.dashboard', compact('etudiant', 'stats', 'evenements', 'devoirs'));
    }
    
    /**
     * Affiche la liste des cours de l'étudiant
     */
    public function cours(Request $request)
    {
        // Générer des cours fictifs
        $coursData = [];
        
        $matieres = ['Mathématiques', 'Programmation Web', 'Bases de données', 'Algorithmique', 'Intelligence Artificielle', 'Réseaux', 'Systèmes d\'exploitation', 'Anglais', 'Communication'];
        
        // Créer 25 cours fictifs pour la pagination
        for ($i = 1; $i <= 25; $i++) {
            $matiere = $matieres[($i - 1) % count($matieres)];
            
            $cours = new \stdClass();
            $cours->id = $i;
            $cours->titre = $matiere;
            $cours->description = 'Description du cours de ' . $matiere;
            $cours->image = 'cours-' . ($i % 5 + 1) . '.jpg'; // Images fictives
            $cours->enseignant = 'Prof. ' . ['Martin', 'Dubois', 'Leroy', 'Moreau', 'Petit'][($i - 1) % 5];
            $cours->progression = rand(0, 100);
            $cours->ressources_count = rand(3, 15);
            $cours->devoirs_count = rand(1, 5);
            
            $coursData[] = $cours;
        }
        
        // Convertir en collection
        $coursCollection = collect($coursData);
        
        // Pagination manuelle
        $page = $request->get('page', 1);
        $perPage = 9; // 9 cours par page pour un affichage en grille 3x3
        $offset = ($page - 1) * $perPage;
        
        $currentPageCours = $coursCollection->slice($offset, $perPage)->values();
        
        $cours = new LengthAwarePaginator(
            $currentPageCours,
            $coursCollection->count(),
            $perPage,
            $page,
            ['path' => route('etudiant.cours')]
        );
        
        return view('etudiant.cours.index', compact('cours'));
    }

    /**
     * Affiche la liste des messages de l'étudiant
     */
    public function messages(Request $request)
    {
        // Récupérer la liste des messages
        $messagesData = $this->getMessagesFictifs();
        
        // Filtres
        $statutFiltre = $request->get('statut', 'tous');
        $expediteurFiltre = $request->get('expediteur', 'tous');
        $recherche = $request->get('recherche', '');
        
        // Appliquer les filtres
        $messagesCollection = collect($messagesData);
        
        if ($statutFiltre === 'non_lus') {
            $messagesCollection = $messagesCollection->filter(function($message) {
                return $message->lu === false;
            });
        } elseif ($statutFiltre === 'lus') {
            $messagesCollection = $messagesCollection->filter(function($message) {
                return $message->lu === true;
            });
        }
        
        if ($expediteurFiltre !== 'tous') {
            $messagesCollection = $messagesCollection->filter(function($message) use ($expediteurFiltre) {
                return $message->expediteur->role === $expediteurFiltre;
            });
        }
        
        if (!empty($recherche)) {
            $messagesCollection = $messagesCollection->filter(function($message) use ($recherche) {
                return stripos($message->sujet, $recherche) !== false || 
                       stripos($message->contenu, $recherche) !== false ||
                       stripos($message->expediteur->nom, $recherche) !== false ||
                       stripos($message->expediteur->prenom, $recherche) !== false;
            });
        }
        
        // Pagination
        $page = $request->get('page', 1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        
        $currentPageMessages = $messagesCollection->slice($offset, $perPage)->values();
        
        $messages = new LengthAwarePaginator(
            $currentPageMessages,
            $messagesCollection->count(),
            $perPage,
            $page,
            ['path' => route('etudiant.messages')]
        );
        
        // Calculer les statistiques des messages
        $stats = [
            'total' => count($messagesData),
            'non_lus' => count(array_filter($messagesData, function($message) {
                return $message->lu === false;
            })),
            'envoyes' => 0 // Pour le moment, pas de messages envoyés dans les données fictives
        ];
        
        // Récupérer l'étudiant fictif pour l'affichage
        $etudiant = $this->getEtudiantTest();
        
        // Générer une liste fictive d'enseignants pour le formulaire d'envoi de message
        $enseignants = [
            (object) ['id' => 1, 'nom' => 'Alami', 'prenom' => 'Mohammed', 'matiere' => 'Mathématiques'],
            (object) ['id' => 2, 'nom' => 'Benani', 'prenom' => 'Samira', 'matiere' => 'Informatique'],
            (object) ['id' => 3, 'nom' => 'Chaoui', 'prenom' => 'Karim', 'matiere' => 'Physique'],
            (object) ['id' => 4, 'nom' => 'Doukkali', 'prenom' => 'Fatima', 'matiere' => 'Anglais'],
            (object) ['id' => 5, 'nom' => 'El Fassi', 'prenom' => 'Ahmed', 'matiere' => 'Histoire-Géographie']
        ];
        
        return view('etudiant.messages.index', compact('messages', 'statutFiltre', 'expediteurFiltre', 'recherche', 'stats', 'etudiant', 'enseignants'));
    }

    /**
     * Affiche un message spécifique
     */
    public function showMessage($id)
    {
        // Récupérer tous les messages
        $messagesData = $this->getMessagesFictifs();
        
        // Trouver le message avec l'ID spécifié
        $message = collect($messagesData)->firstWhere('id', (int) $id);
        
        if (!$message) {
            return redirect()->route('etudiant.messages')->with('error', 'Message non trouvé');
        }
        
        // Marquer le message comme lu
        $message->lu = true;
        
        // Générer des réponses fictives pour le fil de discussion si message->id est pair
        $thread = [];
        if ($message->id % 2 === 0) {
            $thread = [
                (object) [
                    'id' => 100 + $message->id,
                    'sujet' => 'Re: ' . $message->sujet,
                    'contenu' => 'Merci pour votre message. Je vais examiner cela rapidement.',
                    'date_envoi' => Carbon::parse($message->date_envoi)->addDays(1)->format('Y-m-d H:i:s'),
                    'expediteur' => (object) ['id' => 1, 'nom' => 'Étudiant', 'prenom' => 'Test', 'role' => 'Étudiant', 'photo' => 'avatar-default.jpg'],
                    'pieces_jointes' => []
                ]
            ];
        }
        
        // Récupérer l'étudiant fictif pour l'affichage
        $etudiant = $this->getEtudiantTest();
        
        return view('etudiant.messages.show', compact('message', 'thread', 'etudiant'));
    }

    /**
     * Affiche le formulaire de création de message
     */
    public function createMessage()
    {
        // Récupérer l'étudiant fictif
        $etudiant = $this->getEtudiantTest();
        
        // Liste des enseignants pour le champ de destinataire (identique à celle de la méthode messages)
        $enseignants = [
            (object) ['id' => 1, 'nom' => 'Alami', 'prenom' => 'Mohammed', 'matiere' => 'Mathématiques'],
            (object) ['id' => 2, 'nom' => 'Benani', 'prenom' => 'Samira', 'matiere' => 'Informatique'],
            (object) ['id' => 3, 'nom' => 'Chaoui', 'prenom' => 'Karim', 'matiere' => 'Physique'],
            (object) ['id' => 4, 'nom' => 'Doukkali', 'prenom' => 'Fatima', 'matiere' => 'Anglais'],
            (object) ['id' => 5, 'nom' => 'El Fassi', 'prenom' => 'Ahmed', 'matiere' => 'Histoire-Géographie']
        ];
        
        return view('etudiant.messages.create', compact('enseignants', 'etudiant'));
    }

    /**
     * Traite l'envoi d'un nouveau message
     */
    public function storeMessage(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'destinataire_id' => 'required|integer',
            'sujet' => 'required|string|max:255',
            'contenu' => 'required|string',
            'pieces_jointes.*' => 'file|max:10240' // 10MB max par fichier
        ]);
        
        // Dans un environnement réel, nous sauvegarderions le message en base de données ici
        // Pour la démonstration, nous retournons simplement à la liste des messages avec un message de succès
        
        return redirect()->route('etudiant.messages')->with('success', 'Votre message a été envoyé avec succès');
    }

    /**
     * Affiche les notifications de l'étudiant
     */
    public function notifications(Request $request)
    {
        // Récupérer l'étudiant fictif
        $etudiant = $this->getEtudiantTest();
        
        // Générer des notifications fictives
        $notifications = [];
        $types = ['devoir', 'examen', 'message', 'evenement', 'note', 'administratif'];
        
        for ($i = 1; $i <= 20; $i++) {
            $notification = new \stdClass();
            $notification->id = $i;
            $notification->type = $types[$i % count($types)];
            $notification->titre = "Notification #$i de type " . $notification->type;
            $notification->contenu = "Contenu de la notification #$i";
            $notification->date = now()->subDays($i % 10)->format('Y-m-d H:i:s');
            $notification->lu = ($i % 3 != 0); // 1/3 des notifications non lues
            
            $notifications[] = $notification;
        }
        
        // Filtres
        $typeFiltre = $request->get('type', 'tous');
        $statutFiltre = $request->get('statut', 'tous');
        
        // Collection et pagination
        $notificationsCollection = collect($notifications);
        
        // Appliquer les filtres
        if ($typeFiltre !== 'tous') {
            $notificationsCollection = $notificationsCollection->filter(function($notification) use ($typeFiltre) {
                return $notification->type === $typeFiltre;
            });
        }
        
        if ($statutFiltre === 'non_lues') {
            $notificationsCollection = $notificationsCollection->filter(function($notification) {
                return $notification->lu === false;
            });
        }
        
        // Pagination
        $page = $request->get('page', 1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        
        $currentPageNotifications = $notificationsCollection->slice($offset, $perPage)->values();
        
        $notifications = new LengthAwarePaginator(
            $currentPageNotifications,
            $notificationsCollection->count(),
            $perPage,
            $page,
            ['path' => route('etudiant.notifications')]
        );
        
        return view('etudiant.notifications.index', compact('notifications', 'typeFiltre', 'statutFiltre', 'etudiant'));
    }

    /**
     * Affiche le calendrier de l'étudiant
     */
    public function calendrier()
    {
        // Récupérer l'étudiant fictif
        $etudiant = $this->getEtudiantTest();
        
        // Générer des événements fictifs pour le calendrier
        $evenements = [];
        $types = ['cours', 'devoir', 'examen', 'personnel', 'autre'];
        $titres = [
            'Cours de Mathématiques', 'TP Programmation', 'Examen final', 
            'Rendez-vous administration', 'Projet de groupe', 'Conférence IA'
        ];
        
        // Créer des événements sur les 30 prochains jours
        for ($i = 1; $i <= 25; $i++) {
            $evenement = new \stdClass();
            $evenement->id = $i;
            $evenement->titre = $titres[$i % count($titres)];
            $evenement->type = $types[$i % count($types)];
            $evenement->date = now()->addDays($i % 30)->format('Y-m-d');
            $evenement->heure_debut = sprintf('%02d:00', 8 + ($i % 10));
            $evenement->heure_fin = sprintf('%02d:00', 9 + ($i % 10));
            $evenement->lieu = 'Salle ' . (100 + $i);
            $evenement->description = 'Description de l\'événement #' . $i;
            $evenement->couleur = '#' . substr(md5($evenement->type), 0, 6);
            
            $evenements[] = $evenement;
        }
        
        return view('etudiant.calendrier.index', compact('etudiant', 'evenements'));
    }

    /**
     * Affiche le profil de l'étudiant
     */
    public function profil()
    {
        // Récupérer l'étudiant fictif
        $etudiant = $this->getEtudiantTest();
        
        // Statistiques académiques
        $stats = [
            'moyenne_generale' => 14.5,
            'progression_generale' => 65,
            'assiduite' => 92
        ];
        
        // Matieres avec progression et moyenne
        $matieres = [
            (object) ['id' => 1, 'nom' => 'Mathématiques', 'moyenne' => 13.5, 'progression' => 70],
            (object) ['id' => 2, 'nom' => 'Programmation Web', 'moyenne' => 16.0, 'progression' => 85],
            (object) ['id' => 3, 'nom' => 'Bases de données', 'moyenne' => 14.0, 'progression' => 65],
            (object) ['id' => 4, 'nom' => 'Algorithmique', 'moyenne' => 15.5, 'progression' => 80],
            (object) ['id' => 5, 'nom' => 'Anglais', 'moyenne' => 12.0, 'progression' => 60],
            (object) ['id' => 6, 'nom' => 'Communication', 'moyenne' => 16.5, 'progression' => 90]
        ];
        
        // Historique de connexions
        $connexions = [
            (object) ['date' => now()->subDays(1)->format('Y-m-d H:i:s'), 'ip' => '192.168.1.1', 'navigateur' => 'Chrome/Windows'],
            (object) ['date' => now()->subDays(3)->format('Y-m-d H:i:s'), 'ip' => '192.168.1.1', 'navigateur' => 'Chrome/Windows'],
            (object) ['date' => now()->subDays(7)->format('Y-m-d H:i:s'), 'ip' => '10.0.0.5', 'navigateur' => 'Firefox/MacOS'],
            (object) ['date' => now()->subDays(10)->format('Y-m-d H:i:s'), 'ip' => '10.0.0.5', 'navigateur' => 'Safari/iOS']
        ];
        
        return view('etudiant.profil.index', compact('etudiant', 'stats', 'matieres', 'connexions'));
    }

    /**
     * Met à jour le profil de l'étudiant
     */
    public function updateProfil(Request $request)
    {
        // Validation des données
        $request->validate([
            'prenom' => 'required|string|max:50',
            'nom' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255'
        ]);
        
        // Dans un environnement réel, nous mettrions à jour les informations en base de données
        // Pour la démo, nous retournons simplement au profil avec un message de succès
        
        return redirect()->route('etudiant.profil')->with('success', 'Profil mis à jour avec succès');
    }

    /**
     * Met à jour le mot de passe de l'étudiant
     */
    public function updatePassword(Request $request)
    {
        // Validation des données
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed'
        ]);
        
        // Dans un environnement réel, nous vérifierions l'ancien mot de passe et mettrions à jour
        // Pour la démo, nous retournons simplement au profil avec un message de succès
        
        return redirect()->route('etudiant.profil')->with('success', 'Mot de passe mis à jour avec succès');
    }
}
