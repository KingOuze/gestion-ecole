// Initialisation du calendrier
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: [
            // Remplacez par les événements réels
            {
                title: 'Examen Math',
                start: '2024-09-30'
            },
            {
                title: 'Examen Histoire',
                start: '2024-10-05'
            }
        ]
    });
    calendar.render();
});