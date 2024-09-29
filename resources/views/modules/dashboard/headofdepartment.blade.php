<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js"></script>

<style>
    #calendar {
        max-width: 1024px;
        margin: 0 auto;
        margin-right: 0px;
        padding: 20px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'listDay', // Mengubah tampilan ke daftar
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: ''
            },
            noEventsContent: function() {
                // Custom message when no events are available for the day
                return 'No events for today. Check again later!';
            },
            events: [
                {
                    title: 'Morning Exercise',
                    start: '2024-09-28T06:00:00',
                    end: '2024-09-28T07:00:00'
                },
                {
                    title: 'Morning Exalt',
                    start: '2024-09-28T06:00:00',
                    end: '2024-09-28T07:00:00'
                },
                {
                    title: 'Morning Camp',
                    start: '2024-09-28T06:00:00',
                    end: '2024-09-28T07:15:00'
                },
                {
                    title: 'Team Meeting',
                    start: '2024-09-28T10:00:00',
                    end: '2024-09-28T11:00:00'
                },
                {
                    title: 'Lunch Break',
                    start: '2024-09-28T12:00:00',
                    end: '2024-09-28T13:00:00'
                },
                {
                    title: 'Client Call',
                    start: '2024-09-28T15:00:00',
                    end: '2024-09-29T16:00:00'
                }
            ]
        });

        calendar.render();
    });
</script>

@extends('layouts.backend.app')
@section('title', 'Dashboard')

@section('content')
    <section class="section dashboard">
        <div id="calendar"></div>
    </section>
@endsection
