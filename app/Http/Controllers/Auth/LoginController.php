<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /**
     * Crée une nouvelle instance du contrôleur.
     *
     * @return void
     */
    public function __construct()
    {
        // Supprimer le middleware guest pour permettre l'accès à la page de connexion
    }

    /**
     * Affiche le formulaire de connexion.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('etudiant.dashboard');
        }
        return view('auth.login');
    }

    /**
     * Gère une tentative d'authentification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Log des informations de connexion (sans le mot de passe)
        Log::info('Tentative de connexion', ['email' => $credentials['email']]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Log::info('Connexion réussie', ['user_id' => Auth::id()]);
            return redirect()->route('etudiant.dashboard');
        }

        // Log de l'échec de connexion
        Log::warning('Échec de connexion', ['email' => $credentials['email']]);

        return back()
            ->withErrors(['email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.'])
            ->withInput($request->only('email'));
    }

    /**
     * Déconnecte l'utilisateur de l'application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
