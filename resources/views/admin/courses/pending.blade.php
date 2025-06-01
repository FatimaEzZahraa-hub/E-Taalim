@extends('layouts.admin')

@section('title', 'Cours en attente de validation')

@section('page_title', 'Cours en attente de validation')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Liste des cours à valider</h6>
            <div class="input-group" style="width: 300px;">
                <input type="text" class="form-control" placeholder="Rechercher un cours..." id="searchInput">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="coursesTable">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Enseignant</th>
                            <th>Date de soumission</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($courses as $course)
                        <tr>
                            <td>{{ $course->titre }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($course->description, 100) }}</td>
                            <td>{{ $course->prenom }} {{ $course->nom }}</td>
                            <td>{{ \Carbon\Carbon::parse($course->date_creation)->format('d/m/Y') }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info mb-2" data-bs-toggle="modal" data-bs-target="#viewCourseModal{{ $course->id }}">
                                    <i class="fas fa-eye"></i> Voir détails
                                </button>
                                
                                <form action="{{ route('admin.courses.approve', $course->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success mb-2">
                                        <i class="fas fa-check"></i> Approuver
                                    </button>
                                </form>
                                
                                <button type="button" class="btn btn-sm btn-danger mb-2" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $course->id }}">
                                    <i class="fas fa-times"></i> Rejeter
                                </button>
                                
                                <!-- Modal pour voir les détails du cours -->
                                <div class="modal fade" id="viewCourseModal{{ $course->id }}" tabindex="-1" aria-labelledby="viewCourseModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewCourseModalLabel">Détails du cours</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mb-3">
                                                    <div class="col-md-4 fw-bold">Titre :</div>
                                                    <div class="col-md-8">{{ $course->titre }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4 fw-bold">Enseignant :</div>
                                                    <div class="col-md-8">{{ $course->prenom }} {{ $course->nom }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4 fw-bold">Date de création :</div>
                                                    <div class="col-md-8">{{ \Carbon\Carbon::parse($course->date_creation)->format('d/m/Y H:i') }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4 fw-bold">Description :</div>
                                                    <div class="col-md-8">{{ $course->description }}</div>
                                                </div>
                                                
                                                <!-- Liste des chapitres/sections (si disponible) -->
                                                @php
                                                    // Données factices pour les chapitres du cours
                                                    $chapters = [
                                                        (object)[
                                                            'id' => 1,
                                                            'titre' => 'Introduction au sujet',
                                                            'cours_id' => $course->id
                                                        ],
                                                        (object)[
                                                            'id' => 2,
                                                            'titre' => 'Concepts fondamentaux',
                                                            'cours_id' => $course->id
                                                        ],
                                                        (object)[
                                                            'id' => 3,
                                                            'titre' => 'Applications pratiques',
                                                            'cours_id' => $course->id
                                                        ]
                                                    ];
                                                @endphp
                                                
                                                @if(isset($chapters) && count($chapters) > 0)
                                                <div class="row mb-3">
                                                    <div class="col-md-12 fw-bold">Chapitres du cours :</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <ul class="list-group">
                                                            @foreach($chapters as $chapter)
                                                                <li class="list-group-item">{{ $chapter->titre }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                <form action="{{ route('admin.courses.approve', $course->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-check"></i> Approuver
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $course->id }}" data-bs-dismiss="modal">
                                                    <i class="fas fa-times"></i> Rejeter
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Modal pour rejeter le cours -->
                                <div class="modal fade" id="rejectModal{{ $course->id }}" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="rejectModalLabel">Rejeter le cours</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('admin.courses.reject', $course->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="reason" class="form-label">Raison du rejet</label>
                                                        <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
                                                        <small class="text-muted">Cette raison sera communiquée à l'enseignant.</small>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <button type="submit" class="btn btn-danger">Confirmer le rejet</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Aucun cours en attente de validation</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Recherche de cours
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#coursesTable tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endsection
