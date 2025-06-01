@extends('layouts.app')

@section('title', 'Calendrier')

@section('styles')
<style>
    .calendar-container {
        background-color: #f8f9fa;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
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
        width: 60px;
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
<div class="container py-4">
    
    <div class="row">
        <div class="col-lg-8">
            <div class="calendar-container">
                <div class="calendar-nav">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button id="prevYear" class="year-btn btn btn-sm"><i class="bi bi-chevron-double-left"></i> Année</button>
                        <div class="d-flex align-items-center">
                            <button id="prevMonth" class="nav-btn"><i class="bi bi-chevron-left"></i></button>
                            <h2 id="currentMonth" class="mx-3 mb-0">Février 2025</h2>
                            <button id="nextMonth" class="nav-btn"><i class="bi bi-chevron-right"></i></button>
                        </div>
                        <button id="nextYear" class="year-btn btn btn-sm">Année <i class="bi bi-chevron-double-right"></i></button>
                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="yearDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <span id="selectedYear">2025</span>
                            </button>
                            <ul class="dropdown-menu year-dropdown" aria-labelledby="yearDropdown" style="max-height: 300px; overflow-y: auto;">
                                <!-- Les années seront générées par JavaScript -->
                            </ul>
                        </div>
                    </div>
                </div>
                
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
                        <!-- Le contenu du calendrier sera généré par JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="event-details">
                <h3 id="selectedDate">Lun 24 février 2025</h3>
                
                <div class="event-list" id="eventList">
                    <div class="event-item">
                        <div class="event-title">
                            <i class="bi bi-calendar-event"></i>
                            Événement : Hackathon
                        </div>
                        <div class="event-time">
                            <div>De : feb 24, 2025 8:30 a.m.</div>
                            <div>À : feb 25, 2025 11:30 a.m.</div>
                        </div>
                        <div class="event-description">
                            Description : Hackathon annuel de programmation pour les étudiants.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<button class="add-event-btn" data-bs-toggle="modal" data-bs-target="#addEventModal">
    <i class="bi bi-plus"></i>
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
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="eventStartTime" class="form-label">Heure de début</label>
                            <input type="time" class="form-control" id="eventStartTime" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="eventEndTime" class="form-label">Heure de fin</label>
                            <input type="time" class="form-control" id="eventEndTime" required>
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
                            <option value="devoir">Devoir</option>
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
            {
                id: 1,
                title: 'Hackathon',
                start: new Date(2025, 1, 24, 8, 30), // 24 février 2025, 8h30
                end: new Date(2025, 1, 25, 11, 30),  // 25 février 2025, 11h30
                description: 'Hackathon annuel de programmation pour les étudiants.'
            },
            {
                id: 2,
                title: 'Examen de Mathématiques',
                start: new Date(2025, 1, 15, 10, 0), // 15 février 2025, 10h00
                end: new Date(2025, 1, 15, 12, 0),   // 15 février 2025, 12h00
                description: 'Examen final du semestre pour le cours de mathématiques.'
            },
            {
                id: 3,
                title: 'Remise de projet',
                start: new Date(2025, 1, 28, 23, 59), // 28 février 2025, 23h59
                end: new Date(2025, 1, 28, 23, 59),   // 28 février 2025, 23h59
                description: 'Date limite pour la remise du projet final.'
            }
        ];
        
        // Variables pour suivre la date actuelle
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
            document.getElementById('currentMonth').textContent = new Date(year, month, 1).toLocaleDateString('fr-FR', { month: 'long', year: 'numeric' });
            
            // Obtenir le premier jour du mois
            const firstDay = new Date(year, month, 1);
            // Obtenir le dernier jour du mois
            const lastDay = new Date(year, month + 1, 0);
            
            // Obtenir le jour de la semaine du premier jour (0 = Dimanche, 1 = Lundi, etc.)
            let firstDayOfWeek = firstDay.getDay();
            if (firstDayOfWeek === 0) firstDayOfWeek = 7; // Convertir Dimanche de 0 à 7
            
            // Calculer le nombre de jours du mois précédent à afficher
            const daysFromPrevMonth = firstDayOfWeek - 1;
            
            // Obtenir le dernier jour du mois précédent
            const lastDayOfPrevMonth = new Date(year, month, 0).getDate();
            
            // Calculer le nombre total de cellules nécessaires (max 42 = 6 semaines)
            const totalCells = Math.ceil((lastDay.getDate() + daysFromPrevMonth) / 7) * 7;
            
            // Générer les cellules du calendrier
            let calendarHTML = '';
            let dayCount = 1;
            let nextMonthDay = 1;
            
            for (let i = 0; i < totalCells / 7; i++) {
                calendarHTML += '<tr>';
                
                for (let j = 0; j < 7; j++) {
                    if (i === 0 && j < daysFromPrevMonth) {
                        // Jours du mois précédent
                        const prevMonthDate = lastDayOfPrevMonth - daysFromPrevMonth + j + 1;
                        calendarHTML += `<td class="other-month">${prevMonthDate}</td>`;
                    } else if (dayCount > lastDay.getDate()) {
                        // Jours du mois suivant
                        calendarHTML += `<td class="other-month">${nextMonthDay}</td>`;
                        nextMonthDay++;
                    } else {
                        // Jours du mois actuel
                        const currentDateObj = new Date(year, month, dayCount);
                        const isToday = isSameDay(currentDateObj, new Date());
                        const isSelected = isSameDay(currentDateObj, selectedDate);
                        const hasEvent = events.some(event => isSameDay(event.start, currentDateObj));
                        
                        let classes = [];
                        if (isToday) classes.push('today');
                        if (isSelected) classes.push('selected');
                        if (hasEvent) classes.push('has-event');
                        
                        calendarHTML += `<td class="${classes.join(' ')}" data-date="${year}-${month+1}-${dayCount}">${dayCount}</td>`;
                        dayCount++;
                    }
                }
                
                calendarHTML += '</tr>';
                
                // Si tous les jours du mois ont été ajoutés, sortir de la boucle
                if (dayCount > lastDay.getDate() && i >= 4) break;
            }
            
            document.getElementById('calendarBody').innerHTML = calendarHTML;
            
            // Ajouter des écouteurs d'événements aux cellules
            const cells = document.querySelectorAll('.calendar-table td:not(.other-month)');
            cells.forEach(cell => {
                cell.addEventListener('click', function() {
                    // Supprimer la classe selected de toutes les cellules
                    document.querySelectorAll('.calendar-table td').forEach(td => td.classList.remove('selected'));
                    
                    // Ajouter la classe selected à la cellule cliquée
                    this.classList.add('selected');
                    
                    // Mettre à jour la date sélectionnée
                    const [year, month, day] = this.dataset.date.split('-').map(Number);
                    selectedDate = new Date(year, month-1, day);
                    
                    // Mettre à jour l'affichage des événements
                    updateEventList();
                });
            });
            
            // Mettre à jour l'affichage des événements
            updateEventList();
        }
        
        // Fonction pour mettre à jour la liste des événements
        function updateEventList() {
            // Mettre à jour le titre de la date sélectionnée
            document.getElementById('selectedDate').textContent = selectedDate.toLocaleDateString('fr-FR', { weekday: 'short', day: 'numeric', month: 'long', year: 'numeric' });
            
            // Filtrer les événements pour la date sélectionnée
            const dayEvents = events.filter(event => isSameDay(event.start, selectedDate));
            
            // Générer le HTML pour les événements
            let eventsHTML = '';
            
            if (dayEvents.length > 0) {
                dayEvents.forEach(event => {
                    eventsHTML += `
                        <div class="event-item">
                            <div class="event-title">
                                <i class="bi bi-calendar-event"></i>
                                Événement : ${event.title}
                            </div>
                            <div class="event-time">
                                <div>De : ${formatDate(event.start)}</div>
                                <div>À : ${formatDate(event.end)}</div>
                            </div>
                            <div class="event-description">
                                Description : ${event.description}
                            </div>
                        </div>
                    `;
                });
            } else {
                eventsHTML = '<p class="text-muted">Aucun événement pour cette date.</p>';
            }
            
            document.getElementById('eventList').innerHTML = eventsHTML;
        }
        
        // Fonction pour vérifier si deux dates sont le même jour
        function isSameDay(date1, date2) {
            return date1.getFullYear() === date2.getFullYear() &&
                   date1.getMonth() === date2.getMonth() &&
                   date1.getDate() === date2.getDate();
        }
        
        // Fonction pour formater une date
        function formatDate(date) {
            const options = { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: 'numeric' };
            return date.toLocaleDateString('en-US', options);
        }
        
        // Fonction pour générer la liste déroulante des années
        function generateYearDropdown() {
            const yearDropdown = document.querySelector('.year-dropdown');
            yearDropdown.innerHTML = '';
            
            for (let year = MIN_YEAR; year <= MAX_YEAR; year++) {
                const li = document.createElement('li');
                const a = document.createElement('a');
                a.classList.add('dropdown-item');
                if (year === currentDate.getFullYear()) {
                    a.classList.add('active');
                }
                a.href = '#';
                a.textContent = year;
                a.addEventListener('click', function(e) {
                    e.preventDefault();
                    currentDate.setFullYear(year);
                    document.getElementById('selectedYear').textContent = year;
                    generateCalendar(currentDate);
                });
                li.appendChild(a);
                yearDropdown.appendChild(li);
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
    });
</script>
@endsection
