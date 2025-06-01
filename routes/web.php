<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MessagingController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\ModuleController;

// Routes d'accueil - affichage de la page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Redirection de /enseignant vers le dashboard de l'enseignant
Route::get('/enseignant', function () {
    return redirect()->route('enseignant.dashboard');
});

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
    
    // Routes pour la gestion des étudiants
    Route::get('/etudiants', [EnseignantController::class, 'etudiants'])->name('etudiants');
    Route::post('/etudiants', [EnseignantController::class, 'storeEtudiant'])->name('etudiants.store');
    Route::post('/etudiants/import', [EnseignantController::class, 'importEtudiants'])->name('etudiants.import');
    Route::get('/etudiants/template', [EnseignantController::class, 'downloadEtudiantsTemplate'])->name('etudiants.template');
    
    // Profil
    Route::get('/profil', [EnseignantController::class, 'profil'])->name('profil');
    Route::post('/profil', [EnseignantController::class, 'updateProfil'])->name('profil.update');
    Route::post('/profil/password', [EnseignantController::class, 'updatePassword'])->name('profil.password');
    
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
    Route::get('/cours/{coursId}/examens/create', [EnseignantController::class, 'createExamen'])->name('cours.examens.create');
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
    
    // Chat (messagerie instantanée)
    Route::get('/chat', [EnseignantController::class, 'chat'])->name('chat');
    
    // Calendrier
    Route::get('/calendrier', [EnseignantController::class, 'calendrier'])->name('calendrier');
    
    // Notifications
    Route::get('/notifications', [EnseignantController::class, 'notifications'])->name('notifications');
});

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
    
    // Calendrier
    Route::get('/calendrier', [AdminController::class, 'calendrier'])->name('admin.calendrier');
});
