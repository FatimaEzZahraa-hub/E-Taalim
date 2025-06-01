<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        // Logique de réinitialisation du mot de passe
        return back()->with('status', 'Nous avons envoyé un lien de réinitialisation à votre adresse e-mail.');
    }
} 