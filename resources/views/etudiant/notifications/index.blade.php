@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Mes notifications</h1>
        <div class="d-flex gap-2">
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-funnel me-1"></i> Filtrer
                </button>
                <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                    <li><a class="dropdown-item {{ !request('type') ? 'active' : '' }}" href="{{ route('etudiant.notifications') }}">Toutes les notifications</a></li>
                    <li><a class="dropdown-item {{ request('type') == 'devoir' ? 'active' : '' }}" href="{{ route('etudiant.notifications', ['type' => 'devoir']) }}">Devoirs</a></li>
                    <li><a class="dropdown-item {{ request('type') == 'examen' ? 'active' : '' }}" href="{{ route('etudiant.notifications', ['type' => 'examen']) }}">Examens</a></li>
                    <li><a class="dropdown-item {{ request('type') == 'message' ? 'active' : '' }}" href="{{ route('etudiant.notifications', ['type' => 'message']) }}">Messages</a></li>
                    <li><a class="dropdown-item {{ request('type') == 'evenement' ? 'active' : '' }}" href="{{ route('etudiant.notifications', ['type' => 'evenement']) }}">u00c9vu00e9nements</a></li>
                    <li><a class="dropdown-item {{ request('type') == 'note' ? 'active' : '' }}" href="{{ route('etudiant.notifications', ['type' => 'note']) }}">Notes</a></li>
                    <li><a class="dropdown-item {{ request('type') == 'administratif' ? 'active' : '' }}" href="{{ route('etudiant.notifications', ['type' => 'administratif']) }}">Administratif</a></li>
                </ul>
            </div>
            <div class="form-check form-switch d-flex align-items-center ms-3">
                <input class="form-check-input me-2" type="checkbox" id="unreadOnly" {{ request('unread') ? 'checked' : '' }}>
                <label class="form-check-label" for="unreadOnly">Non lues uniquement</label>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                @forelse($notifications as $notification)
                    <div class="list-group-item p-4 {{ !$notification->lu ? 'border-start border-3' : '' }}" style="{{ !$notification->lu ? 'border-color: #8668FF;' : '' }}">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 48px; height: 48px; background-color: {{ 
                                    $notification->type == 'devoir' ? '#FFC107' : 
                                    ($notification->type == 'examen' ? '#DC3545' : 
                                    ($notification->type == 'message' ? '#198754' : 
                                    ($notification->type == 'evenement' ? '#0D6EFD' : 
                                    ($notification->type == 'note' ? '#6C757D' : 
                                    ($notification->type == 'administratif' ? '#6610F2' : '#8668FF'))))) }}">
                                    <i class="bi {{ 
                                        $notification->type == 'devoir' ? 'bi-clipboard-check' : 
                                        ($notification->type == 'examen' ? 'bi-pencil-square' : 
                                        ($notification->type == 'message' ? 'bi-envelope' : 
                                        ($notification->type == 'evenement' ? 'bi-calendar-event' : 
                                        ($notification->type == 'note' ? 'bi-award' : 
                                        ($notification->type == 'administratif' ? 'bi-exclamation-circle' : 'bi-bell'))))) }} fs-5"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h5 class="mb-1">{{ $notification->titre }}</h5>
                                    <div>
                                        <small class="text-muted me-2">{{ $notification->date->diffForHumans() }}</small>
                                        @if(!$notification->lu)
                                            <span class="badge" style="background-color: #8668FF;">Nouveau</span>
                                        @endif
                                    </div>
                                </div>
                                <p class="mb-2">{{ $notification->contenu }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="badge {{ 
                                            $notification->type == 'devoir' ? 'bg-warning text-dark' : 
                                            ($notification->type == 'examen' ? 'bg-danger' : 
                                            ($notification->type == 'message' ? 'bg-success' : 
                                            ($notification->type == 'evenement' ? 'bg-primary' : 
                                            ($notification->type == 'note' ? 'bg-secondary' : 
                                            ($notification->type == 'administratif' ? 'bg-purple' : 'bg-info'))))) }}">
                                            {{ 
                                                $notification->type == 'devoir' ? 'Devoir' : 
                                                ($notification->type == 'examen' ? 'Examen' : 
                                                ($notification->type == 'message' ? 'Message' : 
                                                ($notification->type == 'evenement' ? 'u00c9vu00e9nement' : 
                                                ($notification->type == 'note' ? 'Note' : 
                                                ($notification->type == 'administratif' ? 'Administratif' : 'Info'))))) 
                                            }}
                                        </span>
                                    </div>
                                    @if($notification->lien)
                                        <a href="{{ $notification->lien }}" class="btn btn-sm btn-primary" style="background-color: #8668FF; border-color: #8668FF;">
                                            <i class="bi bi-arrow-right me-1"></i> Voir les du00e9tails
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="bi bi-bell-slash fs-1 text-muted"></i>
                        <p class="mt-2 text-muted">Aucune notification</p>
                    </div>
                @endforelse
            </div>
        </div>
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-0 text-muted small">Affichage de {{ $notifications->firstItem() ?? 0 }} u00e0 {{ $notifications->lastItem() ?? 0 }} sur {{ $notifications->total() }} notification(s)</p>
                </div>
                <div>
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const unreadCheckbox = document.getElementById('unreadOnly');
        unreadCheckbox.addEventListener('change', function() {
            const url = new URL(window.location);
            if (this.checked) {
                url.searchParams.set('unread', '1');
            } else {
                url.searchParams.delete('unread');
            }
            window.location = url;
        });
    });
</script>
@endpush
@endsection
