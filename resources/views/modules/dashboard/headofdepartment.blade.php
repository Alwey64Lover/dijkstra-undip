<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js"></script>

<style>
    body {
        background-color: #d4eaff;
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }
    .dashboard {
        display: flex;
        justify-content: space-between;
    }
    .sidebar {
        width: 300px;
        background-color: #EAEAEA;
        border-radius: 10px;
        border-top-right-radius: 0px;
        border-bottom-left-radius: 0px;
        border-bottom-right-radius: 0px;
        padding: 20px;
        box-shadow: -4px 0 8px rgba(0, 0, 0, 0.1), 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    #calendar-container {
        flex-grow: 1;
        background-color: white;
        border-radius: 10px;
        border-top-left-radius: 0px;
        border-bottom-left-radius: 0px;
        border-bottom-right-radius: 0px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    #calendar, #mini-calendar {
        max-width: 100%;
        margin: 0;
    }

    .subject-list ul {
        list-style-type: none;
        padding: 0;
    }

    .subject-list li {
        padding: 8px;
        margin-bottom: 10px;
        border-radius: 5px;
        background-color: #f1f1f1;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .subject-list .color {
        width: 15px;
        height: 15px;
        border-radius: 50%;
        display: inline-block;
    }


    #mini-calendar {
        margin-bottom: 20px;
    }

    #mini-calendar .fc-daygrid-day:hover{
        background-color: whitesmoke;
        cursor: pointer;
    }
    #mini-calendar .fc-toolbar-title {
        font-size: 16px;
        white-space: nowrap;
    }

    #mini-calendar .fc .fc-toolbar-chunk {
        padding: 0 5px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var miniCalendarEl = document.getElementById('mini-calendar');
        var mainCalendarEl = document.getElementById('calendar');
        var sidebarEl = document.querySelector('.subject-list ul');

        function updateSidebar(events) {
            // sidebarEl.innerHTML = '';
            let addedEvents = new Set();
            events.forEach(function(event) {
                if (!addedEvents.has(event.title)) {
                    var li = document.createElement('li');
                    li.textContent = event.title;
                    sidebarEl.appendChild(li);
                    addedEvents.add(event.title);
                }
            });
        }

        function generateRepeatingEvents(title, startDate, endDate, intervalDays, count) {
            let events = [];
            let currentStartDate = new Date(startDate);
            let currentEndDate = new Date(endDate);

            for (let i = 0; i < count; i++) {
                events.push({
                    title: title,
                    start: currentStartDate.toISOString(),
                    end: currentEndDate.toISOString()
                });

                currentStartDate.setDate(currentStartDate.getDate() + intervalDays);
                currentEndDate.setDate(currentEndDate.getDate() + intervalDays);
            }

            return events;
        }

        // Mini calendar di sidebar
        var miniCalendar = new FullCalendar.Calendar(miniCalendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev',
                center: 'title',
                right: 'next'
            },
            dateClick: function(info) {
                mainCalendar.changeView('listDay', info.dateStr);
            }
        });

        var mainCalendar = new FullCalendar.Calendar(mainCalendarEl, {
            initialView: 'listDay',
            headerToolbar: {
                left: 'today',
                center: 'title',
                right: ''
            },
            events: [
                // ...generateRepeatingEvents('Morning Exercise', '2024-09-28T06:00:00', '2024-09-28T07:00:00', 7, 10),
                // ...generateRepeatingEvents('Team Meeting', '2024-09-28T10:00:00', '2024-09-28T11:00:00', 7, 10),
                // ...generateRepeatingEvents('Lunch Break', '2024-09-28T12:00:00', '2024-09-28T13:00:00', 7, 10),
                // ...generateRepeatingEvents('Client Call', '2024-09-28T15:00:00', '2024-09-28T16:00:00', 7, 10)
            ],
            eventDidMount: function(info) {
                console.log('Event mounted:', info.event.title);
            },
            noEventsContent: function() {
                return 'No events for today.';
            }
        });

        mainCalendar.on('eventsSet', function() {
            var events = mainCalendar.getEvents();
            updateSidebar(events);
        });

        // Render both calendars
        miniCalendar.render();
        mainCalendar.render();
    });
</script>

@extends('layouts.backend.app')
@section('title', 'Dashboard')

@section('content')
    <section class="section dashboard">
        <!-- Sidebar section -->
        <div class="sidebar">
            <!-- Mini calendar di sidebar -->
            <div id="mini-calendar"></div>
            @foreach ($courses as $course)
                <div class="subject-list">
                    <ul>
                        <li>{{ $course->name }}</li>
                    </ul>
                </div>
            @endforeach
        <a href="#" style="color: green;">+ Tambahkan Mata Kuliah</a></li>
        </div>

        <!-- Calendar section -->
        <div id="calendar-container">
            <div id="calendar"></div>
        </div>
    </section>
@endsection
