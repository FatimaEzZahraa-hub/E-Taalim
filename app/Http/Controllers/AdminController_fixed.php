<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ObjHelper;

class AdminController extends Controller
{
    // ... autres méthodes existantes ...
    
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
            // Préparer les métadonnées de l'étudiant
            $metaData = [
                'telephone' => $request->telephone,
                'filiere' => $request->filiere,
                'annee_scolaire' => $request->annee_scolaire,
            ];
            
            // Créer un nouvel utilisateur dans la table users
            $userData = [
                'name' => $request->nom . ' ' . $request->prenom,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'student',
                'niveau_id' => $request->niveau_id,
                'groupe_id' => $request->groupe_id,
                'meta_data' => json_encode($metaData),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            $userId = DB::table('users')->insertGetId($userData);

            return redirect()->route('admin.users')->with('success', 'Étudiant ajouté avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erreur lors de l\'ajout de l\'étudiant: ' . $e->getMessage()])->withInput();
        }
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
                'telephone' => $request->telephone,
                'specialite' => $request->specialite,
                'grade' => $request->grade,
                'bio' => $request->bio,
            ];
            
            // Créer un nouvel utilisateur dans la table users
            $userData = [
                'name' => $request->nom . ' ' . $request->prenom,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'teacher',
                'meta_data' => json_encode($metaData),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            $userId = DB::table('users')->insertGetId($userData);

            return redirect()->route('admin.users')->with('success', 'Enseignant ajouté avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erreur lors de l\'ajout de l\'enseignant: ' . $e->getMessage()])->withInput();
        }
    }
    
    // ... autres méthodes existantes ...
}
