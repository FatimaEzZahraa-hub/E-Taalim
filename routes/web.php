<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MessagingController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\ModuleController;

Route::get('/', function () {
    return view('welcome');
});

// Route de déconnexion
Route::post('/logout', function() {
    return redirect('/');
})->name('logout');

// Routes pour l'enseignant (sans authentification pour le développement)
Route::prefix('enseignant')->group(function () {
    // Dashboard
    Route::get('/dashboard', function() {
        return view('enseignant.dashboard');
    })->name('enseignant.dashboard');
    
    // Modules de l'enseignant
    Route::get('/modules', [ModuleController::class, 'mesModules'])->name('enseignant.modules.index');
    Route::get('/modules/{id}', [ModuleController::class, 'showModule'])->name('enseignant.modules.show');
    
    // Gestion des cours
    Route::post('/cours', function() {
        return redirect()->back()->with('success', 'Cours ajouté avec succès');
    })->name('enseignant.cours.store');
    
    // Gestion des devoirs
    Route::post('/devoirs', function() {
        return redirect()->back()->with('success', 'Devoir ajouté avec succès');
    })->name('enseignant.devoirs.store');
    
    // Gestion des examens
    Route::post('/examens', function() {
        return redirect()->back()->with('success', 'Examen planifié avec succès');
    })->name('enseignant.examens.store');
});

