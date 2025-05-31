<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Enseignant;
use App\Models\TravailDevoir;
use App\Models\Examen;
use App\Models\Etudiant;
use App\Models\Soumission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EnseignantController extends Controller
{
    // Méthode statique pour obtenir les cours de l'utilisateur actuel (pour les composants)
    public static function getCoursForCurrentUser()
    {
        // Créer une collection fictive de cours pour le mode démo
        $cours = collect();
        
        // Ajouter quelques cours fictifs
        for ($i = 1; $i <= 5; $i++) {
            $course = new \stdClass();
            $course->id = $i;
            $course->titre = 'Cours ' . $i;
            $cours->push($course);
        }
        
        return $cours;
    }
    // Méthode utilitaire pour obtenir les classes disponibles pour l'enseignant
    private function getClasses()
    {
        // Créer une collection fictive de classes
        $classes = collect();
        
        // Ajouter quelques classes fictives
        $niveaux = ['6ème', '5ème', '4ème', '3ème', '2nde', '1ère', 'Terminale'];
        $sections = ['A', 'B', 'C', 'D'];
        
        $id = 1;
        foreach ($niveaux as $niveau) {
            foreach ($sections as $section) {
                $classe = new \stdClass();
                $classe->id = $id++;
                $classe->nom = $niveau . ' ' . $section;
                $classe->niveau = $niveau;
                $classe->section = $section;
                $classes->push($classe);
            }
        }
        
        return $classes;
    }
    
    public function dashboard(Request $request)
    {
        // Créer un objet enseignant fictif pour le mode démo sans accéder à la base de données
        $enseignant = new \stdClass();
        $enseignant->id = 1;
        $enseignant->nom = 'Enseignant';
        $enseignant->prenom = 'Test';
        $enseignant->telephone = '0600000000';
        $enseignant->photo = null;
        $enseignant->code = 'default_code'; // Added code property to $enseignant initialization
        $enseignant->cours = collect(); // Added cours property to $enseignant initialization
        
        // Obtenir les classes disponibles
        $classes = $this->getClasses();
        
        // Créer une collection de cours fictifs avec différentes classes et matières
        $cours = collect();
        
        $matieres = ['Mathématiques', 'Physique', 'Chimie', 'Français', 'Histoire-Géographie', 'Anglais', 'SVT'];
        
        // Créer 15 cours fictifs
        for ($i = 1; $i <= 15; $i++) {
            $course = new \stdClass();
            $course->id = $i;
            $course->titre = 'Cours ' . $i;
            $course->description = 'Description du cours ' . $i;
            
            // Assigner une classe et une matière
            $classeIndex = ($i % count($classes));
            $classe = $classes[$classeIndex];
            $course->classe = $classe;
            $course->niveau = $classe->niveau;
            
            $matiereIndex = ($i % count($matieres));
            $course->matiere = $matieres[$matiereIndex];
            
            // Ajouter des collections vides pour les relations
            $course->etudiants = collect([]);
            $course->travauxDevoirs = collect([]);
            $course->examens = collect([]);
            
            // Ajouter quelques étudiants fictifs
            for ($j = 1; $j <= rand(5, 15); $j++) {
                $etudiant = new \stdClass();
                $etudiant->id = $j;
                $etudiant->nom = 'Etudiant ' . $j;
                $course->etudiants->push($etudiant);
            }
            
            // Ajouter quelques travaux fictifs
            for ($j = 1; $j <= rand(1, 3); $j++) {
                $travail = new \stdClass();
                $travail->id = $j;
                $travail->titre = 'Travail ' . $j . ' pour cours ' . $i;
                $course->travauxDevoirs->push($travail);
            }
            
            // Ajouter quelques examens fictifs
            for ($j = 1; $j <= rand(0, 2); $j++) {
                $examen = new \stdClass();
                $examen->id = $j;
                $examen->titre = 'Examen ' . $j . ' pour cours ' . $i;
                $examen->date_exam = now()->addDays(rand(1, 30));
                $course->examens->push($examen);
            }
            
            $cours->push($course);
        }
        
        // Filtrer par classe si spécifié
        $classeId = $request->query('classe_id');
        if ($classeId) {
            $cours = $cours->filter(function($course) use ($classeId) {
                return $course->niveau == $classeId;
            });
        }
        
        // Filtrer par matière si spécifié
        $matiereId = $request->query('matiere_id');
        if ($matiereId) {
            $cours = $cours->filter(function($course) use ($matiereId) {
                return $course->matiere == $matiereId;
            });
        }
        
        return view('enseignant.dashboard', compact('enseignant', 'cours', 'classes'));
    }
    
    public function profil()
    {
        // Créer un objet enseignant fictif pour le mode démo sans accéder à la base de données
        $user = new \stdClass();
        $user->id = 1;
        $user->nom = 'Enseignant';
        $user->prenom = 'Test';
        $user->email = 'enseignant@etaalim.com';
        $user->telephone = '0600000000';
        $user->photo = null;
        $user->code = 'default_code';
        
        return view('enseignant.profil.index', compact('user'));
    }
    
    public function updateProfil(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'telephone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        // En mode démo, nous ne sauvegardons pas réellement les données
        if ($request->hasFile('photo')) {
            $photoName = time() . '.' . $request->photo->extension();
            $request->photo->storeAs('public/photos', $photoName);
        }
        
        return redirect()->route('enseignant.profil')->with('success', 'Profil mis à jour avec succès (mode démo)');
    }
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        // En mode démo, nous ne changeons pas réellement le mot de passe
        // Dans une application réelle, nous vérifierions le mot de passe actuel et mettrions à jour le nouveau
        
        return redirect()->route('enseignant.profil')->with('success', 'Mot de passe mis à jour avec succès (mode démo)');
    }
    
    // Gestion des cours
    public function cours(Request $request)
    {
        // Obtenir les classes disponibles
        $classes = $this->getClasses();
        
        // Filtrer par classe si spécifié
        $classeId = $request->query('classe_id');
        
        // Créer une collection fictive de cours
        $allCours = collect();
        
        // Ajouter plus de cours fictifs pour démontrer la pagination
        for ($i = 1; $i <= 50; $i++) {
            $course = new \stdClass();
            $course->id = $i;
            $course->titre = 'Cours ' . $i;
            $course->description = 'Description du cours ' . $i;
            
            // Assigner une classe aléatoire à chaque cours
            $classeIndex = ($i % count($classes));
            $classe = $classes[$classeIndex];
            $course->classe = $classe;
            
            // Ajouter des collections vides pour les relations
            $course->travauxDevoirs = collect([]);
            $course->examens = collect([]);
            
            // Ajouter quelques travaux fictifs
            for ($j = 1; $j <= rand(1, 3); $j++) {
                $travail = new \stdClass();
                $travail->id = $j;
                $travail->titre = 'Travail ' . $j . ' pour cours ' . $i;
                $course->travauxDevoirs->push($travail);
            }
            
            // Ajouter quelques examens fictifs
            for ($j = 1; $j <= rand(0, 2); $j++) {
                $examen = new \stdClass();
                $examen->id = $j;
                $examen->titre = 'Examen ' . $j . ' pour cours ' . $i;
                $course->examens->push($examen);
            }
            
            // Si un filtre de classe est appliqué, n'ajouter que les cours de cette classe
            if (!$classeId || $classe->id == $classeId) {
                $allCours->push($course);
            }
        }
        
        // Paginer manuellement la collection
        $perPage = 21; // 21 éléments par page
        $currentPage = $request->query('page', 1);
        $currentPageItems = $allCours->forPage($currentPage, $perPage);
        
        // Créer un paginateur personnalisé
        $cours = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentPageItems,
            $allCours->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        
        return view('enseignant.cours.index', compact('cours', 'classes', 'classeId'));
    }
    
    public function createCours()
    {
        // Obtenir les classes disponibles
        $classes = $this->getClasses();
        
        return view('enseignant.cours.create', compact('classes'));
    }
    
    public function storeCours(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'classe_id' => 'required|integer',
            'fichier' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:10240',
        ]);
        
        // En mode démo, nous stockons uniquement le fichier s'il est fourni
        if ($request->hasFile('fichier')) {
            $fichierName = time() . '.' . $request->fichier->extension();
            $request->fichier->storeAs('public/cours', $fichierName);
        }
        
        return redirect()->route('enseignant.cours')->with('success', 'Cours ajouté avec succès (mode démo)');
    }
    
    public function editCours($id)
    {
        // Obtenir les classes disponibles
        $classes = $this->getClasses();
        
        // Créer un objet cours fictif pour le mode démo
        $cours = new \stdClass();
        $cours->id = $id;
        $cours->titre = 'Cours de démonstration';
        $cours->description = 'Description du cours de démonstration';
        $cours->fichier = null;
        
        // Assigner une classe au cours
        $classeIndex = ($id % count($classes));
        $cours->classe = $classes[$classeIndex];
        
        return view('enseignant.cours.edit', compact('cours', 'classes'));
    }
    
    public function updateCours(Request $request, $id)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'classe_id' => 'required|integer',
            'fichier' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:10240',
        ]);
        
        // En mode démo, nous stockons uniquement le fichier s'il est fourni
        if ($request->hasFile('fichier')) {
            $fichierName = time() . '.' . $request->fichier->extension();
            $request->fichier->storeAs('public/cours', $fichierName);
        }
        
        return redirect()->route('enseignant.cours')->with('success', 'Cours mis à jour avec succès (mode démo)');
    }
    
    public function deleteCours($id)
    {
        // En mode démo, nous ne supprimons rien réellement
        return redirect()->route('enseignant.cours')->with('success', 'Cours supprimé avec succès (mode démo)');
    }
    
    // Gestion des travaux et devoirs
    public function travauxDevoirs($coursId)
    {
        // Créer un objet cours fictif pour le mode démo
        $cours = new \stdClass();
        $cours->id = $coursId;
        $cours->titre = 'Cours de démonstration';
        
        // Créer une collection vide de travaux/devoirs
        $travauxDevoirs = collect([]);
        
        return view('enseignant.travaux_devoirs.index', compact('cours', 'travauxDevoirs'));
    }
    
    public function createTravailDevoir($coursId)
    {
        // Créer un objet cours fictif pour le mode démo
        $cours = new \stdClass();
        $cours->id = $coursId;
        $cours->titre = 'Cours de démonstration';
        
        return view('enseignant.travaux_devoirs.create', compact('cours'));
    }
    
    public function storeTravailDevoir(Request $request, $coursId)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_limite' => 'required|date',
            'fichier' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:10240',
        ]);
        
        // En mode démo, nous stockons uniquement le fichier s'il est fourni
        if ($request->hasFile('fichier')) {
            $fichierName = time() . '.' . $request->fichier->extension();
            $request->fichier->storeAs('public/travaux_devoirs', $fichierName);
        }
        
        return redirect()->route('enseignant.travaux_devoirs', $coursId)->with('success', 'Travail/Devoir ajouté avec succès (mode démo)');
    }
    
    public function editTravailDevoir($coursId, $id)
    {
        // Créer des objets fictifs pour le mode démo
        $cours = new \stdClass();
        $cours->id = $coursId;
        $cours->titre = 'Cours de démonstration';
        
        $travailDevoir = new \stdClass();
        $travailDevoir->id = $id;
        $travailDevoir->titre = 'Travail/Devoir de démonstration';
        $travailDevoir->description = 'Description du travail/devoir de démonstration';
        $travailDevoir->date_limite = date('Y-m-d', strtotime('+1 week'));
        $travailDevoir->fichier = null;
        
        return view('enseignant.travaux_devoirs.edit', compact('cours', 'travailDevoir'));
    }
    
    public function updateTravailDevoir(Request $request, $coursId, $id)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_limite' => 'required|date',
            'fichier' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:10240',
        ]);
        
        // En mode démo, nous stockons uniquement le fichier s'il est fourni
        if ($request->hasFile('fichier')) {
            $fichierName = time() . '.' . $request->fichier->extension();
            $request->fichier->storeAs('public/travaux_devoirs', $fichierName);
        }
        
        return redirect()->route('enseignant.travaux_devoirs', $coursId)->with('success', 'Travail/Devoir mis à jour avec succès (mode démo)');
    }
    
    public function deleteTravailDevoir($coursId, $id)
    {
        // En mode démo, nous ne supprimons rien réellement
        return redirect()->route('enseignant.travaux_devoirs', $coursId)->with('success', 'Travail/Devoir supprimé avec succès (mode démo)');
    }
    
    // Gestion des examens
    public function examens($coursId)
    {
        // Créer un objet cours fictif pour le mode démo
        $cours = new \stdClass();
        $cours->id = $coursId;
        $cours->titre = 'Cours de démonstration';
        
        // Créer une collection vide d'examens
        $examens = collect([]);
        
        return view('enseignant.examens.index', compact('cours', 'examens'));
    }
    
    public function createExamen($coursId)
    {
        // Créer un objet cours fictif pour le mode démo
        $cours = new \stdClass();
        $cours->id = $coursId;
        $cours->titre = 'Cours de démonstration';
        
        return view('enseignant.cours.examens.create', compact('cours'));
    }
    
    public function storeExamen(Request $request, $coursId)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_exam' => 'required|date',
            'fichier' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:10240',
        ]);
        
        // En mode démo, nous stockons uniquement le fichier s'il est fourni
        if ($request->hasFile('fichier')) {
            $fichierName = time() . '.' . $request->fichier->extension();
            $request->fichier->storeAs('public/examens', $fichierName);
        }
        
        return redirect()->route('enseignant.examens', $coursId)->with('success', 'Examen ajouté avec succès (mode démo)');
    }
    
    public function editExamen($coursId, $id)
    {
        // Créer des objets fictifs pour le mode démo
        $cours = new \stdClass();
        $cours->id = $coursId;
        $cours->titre = 'Cours de démonstration';
        
        $examen = new \stdClass();
        $examen->id = $id;
        $examen->titre = 'Examen de démonstration';
        $examen->description = 'Description de l\'examen de démonstration';
        $examen->date_exam = date('Y-m-d', strtotime('+2 weeks'));
        $examen->fichier = null;
        
        return view('enseignant.examens.edit', compact('cours', 'examen'));
    }
    
    public function updateExamen(Request $request, $coursId, $id)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_exam' => 'required|date',
            'fichier' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:10240',
        ]);
        
        // En mode démo, nous stockons uniquement le fichier s'il est fourni
        if ($request->hasFile('fichier')) {
            $fichierName = time() . '.' . $request->fichier->extension();
            $request->fichier->storeAs('public/examens', $fichierName);
        }
        
        return redirect()->route('enseignant.examens', $coursId)->with('success', 'Examen mis à jour avec succès (mode démo)');
    }
    
    public function deleteExamen($coursId, $id)
    {
        // En mode démo, nous ne supprimons rien réellement
        return redirect()->route('enseignant.examens', $coursId)->with('success', 'Examen supprimé avec succès (mode démo)');
    }
    
    // Gestion des soumissions
    public function soumissions($coursId, $travailDevoirId)
    {
        // Créer des objets fictifs pour le mode démo
        $cours = new \stdClass();
        $cours->id = $coursId;
        $cours->titre = 'Cours de démonstration';
        
        $travailDevoir = new \stdClass();
        $travailDevoir->id = $travailDevoirId;
        $travailDevoir->titre = 'Travail/Devoir de démonstration';
        
        // Créer une collection vide de soumissions
        $soumissions = collect([]);
        
        return view('enseignant.soumissions.index', compact('cours', 'travailDevoir', 'soumissions'));
    }
    
    public function allTravaux(Request $request)
    {
        // Obtenir les classes disponibles
        $classes = $this->getClasses();
        
        // Filtrer par classe si spécifié
        $classeId = $request->query('classe_id');
        
        // Créer une collection fictive de travaux
        $travaux = collect();
        
        // Ajouter quelques travaux fictifs
        for ($i = 1; $i <= 10; $i++) {
            $travail = new \stdClass();
            $travail->id = $i;
            $travail->titre = 'Travail/Devoir ' . $i;
            $travail->description = 'Description du travail/devoir ' . $i;
            $travail->date_limite = now()->addDays($i);
            
            // Assigner une classe aléatoire à chaque travail
            $classeIndex = ($i % count($classes));
            $classe = $classes[$classeIndex];
            $travail->classe = $classe;
            
            $travail->cours = new \stdClass();
            $travail->cours->id = $i;
            $travail->cours->titre = 'Cours ' . $i;
            $travail->cours->classe = $classe;
            
            // Si un filtre de classe est appliqué, n'ajouter que les travaux de cette classe
            if (!$classeId || $classe->id == $classeId) {
                $travaux->push($travail);
            }
        }
        
        return view('enseignant.travaux.index', compact('travaux', 'classes', 'classeId'));
    }
    
    public function createTravail()
    {
        // Créer une collection fictive de cours
        $cours = collect();
        
        // Ajouter quelques cours fictifs
        for ($i = 1; $i <= 5; $i++) {
            $course = new \stdClass();
            $course->id = $i;
            $course->titre = 'Cours ' . $i;
            $cours->push($course);
        }
        
        return view('enseignant.travaux.create', compact('cours'));
    }
    
    public function allExamens(Request $request)
    {
        // Obtenir les classes disponibles
        $classes = $this->getClasses();
        
        // Filtrer par classe si spécifié
        $classeId = $request->query('classe_id');
        
        // Créer une collection fictive d'examens
        $examens = collect();
        
        // Ajouter quelques examens fictifs
        for ($i = 1; $i <= 10; $i++) {
            $examen = new \stdClass();
            $examen->id = $i;
            $examen->titre = 'Examen ' . $i;
            $examen->description = 'Description de l\'examen ' . $i;
            $examen->date_exam = now()->addDays($i * 2);
            
            // Assigner une classe aléatoire à chaque examen
            $classeIndex = ($i % count($classes));
            $classe = $classes[$classeIndex];
            $examen->classe = $classe;
            
            $examen->cours = new \stdClass();
            $examen->cours->id = $i;
            $examen->cours->titre = 'Cours ' . $i;
            $examen->cours->classe = $classe;
            
            // Si un filtre de classe est appliqué, n'ajouter que les examens de cette classe
            if (!$classeId || $classe->id == $classeId) {
                $examens->push($examen);
            }
        }
        
        return view('enseignant.examens.index', compact('examens', 'classes', 'classeId'));
    }
    
    public function allSoumissions(Request $request)
    {
        // Obtenir les classes disponibles
        $classes = $this->getClasses();
        
        // Filtrer par classe si spécifié
        $classeId = $request->query('classe_id');
        
        // Créer une collection fictive de soumissions
        $soumissions = collect();
        
        // Ajouter quelques soumissions fictives
        for ($i = 1; $i <= 20; $i++) {
            $soumission = new \stdClass();
            $soumission->id = $i;
            $soumission->date_soumission = now()->subDays($i);
            $soumission->note = rand(0, 20);
            $soumission->commentaire = 'Commentaire sur la soumission ' . $i;
            
            // Assigner une classe aléatoire à chaque soumission
            $classeIndex = ($i % count($classes));
            $classe = $classes[$classeIndex];
            
            $soumission->etudiant = new \stdClass();
            $soumission->etudiant->id = $i;
            $soumission->etudiant->nom = 'Nom ' . $i;
            $soumission->etudiant->prenom = 'Prénom ' . $i;
            $soumission->etudiant->classe = $classe;
            
            $soumission->travailDevoir = new \stdClass();
            $soumission->travailDevoir->id = ceil($i/2);
            $soumission->travailDevoir->titre = 'Travail/Devoir ' . ceil($i/2);
            $soumission->travailDevoir->classe = $classe;
            
            $soumission->cours = new \stdClass();
            $soumission->cours->id = ceil($i/2);
            $soumission->cours->titre = 'Cours ' . ceil($i/2);
            $soumission->cours->classe = $classe;
            
            // Si un filtre de classe est appliqué, n'ajouter que les soumissions de cette classe
            if (!$classeId || $classe->id == $classeId) {
                $soumissions->push($soumission);
            }
        }
        
        return view('enseignant.soumissions.index', compact('soumissions', 'classes', 'classeId'));
    }
    
    public function messages()
    {
        // Créer une collection fictive de messages
        $messages = collect();
        
        // Ajouter quelques messages fictifs
        for ($i = 1; $i <= 10; $i++) {
            $message = new \stdClass();
            $message->id = $i;
            $message->sujet = 'Sujet du message ' . $i;
            $message->contenu = 'Contenu du message ' . $i;
            $message->date_envoi = now()->subDays($i);
            $message->lu = rand(0, 1);
            
            if ($i % 2 == 0) {
                // Message reçu
                $message->expediteur = new \stdClass();
                $message->expediteur->id = $i;
                $message->expediteur->nom = 'Nom ' . $i;
                $message->expediteur->prenom = 'Prénom ' . $i;
                $message->expediteur->type = 'Étudiant';
                $message->type = 'reçu';
            } else {
                // Message envoyé
                $message->destinataire = new \stdClass();
                $message->destinataire->id = $i;
                $message->destinataire->nom = 'Nom ' . $i;
                $message->destinataire->prenom = 'Prénom ' . $i;
                $message->destinataire->type = 'Étudiant';
                $message->type = 'envoyé';
            }
            
            $messages->push($message);
        }
        
        return view('enseignant.messages.index', compact('messages'));
    }
    
    public function createMessage()
    {
        // Créer une collection fictive d'étudiants
        $etudiants = collect();
        
        // Ajouter quelques étudiants fictifs
        for ($i = 1; $i <= 10; $i++) {
            $etudiant = new \stdClass();
            $etudiant->id = $i;
            $etudiant->nom = 'Nom ' . $i;
            $etudiant->prenom = 'Prénom ' . $i;
            $etudiants->push($etudiant);
        }
        
        return view('enseignant.messages.create', compact('etudiants'));
    }
    
    public function storeMessage(Request $request)
    {
        $request->validate([
            'destinataire_id' => 'required',
            'sujet' => 'required|string|max:255',
            'contenu' => 'required|string',
        ]);
        
        // Simuler l'enregistrement du message
        
        return redirect()->route('enseignant.messages')->with('success', 'Message envoyé avec succès.');
    }
    
    public function showMessage($id)
    {
        // Créer un message fictif
        $message = new \stdClass();
        $message->id = $id;
        $message->sujet = 'Sujet du message ' . $id;
        $message->contenu = 'Contenu du message ' . $id . '. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget ultricies nisl nisl eget nisl. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget ultricies nisl nisl eget nisl.';
        $message->date_envoi = now()->subDays($id);
        $message->lu = true;
        
        if ($id % 2 == 0) {
            // Message reçu
            $message->expediteur = new \stdClass();
            $message->expediteur->id = $id;
            $message->expediteur->nom = 'Nom ' . $id;
            $message->expediteur->prenom = 'Prénom ' . $id;
            $message->expediteur->type = 'Étudiant';
            $message->type = 'reçu';
        } else {
            // Message envoyé
            $message->destinataire = new \stdClass();
            $message->destinataire->id = $id;
            $message->destinataire->nom = 'Nom ' . $id;
            $message->destinataire->prenom = 'Prénom ' . $id;
            $message->destinataire->type = 'Étudiant';
            $message->type = 'envoyé';
        }
        
        return view('enseignant.messages.show', compact('message'));
    }
    
    public function deleteMessage($id)
    {
        // Simuler la suppression du message
        
        return redirect()->route('enseignant.messages')->with('success', 'Message supprimé avec succès.');
    }
    
    /**
     * Affiche la page de chat (messagerie instantanée)
     */
    public function chat()
    {
        // Dans une implémentation réelle, vous récupéreriez les conversations de l'enseignant
        
        return view('enseignant.chat.index');
    }
    
    /**
     * Affiche la page du calendrier
     */
    public function calendrier()
    {
        // Exemple d'événements pour démonstration
        $events = [
            (object) ['id' => 1, 'title' => 'Hackathon IA', 'date' => '2025-02-24', 'time' => '09:00', 'description' => 'Hackathon sur l\'intelligence artificielle organisé par l\'université.'],
            (object) ['id' => 2, 'title' => 'Examen Final', 'date' => '2025-02-28', 'time' => '14:00', 'description' => 'Examen final du module Programmation Web.'],
            (object) ['id' => 3, 'title' => 'Réunion Pédagogique', 'date' => '2025-02-15', 'time' => '10:30', 'description' => 'Réunion avec l\'ensemble des enseignants du département.'],
        ];
        
        return view('enseignant.calendrier.index', compact('events'));
    }
    
    /**
     * Affiche la page des notifications
     */
    public function notifications(Request $request)
    {
        // Dans une implémentation réelle, vous récupéreriez les notifications de l'enseignant depuis la base de données
        // Pour l'instant, nous utilisons des données statiques pour la démonstration
        
        // Créer un tableau de notifications fictives
        $notificationsData = [
            (object) [
                'id' => 1,
                'type' => 'soumission',
                'titre' => 'Nouvelle soumission',
                'contenu' => 'L\'\u00e9tudiant <strong>Ahmed Benani</strong> a soumis son devoir pour le cours <strong>Mathématiques Avancées</strong>.',
                'date' => now()->subHours(2),
                'lu' => false,
                'icone' => 'bi-file-earmark-text',
                'couleur' => 'primary'
            ],
            (object) [
                'id' => 2,
                'type' => 'evenement',
                'titre' => 'Nouvel événement planifié',
                'contenu' => 'L\'administration a planifié une <strong>réunion pédagogique</strong> pour le 5 juin 2025 à 14h00.',
                'date' => now()->subHours(5),
                'lu' => false,
                'icone' => 'bi-calendar-event',
                'couleur' => 'info'
            ],
            (object) [
                'id' => 3,
                'type' => 'message',
                'titre' => 'Nouveau message',
                'contenu' => 'Vous avez reçu un message de <strong>Directeur Académique</strong> concernant le programme du semestre prochain.',
                'date' => now()->subDay(),
                'lu' => true,
                'icone' => 'bi-envelope',
                'couleur' => 'success'
            ],
            (object) [
                'id' => 4,
                'type' => 'soumission',
                'titre' => 'Soumission en retard',
                'contenu' => 'L\'\u00e9tudiant <strong>Karim Alaoui</strong> a soumis son devoir en retard pour le cours <strong>Physique Quantique</strong>.',
                'date' => now()->subDays(2),
                'lu' => true,
                'icone' => 'bi-exclamation-triangle',
                'couleur' => 'warning'
            ],
            (object) [
                'id' => 5,
                'type' => 'administratif',
                'titre' => 'Information administrative',
                'contenu' => 'Les notes finales doivent être soumises avant le 15 juin 2025. Veuillez compléter toutes les évaluations.',
                'date' => now()->subDays(3),
                'lu' => true,
                'icone' => 'bi-building',
                'couleur' => 'secondary'
            ],
            (object) [
                'id' => 6,
                'type' => 'soumission',
                'titre' => 'Nouvelle soumission',
                'contenu' => 'L\'\u00e9tudiant <strong>Fatima Zahra</strong> a soumis son devoir pour le cours <strong>Programmation Web</strong>.',
                'date' => now()->subDays(4),
                'lu' => true,
                'icone' => 'bi-file-earmark-text',
                'couleur' => 'primary'
            ],
            (object) [
                'id' => 7,
                'type' => 'evenement',
                'titre' => 'Rappel d\'\u00e9vénement',
                'contenu' => 'Rappel : La <strong>cérémonie de remise des diplômes</strong> aura lieu le 20 juin 2025.',
                'date' => now()->subDays(5),
                'lu' => true,
                'icone' => 'bi-calendar-event',
                'couleur' => 'info'
            ],
            (object) [
                'id' => 8,
                'type' => 'message',
                'titre' => 'Nouveau message',
                'contenu' => 'Vous avez reçu un message de <strong>Service Technique</strong> concernant la maintenance des équipements informatiques.',
                'date' => now()->subDays(6),
                'lu' => true,
                'icone' => 'bi-envelope',
                'couleur' => 'success'
            ],
        ];
        
        // Filtrer les notifications si nécessaire
        $filter = $request->query('filter', 'all');
        $filteredNotifications = collect($notificationsData);
        
        if ($filter === 'unread') {
            $filteredNotifications = $filteredNotifications->where('lu', false);
        } elseif (in_array($filter, ['soumission', 'evenement', 'message', 'administratif'])) {
            $filteredNotifications = $filteredNotifications->where('type', $filter);
        }
        
        // Paginer les résultats
        $perPage = 5;
        $page = $request->query('page', 1);
        $offset = ($page - 1) * $perPage;
        
        $total = $filteredNotifications->count();
        $lastPage = ceil($total / $perPage);
        
        $notifications = $filteredNotifications->slice($offset, $perPage)->values();
        
        $pagination = [
            'current_page' => (int)$page,
            'last_page' => $lastPage,
            'per_page' => $perPage,
            'total' => $total,
            'path' => route('enseignant.notifications'),
        ];
        
        return view('enseignant.notifications.index', compact('notifications', 'pagination', 'filter'));
    }
    
    /**
     * Affiche la liste des étudiants
     */
    public function etudiants()
    {
        // Générer des étudiants fictifs pour démonstration (plus d'étudiants pour la pagination)
        $etudiantsData = [
            (object) ['id' => 1, 'code' => 'R34678986', 'filiere' => 'DD', 'classe' => 'DD-2A', 'nom' => 'Tazi', 'prenom' => 'Saad', 'email' => 'Tazi.Saad@gmail.com'],
            (object) ['id' => 2, 'code' => 'R12678890', 'filiere' => 'ID', 'classe' => 'ID-3A', 'nom' => 'Saki', 'prenom' => 'Leila', 'email' => 'Saki.Leila@gmail.com'],
            (object) ['id' => 3, 'code' => 'A11234567', 'filiere' => 'GE', 'classe' => 'GE-1A', 'nom' => 'Alami', 'prenom' => 'Fahd', 'email' => 'Alami.Fahd@gmail.com'],
            (object) ['id' => 4, 'code' => 'A09876543', 'filiere' => 'ID', 'classe' => 'ID-2A', 'nom' => 'Radi', 'prenom' => 'Mina', 'email' => 'Radi.Mina@gmail.com'],
            (object) ['id' => 5, 'code' => 'R24670087', 'filiere' => 'DD', 'classe' => 'DD-1A', 'nom' => 'Soul', 'prenom' => 'Hiba', 'email' => 'Soul.Hiba@gmail.com'],
            (object) ['id' => 6, 'code' => 'R35689012', 'filiere' => 'ID', 'classe' => 'ID-1A', 'nom' => 'Bennani', 'prenom' => 'Karim', 'email' => 'Bennani.Karim@gmail.com'],
            (object) ['id' => 7, 'code' => 'A22345678', 'filiere' => 'GE', 'classe' => 'GE-2A', 'nom' => 'Ouazzani', 'prenom' => 'Yasmine', 'email' => 'Ouazzani.Yasmine@gmail.com'],
            (object) ['id' => 8, 'code' => 'R45678901', 'filiere' => 'DD', 'classe' => 'DD-2A', 'nom' => 'Idrissi', 'prenom' => 'Omar', 'email' => 'Idrissi.Omar@gmail.com'],
            (object) ['id' => 9, 'code' => 'A33456789', 'filiere' => 'ID', 'classe' => 'ID-3A', 'nom' => 'Berrada', 'prenom' => 'Sara', 'email' => 'Berrada.Sara@gmail.com'],
            (object) ['id' => 10, 'code' => 'R56789012', 'filiere' => 'GE', 'classe' => 'GE-1A', 'nom' => 'Chraibi', 'prenom' => 'Mehdi', 'email' => 'Chraibi.Mehdi@gmail.com'],
            (object) ['id' => 11, 'code' => 'A44567890', 'filiere' => 'DD', 'classe' => 'DD-1A', 'nom' => 'Tahiri', 'prenom' => 'Amine', 'email' => 'Tahiri.Amine@gmail.com'],
            (object) ['id' => 12, 'code' => 'R67890123', 'filiere' => 'ID', 'classe' => 'ID-2A', 'nom' => 'Lahlou', 'prenom' => 'Nadia', 'email' => 'Lahlou.Nadia@gmail.com'],
            (object) ['id' => 13, 'code' => 'A55678901', 'filiere' => 'GE', 'classe' => 'GE-2A', 'nom' => 'Benmoussa', 'prenom' => 'Youssef', 'email' => 'Benmoussa.Youssef@gmail.com'],
            (object) ['id' => 14, 'code' => 'R78901234', 'filiere' => 'DD', 'classe' => 'DD-2A', 'nom' => 'Alaoui', 'prenom' => 'Fatima', 'email' => 'Alaoui.Fatima@gmail.com'],
            (object) ['id' => 15, 'code' => 'A66789012', 'filiere' => 'ID', 'classe' => 'ID-1A', 'nom' => 'Ziani', 'prenom' => 'Hamza', 'email' => 'Ziani.Hamza@gmail.com'],
            (object) ['id' => 16, 'code' => 'R89012345', 'filiere' => 'GE', 'classe' => 'GE-1A', 'nom' => 'Mansouri', 'prenom' => 'Imane', 'email' => 'Mansouri.Imane@gmail.com'],
            (object) ['id' => 17, 'code' => 'A77890123', 'filiere' => 'DD', 'classe' => 'DD-1A', 'nom' => 'Bouali', 'prenom' => 'Rachid', 'email' => 'Bouali.Rachid@gmail.com'],
            (object) ['id' => 18, 'code' => 'R90123456', 'filiere' => 'ID', 'classe' => 'ID-3A', 'nom' => 'Khalil', 'prenom' => 'Salma', 'email' => 'Khalil.Salma@gmail.com'],
            (object) ['id' => 19, 'code' => 'A88901234', 'filiere' => 'GE', 'classe' => 'GE-2A', 'nom' => 'Hassani', 'prenom' => 'Bilal', 'email' => 'Hassani.Bilal@gmail.com'],
            (object) ['id' => 20, 'code' => 'R01234567', 'filiere' => 'DD', 'classe' => 'DD-2A', 'nom' => 'Benjelloun', 'prenom' => 'Zineb', 'email' => 'Benjelloun.Zineb@gmail.com'],
            (object) ['id' => 21, 'code' => 'A99012345', 'filiere' => 'ID', 'classe' => 'ID-2A', 'nom' => 'Moussaoui', 'prenom' => 'Ismail', 'email' => 'Moussaoui.Ismail@gmail.com'],
            (object) ['id' => 22, 'code' => 'R12345678', 'filiere' => 'GE', 'classe' => 'GE-1A', 'nom' => 'Fassi', 'prenom' => 'Hajar', 'email' => 'Fassi.Hajar@gmail.com'],
        ];
        
        // Convertir le tableau en collection pour utiliser la pagination
        $etudiantsCollection = collect($etudiantsData);
        
        // Obtenir la page actuelle à partir de la requête
        $page = request()->get('page', 1);
        
        // Nombre d'étudiants par page
        $perPage = 10;
        
        // Calculer l'offset
        $offset = ($page - 1) * $perPage;
        
        // Récupérer les étudiants pour la page actuelle
        $currentPageEtudiants = $etudiantsCollection->slice($offset, $perPage)->values();
        
        // Créer un paginateur personnalisé
        $etudiants = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentPageEtudiants,
            $etudiantsCollection->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        return view('enseignant.etudiants.index', compact('etudiants'));
    }
    
    /**
     * Enregistre un nouvel étudiant
     */
    public function storeEtudiant(Request $request)
    {
        // Logique pour enregistrer un étudiant
        // Dans une implémentation réelle, vous valideriez les données et les enregistreriez dans la base de données
        
        return redirect()->route('enseignant.etudiants')->with('success', 'L\'\u00e9tudiant a été ajouté avec succès.');
    }
    
    /**
     * Importe une liste d'étudiants depuis un fichier Excel
     */
    public function importEtudiants(Request $request)
    {
        // Logique pour importer des étudiants depuis un fichier Excel
        // Dans une implémentation réelle, vous valideriez le fichier et importeriez les données
        
        return redirect()->route('enseignant.etudiants')->with('success', 'Les étudiants ont été importés avec succès.');
    }
    
    /**
     * Télécharge un modèle de fichier Excel pour l'importation d'étudiants
     */
    public function downloadEtudiantsTemplate()
    {
        // Logique pour générer et télécharger un modèle de fichier Excel
        // Dans une implémentation réelle, vous généreriez un fichier Excel avec les en-têtes appropriées
        
        // Pour l'instant, redirigeons simplement vers la page des étudiants
        return redirect()->route('enseignant.etudiants');
    }
    
    /**
     * Supprime un étudiant
     */
    public function deleteEtudiant($id)
    {
        // Logique pour supprimer un étudiant
        // Dans une implémentation réelle, vous trouveriez l'étudiant par son ID et le supprimeriez
        
        return redirect()->route('enseignant.etudiants')->with('success', 'L\'\u00e9tudiant a été supprimé avec succès.');
    }
}
