<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\EtudiantDashboardController;
use App\Http\Controllers\EnseignantController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Routes publiques
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('/faq', 'pages.faq')->name('faq');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/politique-de-confidentialite', 'pages.politique')->name('politique');
Route::view('/conditions-utilisation', 'pages.conditions')->name('conditions');
Route::view('/contact-administration', 'pages.contact-admin')->name('contact.admin');

// Routes d'authentification
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
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

// Routes pour les étudiants
Route::middleware(['auth', \App\Http\Middleware\CheckRole::class.':etudiant'])->prefix('etudiant')->name('etudiant.')->group(function () {
    Route::get('/dashboard', [EtudiantDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/cours', [EtudiantDashboardController::class, 'cours'])->name('cours');
    Route::get('/cours/{id}', [EtudiantDashboardController::class, 'showCours'])->name('cours.show');
    Route::get('/devoirs', [EtudiantDashboardController::class, 'devoirs'])->name('devoirs');
    Route::get('/devoirs/{id}', [EtudiantDashboardController::class, 'showDevoir'])->name('devoirs.show');
    Route::post('/devoirs/{id}/soumettre', [EtudiantDashboardController::class, 'soumettre'])->name('devoirs.soumettre');
    Route::get('/examens', [EtudiantDashboardController::class, 'examens'])->name('examens');
    Route::get('/examens/{id}', [EtudiantDashboardController::class, 'showExamen'])->name('examens.show');
    Route::get('/messages', [EtudiantDashboardController::class, 'messages'])->name('messages');
    Route::get('/calendrier', [EtudiantDashboardController::class, 'calendrier'])->name('calendrier');
    Route::get('/notifications', [EtudiantDashboardController::class, 'notifications'])->name('notifications');
    Route::get('/profil', [EtudiantDashboardController::class, 'profil'])->name('profil');
    Route::post('/profil', [EtudiantDashboardController::class, 'updateProfil'])->name('profil.update');
    Route::post('/profil/password', [EtudiantDashboardController::class, 'updatePassword'])->name('profil.password');
});

// Routes pour les enseignants
Route::middleware(['auth', \App\Http\Middleware\CheckRole::class.':enseignant'])->prefix('enseignant')->name('enseignant.')->group(function () {
    Route::get('/dashboard', [EnseignantController::class, 'dashboard'])->name('dashboard');
    Route::get('/cours', [EnseignantController::class, 'cours'])->name('cours');
    Route::get('/cours/create', [EnseignantController::class, 'createCours'])->name('cours.create');
    Route::post('/cours', [EnseignantController::class, 'storeCours'])->name('cours.store');
    Route::get('/cours/{id}/edit', [EnseignantController::class, 'editCours'])->name('cours.edit');
    Route::put('/cours/{id}', [EnseignantController::class, 'updateCours'])->name('cours.update');
    Route::delete('/cours/{id}', [EnseignantController::class, 'deleteCours'])->name('cours.delete');
    Route::get('/travaux', [EnseignantController::class, 'travaux'])->name('travaux');
    Route::get('/examens', [EnseignantController::class, 'examens'])->name('examens');
    Route::get('/messages', [EnseignantController::class, 'messages'])->name('messages');
    Route::get('/notifications', [EnseignantController::class, 'notifications'])->name('notifications');
    Route::get('/profil', [EnseignantController::class, 'profil'])->name('profil');
    Route::post('/profil', [EnseignantController::class, 'updateProfil'])->name('profil.update');
    Route::post('/profil/password', [EnseignantController::class, 'updatePassword'])->name('profil.password');
});
