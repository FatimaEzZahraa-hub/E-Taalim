<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnseignantController;

// Routes d'accueil - redirection temporaire vers le dashboard enseignant
Route::get('/', function () {
    return redirect()->route('enseignant.dashboard');
});

// Redirection de /enseignant vers le dashboard de l'enseignant
Route::get('/enseignant', function () {
    return redirect()->route('enseignant.dashboard');
})->name('home');

// Routes d'authentification
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes pour les enseignants (temporairement sans authentification pour test)
Route::prefix('enseignant')->name('enseignant.')->group(function () {
    // Routes pour l'enseignant
    // Dashboard
    Route::get('/dashboard', [EnseignantController::class, 'dashboard'])->name('dashboard');
    
    // Profil
    Route::get('/profil', [EnseignantController::class, 'profil'])->name('profil');
    Route::post('/profil', [EnseignantController::class, 'updateProfil'])->name('profil.update');
    
    // Cours
    Route::get('/cours', [EnseignantController::class, 'cours'])->name('cours');
    Route::get('/cours/{id}', [EnseignantController::class, 'showCours'])->name('cours.show');
    Route::get('/cours/create', [EnseignantController::class, 'createCours'])->name('cours.create');
    Route::post('/cours', [EnseignantController::class, 'storeCours'])->name('cours.store');
    Route::get('/cours/{id}/edit', [EnseignantController::class, 'editCours'])->name('cours.edit');
    Route::put('/cours/{id}', [EnseignantController::class, 'updateCours'])->name('cours.update');
    Route::delete('/cours/{id}', [EnseignantController::class, 'deleteCours'])->name('cours.delete');
    
    // Travaux et devoirs
    Route::get('/cours/{coursId}/travaux-devoirs', [EnseignantController::class, 'travauxDevoirs'])->name('travaux_devoirs');
    Route::get('/cours/{coursId}/travaux-devoirs/create', [EnseignantController::class, 'createTravailDevoir'])->name('travaux_devoirs.create');
    Route::post('/cours/{coursId}/travaux-devoirs', [EnseignantController::class, 'storeTravailDevoir'])->name('travaux_devoirs.store');
    Route::get('/travaux', [EnseignantController::class, 'allTravaux'])->name('travaux');
    Route::get('/travaux/create', [EnseignantController::class, 'createTravail'])->name('travaux.create');
    Route::get('/cours/{coursId}/travaux-devoirs/{id}/edit', [EnseignantController::class, 'editTravailDevoir'])->name('travaux_devoirs.edit');
    Route::put('/cours/{coursId}/travaux-devoirs/{id}', [EnseignantController::class, 'updateTravailDevoir'])->name('travaux_devoirs.update');
    Route::delete('/cours/{coursId}/travaux-devoirs/{id}', [EnseignantController::class, 'deleteTravailDevoir'])->name('travaux_devoirs.delete');
    
    // Examens
    Route::get('/examens', [EnseignantController::class, 'allExamens'])->name('examens');
    Route::get('/cours/{coursId}/examens/create', [EnseignantController::class, 'createExamen'])->name('examens.create');
    Route::get('/cours/{coursId}/examens', [EnseignantController::class, 'examens'])->name('cours.examens');
    Route::post('/cours/{coursId}/examens', [EnseignantController::class, 'storeExamen'])->name('cours.examens.store');
    Route::get('/cours/{coursId}/examens/{id}/edit', [EnseignantController::class, 'editExamen'])->name('cours.examens.edit');
    Route::put('/cours/{coursId}/examens/{id}', [EnseignantController::class, 'updateExamen'])->name('cours.examens.update');
    Route::delete('/cours/{coursId}/examens/{id}', [EnseignantController::class, 'deleteExamen'])->name('cours.examens.delete');
    
    // Soumissions
    Route::get('/cours/{coursId}/travaux-devoirs/{travailDevoirId}/soumissions', [EnseignantController::class, 'soumissions'])->name('cours.soumissions');
    Route::get('/soumissions', [EnseignantController::class, 'allSoumissions'])->name('soumissions');
    
    // Messages
    Route::get('/messages', [EnseignantController::class, 'messages'])->name('messages');
    Route::get('/messages/create', [EnseignantController::class, 'createMessage'])->name('messages.create');
    Route::post('/messages', [EnseignantController::class, 'storeMessage'])->name('messages.store');
    Route::get('/messages/{id}', [EnseignantController::class, 'showMessage'])->name('messages.show');
    Route::delete('/messages/{id}', [EnseignantController::class, 'deleteMessage'])->name('messages.delete');
});
