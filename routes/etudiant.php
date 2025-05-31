<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EtudiantController;

// Routes pour les u00e9tudiants
Route::prefix('etudiant')->name('etudiant.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [EtudiantController::class, 'dashboard'])->name('dashboard');
    
    // Cours
    Route::get('/cours', [EtudiantController::class, 'cours'])->name('cours');
    Route::get('/cours/{id}', [EtudiantController::class, 'showCours'])->name('cours.show');
    
    // Devoirs
    Route::get('/devoirs', [EtudiantController::class, 'devoirs'])->name('devoirs');
    Route::get('/devoirs/{id}', [EtudiantController::class, 'showDevoir'])->name('devoirs.show');
    Route::post('/devoirs/{id}/soumettre', [EtudiantController::class, 'soumettre'])->name('devoirs.soumettre');
    
    // Examens
    Route::get('/examens', [EtudiantController::class, 'examens'])->name('examens');
    Route::get('/examens/{id}', [EtudiantController::class, 'showExamen'])->name('examens.show');
    
    // Messagerie
    Route::get('/messages', [EtudiantController::class, 'messages'])->name('messages');
    Route::get('/messages/create', [EtudiantController::class, 'createMessage'])->name('messages.create');
    Route::post('/messages', [EtudiantController::class, 'storeMessage'])->name('messages.store');
    Route::get('/messages/{id}', [EtudiantController::class, 'showMessage'])->name('messages.show');
    
    // Calendrier
    Route::get('/calendrier', [EtudiantController::class, 'calendrier'])->name('calendrier');
    
    // Notifications
    Route::get('/notifications', [EtudiantController::class, 'notifications'])->name('notifications');
    
    // Profil
    Route::get('/profil', [EtudiantController::class, 'profil'])->name('profil');
    Route::post('/profil', [EtudiantController::class, 'updateProfil'])->name('profil.update');
    Route::post('/profil/password', [EtudiantController::class, 'updatePassword'])->name('profil.password');
});
