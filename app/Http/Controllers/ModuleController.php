<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Niveau;
use App\Models\User;
use App\Models\Groupe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ModuleController extends Controller
{
    /**
     * Affiche la liste des modules
     */
    public function index()
    {
        // Récupérer les modules avec les relations niveau et enseignant
        $modules = Module::with(['niveau', 'enseignant', 'groupes'])
            ->select('id', 'nom', 'code', 'description', 'couleur', 'image', 'niveau_id', 'enseignant_id')
            ->get();
        
        // Récupérer les niveaux directement depuis la table niveaux
        $niveaux = DB::table('niveaux')
            ->where('actif', true)
            ->select('id', 'nom', 'description')
            ->get();
        
        // Récupérer les enseignants depuis la table users
        $enseignants = DB::table('users')
            ->where('role', '=', 'teacher')
            ->select('id', 'email', 'name')
            ->get();
        
        return view('admin.modules.index', compact('modules', 'niveaux', 'enseignants'));
    }
    
    /**
     * Affiche le formulaire de création d'un module
     */
    public function create()
    {
        // Temporairement, rediriger vers la liste des modules avec un message
        // car la vue admin.modules.create n'existe peut-être pas encore
        return redirect()->route('admin.modules.index')
            ->with('info', 'Le formulaire de création des modules est en cours de du00e9veloppement.');
        
        /* Code original commentu00e9 pour ru00e9fu00e9rence future
        // Récupérer les niveaux directement depuis la table niveaux avec des alias explicites
        $niveaux = DB::table('niveaux')
            ->where('actif', true)
            ->select(
                'niveaux.id as id', 
                'niveaux.nom as nom', 
                'niveaux.description as description'
            )
            ->get();
        
        // Récupérer les enseignants depuis la table users avec des alias explicites
        $enseignants = DB::table('users')
            ->where('role', '=', 'teacher')
            ->select(
                'users.id as id', 
                'users.email as email', 
                'users.name as name'
            )
            ->get();
        
        // Gu00e9nu00e9rer des couleurs aluatoires pour les suggestions
        $couleurs_suggestions = [
            '#4CAF50', // Vert
            '#2196F3', // Bleu
            '#FFC107', // Jaune
            '#9C27B0', // Violet
            '#F44336', // Rouge
            '#009688', // Turquoise
            '#FF5722', // Orange
            '#607D8B', // Bleu-gris
        ];
        
        return view('admin.modules.create', compact('niveaux', 'enseignants', 'couleurs_suggestions'));
        */
    }
    
    /**
     * Enregistre un nouveau module
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'code' => 'nullable|string|max:20',
            'niveau_id' => 'required|exists:niveaux,id',
            'enseignant_id' => 'required|exists:users,id',
            'couleur' => 'nullable|string|max:20',
            'image' => 'nullable|image|max:2048', // 2MB max
            'groupes' => 'nullable|array',
            'groupes.*' => 'exists:groupes,id',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        try {
            // Traitement de l'image si elle est fournie
            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($request->nom) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('storage/modules'), $imageName);
                $imagePath = 'modules/' . $imageName;
            }
            
            // Cru00e9ation du module avec Query Builder
            $moduleId = DB::table('modules')->insertGetId([
                'nom' => $request->nom,
                'description' => $request->description,
                'code' => $request->code,
                'niveau_id' => $request->niveau_id,
                'enseignant_id' => $request->enseignant_id,
                'couleur' => $request->couleur ?? '#2196F3', // Bleu par du00e9faut
                'image' => $imagePath,
                'actif' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            // Association aux groupes si spu00e9cifiu00e9s
            if ($request->has('groupes') && is_array($request->groupes)) {
                foreach ($request->groupes as $groupeId) {
                    DB::table('module_groupe')->insert([
                        'module_id' => $moduleId,
                        'groupe_id' => $groupeId,
                        'date_affectation' => now(),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
            
            return redirect()->route('admin.modules.index')
                ->with('success', 'Module cru00e9u00e9 avec succu00e8s');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Erreur lors de la cru00e9ation du module: ' . $e->getMessage()])
                ->withInput();
        }
    }
    
    /**
     * Affiche les du00e9tails d'un module
     */
    public function show($id)
    {
        // Temporairement, rediriger vers la liste des modules avec un message
        // car la vue admin.modules.show n'existe pas encore
        return redirect()->route('admin.modules.index')
            ->with('info', 'La vue du00e9taillu00e9e des modules est en cours de du00e9veloppement.');
        
        /* Code original commentu00e9 pour ru00e9fu00e9rence future
        // Charger uniquement les relations qui existent certainement
        // pour u00e9viter les erreurs de tables ou modu00e8les inexistants
        $module = Module::with(['niveau', 'enseignant', 'groupes'])->findOrFail($id);
        
        // Ajouter des collections vides pour les relations qui pourraient causer des erreurs
        $module->cours = collect();
        $module->devoirs = collect();
        
        return view('admin.modules.show', compact('module'));
        */
    }
    
    /**
     * Affiche le formulaire de modification d'un module
     */
    public function edit($id)
    {
        // Temporairement, rediriger vers la liste des modules avec un message
        // car la vue admin.modules.edit n'existe pas encore
        return redirect()->route('admin.modules.index')
            ->with('info', 'Le formulaire de modification des modules est en cours de du00e9veloppement.');
        
        /* Code original commentu00e9 pour ru00e9fu00e9rence future
        $module = Module::with(['groupes'])->findOrFail($id);
        $niveaux = Niveau::where('actif', true)->get();
        $enseignants = User::where('role', 'teacher')->get();
        
        // Ru00e9cupu00e9rer les groupes du niveau su00e9lectionnu00e9
        $groupes = Groupe::where('niveau_id', $module->niveau_id)->get();
        
        // Couleurs suggestions
        $couleurs_suggestions = [
            '#4CAF50', // Vert
            '#2196F3', // Bleu
            '#FFC107', // Jaune
            '#9C27B0', // Violet
            '#F44336', // Rouge
            '#009688', // Turquoise
            '#FF5722', // Orange
            '#607D8B', // Bleu-gris
        ];
        
        return view('admin.modules.edit', compact('module', 'niveaux', 'enseignants', 'groupes', 'couleurs_suggestions'));
        */
    }
    
    /**
     * Met u00e0 jour un module
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'code' => 'nullable|string|max:20',
            'niveau_id' => 'required|exists:niveaux,id',
            'enseignant_id' => 'required|exists:users,id',
            'couleur' => 'nullable|string|max:20',
            'image' => 'nullable|image|max:2048', // 2MB max
            'groupes' => 'nullable|array',
            'groupes.*' => 'exists:groupes,id',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        try {
            $module = Module::findOrFail($id);
            
            // Traitement de l'image si elle est fournie
            if ($request->hasFile('image')) {
                // Supprimer l'ancienne image si elle existe
                if ($module->image && file_exists(public_path('storage/' . $module->image))) {
                    unlink(public_path('storage/' . $module->image));
                }
                
                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($request->nom) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('storage/modules'), $imageName);
                $module->image = 'modules/' . $imageName;
            }
            
            // Mise u00e0 jour du module
            $module->nom = $request->nom;
            $module->description = $request->description;
            $module->code = $request->code;
            $module->niveau_id = $request->niveau_id;
            $module->enseignant_id = $request->enseignant_id;
            $module->couleur = $request->couleur ?? '#2196F3';
            $module->save();
            
            // Mise u00e0 jour des groupes
            if ($request->has('groupes')) {
                $module->groupes()->sync($request->groupes);
            } else {
                $module->groupes()->detach();
            }
            
            return redirect()->route('admin.modules.index')
                ->with('success', 'Module mis u00e0 jour avec succu00e8s');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Erreur lors de la mise u00e0 jour du module: ' . $e->getMessage()])
                ->withInput();
        }
    }
    
    /**
     * Supprime un module
     */
    public function destroy($id)
    {
        try {
            $module = Module::findOrFail($id);
            
            // Supprimer l'image si elle existe
            if ($module->image && file_exists(public_path('storage/' . $module->image))) {
                unlink(public_path('storage/' . $module->image));
            }
            
            // Supprimer le module
            $module->delete();
            
            return redirect()->route('admin.modules.index')
                ->with('success', 'Module supprimu00e9 avec succu00e8s');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Erreur lors de la suppression du module: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Affiche les modules de l'enseignant connectu00e9
     */
    public function mesModules()
    {
        $enseignant = Auth::user();
        $modules = Module::where('enseignant_id', $enseignant->id)
                        ->with(['niveau', 'groupes', 'cours', 'devoirs'])
                        ->get();
        
        return view('enseignant.modules.index', compact('modules'));
    }
    
    /**
     * Affiche les du00e9tails d'un module pour l'enseignant
     */
    public function showModule($id)
    {
        $enseignant = Auth::user();
        $module = Module::where('id', $id)
                        ->where('enseignant_id', $enseignant->id)
                        ->with(['niveau', 'groupes', 'cours', 'devoirs'])
                        ->firstOrFail();
        
        return view('enseignant.modules.show', compact('module'));
    }
    
    /**
     * Ru00e9cupu00e8re les groupes d'un niveau (pour AJAX)
     */
    public function getGroupesByNiveau($niveau_id)
    {
        $groupes = Groupe::where('niveau_id', $niveau_id)
                        ->where('actif', true)
                        ->get(['id', 'nom']);
                        
        return response()->json(['groupes' => $groupes]);
    }
}
