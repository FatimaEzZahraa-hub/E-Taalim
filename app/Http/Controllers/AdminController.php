<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Constructeur
     */
    public function __construct()
    {
        // Middleware d'authentification désactivé pour le développement
    }

    /**
     * Affiche le tableau de bord de l'administrateur
     */
    public function dashboard()
    {
        // Statistiques temporaires pour le développement
        $users_count = DB::table('users')->count();
        
        // Valeurs temporaires pour le développement
        $students_count = 0; // Sera mis à jour quand la migration sera terminée
        $teachers_count = 0; // Sera mis à jour quand la migration sera terminée
            
        // Nombre de cours
        $courses_count = 0; // Temporairement mis u00e0 0 jusqu'u00e0 la cru00e9ation de la table
        
        // Nombre d'événements
        $events_count = 0; // Temporairement mis u00e0 0 jusqu'u00e0 la cru00e9ation de la table
        
        // Compilation des statistiques
        $stats = [
            'users_count' => $users_count,
            'students_count' => $students_count,
            'teachers_count' => $teachers_count,
            'courses_count' => $courses_count,
            'events_count' => $events_count,
        ];
        
        // Récupération des derniers événements (temporairement désactivé)
        $latest_events = collect([]); // Collection vide temporaire
        
        // Récupération des derniers messages (temporairement désactivé)
        $latest_messages = collect([]); // Collection vide temporaire
        
        return view('admin.dashboard.index', compact('stats', 'latest_events', 'latest_messages'));
    }
    
    /**
     * Gestion des comptes utilisateurs
     * @param Request $request
     */
    public function usersList(Request $request)
    {
        // Récupérer les paramètres de filtrage
        $search = $request->input('search', '');
        $role = $request->input('role', '');
        $status = $request->input('status', '');
        
        // Récupération des utilisateurs depuis la base de données avec filtrage
        $usersQuery = DB::table('users')
            ->select(
                'users.id',
                'users.email',
                'users.name',
                'users.email_verified_at',
                'users.created_at',
                'users.updated_at'
            );
        
        // Appliquer le filtre de recherche si présent
        if (!empty($search)) {
            $usersQuery->where(function($query) use ($search) {
                $query->where('users.email', 'like', "%{$search}%")
                      ->orWhere('users.name', 'like', "%{$search}%");
            });
        }
        
        // Filtre de rôle temporairement désactivé jusqu'à la création de la colonne role
        // if (!empty($role)) {
        //     $usersQuery->where('users.role', $role);
        // }
        
        // Récupérer les utilisateurs
        $users = $usersQuery->get();
        
        // Filtrer par statut si nécessaire (car stocké dans meta_data JSON)
        if (!empty($status)) {
            $users = $users->filter(function($user) use ($status) {
                $metaData = json_decode($user->meta_data ?? '{}', true) ?: [];
                $isActive = isset($metaData['active']) ? $metaData['active'] == 1 : true;
                return ($status === 'active' && $isActive) || ($status === 'inactive' && !$isActive);
            });
        }
        
        // Déboguer pour voir les utilisateurs récupérés
        Log::info('Utilisateurs récupérés:', ['count' => count($users), 'users' => $users, 'filtres' => ['search' => $search, 'role' => $role, 'status' => $status]]);
        
        // Récupération des étudiants depuis la base de données (temporairement désactivé)
        // En attendant la migration qui ajoutera la colonne 'role'
        $studentsQuery = DB::table('users')
            ->select(
                'id',
                'email',
                'name as nom',
                'created_at'
            )
            ->limit(0); // Aucun résultat pour éviter les erreurs
        
        // Appliquer le filtre de recherche pour les étudiants si présent
        $studentSearch = $request->input('student_search', '');
        if (!empty($studentSearch)) {
            $studentsQuery->where(function($query) use ($studentSearch) {
                $query->where('email', 'like', "%{$studentSearch}%")
                      ->orWhere('name', 'like', "%{$studentSearch}%");
            });
        }
        
        // Récupérer les étudiants
        $students = $studentsQuery->orderBy('created_at', 'desc')->get();
        
        // Traiter les métadonnées JSON pour chaque étudiant
        foreach ($students as $student) {
            $metaData = json_decode($student->meta_data ?? '{}', true) ?: [];
            $student->prenom = $metaData['prenom'] ?? '';
            $student->telephone = $metaData['telephone'] ?? 'N/A';
            $student->filiere = $metaData['filiere'] ?? 'N/A';
            $student->annee_scolaire = $metaData['annee_scolaire'] ?? 'N/A';
            $student->niveau = $metaData['niveau'] ?? 'N/A';
            $student->isActive = isset($metaData['active']) ? $metaData['active'] == 1 : true;
        }
        
        // Filtrer par niveau si nécessaire
        $studentNiveau = $request->input('student_niveau', '');
        if (!empty($studentNiveau)) {
            $students = $students->filter(function($student) use ($studentNiveau) {
                return $student->niveau == $studentNiveau;
            });
        }
        
        // Filtrer par statut si nécessaire
        $studentStatus = $request->input('student_status', '');
        if (!empty($studentStatus)) {
            $students = $students->filter(function($student) use ($studentStatus) {
                return ($studentStatus === 'active' && $student->isActive) || 
                       ($studentStatus === 'inactive' && !$student->isActive);
            });
        }
        
        // Déboguer pour voir les étudiants récupérés
        Log::info('Étudiants récupérés:', ['count' => count($students)]);
        
        // Récupération des enseignants depuis la base de données (temporairement désactivé)
        // En attendant la migration qui ajoutera la colonne 'role'
        $teachersQuery = DB::table('users')
            ->select(
                'id',
                'email',
                'name as nom',
                'created_at'
            )
            ->limit(0); // Aucun résultat pour éviter les erreurs
        
        // Appliquer le filtre de recherche pour les enseignants si présent
        $teacherSearch = $request->input('teacher_search', '');
        if (!empty($teacherSearch)) {
            $teachersQuery->where(function($query) use ($teacherSearch) {
                $query->where('email', 'like', "%{$teacherSearch}%")
                      ->orWhere('name', 'like', "%{$teacherSearch}%");
            });
        }
        
        // Récupérer les enseignants
        $teachers = $teachersQuery->orderBy('created_at', 'desc')->get();
        
        // Traiter les métadonnées JSON pour chaque enseignant
        foreach ($teachers as $teacher) {
            $metaData = json_decode($teacher->meta_data ?? '{}', true) ?: [];
            $teacher->prenom = $metaData['prenom'] ?? '';
            $teacher->telephone = $metaData['telephone'] ?? 'N/A';
            $teacher->specialite = $metaData['specialite'] ?? 'N/A';
            $teacher->grade = $metaData['grade'] ?? 'N/A';
            $teacher->isActive = isset($metaData['active']) ? $metaData['active'] == 1 : true;
        }
        
        // Filtrer par spécialité si nécessaire
        $teacherSpecialite = $request->input('teacher_specialite', '');
        if (!empty($teacherSpecialite)) {
            $teachers = $teachers->filter(function($teacher) use ($teacherSpecialite) {
                return $teacher->specialite == $teacherSpecialite;
            });
        }
        
        // Filtrer par statut si nécessaire
        $teacherStatus = $request->input('teacher_status', '');
        if (!empty($teacherStatus)) {
            $teachers = $teachers->filter(function($teacher) use ($teacherStatus) {
                return ($teacherStatus === 'active' && $teacher->isActive) || 
                       ($teacherStatus === 'inactive' && !$teacher->isActive);
            });
        }
        
        // Déboguer pour voir les enseignants récupérés
        Log::info('Enseignants récupérés:', ['count' => count($teachers)]);
                    
        // Temporairement désactivé jusqu'à la création de la table niveaux
        $niveaux = collect([]);
        
        return view('admin.users.index', compact('users', 'students', 'teachers', 'niveaux'));
    }
    
    /**
     * Supprimer un utilisateur
     */
    public function destroyUser($id)
    {
        try {
            // Vérifier si l'utilisateur existe
            $user = DB::table('users')->where('id', $id)->first();
            
            if (!$user) {
                return redirect()->route('admin.users')->with('error', 'Utilisateur non trouvé');
            }
            
            // Supprimer l'utilisateur
            DB::table('users')->where('id', $id)->delete();
            
            return redirect()->route('admin.users')->with('success', 'Utilisateur supprimé avec succès');
        } catch (\Exception $e) {
            return redirect()->route('admin.users')->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }
    
    /**
     * Afficher le formulaire d'édition d'un utilisateur
     */
    public function editUser($id)
    {
        try {
            // Récupérer l'utilisateur
            $user = DB::table('users')->where('id', $id)->first();
            
            if (!$user) {
                return redirect()->route('admin.users')->with('error', 'Utilisateur non trouvé');
            }
            
            // Vérifier si la propriété meta_data existe (nom correct de la colonne)
            $metaData = [];
            if (property_exists($user, 'meta_data') && $user->meta_data) {
                $metaData = json_decode($user->meta_data, true) ?? [];
            } else {
                // Créer un tableau de métadonnées vide ou avec des valeurs par défaut
                if ($user->role === 'student') {
                    $metaData = [
                        'prenom' => '',
                        'niveau_id' => null,
                        'telephone' => '',
                        'filiere' => '',
                        'annee_scolaire' => ''
                    ];
                } elseif ($user->role === 'teacher') {
                    $metaData = [
                        'prenom' => '',
                        'specialite' => '',
                        'grade' => '',
                        'telephone' => ''
                    ];
                }
            }
            
            // Récupérer tous les niveaux pour le formulaire d'édition d'étudiant
            $niveaux = \App\Models\Niveau::where('actif', true)->get();
            
            return view('admin.users.edit', compact('user', 'metaData', 'niveaux'));
        } catch (\Exception $e) {
            return redirect()->route('admin.users')->with('error', 'Erreur lors de la récupération des données: ' . $e->getMessage());
        }
    }
    
    /**
     * Mettre à jour les données d'un utilisateur
     */
    public function updateUser(Request $request, $id)
    {
        try {
            // Valider les données du formulaire
            $request->validate([
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $id,
                'telephone' => 'nullable|string|max:20',
            ]);
            
            // Récupérer l'utilisateur
            $user = DB::table('users')->where('id', $id)->first();
            
            if (!$user) {
                return redirect()->route('admin.users')->with('error', 'Utilisateur non trouvé');
            }
            
            // Décoder les métadonnées existantes ou créer un tableau vide
            $metaData = [];
            if (property_exists($user, 'meta_data') && $user->meta_data) {
                $metaData = json_decode($user->meta_data, true) ?? [];
            }
            
            // Mettre à jour les métadonnées en fonction du rôle
            if ($user->role === 'student') {
                $request->validate([
                    'niveau_id' => 'nullable|exists:niveaux,id',
                ]);
                
                // Conserver le prénom dans les métadonnées
                $metaData['prenom'] = $request->prenom;
                $metaData['niveau_id'] = $request->niveau_id;
                $metaData['telephone'] = $request->telephone;
                $metaData['filiere'] = $request->filiere ?? $metaData['filiere'] ?? '';
                $metaData['annee_scolaire'] = $request->annee_scolaire ?? $metaData['annee_scolaire'] ?? '';
            } elseif ($user->role === 'teacher') {
                $request->validate([
                    'specialite' => 'nullable|string|max:255',
                    'grade' => 'nullable|string|max:255',
                ]);
                
                // Conserver le prénom dans les métadonnées
                $metaData['prenom'] = $request->prenom;
                $metaData['specialite'] = $request->specialite ?? $metaData['specialite'] ?? '';
                $metaData['grade'] = $request->grade ?? $metaData['grade'] ?? '';
                $metaData['telephone'] = $request->telephone;
            }
            
            // Mettre à jour l'utilisateur
            DB::table('users')->where('id', $id)->update([
                'name' => $request->nom, // Utiliser le nom correct de la colonne (name au lieu de nom)
                'email' => $request->email,
                'meta_data' => json_encode($metaData), // Utiliser le nom correct de la colonne
                'updated_at' => now(),
            ]);
            
            // Rediriger vers la page d'édition avec un paramètre success pour afficher l'alerte SweetAlert2
            return redirect()->route('admin.users.edit', ['id' => $id, 'success' => true]);
        } catch (\Exception $e) {
            return redirect()->route('admin.users.edit', $id)->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
        }
    }
    
    /**
     * Activer/Désactiver un compte utilisateur
     * 
     * Cette méthode utilise le champ meta_data pour stocker l'état actif/inactif de l'utilisateur
     * sans avoir besoin d'ajouter une colonne spécifique à la table users.
     */
    public function toggleUserStatus($id)
    {
        try {
            // Récupérer l'utilisateur
            $user = DB::table('users')->where('id', $id)->first();
            
            if (!$user) {
                return redirect()->route('admin.users')->with('error', 'Utilisateur non trouvé');
            }
            
            // Décoder les métadonnées JSON
            $metaData = [];
            if (property_exists($user, 'meta_data') && $user->meta_data) {
                $metaData = json_decode($user->meta_data, true) ?? [];
            }
            
            // Inverser l'état actif/inactif
            $metaData['active'] = isset($metaData['active']) && $metaData['active'] == 1 ? 0 : 1;
            $etat = $metaData['active'] == 1 ? 'activé' : 'désactivé';
            
            // Mettre à jour les métadonnées
            DB::table('users')->where('id', $id)->update([
                'meta_data' => json_encode($metaData),
                'updated_at' => now(),
            ]);
            
            return redirect()->route('admin.users')->with('success', "Le compte utilisateur a été $etat avec succès.");
        } catch (\Exception $e) {
            return redirect()->route('admin.users')->with('error', 'Erreur lors du changement de statut: ' . $e->getMessage());
        }
    }
    
    /**
     * Réinitialise le mot de passe d'un utilisateur
     */
    public function resetPassword(Request $request, $id)
    {
        try {
            // Validation
            $validated = $request->validate([
                'new_password' => 'required|string|min:8',
            ]);
            
            // Vérifier si l'utilisateur existe
            $user = DB::table('users')->where('id', $id)->first();
            if (!$user) {
                return redirect()->route('admin.users')->with('error', 'Utilisateur non trouvé');
            }
            
            // Mettre à jour le mot de passe et enregistrer le mot de passe initial
            DB::table('users')->where('id', $id)->update([
                'password' => Hash::make($validated['new_password']),
                'initial_password' => $validated['new_password'],
                'updated_at' => now()
            ]);
            
            return redirect()->route('admin.users')->with('success', 'Mot de passe réinitialisé avec succès');
        } catch (\Exception $e) {
            return redirect()->route('admin.users')->with('error', 'Erreur lors de la réinitialisation du mot de passe: ' . $e->getMessage());
        }
    }
    
    /**
     * Affiche le formulaire d'ajout d'un étudiant
     */
    public function addStudentForm()
    {
        // Récupérer tous les niveaux actifs
        $niveaux = \App\Models\Niveau::where('actif', true)->get();
        
        return view('admin.users.add_student', compact('niveaux'));
    }
    
    /**
     * Enregistre un nouvel étudiant
     */
    public function storeStudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'niveau_id' => 'required|exists:niveaux,id',
            'groupe_id' => 'nullable|exists:groupes,id',
            'filiere' => 'nullable|string|max:100',
            'annee_scolaire' => 'nullable|string|max:10',
            'telephone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        try {
            // Préparer les métadonnées
            $metaData = [
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'filiere' => $request->filiere,
                'annee_scolaire' => $request->annee_scolaire,
                'telephone' => $request->telephone,
                'active' => 1,
            ];
            
            // Créer un nouvel utilisateur dans la table users
            $userData = [
                'name' => $request->nom . ' ' . $request->prenom,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'initial_password' => $request->password, // Enregistrer le mot de passe initial en clair
                'role' => 'student',
                'niveau_id' => $request->niveau_id,
                'groupe_id' => $request->groupe_id,
                'meta_data' => json_encode($metaData),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            $userId = DB::table('users')->insertGetId($userData);
            
            // Si un groupe est spécifié, ajouter l'étudiant au groupe
            if ($request->groupe_id) {
                DB::table('groupe_student')->insert([
                    'groupe_id' => $request->groupe_id,
                    'user_id' => $userId,
                    'date_affectation' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            
            return redirect()->route('admin.users')->with('success', 'Étudiant ajouté avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erreur lors de l\'ajout de l\'étudiant: ' . $e->getMessage()])->withInput();
        }
    }
    /**
     * Affiche les détails d'un utilisateur
     */
    public function viewUser($id)
    {
        // Temporairement, rediriger vers la liste des utilisateurs avec un message
        // car la vue admin.users.view n'existe pas encore
        return redirect()->route('admin.users')
            ->with('info', 'La vue détaillée des utilisateurs est en cours de développement.');
    }

    /**
     * Validation des ressources pédagogiques
     */
    public function pendingCourses()
    {
        // Données factices pour les cours en attente
        $courses = [
            (object)[
                'id' => 1,
                'titre' => 'Introduction à la programmation Python',
                'description' => 'Un cours complet pour apprendre les bases de la programmation avec Python.',
                'date_creation' => now()->subDays(3),
                'enseignant_id' => 2,
                'statut' => 'en_attente',
                'nom' => 'Dupont',
                'prenom' => 'Jean'
            ],
            (object)[
                'id' => 2,
                'titre' => 'Mathématiques pour l\'informatique',
                'description' => 'Ce cours couvre les concepts mathématiques essentiels pour la programmation et l\'informatique.',
                'date_creation' => now()->subDays(5),
                'enseignant_id' => 3,
                'statut' => 'en_attente',
                'nom' => 'Martin',
                'prenom' => 'Sophie'
            ],
        ];
                    
        return view('admin.courses.pending', compact('courses'));
    }
    
    /**
     * Approuver un cours
     */
    public function approveCourse($id)
    {
        try {
            // Vérifier si la colonne 'statut' existe dans la table 'cours'
            if (Schema::hasColumn('cours', 'statut')) {
                // Si la colonne existe, mettre à jour le statut
                DB::table('cours')
                    ->where('id', $id)
                    ->update(['statut' => 'approuve']);
            } else {
                // Si la colonne n'existe pas, continuer sans mettre à jour le statut
                // On pourrait ajouter un log ici pour informer qu'il faudrait exécuter la migration
                Log::warning("La colonne 'statut' n'existe pas dans la table 'cours'. Veuillez exécuter la migration appropriée.");
            }
            
            // Créer une notification pour l'enseignant
            $course = DB::table('cours')->where('id', $id)->first();
            $enseignant = DB::table('enseignants')->where('id', $course->enseignant_id)->first();
            
            DB::table('notifications')->insert([
                'titre' => 'Approbation de cours',
                'message' => 'Votre cours "' . $course->titre . '" a été approuvé',
                'date_notification' => now(),
                'lu' => 0,
                'user_id' => $enseignant->utilisateur_id
            ]);
            
            return redirect()->back()->with('success', 'Cours approuvé avec succès');
        } catch (\Exception $e) {
            // Gérer les erreurs éventuelles
            return redirect()->back()->with('error', 'Erreur lors de l\'approbation du cours: ' . $e->getMessage());
        }
    }
    
    /**
     * Rejeter un cours
     */
    public function rejectCourse($id, Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'reason' => 'required|string|min:5',
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            // Vérifier si la colonne 'statut' existe dans la table 'cours'
            if (Schema::hasColumn('cours', 'statut')) {
                // Si la colonne existe, mettre à jour le statut
                DB::table('cours')
                    ->where('id', $id)
                    ->update(['statut' => 'rejete']);
            } else {
                // Si la colonne n'existe pas, continuer sans mettre à jour le statut
                // On pourrait ajouter un log ici pour informer qu'il faudrait exécuter la migration
                Log::warning("La colonne 'statut' n'existe pas dans la table 'cours'. Veuillez exécuter la migration appropriée.");
            }
            
            // Créer une notification pour l'enseignant
            $course = DB::table('cours')->where('id', $id)->first();
            $enseignant = DB::table('enseignants')->where('id', $course->enseignant_id)->first();
            
            DB::table('notifications')->insert([
                'titre' => 'Rejet de cours',
                'message' => 'Votre cours "' . $course->titre . '" a été rejeté. Raison: ' . $request->reason,
                'date_notification' => now(),
                'lu' => 0,
                'user_id' => $enseignant->utilisateur_id
            ]);
            
            return redirect()->back()->with('success', 'Cours rejeté avec succès');
        } catch (\Exception $e) {
            // Gérer les erreurs éventuelles
            return redirect()->back()->with('error', 'Erreur lors du rejet du cours: ' . $e->getMessage());
        }
    }
    
    /**
     * Gestion des plaintes et suggestions
     */
    public function complaints()
    {
        // Données factices pour les plaintes
        $complaints = [
            (object)[
                'id' => 1,
                'user_id' => 3,
                'sujet' => 'Problème d\'accès au cours',
                'message' => 'Je n\'arrive pas à accéder au contenu du cours de programmation Python.',
                'statut' => 'en_attente',
                'date_creation' => now()->subDays(2),
                'email' => 'etudiant1@etaalim.com'
            ],
            (object)[
                'id' => 2,
                'user_id' => 4,
                'sujet' => 'Bug dans le système de soumission des devoirs',
                'message' => 'Quand j\'essaie de soumettre mon devoir, j\'obtiens une erreur 500.',
                'statut' => 'en_cours',
                'date_creation' => now()->subDays(5),
                'email' => 'etudiant2@etaalim.com'
            ],
            (object)[
                'id' => 3,
                'user_id' => 2,
                'sujet' => 'Suggestion d\'amélioration',
                'message' => 'Il serait intéressant d\'ajouter une fonctionnalité de forum de discussion pour chaque cours.',
                'statut' => 'traité',
                'reponse' => 'Merci pour votre suggestion, nous l\'avons ajoutée à notre liste de fonctionnalités à développer.',
                'date_creation' => now()->subDays(10),
                'date_traitement' => now()->subDays(8),
                'email' => 'enseignant1@etaalim.com'
            ],
        ];
                        
        return view('admin.complaints.index', compact('complaints'));
    }
    
    /**
     * Répondre à une plainte
     */
    public function respondToComplaint($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'response' => 'required|string|min:5',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $complaint = DB::table('Complaints')->where('id', $id)->first();
        
        if (!$complaint) {
            return redirect()->back()->with('error', 'Plainte non trouvée');
        }
        
        // Mettre à jour le statut de la plainte
        DB::table('Complaints')
            ->where('id', $id)
            ->update([
                'statut' => 'traite',
                'reponse' => $request->response,
                'date_traitement' => now()
            ]);
            
        // Créer une notification pour l'utilisateur
        DB::table('notifications')->insert([
            'titre' => 'Réponse à votre plainte',
            'message' => 'Votre plainte a reçu une réponse de l\'administration',
            'date_notification' => now(),
            'lu' => 0,
            'user_id' => $complaint->user_id
        ]);
        
        // Envoyer un message à l'utilisateur
        DB::table('messages')->insert([
            'id_expediteur' => Auth::id(),
            'id_destinataire' => $complaint->user_id,
            'contenu' => 'Réponse à votre plainte: ' . $request->response,
            'date_envoi' => now()
        ]);
        
        return redirect()->back()->with('success', 'Réponse envoyée avec succès');
    }
    
    /**
     * Gestion des événements
     */
    public function events()
    {
        // Données factices pour les événements
        $events = [
            (object)[
                'id' => 1,
                'titre' => 'Conférence sur l\'IA dans l\'Education',
                'description' => 'Conférence sur l\'utilisation de l\'intelligence artificielle dans le domaine de l\'education',
                'date_debut' => now()->addDays(5),
                'date_fin' => now()->addDays(5)->addHours(3),
                'created_by' => 1,
                'creator_email' => 'admin@etaalim.com'
            ],
            (object)[
                'id' => 2,
                'titre' => 'Atelier pratique de programmation',
                'description' => 'Atelier pour apprendre les bases de la programmation',
                'date_debut' => now()->addDays(10),
                'date_fin' => now()->addDays(10)->addHours(4),
                'created_by' => 2,
                'creator_email' => 'enseignant1@etaalim.com'
            ],
            (object)[
                'id' => 3,
                'titre' => 'Session d\'examen final',
                'description' => 'Examens de fin d\'année pour les étudiants',
                'date_debut' => now()->addDays(30),
                'date_fin' => now()->addDays(35),
                'created_by' => 1,
                'creator_email' => 'admin@etaalim.com'
            ],
        ];
                    
        return view('admin.events.index', compact('events'));
    }
    
    /**
     * Créer un événement institutionnel
     */
    public function createEvent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $eventId = DB::table('evenements')->insertGetId([
            'titre' => $request->titre,
            'description' => $request->description,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'created_by' => Auth::id(),
        ]);
        
        // Créer une notification pour tous les utilisateurs
        $users = DB::table('utilisateurs')->get();
        
        foreach ($users as $user) {
            DB::table('notifications')->insert([
                'titre' => 'Nouvel événement',
                'message' => 'Nouvel événement institutionnel: ' . $request->titre,
                'date_notification' => now(),
                'lu' => 0,
                'user_id' => $user->id
            ]);
        }
        
        return redirect()->route('admin.events')->with('success', 'Événement créé avec succès');
    }
    
    /**
     * Éditer un événement
     */
    public function editEvent($id, Request $request)
    {
        $event = DB::table('evenements')->where('id', $id)->first();
        
        if (!$event) {
            return redirect()->back()->with('error', 'Événement non trouvé');
        }
        
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'titre' => 'required|string|max:255',
                'description' => 'required|string',
                'date_debut' => 'required|date',
                'date_fin' => 'required|date|after:date_debut',
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            DB::table('evenements')
                ->where('id', $id)
                ->update([
                    'titre' => $request->titre,
                    'description' => $request->description,
                    'date_debut' => $request->date_debut,
                    'date_fin' => $request->date_fin,
                ]);
                
            return redirect()->route('admin.events')->with('success', 'Événement mis à jour avec succès');
        }
        
        return view('admin.events.edit', compact('event'));
    }
    
    /**
     * Supprimer un événement
     */
    public function deleteEvent($id)
    {
        $event = DB::table('evenements')->where('id', $id)->first();
        
        if (!$event) {
            return redirect()->back()->with('error', 'Événement non trouvé');
        }
        
        DB::table('evenements')->where('id', $id)->delete();

        return redirect()->route('admin.events')->with('success', 'Événement supprimé avec succès');
    }

    /**
     * Page des messages
     */
    public function messages()
    {
        // Récupération des messages reçus par l'administrateur connecté
        $admin_id = auth()->id() ?? 1; // Utiliser l'ID 1 si non connecté (pour test)

        // Temporairement désactivé jusqu'à la création des tables messages et utilisateurs
        $messages_received = collect([]);
        $messages_sent = collect([]);
        
        // Récupération de tous les utilisateurs pour le formulaire d'envoi
        // Utiliser la table users au lieu de utilisateurs
        $users = DB::table('users')
            ->select('id', 'email')
            ->where('id', '!=', $admin_id)
            ->get();

        return view('admin.messages.index', compact('messages_received', 'messages_sent', 'users'))
            ->with('info', 'La messagerie est temporairement indisponible. Les tables nécessaires sont en cours de création.');
    }

    /**
     * Envoyer un message
     */
    public function sendMessage(Request $request)
    {
        // Temporairement désactivé jusqu'à la création des tables messages et notifications
        return redirect()->back()->with('info', 'L\'envoi de messages est temporairement indisponible. Les tables nécessaires sont en cours de création.');
        
        /* Code original désactivé
        $validator = Validator::make($request->all(), [
            'id_destinataire' => 'required|exists:users,id',  // Modifié: Utilisateurs -> users
            'message' => 'required|string',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        DB::table('messages')->insert([
            'id_expediteur' => Auth::id(),
            'id_destinataire' => $request->id_destinataire,
            'contenu' => $request->message,
            'date_envoi' => now()
        ]);
        
        // Créer une notification pour le destinataire
        DB::table('notifications')->insert([
            'titre' => 'Nouveau message',
            'message' => 'Vous avez reçu un nouveau message de l\'administration',
            'date_notification' => now(),
            'lu' => 0,
            'user_id' => $request->id_destinataire
        ]);
        */
        
        // return redirect()->back()->with('success', 'Message envoyé avec succès');
    }
    
    /**
     * Afficher les notifications
     */
    public function notifications()
    {
        // Temporairement désactivé jusqu'à la création de la table notifications
        $notifications = collect([
            // Exemples de notifications pour l'affichage
            (object)[
                'id' => 1,
                'titre' => 'Exemple de notification',
                'contenu' => 'Cette notification est un exemple. La fonctionnalité complète sera disponible prochainement.',
                'user_id' => 1,
                'date_creation' => now(),
                'date_expiration' => now()->addDays(7),
                'est_lu' => false,
                'type' => 'info'
            ]
        ]);
                        
        return view('admin.notifications.index', compact('notifications'))
            ->with('info', 'Les notifications sont temporairement indisponibles. La table nécessaire est en cours de création.');
    }
    
    /**
     * Marquer une notification comme lue
     */
    public function markNotificationAsRead($id)
    {
        // Mettre à jour le statut de la notification dans la base de données
        DB::table('notifications')
            ->where('id', $id)
            ->update(['lu' => true]);
        
        return redirect()->back()->with('success', 'Notification marquée comme lue');
    }
    
    /**
     * Marquer plusieurs notifications comme lues
     */
    public function markNotificationsAsRead(Request $request)
    {
        // Récupérer les IDs des notifications à marquer comme lues
        $notification_ids_json = $request->input('notification_ids', '[]');
        
        // Décoder le JSON en tableau
        $notification_ids = json_decode($notification_ids_json, true) ?: [];
        
        // Mettre à jour le statut des notifications dans la base de données
        if (!empty($notification_ids)) {
            DB::table('notifications')
                ->whereIn('id', $notification_ids)
                ->update(['lu' => true]);
        }
        
        // Rediriger vers la page précédente avec un message de succès
        return redirect()->back()->with('success', 'Notifications marquées comme lues');
    }
    
    /**
     * Mettre à jour une notification
     */
    public function updateNotification($id, Request $request)
    {
        // Valider les données
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'type' => 'required|string|in:maintenance,information,evenement,autre',
            'date_expiration' => 'required|date'
        ]);
        
        // Mettre à jour la notification dans la base de données
        DB::table('notifications')
            ->where('id', $id)
            ->update([
                'titre' => $validated['titre'],
                'message' => $validated['contenu'],
                'type' => $validated['type'],
                'date_expiration' => $validated['date_expiration'],
                'updated_at' => now()
            ]);
        
        return redirect()->route('admin.notifications')->with('success', 'Notification mise à jour avec succès');
    }
    
    /**
     * Supprimer une notification
     */
    public function deleteNotification($id)
    {
        // Supprimer la notification de la base de données
        DB::table('notifications')->where('id', $id)->delete();
        
        return redirect()->route('admin.notifications')->with('success', 'Notification supprimée avec succès');
    }
    
    /**
     * Récupérer les dernières notifications pour l'affichage dans la modal
     */
    public function getLatestNotifications()
    {
        // Récupérer les notifications depuis la base de données
        $dbNotifications = DB::table('notifications')
            ->select(
                'id',
                'titre',
                'message as contenu',
                'date_notification',
                'lu as est_lu',
                'type'
            )
            ->orderBy('date_notification', 'desc')
            ->limit(5)
            ->get();
        
        // Formater les notifications pour l'affichage
        $notifications = [];
        foreach ($dbNotifications as $notification) {
            $notifications[] = [
                'id' => $notification->id,
                'titre' => $notification->titre,
                'contenu' => $notification->contenu,
                'date_creation' => date('d/m/Y H:i', strtotime($notification->date_notification)),
                'est_lu' => (bool)$notification->est_lu,
                'type' => $notification->type,
                'url' => route('admin.notifications')
            ];
        }
        
        // Compter les notifications non lues
        $unread_count = DB::table('notifications')
            ->where('lu', false)
            ->count();
        
        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unread_count
        ]);
    }
    
    /**
     * Créer une nouvelle notification
     */
    public function storeNotification(Request $request)
    {
        // Valider les données
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'type' => 'required|string|in:maintenance,information,evenement,autre',
            'date_expiration' => 'required|date'
        ]);
        
        // Insérer la notification dans la base de données
        DB::table('notifications')->insert([
            'titre' => $validated['titre'],
            'message' => $validated['contenu'],
            'type' => $validated['type'],
            'date_notification' => now(),
            'date_expiration' => $validated['date_expiration'],
            'lu' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        return redirect()->route('admin.notifications')->with('success', 'Notification créée avec succès');
    }
    
    /**
     * Répondre à un message
     */
    public function replyMessage($id, Request $request)
    {
        // En mode données factices, on simule simplement une redirection
        return redirect()->route('admin.messages')->with('success', 'Réponse envoyée avec succès');
    }
    
    /**
     * Enregistrer un nouvel enseignant
     */
    public function storeTeacher(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'telephone' => 'nullable|string|max:20',
            'specialite' => 'required|string|max:255',
            'grade' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'password' => 'required|min:8|confirmed',
        ]);
        
        try {
            // Préparer les métadonnées de l'enseignant
            $metaData = [
                'prenom' => $validated['prenom'],
                'telephone' => $validated['telephone'],
                'specialite' => $validated['specialite'],
                'grade' => $validated['grade'],
                'bio' => $validated['bio'],
            ];
            
            // Créer un nouvel utilisateur dans la table users
            $userData = [
                'name' => $validated['nom'] . ' ' . $validated['prenom'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'initial_password' => $validated['password'], // Enregistrer le mot de passe initial en clair
                'role' => 'teacher',
                'meta_data' => json_encode($metaData),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            $userId = DB::table('users')->insertGetId($userData);

            return redirect()->route('admin.users')->with('success', 'Enseignant ajouté avec succès');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    /**
     * Afficher la page profil de l'administrateur
     */
    public function profile()
    {
        // Récupérer les informations de l'administrateur connecté
        $admin_id = auth()->id() ?? 1; // Utiliser l'ID 1 si non connecté (pour test)
        
        $admin = DB::table('users')
            ->where('id', $admin_id)
            ->select(
                'id',
                'email',
                'name',
                'meta_data',
                'role'
            )
            ->first();
            
        // Si l'utilisateur n'est pas trouvé, utiliser des données factices mais ajouter un message d'erreur
        if (!$admin) {
            // Créer un objet avec des données par défaut
            $admin = (object)[
                'id' => auth()->id() ?? 1,
                'email' => 'admin@etaalim.com',
                'name' => 'Admin E-Taalim',
                'role' => 'admin',
                'meta_data' => json_encode([
                    'prenom' => 'Admin',
                    'nom' => 'E-Taalim',
                    'telephone' => '',
                    'photo' => null,
                    'active' => 1
                ])
            ];
            
            // Ajouter un message d'erreur
            session()->flash('error', 'Administrateur non trouvé');
        }
        
        // Décoder les métadonnées JSON si elles existent
        if (isset($admin->meta_data) && is_string($admin->meta_data)) {
            $admin->meta_data = json_decode($admin->meta_data);
        }
        
        return view('admin.profile.index', compact('admin'));
    }
    
    /**
     * Mettre à jour le profil de l'administrateur
     */
    public function updateProfile(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        // Récupérer l'ID de l'administrateur connecté
        $admin_id = auth()->id() ?? 1; // Utiliser l'ID 1 si non connecté (pour test)
        
        // Récupérer l'utilisateur
        $admin = DB::table('users')
            ->where('id', $admin_id)
            ->first();
            
        // Si l'administrateur n'est pas trouvé, rediriger avec erreur
        if (!$admin) {
            return redirect()->back()->with('error', 'Administrateur non trouvé');
        }
        
        // Décoder les métadonnées existantes
        $metaData = json_decode($admin->meta_data ?? '{}', true) ?: [];
        
        // Gérer le téléchargement de la photo si présente
        $photoPath = $metaData['photo'] ?? null;
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($photoPath && file_exists(storage_path('app/public/' . $photoPath))) {
                unlink(storage_path('app/public/' . $photoPath));
            }
            
            // Stocker la nouvelle photo
            $photoPath = $request->file('photo')->store('profile_photos', 'public');
        }
        
        // Mettre à jour les métadonnées
        $metaData['prenom'] = $validated['prenom'];
        $metaData['nom'] = $validated['nom'];
        $metaData['telephone'] = $validated['telephone'];
        $metaData['photo'] = $photoPath;
        
        // Mettre à jour les informations de l'utilisateur
        DB::table('users')
            ->where('id', $admin_id)
            ->update([
                'name' => $validated['nom'] . ' ' . $validated['prenom'],
                'email' => $validated['email'],
                'meta_data' => json_encode($metaData),
                'updated_at' => now()
            ]);
            
        return redirect()->route('admin.profile')->with('success', 'Profil mis à jour avec succès');
    }
    
    /**
     * Mettre à jour le mot de passe de l'administrateur
     */
    public function updatePassword(Request $request)
    {
        // Validation des données - Temporairement modifié pour ne pas exiger le mot de passe actuel
        $validated = $request->validate([
            'current_password' => 'nullable|string', // Rendu optionnel temporairement
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        // Récupérer l'ID de l'administrateur connecté
        $admin_id = auth()->id() ?? 1; // Utiliser l'ID 1 si non connecté (pour test)
        
        // Récupérer l'utilisateur
        $user = DB::table('users')
            ->where('id', $admin_id)
            ->first();
            
        // Si l'utilisateur n'est pas trouvé, rediriger avec erreur
        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur non trouvé');
        }
        
        // TEMPORAIRE: Contournement de la vérification du mot de passe actuel
        // Cette section est temporairement désactivée pour permettre la réinitialisation du mot de passe
        // Sera réactivée après la réinitialisation
        /*
        if (!Hash::check($validated['current_password'], $user->password)) {
            return redirect()->back()->with('error', 'Le mot de passe actuel est incorrect');
        }
        */
        
        // Mettre à jour le mot de passe
        DB::table('users')
            ->where('id', $admin_id)
            ->update([
                'password' => Hash::make($validated['password']),
                'updated_at' => now()
            ]);
            
        return redirect()->route('admin.profile')->with('success', 'Mot de passe mis à jour avec succès');
    }
    
    /**
     * Afficher la page paramètres de l'administrateur
     */
    public function settings()
    {
        // Récupérer les informations de l'administrateur connecté
        $admin_id = auth()->id() ?? 1; // Utiliser l'ID 1 si non connecté (pour test)
        
        $admin = DB::table('users')
            ->where('id', $admin_id)
            ->where('role', 'admin')
            ->select(
                'id',
                'email'
            )
            ->first();
            
        // Si l'administrateur n'est pas trouvé, utiliser des données factices
        if (!$admin) {
            $admin = (object)[
                'id' => 1,
                'email' => 'admin@etaalim.com'
            ];
        }
        
        return view('admin.settings.index', compact('admin'));
    }
    
    /**
     * Mettre à jour les paramètres généraux
     */
    public function updateGeneralSettings(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'timezone' => 'required|string'
        ]);
        
        // Récupérer l'ID de l'administrateur connecté
        $admin_id = auth()->id() ?? 1; // Utiliser l'ID 1 si non connecté (pour test)
        
        // Stocker les paramètres dans la session
        session(['app_timezone' => $validated['timezone']]);
        
        // Mettre à jour les paramètres dans la base de données si nécessaire
        // Vérifier si la table paramètres existe
        if (Schema::hasTable('parametres')) {
            // Mettre à jour ou créer les paramètres
            DB::table('parametres')->updateOrInsert(
                ['cle' => 'site_name'],
                ['valeur' => $validated['site_name'], 'updated_at' => now()]
            );
            
            DB::table('parametres')->updateOrInsert(
                ['cle' => 'contact_email'],
                ['valeur' => $validated['contact_email'], 'updated_at' => now()]
            );
            
            DB::table('parametres')->updateOrInsert(
                ['cle' => 'timezone'],
                ['valeur' => $validated['timezone'], 'updated_at' => now()]
            );
        }
        
        // Mettre à jour l'email de l'administrateur
        DB::table('utilisateurs')
            ->where('id', $admin_id)
            ->update([
                'email' => $validated['contact_email'],
                'updated_at' => now()
            ]);
        
        return redirect()->route('admin.settings')->with('success', 'Paramètres généraux mis à jour avec succès');
    }
    
    /**
     * Mettre à jour les paramètres de notifications
     */
    public function updateNotificationSettings(Request $request)
    {
        // Validation des données
        $email_notifications = $request->input('email_notifications', []);
        $app_notifications = $request->input('app_notifications', []);
        
        // Stocker les paramètres dans la session
        session(['email_notifications' => $email_notifications]);
        session(['app_notifications' => $app_notifications]);
        
        // Mettre à jour les paramètres dans la base de données si nécessaire
        if (Schema::hasTable('parametres')) {
            DB::table('parametres')->updateOrInsert(
                ['cle' => 'email_notifications'],
                ['valeur' => json_encode($email_notifications), 'updated_at' => now()]
            );
            
            DB::table('parametres')->updateOrInsert(
                ['cle' => 'app_notifications'],
                ['valeur' => json_encode($app_notifications), 'updated_at' => now()]
            );
        }
        
        return redirect()->route('admin.settings')->with('success', 'Paramètres de notifications mis à jour avec succès');
    }

    /**
     * Visualiser un cours avant validation
     */
    public function viewCourse($id)
    {
        // Récupérer les informations du cours
        // Pour le moment, nous utilisons des données factices
        $course = (object)[
            'id' => $id,
            'titre' => 'Introduction à la programmation Python',
            'description' => 'Un cours complet pour apprendre les bases de la programmation avec Python.',
            'contenu' => '<h2>Introduction</h2><p>Python est un langage de programmation interprété, orienté objet et de haut niveau avec une sémantique dynamique.</p><h2>Chapitre 1: Installation</h2><p>Pour installer Python, rendez-vous sur le site officiel et téléchargez la dernière version.</p><h2>Chapitre 2: Variables et types de données</h2><p>En Python, les variables sont des références à des objets. Les types de données de base sont les entiers, les flottants, les chaînes de caractères et les booléens.</p>',
            'date_creation' => now()->subDays(3),
            'enseignant_id' => 2,
            'statut' => 'en_attente',
            'nom_enseignant' => 'Dupont',
            'prenom_enseignant' => 'Jean',
            'documents' => [
                (object)[
                    'id' => 1,
                    'nom' => 'Introduction_Python.pdf',
                    'type' => 'pdf',
                    'taille' => '2.5 MB',
                    'date_upload' => now()->subDays(3)
                ],
                (object)[
                    'id' => 2,
                    'nom' => 'Exercices_Python.docx',
                    'type' => 'docx',
                    'taille' => '1.2 MB',
                    'date_upload' => now()->subDays(3)
                ]
            ]
        ];
        
        return view('admin.courses.view', compact('course'));
    }

    /**
     * Consulter un message en détail
     */
    public function viewMessage($id)
    {
        // Récupérer les informations du message
        // Pour le moment, nous utilisons des données factices
        $message = (object)[
            'id' => $id,
            'expediteur_id' => 2,
            'expediteur_email' => 'jean.dupont@etaalim.com',
            'expediteur_nom' => 'Dupont',
            'expediteur_prenom' => 'Jean',
            'expediteur_role' => 'Enseignant',
            'destinataire_id' => 1,
            'destinataire_email' => 'admin@etaalim.com',
            'destinataire_nom' => 'Admin',
            'destinataire_prenom' => 'Admin',
            'destinataire_role' => 'Administrateur',
            'sujet' => 'Question concernant le cours de programmation',
            'contenu' => '<p>Bonjour,</p><p>Je souhaiterais avoir plus d\'informations concernant le processus de validation des cours. J\'ai soumis mon cours de programmation Python il y a trois jours et je n\'ai pas encore reçu de retour.</p><p>Pourriez-vous me tenir informé de l\'avancement de la validation ?</p><p>Cordialement,<br>Jean Dupont</p>',
            'date_envoi' => now()->subDays(2),
            'lu' => false,
            'fichiers_joints' => [
                (object)[
                    'id' => 1,
                    'nom' => 'Question_details.pdf',
                    'type' => 'pdf',
                    'taille' => '1.2 MB',
                    'date_upload' => now()->subDays(2)
                ]
            ]
        ];
        
        return view('admin.messages.view', compact('message'));
    }

    /**
     * Affiche la page du calendrier
     */
    public function calendrier()
    {
        // Exemple d'événements pour démonstration
        $events = [
            (object) ['id' => 1, 'title' => 'Réunion pédagogique', 'date' => '2025-06-05', 'time' => '09:00', 'description' => 'Réunion avec tous les enseignants pour discuter des programmes.'],
            (object) ['id' => 2, 'title' => 'Conseil d\'administration', 'date' => '2025-06-12', 'time' => '14:00', 'description' => 'Révision des objectifs trimestriels et du budget.'],
            (object) ['id' => 3, 'title' => 'Journée portes ouvertes', 'date' => '2025-06-20', 'time' => '10:00', 'description' => 'Accueil des nouveaux étudiants et de leurs parents.'],
            (object) ['id' => 4, 'title' => 'Formation enseignants', 'date' => '2025-06-25', 'time' => '09:30', 'description' => 'Formation sur les nouvelles méthodes pédagogiques.'],
        ];
        
        return view('admin.calendrier.index', compact('events'));
    }

}
