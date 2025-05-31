<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Routes d'authentification
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Routes protégées par le middleware guest
Route::middleware('guest')->group(function () {
    // Réinitialisation de mot de passe
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
         ->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
         ->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
         ->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])
         ->name('password.update');
});

// Route de déconnexion
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Routes protégées
Route::middleware('auth')->group(function () {
    // Route du tableau de bord étudiant
    Route::get('/etudiant/dashboard', function () {
        return view('etudiant.dashboard');
    })->name('etudiant.dashboard');
    
    // Autres routes étudiantes
    Route::get('/etudiant/ressources', function () {
        return view('etudiant.ressources-pedagogiques');
    })->name('etudiant.ressources');
    
    Route::get('/etudiant/messagerie', function () {
        return view('etudiant.messagerie');
    })->name('etudiant.messagerie');
    
    Route::get('/etudiant/profil', function () {
        return view('etudiant.profil');
    })->name('etudiant.profil');
});

// Routes publiques
Route::view('/faq', 'pages.faq')->name('faq');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/politique-de-confidentialite', 'pages.politique')->name('politique');
Route::view('/conditions-utilisation', 'pages.conditions')->name('conditions');
Route::view('/contact-administration', 'pages.contact-admin')->name('contact.admin');
