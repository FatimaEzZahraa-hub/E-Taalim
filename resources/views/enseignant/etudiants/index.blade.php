@extends('layouts.app')

@section('title', 'Étudiants')

@section('content')
<div class="container-fluid mt-4">
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h1 class="mb-0" style="font-weight: 700; color: #333;">Gestion des Étudiants</h1>
            <p class="text-muted mb-0 mt-1">Consultez et gérez la liste des étudiants</p>
        </div>
        <div class="col-md-6 text-md-end">
            <div class="d-flex justify-content-md-end gap-2">
                <button type="button" class="btn btn-action" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                    <i class="bi bi-person-plus me-2"></i> Ajouter un étudiant
                </button>
                <button type="button" class="btn btn-action-outline" data-bs-toggle="modal" data-bs-target="#importStudentsModal">
                    <i class="bi bi-file-earmark-spreadsheet me-2"></i> Importer une liste
                </button>
            </div>
        </div>
    </div>
    
    <style>
        .btn-action {
            background-color: #8668FF;
            color: white;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            border: none;
            box-shadow: 0 4px 6px rgba(134, 104, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .btn-action:hover {
            background-color: #7559f0;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(134, 104, 255, 0.3);
        }
        
        .btn-action-outline {
            background-color: white;
            color: #8668FF;
            border: 1px solid #8668FF;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-action-outline:hover {
            background-color: rgba(134, 104, 255, 0.1);
            color: #8668FF;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(134, 104, 255, 0.1);
        }
    </style>
    
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-lg overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="students-table">
                            <thead style="background-color: #8668FF; color: white;">
                                <tr>
                                    <th class="px-4 py-3">Code</th>
                                    <th class="px-4 py-3">Filière</th>
                                    <th class="px-4 py-3">Groupe</th>
                                    <th class="px-4 py-3">Nom</th>
                                    <th class="px-4 py-3">Prénom</th>
                                    <th class="px-4 py-3">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($etudiants as $etudiant)
                                <tr class="border-bottom">
                                    <td class="px-4 py-3 font-weight-bold">{{ $etudiant->code }}</td>
                                    <td class="px-4 py-3">
                                        <span class="badge" style="background-color: rgba(134, 104, 255, 0.2); color: #8668FF; font-weight: 500; padding: 6px 12px; border-radius: 30px;">
                                            {{ $etudiant->filiere }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">{{ $etudiant->groupe }}</td>
                                    <td class="px-4 py-3 font-weight-bold">{{ $etudiant->nom }}</td>
                                    <td class="px-4 py-3">{{ $etudiant->prenom }}</td>
                                    <td class="px-4 py-3">
                                        <a href="mailto:{{ $etudiant->email }}" class="text-decoration-none" style="color: #8668FF;">
                                            <i class="bi bi-envelope-fill me-1"></i> {{ $etudiant->email }}
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination-container p-4 d-flex justify-content-between align-items-center">
                        <div class="pagination-info">
                            <p class="text-muted mb-0">
                                Affichage de {{ $etudiants->firstItem() ?? 0 }} à {{ $etudiants->lastItem() ?? 0 }} sur {{ $etudiants->total() }} étudiants
                            </p>
                        </div>
                        <div>
                            {{ $etudiants->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        /* Styles pour la pagination */
        .pagination-container {
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .pagination {
            margin-bottom: 0;
        }
        
        .page-item.active .page-link {
            background-color: #8668FF;
            border-color: #8668FF;
        }
        
        .page-link {
            color: #8668FF;
        }
        
        .page-link:hover {
            color: #7559f0;
        }
        
        .page-link:focus {
            box-shadow: 0 0 0 0.25rem rgba(134, 104, 255, 0.25);
        }
        
        /* Styles pour le tableau */
        #students-table {
            border-collapse: separate;
            border-spacing: 0;
        }
        
        #students-table thead th {
            border-bottom: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        
        #students-table tbody tr:hover {
            background-color: rgba(134, 104, 255, 0.05);
        }
        
        #students-table tbody tr td {
            vertical-align: middle;
            border-top: none;
        }
        
        .card {
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 10px 20px rgba(134, 104, 255, 0.1) !important;
        }
    </style>
</div>

<!-- Modal pour ajouter un étudiant -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header" style="background-color: #8668FF; color: white;">
                <h5 class="modal-title" id="addStudentModalLabel">
                    <i class="bi bi-person-plus me-2"></i> Ajouter un étudiant
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="addStudentForm" action="{{ route('enseignant.etudiants.store') }}" method="POST">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="code" name="code" placeholder="Code" required>
                                <label for="code">Code</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="filiere" name="filiere" required>
                                    <option value="" selected disabled>Sélectionnez une filière</option>
                                    <option value="DD">Développement Digital (DD)</option>
                                    <option value="ID">Infrastructure Digitale (ID)</option>
                                    <option value="GE">Génie Électrique (GE)</option>
                                </select>
                                <label for="filiere">Filière</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="groupe" name="groupe" required>
                                    <option value="" selected disabled>Sélectionnez un groupe</option>
                                    <option value="DD-1A">DD-1A</option>
                                    <option value="DD-2A">DD-2A</option>
                                    <option value="ID-1A">ID-1A</option>
                                    <option value="ID-2A">ID-2A</option>
                                    <option value="ID-3A">ID-3A</option>
                                    <option value="GE-1A">GE-1A</option>
                                    <option value="GE-2A">GE-2A</option>
                                </select>
                                <label for="groupe">Groupe</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" required>
                                <label for="nom">Nom</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom" required>
                                <label for="prenom">Prénom</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                <label for="email">Email</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-action px-4">
                            <i class="bi bi-check-lg me-2"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour importer des étudiants -->
<div class="modal fade" id="importStudentsModal" tabindex="-1" aria-labelledby="importStudentsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header" style="background-color: #8668FF; color: white;">
                <h5 class="modal-title" id="importStudentsModalLabel">
                    <i class="bi bi-file-earmark-spreadsheet me-2"></i> Importer une liste d'étudiants
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="importStudentsForm" action="{{ route('enseignant.etudiants.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <div class="file-upload-wrapper">
                            <div class="file-upload-message text-center p-5 border border-dashed rounded-3 mb-3" style="border-color: #8668FF;">
                                <i class="bi bi-cloud-arrow-up" style="font-size: 3rem; color: #8668FF;"></i>
                                <p class="mt-3 mb-0">Glissez-déposez votre fichier ici ou cliquez pour parcourir</p>
                                <p class="text-muted small">Formats acceptés: .xlsx, .xls, .csv</p>
                            </div>
                            <input type="file" class="form-control d-none" id="file" name="file" accept=".xlsx,.xls,.csv" required>
                        </div>
                    </div>
                    <div class="alert alert-info">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="bi bi-info-circle-fill" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <h6 class="alert-heading mb-1">Format requis</h6>
                                <p class="mb-0 small">Le fichier doit contenir les colonnes suivantes: <strong>Code, Filière, Groupe, Nom, Prénom, Email</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ route('enseignant.etudiants.template') }}" class="btn btn-action-outline">
                            <i class="bi bi-download me-2"></i> Télécharger le modèle
                        </a>
                        <div>
                            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-action">
                                <i class="bi bi-check-lg me-2"></i> Importer
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Configuration du glisser-déposer pour l'importation de fichiers
        const fileUploadMessage = document.querySelector('.file-upload-message');
        const fileInput = document.getElementById('file');
        
        if (fileUploadMessage && fileInput) {
            fileUploadMessage.addEventListener('click', function() {
                fileInput.click();
            });
            
            fileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    const fileName = this.files[0].name;
                    fileUploadMessage.innerHTML = `<i class="bi bi-file-earmark-check" style="font-size: 2rem; color: #8668FF;"></i><p class="mt-3 mb-0">${fileName}</p>`;
                }
            });
            
            // Glisser-déposer
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                fileUploadMessage.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            ['dragenter', 'dragover'].forEach(eventName => {
                fileUploadMessage.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                fileUploadMessage.addEventListener(eventName, unhighlight, false);
            });
            
            function highlight() {
                fileUploadMessage.style.backgroundColor = 'rgba(134, 104, 255, 0.1)';
            }
            
            function unhighlight() {
                fileUploadMessage.style.backgroundColor = '';
            }
            
            fileUploadMessage.addEventListener('drop', handleDrop, false);
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                fileInput.files = files;
                
                if (files.length > 0) {
                    const fileName = files[0].name;
                    fileUploadMessage.innerHTML = `<i class="bi bi-file-earmark-check" style="font-size: 2rem; color: #8668FF;"></i><p class="mt-3 mb-0">${fileName}</p>`;
                }
            }
        }
    });
</script>



@endsection


