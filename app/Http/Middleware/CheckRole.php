<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Vérifier si l'utilisateur a le rôle requis
        if ($user->estEnseignant() && in_array('enseignant', $roles)) {
            return $next($request);
        }
        
        if ($user->estEtudiant() && in_array('etudiant', $roles)) {
            return $next($request);
        }

        // Si l'utilisateur n'a pas le rôle requis
        abort(403, 'Accès non autorisé.');
    }
}
