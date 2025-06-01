@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tableau de bord étudiant</h1>
    <p>Bienvenue, {{ $etudiant->prenom }} {{ $etudiant->nom }}!</p>
    <p>Code étudiant: {{ $etudiant->code }}</p>
    <p>Classe: {{ $etudiant->classe }}</p>
    <p>Filière: {{ $etudiant->filiere }}</p>
    <p>Niveau: {{ $etudiant->niveau }}</p>
    <p>Email: {{ $etudiant->email }}</p>
    <p>Téléphone: {{ $etudiant->telephone }}</p>
    <p>Adresse: {{ $etudiant->adresse }}</p>
    <p>Date de naissance: {{ $etudiant->date_naissance }}</p>
    <p>Photo: <img src="{{ asset('storage/' . $etudiant->photo) }}" alt="Photo de profil" width="100"></p>
    <h2>Statistiques</h2>
    <p>Nombre de cours: {{ $stats['cours'] }}</p>
    <p>Devoirs en attente: {{ $stats['devoirs_en_attente'] }}</p>
    <p>Examens à venir: {{ $stats['examens_a_venir'] }}</p>
    <p>Messages non lus: {{ $stats['messages_non_lus'] }}</p>
    <h2>Événements à venir</h2>
    <ul>
        @foreach($evenements as $evenement)
            <li>{{ $evenement->titre }} - {{ $evenement->date }} {{ $evenement->heure }} ({{ $evenement->type }})</li>
        @endforeach
    </ul>
    <h2>Devoirs récents</h2>
    <ul>
        @foreach($devoirs as $devoir)
            <li>{{ $devoir->titre }} - {{ $devoir->cours }} - Date limite: {{ $devoir->date_limite->format('d/m/Y') }} - Statut: {{ $devoir->statut }}</li>
        @endforeach
    </ul>
</div>
@endsection 