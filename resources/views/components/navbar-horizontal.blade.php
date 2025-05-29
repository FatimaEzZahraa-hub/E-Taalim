@props(['activeTab' => 'cours'])

<style>
    .navbar-horizontal {
        background-color: white;
        border-radius: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
        overflow: hidden;
    }
    
    .navbar-horizontal .nav-tabs {
        border: none;
        display: flex;
        width: 100%;
    }
    
    .navbar-horizontal .nav-tabs .nav-item {
        flex: 1;
        text-align: center;
    }
    
    .navbar-horizontal .nav-tabs .nav-link {
        border: none;
        border-radius: 0;
        color: #636e72;
        font-weight: 500;
        padding: 15px;
        transition: all 0.3s ease;
    }
    
    .navbar-horizontal .nav-tabs .nav-link.active {
        background-color: #8668FF;
        color: white;
    }
    
    .navbar-horizontal .nav-tabs .nav-link:hover:not(.active) {
        background-color: #f8f9fa;
        color: #8668FF;
    }
    
    .add-resource-btn {
        background-color: #8668FF;
        color: white;
        border: none;
        border-radius: 30px;
        padding: 10px 20px;
        font-weight: 500;
        margin-bottom: 20px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(134, 104, 255, 0.3);
    }
    
    .add-resource-btn:hover {
        background-color: #6A4EFF;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(134, 104, 255, 0.4);
    }
    
    .add-resource-btn i {
        margin-right: 8px;
    }
    
    .resource-dropdown {
        position: relative;
        display: inline-block;
    }
    
    .resource-dropdown-content {
        display: none;
        position: absolute;
        background-color: white;
        min-width: 200px;
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        border-radius: 10px;
        z-index: 1;
        padding: 10px 0;
        top: 100%;
        left: 0;
        margin-top: 5px;
    }
    
    .resource-dropdown-content a {
        color: #636e72;
        padding: 10px 15px;
        text-decoration: none;
        display: block;
        transition: all 0.2s ease;
    }
    
    .resource-dropdown-content a:hover {
        background-color: #f8f9fa;
        color: #8668FF;
    }
    
    .resource-dropdown:hover .resource-dropdown-content {
        display: block;
    }
</style>

<div class="mb-4">
    <div class="resource-dropdown">
        <button class="add-resource-btn">
            <i class="fas fa-plus"></i> Ajouter une ressource
        </button>
        <div class="resource-dropdown-content">
            <a href="{{ route('enseignant.cours.create') }}">
                <i class="fas fa-book me-2"></i> Cours
            </a>
            <a href="{{ route('enseignant.travaux.create') }}">
                <i class="fas fa-tasks me-2"></i> Travail/Devoir
            </a>
            <a href="#" data-bs-toggle="modal" data-bs-target="#selectCoursModal">
                <i class="fas fa-clipboard-check me-2"></i> Examen
            </a>
        </div>
    </div>
</div>

<!-- Modal pour sélectionner un cours pour créer un examen -->
<div class="modal fade" id="selectCoursModal" tabindex="-1" aria-labelledby="selectCoursModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectCoursModalLabel">Sélectionner un cours</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Veuillez sélectionner un cours pour créer un examen :</p>
                <div class="list-group">
                    @foreach(\App\Http\Controllers\EnseignantController::getCoursForCurrentUser() as $cours)
                        <a href="{{ route('enseignant.examens.create', ['coursId' => $cours->id]) }}" class="list-group-item list-group-item-action">
                            {{ $cours->titre }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<div class="navbar-horizontal">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'cours' ? 'active' : '' }}" href="{{ route('enseignant.cours') }}">
                Cours
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'travaux' ? 'active' : '' }}" href="{{ route('enseignant.travaux') }}">
                Travaux Et Devoirs
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'examens' ? 'active' : '' }}" href="{{ route('enseignant.examens') }}">
                Examens
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'soumissions' ? 'active' : '' }}" href="{{ route('enseignant.soumissions') }}">
                Soumissions
            </a>
        </li>
    </ul>
</div>
