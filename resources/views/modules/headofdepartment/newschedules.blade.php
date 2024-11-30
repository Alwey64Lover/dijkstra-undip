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
                            <div id="validationAlert_{{$day}}" class="alert alert-danger alert-dismissible fade" role="alert" style="display: none;">
                                <i class="bi bi-exclamation-triangle"></i> Please fill in all required fields
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <form id="courseForm{{ $day }}">
                                <div class="form-group mb-3">
                                    <label>Course Name</label>
                                    <select class="form-select" name="course_name" onchange="calculateEndTime('{{$day}}')" required>
                                        <option value="">Pilih Mata Kuliah yang Tersedia</option>
                                        @foreach ($existing_dept_courses as $courses)
                                            @if($courses->courseDepartment->action_name === 'waiting')
                                                <option value="{{$courses->id}}">
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
                                <div class="form-group mb-3">
                                    <label>Room</label>
                                    <select class="form-select" name="room" required>
                                        <option value="">Pilih Ruangan yang Tersedia</option>
                                        @foreach ($roomavailable as $room)
                                            <option value="{{$room->id}}">{{$room->type}}{{$room->name}}</option>
                                        @endforeach
                                    </select>
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
    function checkRoomAvailability(day, startTime, endTime) {
        const sessionData = JSON.parse(sessionStorage.getItem('courseSchedules')) || {};
        const daySchedules = sessionData[day] || [];

        // Get all rooms that are already booked for the given time slot
        const bookedRooms = daySchedules.filter(schedule => {
            return (
                (startTime >= schedule.startTime && startTime < schedule.endTime) ||
                (endTime > schedule.startTime && endTime <= schedule.endTime) ||
                (startTime <= schedule.startTime && endTime >= schedule.endTime)
            );
        }).map(schedule => schedule.roomName);

        return bookedRooms;
    }

    function calculateEndTime(day) {
        const form = document.getElementById(`courseForm${day}`);
        const startTimeSelect = document.getElementById(`start_time_${day}`);
        const endTimeInput = document.getElementById(`end_time_${day}`);
        const courseSelect = form.course_name;
        const roomSelect = form.room;

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

            endTimeInput.value = endTime;

            // Get booked rooms for this time slot
            const bookedRooms = checkRoomAvailability(day, startTimeSelect.value, endTime);

            // Reset and update room options
            Array.from(roomSelect.options).forEach(option => {
                if (option.value !== '') { // Skip the default "Select Room" option
                    option.disabled = bookedRooms.includes(option.text);
                    option.style.display = bookedRooms.includes(option.text) ? 'none' : '';
                }
            });
        }
    }

    function checkExistingCourseClass(courseName, className) {
        const sessionData = JSON.parse(sessionStorage.getItem('courseSchedules')) || {};
        let exists = false;

        // Check all days
        Object.values(sessionData).forEach(daySchedules => {
            daySchedules.forEach(schedule => {
                if (schedule.courseName === courseName && schedule.className === className) {
                    exists = true;
                }
            });
        });

        return exists;
    }

    function addCourse(day) {
        const form = document.getElementById(`courseForm${day}`);
        const validationAlert = document.querySelector(`#validationAlert_${day}`);

        // Form validation
        if (!form.course_name.value || !form.class.value || !form.room.value || !form.start_time.value || !form.end_time.value) {
            if (validationAlert) {
                validationAlert.style.display = 'block';
                validationAlert.classList.add('show');
                validationAlert.innerHTML = '<i class="bi bi-exclamation-triangle"></i> Please fill in all required fields';
            }
            return;
        }

        // Prepare data for AJAX request
        const formData = {
            room_id: form.room.value,
            course_department_detail_id: form.course_name.value, // This will now have the correct ID
            name: form.class.value,
            day: day.toLowerCase(),
            start_time: form.start_time.value,
            end_time: form.end_time.value,
            _token: '{{ csrf_token() }}'
        };

        // Send AJAX request to store data
        $.ajax({
            url: '/store-schedule', // Create this route in web.php
            type: 'POST',
            data: formData,
            success: function(response) {
                // Refresh the schedule display
                loadSchedulesFromDatabase();
                // Close modal and reset form
                $(`#addCourseModal${day}`).modal('hide');
                form.reset();
            },
            error: function(xhr) {
                validationAlert.style.display = 'block';
                validationAlert.classList.add('show');
                validationAlert.innerHTML = '<i class="bi bi-exclamation-triangle"></i> ' + xhr.responseJSON.message;
            }
        });
    }

    // New function to load schedules from database
    function loadSchedulesFromDatabase() {
        $.ajax({
            url: '/get-schedules', // Create this route in web.php
            type: 'GET',
            success: function(schedules) {
                ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'].forEach(day => {
                    const scheduleBody = document.getElementById(`schedule-${day}`);
                    scheduleBody.innerHTML = '';

                    const daySchedules = schedules.filter(schedule => schedule.day === day);
                    daySchedules.forEach(schedule => {
                        const newRow = `
                            <tr>
                                <td>${schedule.start_time}</td>
                                <td>${schedule.end_time}</td>
                                <td>${schedule.course_name}</td>
                                <td>${schedule.name}</td>
                                <td>${schedule.room_name}</td>
                                <td>
                                    <button class="btn btn-sm btn-danger" onclick="removeSchedule(${schedule.id})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                        scheduleBody.insertAdjacentHTML('beforeend', newRow);
                    });
                });
            }
        });
    }

    // Update page load event
    document.addEventListener('DOMContentLoaded', () => {
        loadSchedulesFromDatabase();
    });


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
    function removeSchedule(scheduleId) {
        $.ajax({
            url: `/delete-schedule/${scheduleId}`,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                loadSchedulesFromDatabase();
            }
        });
    }


    // Load schedules when page loads
    document.addEventListener('DOMContentLoaded', () => {
        displayScheduleFromSession();
    });

</script>

@endsection
