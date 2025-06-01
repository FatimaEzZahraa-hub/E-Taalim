@extends('layouts.admin')

@section('title', 'Gestion des Utilisateurs')

@section('page_title', 'Gestion des Utilisateurs')

@section('content')
<div class="container-fluid">
    <!-- Boutons rapides -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-center gap-3">
            <button class="btn btn-lg btn-primary" onclick="showTab('all')">
                <i class="fas fa-users"></i> Tous les utilisateurs
            </button>
            <button class="btn btn-lg btn-success" onclick="showTab('students')">
                <i class="fas fa-user-graduate"></i> Liste des étudiants
            </button>
            <button class="btn btn-lg btn-info text-white" onclick="showTab('teachers')">
                <i class="fas fa-chalkboard-teacher"></i> Liste des enseignants
            </button>
        </div>
    </div>
    
    <!-- Onglets (masqués mais utilisés pour la navigation) -->
    <ul class="nav nav-tabs d-none" id="userTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">Tous les utilisateurs</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="students-tab" data-bs-toggle="tab" data-bs-target="#students" type="button" role="tab" aria-controls="students" aria-selected="false">Étudiants</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="teachers-tab" data-bs-toggle="tab" data-bs-target="#teachers" type="button" role="tab" aria-controls="teachers" aria-selected="false">Enseignants</button>
        </li>
    </ul>
    
    <!-- Contenu des onglets -->
    <div class="tab-content" id="userTabsContent">
        <!-- Tous les utilisateurs -->
        <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Liste des utilisateurs</h6>
                    <div>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                            <i class="fas fa-user-graduate"></i> Ajouter un étudiant
                        </button>
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#addTeacherModal">
                            <i class="fas fa-chalkboard-teacher"></i> Ajouter un enseignant
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Barre de recherche et filtres -->
                    <form action="{{ route('admin.users') }}" method="GET" id="filterForm">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="search" class="form-label">Rechercher</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="search" name="search" placeholder="Rechercher par email, nom..." value="{{ request('search') }}">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="role" class="form-label">Filtrer par rôle</label>
                                    <select class="form-select" id="role" name="role" onchange="this.form.submit()">
                                        <option value="" {{ request('role') == '' ? 'selected' : '' }}>Tous les rôles</option>
                                        <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>Étudiants</option>
                                        <option value="teacher" {{ request('role') == 'teacher' ? 'selected' : '' }}>Enseignants</option>
                                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrateurs</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="status" class="form-label">Filtrer par statut</label>
                                    <select class="form-select" id="status" name="status" onchange="this.form.submit()">
                                        <option value="" {{ request('status') == '' ? 'selected' : '' }}>Tous les statuts</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actifs</option>
                                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactifs</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive overflow-auto">
                        <table class="table table-bordered table-hover" id="usersTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Rôle</th>
                                    <th>Mot de passe initial</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->role == 'admin')
                                            <span class="badge bg-danger">Administrateur</span>
                                        @elseif($user->role == 'teacher')
                                            <span class="badge bg-info text-white">Enseignant</span>
                                        @elseif($user->role == 'student')
                                            <span class="badge bg-success">Étudiant</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(property_exists($user, 'initial_password') && $user->initial_password)
                                            <code>{{ $user->initial_password }}</code>
                                        @else
                                            <span class="text-muted">Non disponible</span>
                                            <i class="fas fa-info-circle text-info" title="Cliquez sur le bouton 'Mot de passe' pour définir un nouveau mot de passe et le voir s'afficher ici"></i>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <!-- Activer/Désactiver -->
                                            @php
                                                $metaData = json_decode($user->meta_data ?? '{}', true) ?: [];
                                                $isActive = isset($metaData['active']) ? $metaData['active'] == 1 : true;
                                            @endphp
                                            <button class="btn {{ $isActive ? 'btn-warning' : 'btn-success' }} btn-sm mx-1" 
                                                title="{{ $isActive ? 'Désactiver' : 'Activer' }} le compte" 
                                                onclick="confirmerChangementStatut({{ $user->id }}, '{{ $isActive ? 'désactiver' : 'activer' }}')">
                                                <i class="fas {{ $isActive ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                                {{ $isActive ? 'Désactiver' : 'Activer' }}
                                            </button>
                                            
                                            <!-- Réinitialiser le mot de passe -->
                                            <button type="button" class="btn btn-info btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#resetPasswordModal{{ $user->id }}">
                                                <i class="fas fa-key"></i> Mot de passe
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Étudiants -->
        <div class="tab-pane fade" id="students" role="tabpanel" aria-labelledby="students-tab">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Liste des étudiants</h6>
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                        <i class="fas fa-user-graduate"></i> Ajouter un étudiant
                    </button>
                </div>
                <div class="card-body">
                    <!-- Barre de recherche et filtres pour étudiants -->
                    <form action="{{ route('admin.users') }}" method="GET" id="studentFilterForm">
                        <input type="hidden" name="tab" value="students">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="student_search" class="form-label">Rechercher</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="student_search" name="student_search" placeholder="Rechercher par nom, email..." value="{{ request('student_search') }}">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="student_niveau" class="form-label">Filtrer par niveau</label>
                                    <select class="form-select" id="student_niveau" name="student_niveau" onchange="this.form.submit()">
                                        <option value="" {{ request('student_niveau') == '' ? 'selected' : '' }}>Tous les niveaux</option>
                                        <option value="Licence 1" {{ request('student_niveau') == 'Licence 1' ? 'selected' : '' }}>Licence 1</option>
                                        <option value="Licence 2" {{ request('student_niveau') == 'Licence 2' ? 'selected' : '' }}>Licence 2</option>
                                        <option value="Licence 3" {{ request('student_niveau') == 'Licence 3' ? 'selected' : '' }}>Licence 3</option>
                                        <option value="Master 1" {{ request('student_niveau') == 'Master 1' ? 'selected' : '' }}>Master 1</option>
                                        <option value="Master 2" {{ request('student_niveau') == 'Master 2' ? 'selected' : '' }}>Master 2</option>
                                        <option value="Doctorat" {{ request('student_niveau') == 'Doctorat' ? 'selected' : '' }}>Doctorat</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="student_status" class="form-label">Filtrer par statut</label>
                                    <select class="form-select" id="student_status" name="student_status" onchange="this.form.submit()">
                                        <option value="" {{ request('student_status') == '' ? 'selected' : '' }}>Tous les statuts</option>
                                        <option value="active" {{ request('student_status') == 'active' ? 'selected' : '' }}>Actifs</option>
                                        <option value="inactive" {{ request('student_status') == 'inactive' ? 'selected' : '' }}>Inactifs</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive overflow-auto">
                        <table class="table table-bordered table-hover" id="studentsTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                <tr>
                                    <td>{{ ObjHelper::prop($student, 'id', 'N/A') }}</td>
                                    <td>
                                        {{ ObjHelper::prop($student, 'nom', ObjHelper::prop($student, 'name', 'N/A')) }}
                                        @php
                                            $metaData = json_decode($student->meta_data ?? '{}', true) ?: [];
                                            $isActive = isset($metaData['active']) ? $metaData['active'] == 1 : true;
                                        @endphp
                                        @if(!$isActive)
                                            <span class="badge bg-danger ms-2">Inactif</span>
                                        @endif
                                    </td>
                                    <td>{{ ObjHelper::prop($student, 'prenom', 'N/A') }}</td>
                                    <td>{{ ObjHelper::prop($student, 'email', 'N/A') }}</td>
                                    <td>{{ ObjHelper::prop($student, 'telephone', 'N/A') }}</td>

                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <!-- Modifier -->
                                            <a href="{{ route('admin.users.edit', $student->id) }}" class="btn btn-primary btn-sm mx-1" title="Modifier l'étudiant">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <!-- Supprimer -->
                                            <a href="#" class="btn btn-danger btn-sm mx-1" title="Supprimer l'étudiant" 
                                               onclick="confirmerSuppression({{ $student->id }})">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Enseignants -->
        <div class="tab-pane fade" id="teachers" role="tabpanel" aria-labelledby="teachers-tab">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Liste des enseignants</h6>
                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#addTeacherModal">
                        <i class="fas fa-chalkboard-teacher"></i> Ajouter un enseignant
                    </button>
                </div>
                <div class="card-body">
                    <!-- Barre de recherche et filtres pour enseignants -->
                    <form action="{{ route('admin.users') }}" method="GET" id="teacherFilterForm">
                        <input type="hidden" name="tab" value="teachers">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="teacher_search" class="form-label">Rechercher</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="teacher_search" name="teacher_search" placeholder="Rechercher par nom, email..." value="{{ request('teacher_search') }}">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="teacher_specialite" class="form-label">Filtrer par spécialité</label>
                                    <select class="form-select" id="teacher_specialite" name="teacher_specialite" onchange="this.form.submit()">
                                        <option value="" {{ request('teacher_specialite') == '' ? 'selected' : '' }}>Toutes les spécialités</option>
                                        <option value="Mathématiques" {{ request('teacher_specialite') == 'Mathématiques' ? 'selected' : '' }}>Mathématiques</option>
                                        <option value="Physique" {{ request('teacher_specialite') == 'Physique' ? 'selected' : '' }}>Physique</option>
                                        <option value="Informatique" {{ request('teacher_specialite') == 'Informatique' ? 'selected' : '' }}>Informatique</option>
                                        <option value="Langues" {{ request('teacher_specialite') == 'Langues' ? 'selected' : '' }}>Langues</option>
                                        <option value="Sciences Humaines" {{ request('teacher_specialite') == 'Sciences Humaines' ? 'selected' : '' }}>Sciences Humaines</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="teacher_status" class="form-label">Filtrer par statut</label>
                                    <select class="form-select" id="teacher_status" name="teacher_status" onchange="this.form.submit()">
                                        <option value="" {{ request('teacher_status') == '' ? 'selected' : '' }}>Tous les statuts</option>
                                        <option value="active" {{ request('teacher_status') == 'active' ? 'selected' : '' }}>Actifs</option>
                                        <option value="inactive" {{ request('teacher_status') == 'inactive' ? 'selected' : '' }}>Inactifs</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive overflow-auto">
                        <table class="table table-bordered table-hover" id="teachersTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teachers as $teacher)
                                <tr>
                                    <td>{{ ObjHelper::prop($teacher, 'id', 'N/A') }}</td>
                                    <td>
                                        {{ ObjHelper::prop($teacher, 'nom', 'N/A') }}
                                        @php
                                            $metaData = json_decode($teacher->meta_data ?? '{}', true) ?: [];
                                            $isActive = isset($metaData['active']) ? $metaData['active'] == 1 : true;
                                        @endphp
                                        @if(!$isActive)
                                            <span class="badge bg-danger ms-2">Inactif</span>
                                        @endif
                                    </td>
                                    <td>{{ ObjHelper::prop($teacher, 'prenom', 'N/A') }}</td>
                                    <td>{{ ObjHelper::prop($teacher, 'email', 'N/A') }}</td>
                                    <td>{{ ObjHelper::prop($teacher, 'telephone', 'N/A') }}</td>

                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <!-- Modifier -->
                                            <a href="{{ route('admin.users.edit', $teacher->id) }}" class="btn btn-primary btn-sm mx-1" title="Modifier l'enseignant">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <!-- Supprimer -->
                                            <a href="#" class="btn btn-danger btn-sm mx-1" title="Supprimer l'enseignant" 
                                               onclick="confirmerSuppression({{ $teacher->id }})">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Ajout Étudiant -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">Ajouter un étudiant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.users.store-student') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="prenom" class="form-label">Prénom</label>
                                <input type="text" class="form-control" id="prenom" name="prenom" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telephone" class="form-label">Téléphone</label>
                                <input type="tel" class="form-control" id="telephone" name="telephone">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="niveau_id" class="form-label">Niveau</label>
                                <select id="niveau_id" class="form-select" name="niveau_id" required>
                                    <option value="">Sélectionnez un niveau</option>
                                    @foreach($niveaux ?? [] as $niveau)
                                        <option value="{{ $niveau->id }}">{{ $niveau->nom ?? 'Niveau ' . $niveau->id }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="groupe_id" class="form-label">Groupe</label>
                                <select id="groupe_id" class="form-select" name="groupe_id">
                                    <option value="">Sélectionnez d'abord un niveau</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="filiere" class="form-label">Filière</label>
                                <input type="text" class="form-control" id="filiere" name="filiere" placeholder="Ex: Sciences Mathématiques">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="annee_scolaire" class="form-label">Année scolaire</label>
                                <input type="text" class="form-control" id="annee_scolaire" name="annee_scolaire" value="{{ date('Y') }}-{{ date('Y')+1 }}" placeholder="Ex: 2025-2026">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date_naissance" class="form-label">Date de naissance</label>
                                <input type="date" class="form-control" id="date_naissance" name="date_naissance">
                            </div>
                            <div class="col-md-6 mb-3">
                                <!-- Champ supplémentaire si nécessaire -->
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-success">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal Ajout Enseignant -->
    <div class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTeacherModalLabel">Ajouter un enseignant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.users.store-teacher') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="teacher_nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="teacher_nom" name="nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="teacher_prenom" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="teacher_prenom" name="prenom" required>
                        </div>
                        <div class="mb-3">
                            <label for="teacher_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="teacher_email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="teacher_telephone" class="form-label">Téléphone</label>
                            <input type="tel" class="form-control" id="teacher_telephone" name="telephone">
                        </div>
                        <div class="mb-3">
                            <label for="specialite" class="form-label">Spécialité</label>
                            <select class="form-select" id="specialite" name="specialite">
                                <option value="Informatique">Informatique</option>
                                <option value="Mathématiques">Mathématiques</option>
                                <option value="Physique">Physique</option>
                                <option value="Chimie">Chimie</option>
                                <option value="Biologie">Biologie</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="grade" class="form-label">Grade</label>
                            <select class="form-select" id="grade" name="grade">
                                <option value="Professeur">Professeur</option>
                                <option value="Maître de conférences">Maître de conférences</option>
                                <option value="Docteur">Docteur</option>
                                <option value="Doctorant">Doctorant</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="teacher_password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="teacher_password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="teacher_password_confirmation" class="form-label">Confirmer le mot de passe</label>
                            <input type="password" class="form-control" id="teacher_password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modals pour réinitialiser les mots de passe -->
@foreach($users as $user)
<div class="modal fade" id="resetPasswordModal{{ $user->id }}" tabindex="-1" aria-labelledby="resetPasswordModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resetPasswordModalLabel{{ $user->id }}">Réinitialiser le mot de passe - {{ $user->email }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.users.reset-password', $user->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="new_password{{ $user->id }}" class="form-label">Nouveau mot de passe</label>
                        <input type="text" class="form-control" id="new_password{{ $user->id }}" name="new_password" required>
                        <small class="form-text text-muted">Le mot de passe doit contenir au moins 8 caractères.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection

@section('scripts')
<!-- SweetAlert2 pour des alertes modernes et attrayantes -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Fonction pour afficher l'onglet sélectionné
function showTab(tabId) {
    // Masquer tous les onglets
    document.querySelectorAll('.tab-pane').forEach(function(tab) {
        tab.classList.remove('show', 'active');
    });
    
    // Afficher l'onglet sélectionné
    const selectedTab = document.getElementById(tabId);
    if (selectedTab) {
        selectedTab.classList.add('show', 'active');
    }
    
    // Mettre à jour les onglets (pour la navigation)
    document.querySelectorAll('#userTabs .nav-link').forEach(function(tabLink) {
        tabLink.classList.remove('active');
        tabLink.setAttribute('aria-selected', 'false');
    });
    
    const activeTabLink = document.querySelector('#userTabs .nav-link[data-bs-target="#' + tabId + '"]');
    if (activeTabLink) {
        activeTabLink.classList.add('active');
        activeTabLink.setAttribute('aria-selected', 'true');
    }
}

// Fonction pour confirmer et effectuer la suppression d'un utilisateur
function confirmerSuppression(id) {
    Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: "Cette action est irréversible !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, supprimer !',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            // Afficher un indicateur de chargement
            Swal.fire({
                title: 'Suppression en cours...',
                text: 'Veuillez patienter',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Rediriger vers la route de suppression
            window.location.href = '/admin/supprimer-utilisateur/' + id;
        }
    });
}

function confirmerChangementStatut(id, action) {
    const titre = action === 'activer' ? 'Activer ce compte ?' : 'Désactiver ce compte ?';
    const texte = action === 'activer' 
        ? "L'utilisateur pourra à nouveau se connecter à la plateforme." 
        : "L'utilisateur ne pourra plus se connecter à la plateforme.";
    const boutonTexte = action === 'activer' ? 'Oui, activer' : 'Oui, désactiver';
    const couleurBouton = action === 'activer' ? '#28a745' : '#ffc107';
    
    Swal.fire({
        title: titre,
        text: texte,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: couleurBouton,
        cancelButtonColor: '#6c757d',
        confirmButtonText: boutonTexte,
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            // Afficher un indicateur de chargement
            Swal.fire({
                title: 'Traitement en cours...',
                text: 'Veuillez patienter',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Créer un formulaire dynamique pour soumettre en POST
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/users/' + id + '/toggle-status';
            form.style.display = 'none';
            
            // Ajouter le token CSRF
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            // Ajouter le formulaire au document et le soumettre
            document.body.appendChild(form);
            form.submit();
        }
    });
}

// Fonction pour activer l'onglet approprié en fonction du paramètre tab dans l'URL
function activateTabFromUrl() {
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab');
    
    if (tab) {
        // Activer l'onglet correspondant
        if (tab === 'students') {
            document.querySelector('a[href="#students"]').click();
        } else if (tab === 'teachers') {
            document.querySelector('a[href="#teachers"]').click();
        }
    }
}

// Fonction pour montrer un onglet spécifique (utilisée par les boutons rapides)
function showTab(tabName) {
    document.querySelector(`button[data-bs-target="#${tabName}"]`).click();
}

// Fonction pour filtrer les tableaux côté client
function filterTable(tableId, searchValue, columnIndex) {
    const table = document.getElementById(tableId);
    if (!table) return;
    
    const rows = table.getElementsByTagName('tr');
    
    for (let i = 1; i < rows.length; i++) { // Commencer à 1 pour sauter l'en-tête
        const cell = rows[i].getElementsByTagName('td')[columnIndex];
        if (cell) {
            const text = cell.textContent || cell.innerText;
            if (text.toLowerCase().indexOf(searchValue.toLowerCase()) > -1) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }
}

// Fonction pour filtrer par rôle
function filterByRole(tableId, role) {
    const table = document.getElementById(tableId);
    if (!table) return;
    
    const rows = table.getElementsByTagName('tr');
    
    for (let i = 1; i < rows.length; i++) { // Commencer à 1 pour sauter l'en-tête
        const roleCell = rows[i].getElementsByTagName('td')[2]; // Colonne du rôle
        if (roleCell) {
            const roleText = roleCell.textContent || roleCell.innerText;
            if (role === '' || roleText.toLowerCase() === role.toLowerCase()) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }
}

// Fonction pour filtrer par statut (actif/inactif)
function filterByStatus(tableId, status) {
    const table = document.getElementById(tableId);
    if (!table) return;
    
    const rows = table.getElementsByTagName('tr');
    
    for (let i = 1; i < rows.length; i++) { // Commencer à 1 pour sauter l'en-tête
        // Vérifier s'il y a un badge "Inactif" dans la colonne du nom ou une icône toggle dans la colonne d'action
        const nameCell = rows[i].getElementsByTagName('td')[1]; // Colonne du nom
        const actionCell = rows[i].getElementsByTagName('td')[rows[i].getElementsByTagName('td').length - 1]; // Dernière colonne (actions)
        
        let isInactive = false;
        
        // Vérifier si le badge "Inactif" est présent dans la colonne du nom
        if (nameCell && nameCell.innerHTML.includes('badge-danger')) {
            isInactive = true;
        }
        
        // Vérifier si l'icône toggle indique un statut inactif dans la colonne d'action
        if (actionCell && actionCell.querySelector('.fa-toggle-off')) {
            isInactive = true;
        }
        
        if (status === '' || (status === 'active' && !isInactive) || (status === 'inactive' && isInactive)) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
    }
}

// Attacher les événements aux éléments de l'interface
document.addEventListener('DOMContentLoaded', function() {
    // Activer l'onglet approprié en fonction de l'URL
    activateTabFromUrl();
    
    // Recherche côté client pour tous les utilisateurs
    const searchInput = document.getElementById('search');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchValue = this.value;
            filterTable('usersTable', searchValue, 1); // Filtrer sur la colonne du nom/email
        });
    }
    
    // Recherche côté client pour les étudiants
    const studentSearchInput = document.getElementById('student_search');
    if (studentSearchInput) {
        studentSearchInput.addEventListener('keyup', function() {
            const searchValue = this.value;
            filterTable('studentsTable', searchValue, 1); // Filtrer sur la colonne du nom/email
        });
    }
    
    // Recherche côté client pour les enseignants
    const teacherSearchInput = document.getElementById('teacher_search');
    if (teacherSearchInput) {
        teacherSearchInput.addEventListener('keyup', function() {
            const searchValue = this.value;
            filterTable('teachersTable', searchValue, 1); // Filtrer sur la colonne du nom/email
        });
    }
    
    // Chargement dynamique des groupes en fonction du niveau sélectionné
    const niveauSelect = document.getElementById('niveau_id');
    if (niveauSelect) {
        niveauSelect.addEventListener('change', function() {
            const niveauId = this.value;
            const groupeSelect = document.getElementById('groupe_id');
            
            // Réinitialiser le select des groupes
            groupeSelect.innerHTML = '<option value="">Sélectionnez d\'abord un niveau</option>';
            
            if (niveauId) {
                // Activer le spinner de chargement si nécessaire
                // document.getElementById('groupe-loading').style.display = 'inline-block';
                
                // Faire une requête AJAX pour obtenir les groupes du niveau sélectionné
                fetch(`/admin/api/niveaux/${niveauId}/groupes`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erreur réseau');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Données reçues:', data);
                        if (data.groupes && data.groupes.length > 0) {
                            data.groupes.forEach(groupe => {
                                const option = document.createElement('option');
                                option.value = groupe.id;
                                option.textContent = groupe.nom;
                                groupeSelect.appendChild(option);
                            });
                        } else {
                            const option = document.createElement('option');
                            option.value = '';
                            option.textContent = 'Aucun groupe disponible pour ce niveau';
                            groupeSelect.appendChild(option);
                        }
                        
                        // Désactiver le spinner de chargement si nécessaire
                        // document.getElementById('groupe-loading').style.display = 'none';
                    })
                    .catch(error => {
                        console.error('Erreur lors du chargement des groupes:', error);
                        const option = document.createElement('option');
                        option.value = '';
                        option.textContent = 'Erreur lors du chargement des groupes';
                        groupeSelect.appendChild(option);
                        
                        // Désactiver le spinner de chargement si nécessaire
                        // document.getElementById('groupe-loading').style.display = 'none';
                    });
            }
        });
    }
});
</script>
@endsection
