<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Niveau;
use App\Models\Groupe;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Constructeur
     */
    public function __construct()
    {
        // Middleware d'authentification du00e9sactivu00e9 pour le du00e9veloppement
    }

    /**
     * Affiche le formulaire d'ajout d'un u00e9tudiant
     */
    public function addStudentForm()
    {
        // Ru00e9cupu00e9rer tous les niveaux actifs
        $niveaux = Niveau::where('actif', true)->get();
        
        return view('admin.users.add_student', compact('niveaux'));
    }

    /**
     * Enregistre un nouvel u00e9tudiant
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Du00e9terminer quelle table d'utilisateurs utiliser
            $userTable = Schema::hasTable('users') ? 'users' : 'utilisateurs';
            $passwordField = $userTable === 'users' ? 'password' : 'mot_de_passe';
            
            // Vu00e9rifier si la colonne role existe dans la table
            $hasRoleColumn = Schema::hasColumn($userTable, 'role');
            $hasRoleIdColumn = Schema::hasColumn($userTable, 'role_id');
            
            // Pru00e9parer les donnu00e9es de l'utilisateur
            $userData = [
                'name' => $request->nom . ' ' . $request->prenom,
                'email' => $request->email,
                $passwordField => Hash::make($request->password),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            // Ajouter le ru00f4le si la colonne existe
            if ($hasRoleColumn) {
                $userData['role'] = 'student';
            }
            
            // Ajouter role_id si la colonne existe
            if ($hasRoleIdColumn) {
                // Obtenir l'ID du ru00f4le u00e9tudiant
                $roleId = DB::table('Role')->where('nom', 'etudiant')->value('id');
                if ($roleId) {
                    $userData['role_id'] = $roleId;
                }
            }
            
            // Ajouter niveau_id et groupe_id si les colonnes existent
            if (Schema::hasColumn($userTable, 'niveau_id')) {
                $userData['niveau_id'] = $request->niveau_id;
            }
            
            if (Schema::hasColumn($userTable, 'groupe_id')) {
                $userData['groupe_id'] = $request->groupe_id;
            }
            
            // Cru00e9er un nouvel utilisateur
            $userId = DB::table($userTable)->insertGetId($userData);
            
            // Vu00e9rifier si la table Etudiants existe
            if (Schema::hasTable('Etudiants')) {
                // Cru00e9er l'u00e9tudiant
                DB::table('Etudiants')->insert([
                    'utilisateur_id' => $userId,
                    'nom' => $request->nom,
                    'prenom' => $request->prenom,
                    'date_creation' => now(),
                ]);
            }
            
            // Si un groupe est spu00e9cifiu00e9, ajouter l'u00e9tudiant au groupe
            if ($request->groupe_id) {
                DB::table('groupe_student')->insert([
                    'groupe_id' => $request->groupe_id,
                    'user_id' => $userId,
                    'date_affectation' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            
            return redirect()->route('admin.users')->with('success', 'u00c9tudiant ajoutu00e9 avec succu00e8s');
            
        } catch (\Exception $e) {
            // Log l'erreur pour du00e9bogage
            Log::error('Erreur lors de l\'ajout d\'un u00e9tudiant: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Une erreur est survenue lors de l\'ajout de l\'u00e9tudiant. Du00e9tails: ' . $e->getMessage()])->withInput();
        }
    }
}
