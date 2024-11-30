@extends('layouts.backend.app')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Course Schedule {{$latest_academic_year->name}}</h4>
        <button type="submit" class="btn btn-primary">Submit Schedule</button>
    </div>
    <div class="card-body">
        @php
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        @endphp

        @foreach($days as $day)
            <div class="day-section mb-4">
                <div class="d-flex align-items-center mb-2">
                    <h5 class="text-primary mb-0 me-2">{{ $day }}</h5>
                    <button type="button" class="btn btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#addCourseModal{{ $day }}">
                        <i class="bi bi-plus"></i> Add Course
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Course</th>
                                <th>Class</th>
                                <th>Room</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="schedule-{{ $day }}">
                            <!-- Dynamic content will be added here -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal for {{ $day }} -->
            <div class="modal fade" id="addCourseModal{{ $day }}" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Course for {{ $day }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="courseForm{{ $day }}">
                                <div class="form-group mb-3">
                                    <label>Course Name</label>
                                    <select class="form-select" name="course_name" onchange="calculateEndTime('{{$day}}')" required>
                                        <option value="">Pilih Mata Kuliah yang Tersedia</option>
                                        @foreach ($existing_dept_courses as $courses)
                                            @if($courses->courseDepartment->action_name === 'waiting')
                                                <option value="{{$courses->course->id}}">
                                                    {{$courses->course->name}} - {{$courses->sks}} SKS
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Class</label>
                                    <input type="text" class="form-control" name="class" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Room</label>
                                    <select class="form-select" name="room" required>
                                        <option value="">Pilih Ruangan yang Tersedia</option>
                                        @foreach ($roomavailable as $room)
                                            <option value="{{$room->id}}">{{$room->type}}{{$room->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Start Time</label>
                                    <select class="form-select" name="start_time" id="start_time_{{$day}}" onchange="calculateEndTime('{{$day}}')" required>
                                        <option value="">Pilih Waktu Mulai</option>
                                        @php
                                            for ($hour = 7; $hour <= 18; $hour++) {
                                                for ($minute = 0; $minute < 60; $minute += 10) {
                                                    $time = sprintf("%02d:%02d", $hour, $minute);
                                                    echo "<option value='$time'>$time</option>";
                                                }
                                            }
                                        @endphp
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>End Time</label>
                                    <input type="text" class="form-control" name="end_time" id="end_time_{{$day}}" readonly>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="addCourse('{{ $day }}')">Add Course</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    function calculateEndTime(day) {
        const form = document.getElementById(`courseForm${day}`);
        const startTimeSelect = document.getElementById(`start_time_${day}`);
        const endTimeInput = document.getElementById(`end_time_${day}`);
        const courseSelect = form.course_name;

        if (startTimeSelect.value && courseSelect.value) {
            const selectedOption = courseSelect.options[courseSelect.selectedIndex];
            const sks = parseInt(selectedOption.text.split(' - ')[1]);
            const durationMinutes = sks * 50;

            const [hours, minutes] = startTimeSelect.value.split(':');
            const startDate = new Date();
            startDate.setHours(parseInt(hours));
            startDate.setMinutes(parseInt(minutes));

            const endDate = new Date(startDate.getTime() + durationMinutes * 60000);
            const endTime = `${String(endDate.getHours()).padStart(2, '0')}:${String(endDate.getMinutes()).padStart(2, '0')}`;

            console.log(endDate);
            console.log(endTime);
            endTimeInput.value = endTime;
        }
    }

    function addCourse(day) {
        const form = document.getElementById(`courseForm${day}`);
        const scheduleBody = document.getElementById(`schedule-${day}`);

        const startTime = form.start_time.value;
        const endTime = form.end_time.value;
        const courseSelect = form.course_name;
        const courseName = courseSelect.options[courseSelect.selectedIndex].text.split(' - ')[0];
        const className = form.class.value;
        const roomSelect = form.room;
        const roomName = roomSelect.options[roomSelect.selectedIndex].text;

        // Create schedule data object
        const scheduleData = {
            startTime,
            endTime,
            courseName,
            className,
            roomName
        };

        // Get existing data from session storage or initialize empty object
        let sessionData = JSON.parse(sessionStorage.getItem('courseSchedules')) || {};

        // Initialize array for specific day if doesn't exist
        if (!sessionData[day]) {
            sessionData[day] = [];
        }

        // Add new schedule data
        sessionData[day].push(scheduleData);

        // Save to session storage
        sessionStorage.setItem('courseSchedules', JSON.stringify(sessionData));

        displayScheduleFromSession();

        $(`#addCourseModal${day}`).modal('hide');
        form.reset();
    }

    // Function to display schedules from session storage
    function displayScheduleFromSession() {
        const sessionData = JSON.parse(sessionStorage.getItem('courseSchedules')) || {};

        // For each day, populate the table
        ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'].forEach(day => {
            const scheduleBody = document.getElementById(`schedule-${day}`);
            scheduleBody.innerHTML = '';

            if (sessionData[day]) {
                sessionData[day].sort((a, b) => a.startTime.localeCompare(b.startTime));

                sessionData[day].forEach(schedule => {
                    const newRow = `
                        <tr data-time="${schedule.startTime}">
                            <td>${schedule.startTime}</td>
                            <td>${schedule.endTime}</td>
                            <td>${schedule.courseName}</td>
                            <td>${schedule.className}</td>
                            <td>${schedule.roomName}</td>
                            <td>
                                <button class="btn btn-sm btn-danger" onclick="removeSchedule('${day}', '${schedule.startTime}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    scheduleBody.insertAdjacentHTML('beforeend', newRow);
                });
            }
        });
    }

    // Function to remove schedule
    function removeSchedule(day, startTime) {
        let sessionData = JSON.parse(sessionStorage.getItem('courseSchedules')) || {};
        sessionData[day] = sessionData[day].filter(schedule => schedule.startTime !== startTime);
        sessionStorage.setItem('courseSchedules', JSON.stringify(sessionData));
        displayScheduleFromSession();
    }

    // Load schedules when page loads
    document.addEventListener('DOMContentLoaded', () => {
        displayScheduleFromSession();
    });

</script>

@endsection
