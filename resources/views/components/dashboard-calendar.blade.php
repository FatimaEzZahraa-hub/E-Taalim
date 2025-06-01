@props(['events' => []])

<div class="card shadow-sm h-100">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">Calendrier</h5>
    </div>
    <div class="card-body p-0">
        <div class="text-center py-4">
            <div class="calendar-icon mb-3">
                <i class="bi bi-calendar3 text-primary" style="font-size: 3rem;"></i>
            </div>
            <h5 class="fw-bold">Calendrier</h5>
            <p class="text-muted">Vous avez 3 événements à venir cette semaine</p>
            <a href="{{ route('enseignant.calendrier') }}" class="btn btn-outline-primary">
                Voir le calendrier
            </a>
        </div>
        
        <div class="upcoming-events p-3 border-top">
            <h6 class="fw-bold mb-3">Prochains événements</h6>
            
            @php
                $hasEvents = false;
            @endphp
            
            @foreach($events as $event)
                @if($event->date >= now())
                    @php
                        $hasEvents = true;
                    @endphp
                    <div class="event-item d-flex align-items-center mb-2">
                        <div class="event-date me-3 text-center">
                            <div class="date-day fw-bold">{{ date('d', strtotime($event->date)) }}</div>
                            <div class="date-month small text-muted">{{ date('M', strtotime($event->date)) }}</div>
                        </div>
                        <div class="event-details">
                            <div class="event-title fw-semibold">{{ $event->title }}</div>
                            <div class="event-time small text-muted">
                                <i class="bi bi-clock me-1"></i> {{ date('H:i', strtotime($event->date)) }}
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
            
            @if(!$hasEvents)
                <div class="text-center text-muted py-3">
                    Aucun événement à venir
                </div>
            @endif
        </div>
    </div>
</div>
