<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Models\Utilisateur;
use App\Models\Role;
use App\Models\Enseignant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'mot_de_passe' => 'required',
        ]);
        
        $credentials = [
            'email' => $request->email,
            'password' => $request->mot_de_passe,
        ];
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            if ($user->estEnseignant()) {
                return redirect()->route('enseignant.dashboard');
            } else {
                // Rediriger vers d'autres tableaux de bord selon le rôle
                return redirect('/');
            }
        }
        
        return back()->withErrors([
            'email' => 'Les informations d\'identification fournies ne correspondent pas à nos enregistrements.',
        ]);
    }
    
    public function showRegister()
    {
        return view('auth.register');
    }
    
    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:Utilisateurs,email',
            'mot_de_passe' => 'required|min:8|confirmed',
            'telephone' => 'nullable|string|max:20',
        ]);
        
        // Trouver le rôle enseignant
        $roleEnseignant = Role::where('nom', 'enseignant')->first();
        
        if (!$roleEnseignant) {
            // Créer le rôle s'il n'existe pas
            $roleEnseignant = Role::create(['nom' => 'enseignant']);
        }
        
        // Créer l'utilisateur
        $utilisateur = Utilisateur::create([
            'email' => $request->email,
            'mot_de_passe' => Hash::make($request->mot_de_passe),
            'role_id' => $roleEnseignant->id,
        ]);
        
        // Créer le profil enseignant
        Enseignant::create([
            'utilisateur_id' => $utilisateur->id,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'telephone' => $request->telephone,
        ]);
        
        Auth::login($utilisateur);
        
        return redirect()->route('enseignant.dashboard');
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
=======
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Affiche la page de connexion
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Traite la demande de connexion
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Vérifier les informations d'identification dans la table Utilisateurs
        $user = DB::table('Utilisateurs')
                  ->where('email', $request->email)
                  ->first();

        if ($user && Hash::check($request->password, $user->mot_de_passe)) {
            // Vérifier si l'utilisateur est actif
            $metaData = [];
            if (property_exists($user, 'meta_data') && $user->meta_data) {
                $metaData = json_decode($user->meta_data, true) ?? [];
            }
            
            // Si l'utilisateur est inactif, refuser la connexion
            if (isset($metaData['active']) && $metaData['active'] == 0) {
                return redirect()->back()->withErrors(['email' => 'Votre compte a été désactivé. Veuillez contacter l\'administrateur.']);
            }
            
            // Authentifiez l'utilisateur manuellement
            Auth::loginUsingId($user->id);
            
            // Vérifiez le rôle de l'utilisateur
            $role = DB::table('Role')
                      ->join('Utilisateurs', 'Role.id', '=', 'Utilisateurs.role_id')
                      ->where('Utilisateurs.id', $user->id)
                      ->value('Role.nom');
            
            if ($role === 'administrateur') {
                return redirect()->route('admin.dashboard');
            } else {
                // Rediriger vers la page appropriée en fonction du rôle
                return redirect('/')->with('success', 'Vous êtes connecté');
            }
        }
        
        return redirect()->back()->withErrors(['email' => 'Ces informations d\'identification ne correspondent pas à nos enregistrements.']);
    }

    /**
     * Affiche la page d'inscription
     */
    public function showRegistrationForm()
    {
        $niveaux = \App\Models\Niveau::where('actif', true)->get();
        return view('auth.register', compact('niveaux'));
    }

    /**
     * Traite la demande d'inscription
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:Utilisateurs,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:etudiant,enseignant',
            'niveau_id' => 'required_if:role,etudiant|exists:niveaux,id',
            'groupe_id' => 'nullable|exists:groupes,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Obtenez l'ID du rôle
        $roleId = DB::table('Role')->where('nom', $request->role)->value('id');

        // Créer un nouvel utilisateur
        $userId = DB::table('Utilisateurs')->insertGetId([
            'email' => $request->email,
            'mot_de_passe' => Hash::make($request->password),
            'role_id' => $roleId,
            'role' => $request->role,
            'niveau_id' => $request->role === 'etudiant' ? $request->niveau_id : null,
            'groupe_id' => $request->role === 'etudiant' && $request->has('groupe_id') ? $request->groupe_id : null,
        ]);

        // Création des détails spécifiques en fonction du rôle
        if ($request->role === 'etudiant') {
            DB::table('Etudiants')->insert([
                'utilisateur_id' => $userId,
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'date_creation' => now(),
            ]);
        } elseif ($request->role === 'enseignant') {
            DB::table('Enseignants')->insert([
                'utilisateur_id' => $userId,
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'date_creation' => now(),
            ]);
        }

        // Connecter l'utilisateur
        Auth::loginUsingId($userId);

        return redirect('/')->with('success', 'Votre compte a été créé avec succès');
    }

    /**
     * Déconnexion de l'utilisateur
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Vous avez été déconnecté');
>>>>>>> origin/interface-admin
    }
}
