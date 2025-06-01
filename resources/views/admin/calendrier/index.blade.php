@extends('layouts.admin')

@section('title', 'Calendrier')

@section('styles')
<style>
    .calendar-container {
        background-color: #f8f9fa;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        width: 100%;
        overflow-x: auto;
    }
    
    .calendar-header {
        text-align: center;
        margin-bottom: 20px;
    }
    
    .calendar-header h2 {
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
    }
    
    .calendar-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 5px;
        table-layout: fixed;
    }
    
    .calendar-table th {
        text-align: center;
        padding: 10px;
        font-weight: 600;
        color: #8668FF;
    }
    
    .calendar-table td {
        text-align: center;
        padding: 15px;
        border-radius: 10px;
        transition: all 0.3s ease;
        position: relative;
        height: 60px;
        width: auto;
    }
    
    .calendar-table td:hover {
        background-color: #f0f0f0;
        cursor: pointer;
    }
    
    .calendar-table td.today {
        background-color: #8668FF;
        color: white;
        font-weight: 600;
    }
    
    .calendar-table td.has-event {
        position: relative;
    }
    
    .calendar-table td.has-event::after {
        content: '';
        position: absolute;
        bottom: 5px;
        left: 50%;
        transform: translateX(-50%);
        width: 6px;
        height: 6px;
        background-color: #8668FF;
        border-radius: 50%;
    }
    
    .calendar-table td.other-month {
        color: #aaa;
    }
    
    .calendar-table td.selected {
        background-color: #8668FF;
        color: white;
    }
    
    .event-details {
        background-color: white;
        border-radius: 15px;
        padding: 20px;
        margin-top: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    
    .event-details h3 {
        color: #8668FF;
        font-weight: 600;
        margin-bottom: 15px;
    }
    
    .event-item {
        border: 1px solid #eee;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }
    
    .event-item:hover {
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    
    .event-title {
        font-weight: 600;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
    }
    
    .event-title i {
        margin-right: 10px;
        color: #8668FF;
    }
    
    .event-time {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 10px;
    }
    
    .event-description {
        color: #555;
    }
    
    .calendar-nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .calendar-nav button.nav-btn {
        background: none;
        border: none;
        font-size: 1.2rem;
        color: #8668FF;
        cursor: pointer;
        padding: 5px 10px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }
    
    .calendar-nav button.nav-btn:hover {
        background-color: rgba(134, 104, 255, 0.1);
        transform: scale(1.1);
    }
    
    .calendar-nav button.year-btn {
        background-color: #fff;
        border: 1px solid #8668FF;
        color: #8668FF;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .calendar-nav button.year-btn:hover {
        background-color: #8668FF;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(134, 104, 255, 0.2);
    }
    
    .add-event-btn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: #8668FF;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 4px 15px rgba(134, 104, 255, 0.3);
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    
    .add-event-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(134, 104, 255, 0.4);
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Calendrier</h5>
                </div>
                <div class="card-body p-0 p-md-3">
                    <div class="calendar-container">
                        <div class="calendar-nav">
                            <div class="d-flex justify-content-between align-items-center w-100">
                                <div>
                                    <button id="prevYear" class="nav-btn">&lt;&lt;</button>
                                    <button id="prevMonth" class="nav-btn">&lt;</button>
                                </div>
                                <div class="text-center">
                                    <h2 id="currentMonth" class="mb-0"></h2>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <span>Année: </span>
                                        <span id="selectedYear" class="ms-2"></span>
                                    </div>
                                </div>
                                <div>
                                    <button id="nextMonth" class="nav-btn">&gt;</button>
                                    <button id="nextYear" class="nav-btn">&gt;&gt;</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <table class="calendar-table">
                                    <thead>
                                        <tr>
                                            <th>Dim</th>
                                            <th>Lun</th>
                                            <th>Mar</th>
                                            <th>Mer</th>
                                            <th>Jeu</th>
                                            <th>Ven</th>
                                            <th>Sam</th>
                                        </tr>
                                    </thead>
                                    <tbody id="calendarBody">
                                        <!-- Le calendrier sera généré dynamiquement par JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <div class="event-details">
                                    <h3 id="selectedDate"></h3>
                                    <div id="eventsList">
                                        <!-- Les événements seront ajoutés dynamiquement par JavaScript -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<button class="add-event-btn" data-bs-toggle="modal" data-bs-target="#addEventModal">
    <i class="fas fa-plus"></i>
</button>

<!-- Modal pour ajouter un événement -->
<div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEventModalLabel">Ajouter un événement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addEventForm">
                    <div class="mb-3">
                        <label for="eventTitle" class="form-label">Titre</label>
                        <input type="text" class="form-control" id="eventTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="eventDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="eventDate" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="eventStartTime" class="form-label">Heure de début</label>
                            <input type="time" class="form-control" id="eventStartTime" required>
                        </div>
                        <div class="col">
                            <label for="eventEndTime" class="form-label">Heure de fin</label>
                            <input type="time" class="form-control" id="eventEndTime">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="eventDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="eventDescription" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="eventType" class="form-label">Type d'événement</label>
                        <select class="form-select" id="eventType">
                            <option value="cours">Cours</option>
                            <option value="examen">Examen</option>
                            <option value="atelier">Atelier</option>
                            <option value="conference">Conférence</option>
                            <option value="reunion">Réunion</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="saveEvent">Enregistrer</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Données fictives pour les événements
        const events = [
            @foreach($events as $event)
            {
                id: {{ $event->id }},
                title: "{{ $event->title }}",
                start: new Date("{{ $event->date }} {{ $event->time }}"),
                description: "{{ $event->description }}"
            },
            @endforeach
        ];
        
        const today = new Date();
        let currentDate = new Date(today.getFullYear(), today.getMonth(), 1); // Mois actuel
        let selectedDate = new Date(today.getFullYear(), today.getMonth(), today.getDate()); // Aujourd'hui
        
        // Constantes pour les limites d'années
        const MIN_YEAR = 2010;
        const MAX_YEAR = 2050;
        
        // Fonction pour générer le calendrier
        function generateCalendar(date) {
            const year = date.getFullYear();
            const month = date.getMonth();
            
            // Mettre à jour le titre du mois
            const monthNames = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];
            document.getElementById('currentMonth').textContent = `${monthNames[month]} ${year}`;
            
            // Obtenir le premier jour du mois
            const firstDay = new Date(year, month, 1);
            const startingDay = firstDay.getDay(); // 0 = Dimanche, 1 = Lundi, etc.
            
            // Obtenir le nombre de jours dans le mois
            const lastDay = new Date(year, month + 1, 0);
            const monthLength = lastDay.getDate();
            
            // Obtenir le dernier jour du mois précédent
            const prevMonthLastDay = new Date(year, month, 0).getDate();
            
            // Générer le corps du calendrier
            const calendarBody = document.getElementById('calendarBody');
            calendarBody.innerHTML = '';
            
            let date = 1;
            let nextMonthDate = 1;
            
            // Créer les lignes du calendrier
            for (let i = 0; i < 6; i++) {
                const row = document.createElement('tr');
                
                // Créer les cellules pour chaque jour de la semaine
                for (let j = 0; j < 7; j++) {
                    const cell = document.createElement('td');
                    
                    if (i === 0 && j < startingDay) {
                        // Jours du mois précédent
                        const prevMonthDay = prevMonthLastDay - startingDay + j + 1;
                        cell.textContent = prevMonthDay;
                        cell.classList.add('other-month');
                        cell.dataset.date = new Date(year, month - 1, prevMonthDay).toISOString().split('T')[0];
                    } else if (date > monthLength) {
                        // Jours du mois suivant
                        cell.textContent = nextMonthDate;
                        cell.classList.add('other-month');
                        cell.dataset.date = new Date(year, month + 1, nextMonthDate).toISOString().split('T')[0];
                        nextMonthDate++;
                    } else {
                        // Jours du mois actuel
                        cell.textContent = date;
                        cell.dataset.date = new Date(year, month, date).toISOString().split('T')[0];
                        
                        // Vérifier si c'est aujourd'hui
                        if (date === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                            cell.classList.add('today');
                        }
                        
                        // Vérifier si c'est la date sélectionnée
                        if (date === selectedDate.getDate() && month === selectedDate.getMonth() && year === selectedDate.getFullYear()) {
                            cell.classList.add('selected');
                        }
                        
                        // Vérifier s'il y a des événements pour cette date
                        const hasEvents = events.some(event => {
                            const eventDate = new Date(event.start);
                            return eventDate.getDate() === date && eventDate.getMonth() === month && eventDate.getFullYear() === year;
                        });
                        
                        if (hasEvents) {
                            cell.classList.add('has-event');
                        }
                        
                        date++;
                    }
                    
                    // Ajouter un écouteur d'événement pour la sélection de date
                    cell.addEventListener('click', function() {
                        // Supprimer la classe 'selected' de la date précédemment sélectionnée
                        const selectedCell = document.querySelector('.calendar-table td.selected');
                        if (selectedCell) {
                            selectedCell.classList.remove('selected');
                        }
                        
                        // Ajouter la classe 'selected' à la nouvelle date sélectionnée
                        this.classList.add('selected');
                        
                        // Mettre à jour la date sélectionnée
                        selectedDate = new Date(this.dataset.date);
                        
                        // Mettre à jour l'affichage de la date sélectionnée
                        updateSelectedDate();
                        
                        // Mettre à jour la liste des événements
                        updateEventList();
                    });
                    
                    row.appendChild(cell);
                }
                
                calendarBody.appendChild(row);
                
                // Arrêter si tous les jours du mois ont été affichés
                if (date > monthLength) {
                    break;
                }
            }
            
            // Mettre à jour l'affichage de la date sélectionnée
            updateSelectedDate();
            
            // Mettre à jour la liste des événements
            updateEventList();
        }
        
        // Fonction pour mettre à jour l'affichage de la date sélectionnée
        function updateSelectedDate() {
            const dayNames = ['dim.', 'lun.', 'mar.', 'mer.', 'jeu.', 'ven.', 'sam.'];
            const monthNames = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];
            
            const dayName = dayNames[selectedDate.getDay()];
            const day = selectedDate.getDate();
            const month = monthNames[selectedDate.getMonth()];
            const year = selectedDate.getFullYear();
            
            document.getElementById('selectedDate').textContent = `${dayName} ${day} ${month} ${year}`;
        }
        
        // Fonction pour mettre à jour la liste des événements
        function updateEventList() {
            const eventList = document.getElementById('eventList');
            const noEvents = document.getElementById('noEvents');
            
            // Filtrer les événements pour la date sélectionnée
            const filteredEvents = events.filter(event => {
                const eventDate = new Date(event.start);
                return eventDate.getDate() === selectedDate.getDate() && 
                       eventDate.getMonth() === selectedDate.getMonth() && 
                       eventDate.getFullYear() === selectedDate.getFullYear();
            });
            
            // Vider la liste des événements
            eventList.innerHTML = '';
            
            // Afficher un message si aucun événement n'est trouvé
            if (filteredEvents.length === 0) {
                noEvents.style.display = 'block';
                eventList.appendChild(noEvents);
                return;
            }
            
            // Masquer le message 'Aucun événement'
            noEvents.style.display = 'none';
            
            // Ajouter chaque événement à la liste
            filteredEvents.forEach(event => {
                const eventItem = document.createElement('div');
                eventItem.classList.add('event-item');
                
                const eventTitle = document.createElement('div');
                eventTitle.classList.add('event-title');
                eventTitle.innerHTML = `<i class="fas fa-calendar-day"></i> ${event.title}`;
                
                const eventTime = document.createElement('div');
                eventTime.classList.add('event-time');
                const hours = event.start.getHours().toString().padStart(2, '0');
                const minutes = event.start.getMinutes().toString().padStart(2, '0');
                eventTime.textContent = `${hours}:${minutes}`;
                
                const eventDescription = document.createElement('div');
                eventDescription.classList.add('event-description');
                eventDescription.textContent = event.description;
                
                eventItem.appendChild(eventTitle);
                eventItem.appendChild(eventTime);
                eventItem.appendChild(eventDescription);
                
                eventList.appendChild(eventItem);
            });
        }
        
        // Fonction pour générer la liste déroulante des années
        function generateYearDropdown() {
            const yearList = document.getElementById('yearList');
            
            for (let year = MIN_YEAR; year <= MAX_YEAR; year++) {
                const yearItem = document.createElement('li');
                const yearLink = document.createElement('a');
                yearLink.classList.add('dropdown-item');
                yearLink.textContent = year;
                yearLink.href = '#';
                yearLink.addEventListener('click', function() {
                    currentDate.setFullYear(year);
                    document.getElementById('selectedYear').textContent = year;
                    generateCalendar(currentDate);
                });
                
                yearItem.appendChild(yearLink);
                yearList.appendChild(yearItem);
            }
        }
        
        // Générer le calendrier initial et la liste déroulante des années
        generateCalendar(currentDate);
        generateYearDropdown();
        document.getElementById('selectedYear').textContent = currentDate.getFullYear();
        
        // Écouteurs d'événements pour les boutons de navigation
        document.getElementById('prevMonth').addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            document.getElementById('selectedYear').textContent = currentDate.getFullYear();
            generateCalendar(currentDate);
        });
        
        document.getElementById('nextMonth').addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            document.getElementById('selectedYear').textContent = currentDate.getFullYear();
            generateCalendar(currentDate);
        });
        
        document.getElementById('prevYear').addEventListener('click', function() {
            const newYear = Math.max(currentDate.getFullYear() - 1, MIN_YEAR);
            currentDate.setFullYear(newYear);
            document.getElementById('selectedYear').textContent = newYear;
            generateCalendar(currentDate);
        });
        
        document.getElementById('nextYear').addEventListener('click', function() {
            const newYear = Math.min(currentDate.getFullYear() + 1, MAX_YEAR);
            currentDate.setFullYear(newYear);
            document.getElementById('selectedYear').textContent = newYear;
            generateCalendar(currentDate);
        });
        
        // Écouteur d'événement pour le bouton d'enregistrement d'événement
        document.getElementById('saveEvent').addEventListener('click', function() {
            const title = document.getElementById('eventTitle').value;
            const date = document.getElementById('eventDate').value;
            const startTime = document.getElementById('eventStartTime').value;
            const endTime = document.getElementById('eventEndTime').value;
            const description = document.getElementById('eventDescription').value;
            
            if (title && date && startTime) {
                // Créer les objets Date pour le début et la fin
                const [year, month, day] = date.split('-').map(Number);
                const [startHour, startMinute] = startTime.split(':').map(Number);
                
                let endHour, endMinute;
                if (endTime) {
                    [endHour, endMinute] = endTime.split(':').map(Number);
                } else {
                    endHour = startHour + 1;
                    endMinute = startMinute;
                }
                
                const startDate = new Date(year, month - 1, day, startHour, startMinute);
                const endDate = new Date(year, month - 1, day, endHour, endMinute);
                
                // Ajouter le nouvel événement
                const newEvent = {
                    id: events.length + 1,
                    title: title,
                    start: startDate,
                    end: endDate,
                    description: description || 'Aucune description'
                };
                
                events.push(newEvent);
                
                // Fermer le modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('addEventModal'));
                modal.hide();
                
                // Réinitialiser le formulaire
                document.getElementById('addEventForm').reset();
                
                // Mettre à jour le calendrier
                generateCalendar(currentDate);
                
                // Si l'événement est pour la date sélectionnée, mettre à jour la liste des événements
                if (isSameDay(startDate, selectedDate)) {
                    updateEventList();
                }
            }
        });
        
        // Fonction utilitaire pour vérifier si deux dates sont le même jour
        function isSameDay(date1, date2) {
            return date1.getDate() === date2.getDate() && 
                   date1.getMonth() === date2.getMonth() && 
                   date1.getFullYear() === date2.getFullYear();
        }
    });
</script>
@endsection
