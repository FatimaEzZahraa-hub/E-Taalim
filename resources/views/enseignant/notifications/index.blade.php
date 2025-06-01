@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4><p class="text-muted mb-0">Gérez vos notifications</p></h4>
        </div>
        <div>
            <button class="btn btn-sm btn-outline-secondary me-2">
                <i class="bi bi-check2-all"></i> Marquer tout comme lu
            </button>
            <div class="dropdown d-inline-block">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-funnel"></i> Filtrer
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                    <li><a class="dropdown-item {{ $filter == 'all' ? 'active' : '' }}" href="{{ route('enseignant.notifications', ['filter' => 'all']) }}">Toutes les notifications</a></li>
                    <li><a class="dropdown-item {{ $filter == 'unread' ? 'active' : '' }}" href="{{ route('enseignant.notifications', ['filter' => 'unread']) }}">Non lues</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item {{ $filter == 'soumission' ? 'active' : '' }}" href="{{ route('enseignant.notifications', ['filter' => 'soumission']) }}">Soumissions</a></li>
                    <li><a class="dropdown-item {{ $filter == 'evenement' ? 'active' : '' }}" href="{{ route('enseignant.notifications', ['filter' => 'evenement']) }}">Événements</a></li>
                    <li><a class="dropdown-item {{ $filter == 'message' ? 'active' : '' }}" href="{{ route('enseignant.notifications', ['filter' => 'message']) }}">Messages</a></li>
                    <li><a class="dropdown-item {{ $filter == 'administratif' ? 'active' : '' }}" href="{{ route('enseignant.notifications', ['filter' => 'administratif']) }}">Administratif</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                @forelse($notifications as $notification)
                    <div class="list-group-item list-group-item-action p-3 {{ $notification->lu ? '' : 'unread' }}">
                        <div class="d-flex align-items-center">
                            <div class="notification-icon me-3 bg-{{ $notification->couleur }} text-white rounded-circle p-2">
                                <i class="bi {{ $notification->icone }}"></i>
                            </div>
                            <div class="notification-content flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="mb-0 fw-bold">{{ $notification->titre }}</h6>
                                    @if(!$notification->lu)
                                        <span class="badge bg-primary rounded-pill">Nouveau</span>
                                    @endif
                                </div>
                                <p class="mb-1">{!! $notification->contenu !!}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        @if($notification->date->isToday())
                                            @if($notification->date->diffInHours(now()) < 1)
                                                Il y a {{ $notification->date->diffInMinutes(now()) }} minutes
                                            @else
                                                Il y a {{ $notification->date->diffInHours(now()) }} heures
                                            @endif
                                        @elseif($notification->date->isYesterday())
                                            Hier, {{ $notification->date->format('H:i') }}
                                        @else
                                            Il y a {{ $notification->date->diffInDays(now()) }} jours
                                        @endif
                                    </small>
                                    <div>
                                        @if($notification->type == 'soumission')
                                            <a href="#" class="btn btn-sm btn-outline-primary">Voir</a>
                                        @elseif($notification->type == 'evenement')
                                            <a href="#" class="btn btn-sm btn-outline-primary">Voir détails</a>
                                            @if(!$notification->lu)
                                                <button class="btn btn-sm btn-outline-success ms-1">Confirmer présence</button>
                                            @endif
                                        @elseif($notification->type == 'message')
                                            <a href="#" class="btn btn-sm btn-outline-primary">Lire</a>
                                        @elseif($notification->type == 'administratif')
                                            <button class="btn btn-sm btn-outline-secondary">Marquer comme fait</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="bi bi-bell-slash text-muted" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="text-muted">Aucune notification</h5>
                        <p class="text-muted">Vous n'avez aucune notification pour le moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @if($pagination['last_page'] > 1)
        <nav aria-label="Pagination des notifications">
            <ul class="pagination justify-content-center">
                <li class="page-item {{ $pagination['current_page'] <= 1 ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $pagination['current_page'] > 1 ? route('enseignant.notifications', ['page' => $pagination['current_page'] - 1, 'filter' => $filter]) : '#' }}" tabindex="{{ $pagination['current_page'] <= 1 ? '-1' : '0' }}" aria-disabled="{{ $pagination['current_page'] <= 1 ? 'true' : 'false' }}">Précédent</a>
                </li>
                
                @for($i = 1; $i <= $pagination['last_page']; $i++)
                    <li class="page-item {{ $pagination['current_page'] == $i ? 'active' : '' }}" aria-current="{{ $pagination['current_page'] == $i ? 'page' : '' }}">
                        <a class="page-link" href="{{ route('enseignant.notifications', ['page' => $i, 'filter' => $filter]) }}">{{ $i }}</a>
                    </li>
                @endfor
                
                <li class="page-item {{ $pagination['current_page'] >= $pagination['last_page'] ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $pagination['current_page'] < $pagination['last_page'] ? route('enseignant.notifications', ['page' => $pagination['current_page'] + 1, 'filter' => $filter]) : '#' }}" tabindex="{{ $pagination['current_page'] >= $pagination['last_page'] ? '-1' : '0' }}" aria-disabled="{{ $pagination['current_page'] >= $pagination['last_page'] ? 'true' : 'false' }}">Suivant</a>
                </li>
            </ul>
        </nav>
    @endif
</div>

<style>
    .notification-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .unread {
        background-color: rgba(134, 104, 255, 0.05);
        border-left: 3px solid #8668FF;
    }
    
    .list-group-item {
        transition: all 0.3s ease;
    }
    
    .list-group-item:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
    
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
    }
    
    .pagination .page-link {
        color: #8668FF;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #8668FF;
        border-color: #8668FF;
        color: white; /* Assure que le texte est blanc et visible */
        font-weight: bold; /* Rend le texte plus visible */
    }
    
    /* Style pour les éléments de pagination au survol */
    .pagination .page-item:not(.active):not(.disabled):hover .page-link {
        background-color: #f0f0f0;
        color: #8668FF;
    }
</style>
@endsection
