<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check() || !in_array(Auth::user()->role->nom, $roles)) {
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}
