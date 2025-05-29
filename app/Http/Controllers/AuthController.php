<?php

namespace App\Http\Controllers;

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
    }
}
