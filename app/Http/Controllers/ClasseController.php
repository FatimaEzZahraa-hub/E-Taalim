<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Niveau;
use App\Models\Groupe;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ClasseController extends Controller
{
    /**
     * Afficher la page principale des classes
     */
    public function index()
    {
        // Temporairement du00e9sactivu00e9 jusqu'u00e0 la cru00e9ation de la table niveaux
        // $niveaux = Niveau::with('groupes')->get();
        $niveaux = collect([]); // Collection vide temporaire
        
        return view('admin.classes.index', compact('niveaux'));
    }
    
    /**
     * Afficher le formulaire de cru00e9ation d'un niveau
     */
    public function createNiveau()
    {
        return view('admin.classes.create_niveau');
    }
    
    /**
     * Enregistrer un nouveau niveau avec ses groupes
     */
    public function storeNiveau(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'nb_groupes' => 'nullable|integer|min:0'
        ]);
        
        // Cru00e9er le niveau
        $niveau = Niveau::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'actif' => true
        ]);
        
        // Si des groupes sont spu00e9cifiu00e9s, les cru00e9er automatiquement
        $nb_groupes = $request->nb_groupes ?? 0;
        
        if ($nb_groupes > 0) {
            for ($i = 1; $i <= $nb_groupes; $i++) {
                $groupe = new Groupe([
                    'nom' => 'Groupe ' . $i,
                    'description' => 'Groupe ' . $i . ' du niveau ' . $niveau->nom,
                    'capacite' => 30,
                    'actif' => true
                ]);
                
                $niveau->groupes()->save($groupe);
            }
        }
        
        return redirect()->route('admin.classes.index')->with('success', 'Niveau cru00e9u00e9 avec ' . $nb_groupes . ' groupe(s)');
    }
    
    /**
     * Afficher le formulaire de modification d'un niveau
     */
    public function editNiveau($id)
    {
        $niveau = Niveau::findOrFail($id);
        return view('admin.classes.edit_niveau', compact('niveau'));
    }
    
    /**
     * Mettre u00e0 jour un niveau
     */
    public function updateNiveau(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);
        
        $niveau = Niveau::findOrFail($id);
        $niveau->update([
            'nom' => $request->nom,
            'description' => $request->description,
            'actif' => $request->has('actif')
        ]);
        
        return redirect()->route('admin.classes.index')->with('success', 'Niveau mis u00e0 jour avec succu00e8s');
    }
    
    /**
     * Supprimer un niveau
     */
    public function destroyNiveau($id)
    {
        $niveau = Niveau::findOrFail($id);
        $niveau->delete();
        
        return redirect()->route('admin.classes.index')->with('success', 'Niveau supprimu00e9 avec succu00e8s');
    }
    
    /**
     * Afficher le formulaire de cru00e9ation d'un groupe
     */
    public function createGroupe($niveau_id)
    {
        $niveau = Niveau::findOrFail($niveau_id);
        return view('admin.classes.create_groupe', compact('niveau'));
    }
    
    /**
     * Enregistrer un nouveau groupe
     */
    public function storeGroupe(Request $request)
    {
        $request->validate([
            'niveau_id' => 'required|exists:niveaux,id',
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'capacite' => 'nullable|integer|min:1'
        ]);
        
        $niveau = Niveau::findOrFail($request->niveau_id);
        
        $groupe = new Groupe([
            'nom' => $request->nom,
            'description' => $request->description,
            'capacite' => $request->capacite ?? 30,
            'actif' => true
        ]);
        
        $niveau->groupes()->save($groupe);
        
        return redirect()->route('admin.classes.index')->with('success', 'Groupe cru00e9u00e9 avec succu00e8s');
    }
    
    /**
     * Afficher le formulaire de modification d'un groupe
     */
    public function editGroupe($id)
    {
        $groupe = Groupe::with('niveau')->findOrFail($id);
        return view('admin.classes.edit_groupe', compact('groupe'));
    }
    
    /**
     * Mettre u00e0 jour un groupe
     */
    public function updateGroupe(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'capacite' => 'nullable|integer|min:1'
        ]);
        
        $groupe = Groupe::findOrFail($id);
        $groupe->update([
            'nom' => $request->nom,
            'description' => $request->description,
            'capacite' => $request->capacite ?? 30,
            'actif' => $request->has('actif')
        ]);
        
        return redirect()->route('admin.classes.index')->with('success', 'Groupe mis u00e0 jour avec succu00e8s');
    }
    
    /**
     * Supprimer un groupe
     */
    public function destroyGroupe($id)
    {
        $groupe = Groupe::findOrFail($id);
        $groupe->delete();
        
        return redirect()->route('admin.classes.index')->with('success', 'Groupe supprimu00e9 avec succu00e8s');
    }
    
    /**
     * Afficher les u00e9tudiants d'un groupe
     */
    public function showGroupeStudents($id)
    {
        $groupe = Groupe::with(['niveau', 'etudiants'])->findOrFail($id);
        $etudiants_disponibles = User::whereNotIn('id', $groupe->etudiants->pluck('id'))
                                    ->where('role', 'student')
                                    ->get();
        
        return view('admin.classes.groupe_students', compact('groupe', 'etudiants_disponibles'));
    }
    
    /**
     * Ajouter des u00e9tudiants u00e0 un groupe
     */
    public function addStudentsToGroupe(Request $request, $id)
    {
        $request->validate([
            'etudiants' => 'required|array',
            'etudiants.*' => 'exists:users,id'
        ]);
        
        $groupe = Groupe::findOrFail($id);
        
        foreach ($request->etudiants as $etudiant_id) {
            // Vu00e9rifier si l'u00e9tudiant n'est pas du00e9ju00e0 dans le groupe
            if (!$groupe->etudiants->contains($etudiant_id)) {
                $groupe->etudiants()->attach($etudiant_id, ['date_affectation' => now()]);
            }
        }
        
        return redirect()->route('admin.classes.groupe.students', $id)
                         ->with('success', 'u00c9tudiants ajoutu00e9s au groupe avec succu00e8s');
    }
    
    /**
     * Retirer un u00e9tudiant d'un groupe
     */
    public function removeStudentFromGroupe(Request $request, $groupe_id, $etudiant_id)
    {
        $groupe = Groupe::findOrFail($groupe_id);
        $groupe->etudiants()->detach($etudiant_id);
        
        return redirect()->route('admin.classes.groupe.students', $groupe_id)
            ->with('success', 'L\'étudiant a été retiré du groupe avec succès.');
    }
    
    /**
     * Récupère les groupes d'un niveau spécifique (pour AJAX)
     */
    public function getGroupesByNiveau($niveau_id)
    {
        $groupes = Groupe::where('niveau_id', $niveau_id)
                        ->where('actif', true)
                        ->get(['id', 'nom']);
                        
        return response()->json(['groupes' => $groupes]);
    }
}