// Routes pour l'administration (sans authentification pour le développement)
Route::prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Gestion des classes (niveaux et groupes)
    Route::get('/classes', [ClasseController::class, 'index'])->name('admin.classes.index');
    
    // Routes pour les niveaux
    Route::get('/classes/niveaux/create', [ClasseController::class, 'createNiveau'])->name('admin.classes.niveaux.create');
    Route::post('/classes/niveaux', [ClasseController::class, 'storeNiveau'])->name('admin.classes.niveaux.store');
    Route::get('/classes/niveaux/{id}/edit', [ClasseController::class, 'editNiveau'])->name('admin.classes.niveaux.edit');
    Route::put('/classes/niveaux/{id}', [ClasseController::class, 'updateNiveau'])->name('admin.classes.niveaux.update');
    Route::delete('/classes/niveaux/{id}', [ClasseController::class, 'destroyNiveau'])->name('admin.classes.niveaux.destroy');
    
    // Routes pour les groupes
    Route::get('/classes/niveaux/{niveau_id}/groupes/create', [ClasseController::class, 'createGroupe'])->name('admin.classes.groupes.create');
    Route::post('/classes/groupes', [ClasseController::class, 'storeGroupe'])->name('admin.classes.groupes.store');
    Route::get('/classes/groupes/{id}/edit', [ClasseController::class, 'editGroupe'])->name('admin.classes.groupes.edit');
    Route::put('/classes/groupes/{id}', [ClasseController::class, 'updateGroupe'])->name('admin.classes.groupes.update');
    Route::delete('/classes/groupes/{id}', [ClasseController::class, 'destroyGroupe'])->name('admin.classes.groupes.destroy');
    
    // Routes pour la gestion des u00e9tudiants dans les groupes
    Route::get('/classes/groupes/{id}/students', [ClasseController::class, 'showGroupeStudents'])->name('admin.classes.groupe.students');
    Route::post('/classes/groupes/{id}/students', [ClasseController::class, 'addStudentsToGroupe'])->name('admin.classes.groupe.add-students');
    Route::delete('/classes/groupes/{groupe_id}/students/{etudiant_id}', [ClasseController::class, 'removeStudentFromGroupe'])->name('admin.classes.groupe.remove-student');
    
    // Route AJAX pour récupérer les groupes d'un niveau
    Route::get('/api/niveaux/{niveau_id}/groupes', [ClasseController::class, 'getGroupesByNiveau'])->name('api.niveaux.groupes');
    
    // Gestion des utilisateurs
    Route::get('/users', [AdminController::class, 'usersList'])->name('admin.users');
    Route::get('/users/{id}', [AdminController::class, 'viewUser'])->name('admin.users.view');
    Route::post('/users/{id}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle-status');
    
    // Gestion des modules
    Route::get('/modules', [ModuleController::class, 'index'])->name('admin.modules.index');
    Route::get('/modules/create', [ModuleController::class, 'create'])->name('admin.modules.create');
    Route::post('/modules', [ModuleController::class, 'store'])->name('admin.modules.store');
    Route::get('/modules/{id}', [ModuleController::class, 'show'])->name('admin.modules.show');
    Route::get('/modules/{id}/edit', [ModuleController::class, 'edit'])->name('admin.modules.edit');
    Route::put('/modules/{id}', [ModuleController::class, 'update'])->name('admin.modules.update');
    Route::delete('/modules/{id}', [ModuleController::class, 'destroy'])->name('admin.modules.destroy');
    Route::get('/students/add', [AdminController::class, 'addStudentForm'])->name('admin.students.add');
    Route::post('/users/store-student', [AdminController::class, 'storeStudent'])->name('admin.users.store-student');
    Route::post('/users/store-teacher', [AdminController::class, 'storeTeacher'])->name('admin.users.store-teacher');
    // Route GET simple pour la suppression des utilisateurs (plus compatible avec tous les environnements)
    Route::get('/supprimer-utilisateur/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    
    // Route GET simple pour changer le statut des utilisateurs (activer/désactiver)
    Route::get('/changer-statut-utilisateur/{id}', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle-status');
    
    // Routes pour l'édition des utilisateurs
    Route::get('/modifier-utilisateur/{id}', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::post('/update-utilisateur/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    
    // Route pour réinitialiser le mot de passe d'un utilisateur
    Route::post('/utilisateurs/{id}/reset-password', [AdminController::class, 'resetPassword'])->name('admin.users.reset-password');
    
    // Validation des cours
    Route::get('/courses/pending', [AdminController::class, 'pendingCourses'])->name('admin.courses.pending');
    Route::get('/courses/{id}/view', [AdminController::class, 'viewCourse'])->name('admin.courses.view');
    Route::post('/courses/{id}/approve', [AdminController::class, 'approveCourse'])->name('admin.courses.approve');
    Route::post('/courses/{id}/reject', [AdminController::class, 'rejectCourse'])->name('admin.courses.reject');
    
    // Gestion des plaintes
    Route::get('/complaints', [AdminController::class, 'complaints'])->name('admin.complaints');
    Route::post('/complaints/{id}/respond', [AdminController::class, 'respondToComplaint'])->name('admin.complaints.respond');
    
    // Anciennes routes de gestion des événements (désactivées)
    // Ces routes sont maintenant gérées par EventController
    
    // Messagerie
    Route::get('/messages', [AdminController::class, 'messages'])->name('admin.messages');
    Route::get('/messages/{id}', [AdminController::class, 'viewMessage'])->name('admin.messages.view');
    Route::get('/messaging', [MessagingController::class, 'index'])->name('admin.messaging.index');
    Route::get('/messaging/conversation/{id}', [MessagingController::class, 'viewConversation'])->name('admin.messaging.conversation');
    Route::post('/messaging/send', [MessagingController::class, 'sendMessage'])->name('admin.messaging.send');
    Route::post('/messaging/create-conversation', [MessagingController::class, 'createConversation'])->name('admin.messaging.create-conversation');
    Route::post('/messaging/create-group', [MessagingController::class, 'createGroup'])->name('admin.messaging.create-group');
    Route::post('/messages/send', [AdminController::class, 'sendMessage'])->name('admin.messages.send');
    
    // Notifications
    Route::get('/notifications', [AdminController::class, 'notifications'])->name('admin.notifications');
    Route::post('/notifications/mark-as-read', [AdminController::class, 'markNotificationsAsRead'])->name('admin.notifications.mark-as-read');
    Route::post('/notifications/{id}/mark-as-read', [AdminController::class, 'markNotificationAsRead'])->name('admin.notification.mark-as-read');
    Route::get('/notifications/get-latest', [AdminController::class, 'getLatestNotifications'])->name('admin.notifications.get-latest');
    Route::put('/notifications/{id}', [AdminController::class, 'updateNotification'])->name('admin.notifications.update');
    Route::delete('/notifications/{id}', [AdminController::class, 'deleteNotification'])->name('admin.notifications.delete');
    Route::post('/notifications', [AdminController::class, 'storeNotification'])->name('admin.notifications.store');

    // Gestion des événements
    Route::get('/events', [EventController::class, 'index'])->name('admin.events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('admin.events.create');
    Route::post('/events', [EventController::class, 'store'])->name('admin.events.store');
    Route::get('/events/{id}', [EventController::class, 'show'])->name('admin.events.show');
    Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('admin.events.edit');
    Route::put('/events/{id}', [EventController::class, 'update'])->name('admin.events.update');
    Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('admin.events.destroy');
    Route::post('/events/{id}/invite', [EventController::class, 'inviteParticipants'])->name('admin.events.invite');
    Route::post('/events/{id}/respond', [EventController::class, 'respondToInvitation'])->name('admin.events.respond');
    Route::put('/notifications/update/{id}', [AdminController::class, 'updateNotification'])->name('admin.notifications.update');
    
    // Profil utilisateur
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    Route::post('/profile/password', [AdminController::class, 'updatePassword'])->name('admin.profile.password');
    
    // Paramètres
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/settings/update-general', [AdminController::class, 'updateGeneralSettings'])->name('admin.settings.update-general');
    Route::post('/settings/update-notifications', [AdminController::class, 'updateNotificationSettings'])->name('admin.settings.update-notifications');
    Route::post('/settings/update-privacy', function() { return redirect()->back()->with('success', 'Paramètres de confidentialité mis à jour'); })->name('admin.settings.update-privacy');
    Route::post('/settings/update-display', function() { return redirect()->back()->with('success', 'Paramètres d\'affichage mis à jour'); })->name('admin.settings.update-display');
    Route::delete('/notifications/delete/{id}', [AdminController::class, 'deleteNotification'])->name('admin.notifications.delete');
    Route::post('/notifications/store', [AdminController::class, 'storeNotification'])->name('admin.notifications.store');
    
    // Messages
    Route::get('/messages', [AdminController::class, 'messages'])->name('admin.messages');
    Route::post('/messages/send', [AdminController::class, 'sendMessage'])->name('admin.messages.send');
    Route::post('/messages/{id}/reply', [AdminController::class, 'replyMessage'])->name('admin.messages.reply');
    
    // Plaintes
    Route::get('/complaints', [AdminController::class, 'complaints'])->name('admin.complaints');
    Route::post('/complaints/{id}/respond', [AdminController::class, 'respondToComplaint'])->name('admin.complaints.respond');
});
