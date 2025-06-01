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
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchAllUsers" placeholder="Rechercher un utilisateur...">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end">
                                <select class="form-select w-auto me-2" id="filterUserRole">
                                    <option value="">Tous les rôles</option>
                                    <option value="administrateur">Administrateurs</option>
                                    <option value="enseignant">Enseignants</option>
                                    <option value="etudiant">Étudiants</option>
                                </select>
                                <select class="form-select w-auto" id="filterUserStatus">
                                    <option value="">Tous les statuts</option>
                                    <option value="actif">Actifs</option>
                                    <option value="inactif">Inactifs</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Rôle</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->role == 'administrateur')
                                            <span class="badge bg-danger">Administrateur</span>
                                        @elseif($user->role == 'enseignant')
                                            <span class="badge bg-info">Enseignant</span>
                                        @elseif($user->role == 'etudiant')
                                            <span class="badge bg-success">Étudiant</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->statut == 'actif')
                                            <span class="badge bg-success">Actif</span>
                                        @else
                                            <span class="badge bg-danger">Inactif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.users.view', $user->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($user->role != 'administrateur')
                                            @if($user->statut == 'actif')
                                                <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-user-slash"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fas fa-user-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
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
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchStudents" placeholder="Rechercher un étudiant...">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end">
                                <select class="form-select w-auto me-2" id="filterStudentNiveau">
                                    <option value="">Tous les niveaux</option>
                                    <option value="Licence 1">Licence 1</option>
                                    <option value="Licence 2">Licence 2</option>
                                    <option value="Licence 3">Licence 3</option>
                                    <option value="Master 1">Master 1</option>
                                    <option value="Master 2">Master 2</option>
                                    <option value="Doctorat">Doctorat</option>
                                </select>
                                <select class="form-select w-auto" id="filterStudentStatus">
                                    <option value="">Tous les statuts</option>
                                    <option value="actif">Actifs</option>
                                    <option value="inactif">Inactifs</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="studentsTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Email</th>
                                    <th>Niveau</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                <tr>
                                    <td>{{ $student->id }}</td>
                                    <td>{{ $student->nom }}</td>
                                    <td>{{ $student->prenom }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->niveau }}</td>
                                    <td>
                                        @if($student->statut == 'actif')
                                            <span class="badge bg-success">Actif</span>
                                        @else
                                            <span class="badge bg-danger">Inactif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.students.view', $student->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($student->statut == 'actif')
                                            <form action="{{ route('admin.students.toggle-status', $student->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-user-slash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.students.toggle-status', $student->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fas fa-user-check"></i>
                                                </button>
                                            </form>
                                        @endif
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
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchTeachers" placeholder="Rechercher un enseignant...">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end">
                                <select class="form-select w-auto me-2" id="filterTeacherSpecialite">
                                    <option value="">Toutes les spécialités</option>
                                    <option value="Informatique">Informatique</option>
                                    <option value="Mathématiques">Mathématiques</option>
                                    <option value="Physique">Physique</option>
                                    <option value="Chimie">Chimie</option>
                                    <option value="Biologie">Biologie</option>
                                </select>
                                <select class="form-select w-auto" id="filterTeacherStatus">
                                    <option value="">Tous les statuts</option>
                                    <option value="actif">Actifs</option>
                                    <option value="inactif">Inactifs</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="teachersTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Email</th>
                                    <th>Spécialité</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teachers as $teacher)
                                <tr>
                                    <td>{{ $teacher->id }}</td>
                                    <td>{{ $teacher->nom }}</td>
                                    <td>{{ $teacher->prenom }}</td>
                                    <td>{{ $teacher->email }}</td>
                                    <td>{{ $teacher->specialite }}</td>
                                    <td>
                                        @if($teacher->statut == 'actif')
                                            <span class="badge bg-success">Actif</span>
                                        @else
                                            <span class="badge bg-danger">Inactif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.teachers.view', $teacher->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($teacher->statut == 'actif')
                                            <form action="{{ route('admin.teachers.toggle-status', $teacher->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-user-slash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.teachers.toggle-status', $teacher->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fas fa-user-check"></i>
                                                </button>
                                            </form>
                                        @endif
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
                <form action="{{ route('admin.students.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="nom" name="nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="tel" class="form-control" id="telephone" name="telephone">
                        </div>
                        <div class="mb-3">
                            <label for="date_naissance" class="form-label">Date de naissance</label>
                            <input type="date" class="form-control" id="date_naissance" name="date_naissance">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
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
                <form action="{{ route('admin.teachers.store') }}" method="POST">
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
@endsection

@section('scripts')
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

document.addEventListener('DOMContentLoaded', function() {
    // Fonction générique de recherche
    function setupSearch(inputId, tableId, columns) {
        const input = document.getElementById(inputId);
        if (!input) return;
        
        input.addEventListener('keyup', function() {
            const value = this.value.toLowerCase();
            const rows = document.querySelectorAll(tableId + ' tbody tr');
            
            rows.forEach(function(row) {
                let found = false;
                
                // Vérifier chaque colonne spécifiée
                columns.forEach(function(colIndex) {
                    const cell = row.querySelectorAll('td')[colIndex];
                    if (cell && cell.textContent.toLowerCase().indexOf(value) > -1) {
                        found = true;
                    }
                });
                
                row.style.display = found ? '' : 'none';
            });
        });
    }

    // Fonction générique de filtrage
    function setupFilter(selectId, tableId, colIndex) {
        const select = document.getElementById(selectId);
        if (!select) return;
        
        select.addEventListener('change', function() {
            const value = this.value.toLowerCase();
            const rows = document.querySelectorAll(tableId + ' tbody tr');
            
            rows.forEach(function(row) {
                const cell = row.querySelectorAll('td')[colIndex];
                if (cell) {
                    const text = cell.textContent.toLowerCase();
                    row.style.display = (value === '' || text.indexOf(value) > -1) ? '' : 'none';
                }
            });
        });
    }

    // ========= Tableau des utilisateurs =========
    // Recherche dans tous les utilisateurs
    setupSearch('searchAllUsers', '#dataTable', [1, 2]); // Email et rôle

    // Filtrage par rôle pour tous les utilisateurs
    setupFilter('filterUserRole', '#dataTable', 2);

    // Filtrage par statut pour tous les utilisateurs
    setupFilter('filterUserStatus', '#dataTable', 3);

    // ========= Tableau des étudiants =========
    // Recherche dans les étudiants
    setupSearch('searchStudents', '#studentsTable', [1, 2, 3]); // Nom, prénom, email

    // Filtrage par niveau pour les étudiants
    setupFilter('filterStudentNiveau', '#studentsTable', 4);

    // Filtrage par statut pour les étudiants
    setupFilter('filterStudentStatus', '#studentsTable', 5);

    // ========= Tableau des enseignants =========
    // Recherche dans les enseignants
    setupSearch('searchTeachers', '#teachersTable', [1, 2, 3]); // Nom, prénom, email

    // Filtrage par spécialité pour les enseignants
    setupFilter('filterTeacherSpecialite', '#teachersTable', 4);

    // Filtrage par statut pour les enseignants
    setupFilter('filterTeacherStatus', '#teachersTable', 5);
});
</script>
@endsection
