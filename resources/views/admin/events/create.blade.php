@extends('layouts.admin')

@section('title', 'Créer un événement')

@section('content')
<div class="container-fluid" style="max-width: 95%; width: 95%; padding: 0 20px;">
    <style>
        /* Styles pour optimiser la visibilitu00e9 du formulaire */
        .container-fluid {
            padding-left: 20px !important;
            padding-right: 20px !important;
            max-width: 95% !important;
            margin-left: auto !important;
            margin-right: auto !important;
            width: 95% !important;
        }
        
        .card {
            border-radius: 8px !important;
            margin-left: auto !important;
            margin-right: auto !important;
            width: 100% !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        }
        
        .card-body {
            padding: 2rem !important;
        }
        
        .form-group {
            margin-bottom: 1.5rem !important;
        }
        
        .form-control, .form-select {
            padding: 0.75rem !important;
            font-size: 1rem !important;
        }
        
        .form-label {
            margin-bottom: 0.5rem !important;
            font-size: 1.05rem !important;
        }
    </style>
    <h1 class="mt-4">Créer un événement</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Tableau de bord</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Événements</a></li>
        <li class="breadcrumb-item active">Créer un événement</li>
    </ol>
    
    <div class="card mb-4" style="width: 100%; max-width: 100%; margin: 2rem 0;">
        <div class="card-header" style="padding: 1.2rem 2rem; background-color: #f8f9fa; border-bottom: 1px solid #e3e6f0;">
            <i class="fas fa-calendar-plus me-2"></i>
            <span style="font-size: 1.2rem; font-weight: 600;">Nouvel événement</span>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('admin.events.store') }}" method="POST">
                @csrf
                <div class="row mb-4" style="margin: 0 0 1.5rem 0; width: 100%;">
                    <div class="col-md-6" style="padding: 0 2rem 0 0;">
                        <div class="form-group mb-4">
                            <label for="titre" class="form-label fw-bold">Titre de l'événement</label>
                            <input type="text" class="form-control form-control-lg" id="titre" name="titre" required value="{{ old('titre') }}" style="width: 100%; border: 1px solid #ced4da; border-radius: 6px;">
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" style="width: 100%; border: 1px solid #ced4da; border-radius: 6px; padding: 12px;">{{ old('description') }}</textarea>
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="location" class="form-label fw-bold">Lieu</label>
                            <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}" style="width: 100%; border: 1px solid #ced4da; border-radius: 6px;">
                        </div>
                    </div>
                    
                    <div class="col-md-6" style="padding: 0 0 0 2rem;">
                        <div class="form-group mb-4">
                            <label for="date_debut" class="form-label fw-bold">Date et heure de début</label>
                            <input type="datetime-local" class="form-control" id="date_debut" name="date_debut" required value="{{ old('date_debut') }}" style="width: 100%; border: 1px solid #ced4da; border-radius: 6px;">
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="date_fin" class="form-label fw-bold">Date et heure de fin</label>
                            <input type="datetime-local" class="form-control" id="date_fin" name="date_fin" required value="{{ old('date_fin') }}" style="width: 100%; border: 1px solid #ced4da; border-radius: 6px;">
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="type" class="form-label fw-bold">Type d'événement</label>
                            <select class="form-select" id="type" name="type" style="width: 100%; border: 1px solid #ced4da; border-radius: 6px; height: calc(1.5em + 1.5rem);">
                                <option value="public" {{ old('type') == 'public' ? 'selected' : '' }}>Public</option>
                                <option value="private" {{ old('type') == 'private' ? 'selected' : '' }}>Privé</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="form-group mb-4" style="width: 100%; margin-top: 1rem;">
                    <label for="participants" class="form-label fw-bold">Inviter des participants</label>
                    <select class="form-select" id="participants" name="participants[]" multiple style="width: 100%; min-height: 150px; border: 1px solid #ced4da; border-radius: 6px; padding: 0.5rem;">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->nom }} {{ $user->prenom }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted" style="display: block; margin-top: 0.5rem;">Maintenez la touche Ctrl (ou Cmd sur Mac) pour sélectionner plusieurs participants.</small>
                </div>
                
                <div class="form-group mb-4" style="width: 100%; background-color: #f8f9fa; padding: 1rem; border-radius: 6px; margin-top: 1rem;">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="send_notification" name="send_notification" checked style="margin-right: 10px; transform: scale(1.2);">
                        <label class="form-check-label fw-bold" for="send_notification">
                            Envoyer une notification aux participants
                        </label>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between" style="width: 100%; margin-top: 2.5rem; padding: 0 1rem;">
                    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary btn-lg" style="padding: 0.75rem 2.5rem; border-radius: 6px; font-weight: 500;">Annuler</a>
                    <button type="submit" class="btn btn-primary btn-lg" style="padding: 0.75rem 2.5rem; border-radius: 6px; font-weight: 500; background-color: #4361ee;">Créer l'événement</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Définir la date et l'heure actuelles comme valeurs par défaut
        const now = new Date();
        const dateDebut = document.getElementById('date_debut');
        const dateFin = document.getElementById('date_fin');
        
        if (!dateDebut.value) {
            // Ajouter 1 heure à l'heure actuelle pour la date de début
            const startDate = new Date(now.getTime() + 60 * 60 * 1000);
            dateDebut.value = formatDateTime(startDate);
        }
        
        if (!dateFin.value) {
            // Ajouter 2 heures à l'heure actuelle pour la date de fin
            const endDate = new Date(now.getTime() + 2 * 60 * 60 * 1000);
            dateFin.value = formatDateTime(endDate);
        }
        
        // Formater la date et l'heure pour l'input datetime-local
        function formatDateTime(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            
            return `${year}-${month}-${day}T${hours}:${minutes}`;
        }
        
        // Validation pour s'assurer que la date de fin est après la date de début
        dateDebut.addEventListener('change', function() {
            const startValue = new Date(this.value);
            const endValue = new Date(dateFin.value);
            
            if (startValue >= endValue) {
                // Si la date de début est après ou égale à la date de fin,
                // définir la date de fin à 1 heure après la date de début
                const newEndDate = new Date(startValue.getTime() + 60 * 60 * 1000);
                dateFin.value = formatDateTime(newEndDate);
            }
        });
    });
</script>
@endsection
