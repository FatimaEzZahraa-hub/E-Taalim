<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifiez si l'utilisateur est connecté
        if (Auth::check()) {
            // Vérifiez si l'utilisateur a le rôle administrateur
            $user = Auth::user();
            $role = DB::table('Role')
                    ->join('Utilisateurs', 'Role.id', '=', 'Utilisateurs.role_id')
                    ->where('Utilisateurs.id', $user->id)
                    ->value('Role.nom');

            if ($role === 'administrateur') {
                return $next($request);
            }
        }
        
        // Rediriger vers la page d'accueil ou afficher une erreur
        return redirect('/')->with('error', 'Accès non autorisé.');
    }
}
