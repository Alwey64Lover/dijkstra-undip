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
    var coursesData = @json($courseclasses);
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var miniCalendarEl = document.getElementById('mini-calendar');
        var mainCalendarEl = document.getElementById('calendar');
        var sidebarEl = document.querySelector('.subject-list ul');

        function updateSidebar(events) {
            sidebarEl.innerHTML = '';

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

        function generateRepeatingEvents(course_name, name_class, start_time, end_time, start_date = '2024-08-21', end_date = '2024-12-21', interval_days = 7, count = 10) {
            let events = [];
            let currentstart_date = new Date(`${start_date}T${start_time}`);
            let currentend_date = new Date(`${start_date}T${end_time}`);
            let lastend_date = new Date(end_date);


            while (currentstart_date <= lastend_date) {
                events.push({
                    title: `${course_name} - Kelas${name_class}`,
                    start: currentstart_date.toISOString(),
                    end: currentend_date.toISOString()
                });

                currentstart_date.setDate(currentstart_date.getDate() + interval_days);
                currentend_date.setDate(currentend_date.getDate() + interval_days);
            }

            return events;
        }

        var events = [];
        coursesData.forEach(function(courseClass) {
            var course = courseClass.course_department_detail.course;
            var repeatingEvents = generateRepeatingEvents(course.name, courseClass.name, courseClass.start_time, courseClass.end_time);
            events.push(...repeatingEvents);
        });


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
            events: events,
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


        miniCalendar.render();
        console.log('Mini Calendar rendered.');
        mainCalendar.render();
        console.log('Main Calendar rendered.');
    });
</script>

@extends('layouts.backend.app')
@section('title', 'Dashboard')

@section('content')
    <section class="section dashboard" id="dashboard-container">
        <!-- Sidebar section -->
        <div class="sidebar">
            <!-- Mini calendar di sidebar -->
            <div id="mini-calendar"></div>
            <div class="subject-list">
                <ul>

                </ul>
            </div>
        </div>

        <!-- Calendar section -->
        <div id="calendar-container">
            <div id="calendar"></div>
        </div>
    </section>
    <div id="form-container" style="display:none;"></div>
@endsection
