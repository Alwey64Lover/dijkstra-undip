@extends('layouts.backend.app')
@include('components.modal.modal-delete')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Course Schedule {{$latest_academic_year->name}}</h4>
        <button type="button" id="submitScheduleBtn" class="btn btn-primary">Submit Schedule</button>
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
    document.addEventListener('DOMContentLoaded', () => {
        $.ajax({
            url: '/check-submission-status',
            type: 'GET',
            success: function(response) {
                if (response.isSubmitted) {
                    loadSchedulesFromDatabase(true); // Pass isSubmitted flag
                    const addCourseButtons = document.querySelectorAll('.btn-light-primary');
                    addCourseButtons.forEach(button => {
                        button.disabled = true;
                        button.classList.remove('btn-light-primary');
                        button.classList.add('btn-secondary');
                    });
                } else {
                    loadSchedulesFromDatabase(false);
                }
            }
        });
    });

    document.getElementById('submitScheduleBtn').addEventListener('click', function() {
        // Disable button immediately when clicked
        const submitBtn = this;
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Submitting...';

        $.ajax({
            url: '/submit-schedule',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Update button state immediately
                submitBtn.innerHTML = 'Submitted';
                submitBtn.classList.remove('btn-primary');
                submitBtn.classList.add('btn-secondary');

                const deleteButtons = document.querySelectorAll('.table .btn-danger');
                deleteButtons.forEach(button => {
                    button.disabled = true;
                    button.classList.remove('btn-danger');
                    button.classList.add('btn-secondary');
                });

                const addCourseButtons = document.querySelectorAll('.btn-light-primary');
                addCourseButtons.forEach(button => {
                    button.disabled = true;
                    button.classList.remove('btn-light-primary');
                    button.classList.add('btn-secondary');
                });

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Schedule has been submitted successfully!'
                });
            },
            error: function(xhr) {
                // Re-enable button if there's an error
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Submit Schedule';

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to submit schedule'
                });
            }
        });
    });



    document.addEventListener('DOMContentLoaded', () => {
        loadSchedulesFromDatabase();

        // Check submission status
        $.ajax({
            url: '/check-submission-status',
            type: 'GET',
            success: function(response) {
                const submitBtn = document.getElementById('submitScheduleBtn');
                if (response.isSubmitted) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = 'Submitted';
                    submitBtn.classList.remove('btn-primary');
                    submitBtn.classList.add('btn-secondary');
                }
            }
        });
    });


    function checkRoomAvailability(day, startTime, endTime, roomId) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '/check-room-availability',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    day: day,
                    start_time: startTime,
                    end_time: endTime,
                    room_id: roomId
                },
                success: function(response) {
                    resolve(response.isAvailable);
                },
                error: function(xhr) {
                    reject(xhr.responseJSON.message);
                }
            });
        });
    }


    async function calculateEndTime(day) {
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

            // Check availability for each room
            for (const option of roomSelect.options) {
                if (option.value !== '') {
                    try {
                        const isAvailable = await checkRoomAvailability(day, startTimeSelect.value, endTime, option.value);
                        option.disabled = !isAvailable;
                        option.style.display = isAvailable ? '' : 'none';
                    } catch (error) {
                        console.error('Error checking room availability:', error);
                    }
                }
            }
        }
    }


    function addCourse(day) {
        const form = document.getElementById(`courseForm${day}`);
        const validationAlert = document.querySelector(`#validationAlert_${day}`);

        // Form validation
        if (!form.course_name.value || !form.class.value || !form.room.value || !form.start_time.value || !form.end_time.value) {
            validationAlert.style.display = 'block';
            validationAlert.classList.add('show');
            validationAlert.innerHTML = '<i class="bi bi-exclamation-triangle"></i> Please fill in all required fields';
            return;
        }

        const courseSelect = form.course_name;
        const courseName = courseSelect.options[courseSelect.selectedIndex].text.split(' - ')[0];
        const className = form.class.value;

        // Check for existing course-class combination
        $.ajax({
            url: '/check-schedule',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                course_name: courseName,
                class_name: className,
                academic_year_id: '{{$latest_academic_year->id}}' // Add this line
            },
            success: function(response) {
                if (response.exists) {
                    validationAlert.style.display = 'block';
                    validationAlert.classList.add('show');
                    validationAlert.innerHTML = '<i class="bi bi-exclamation-triangle"></i> This course class already exists in current academic year';
                    return;
                }

                // If no duplicate found, proceed with course addition
                const formData = {
                    room_id: form.room.value,
                    course_department_detail_id: form.course_name.value,
                    name: form.class.value,
                    day: day.toLowerCase(),
                    start_time: form.start_time.value,
                    end_time: form.end_time.value,
                    _token: $('meta[name="csrf-token"]').attr('content')
                };

                $.ajax({
                    url: '/store-schedule',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        loadSchedulesFromDatabase();
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
        });
    }



    // New function to load schedules from database
    function loadSchedulesFromDatabase(isSubmitted = false) {
    $.ajax({
        url: '/get-schedules',
        type: 'GET',
        success: function(schedules) {
            ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'].forEach(day => {
                const scheduleBody = document.getElementById(`schedule-${day}`);
                scheduleBody.innerHTML = '';

                const daySchedules = schedules.filter(schedule =>
                    schedule.day.toLowerCase() === day.toLowerCase()
                );

                daySchedules.forEach(schedule => {
                    const deleteButton = `
                        <button class="btn btn-sm ${isSubmitted ? 'btn-secondary' : 'btn-danger'}"
                                ${isSubmitted ? 'disabled' : ''}
                                onclick="removeSchedule('${schedule.id}')">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;

                    const newRow = `
                        <tr>
                            <td>${schedule.start_time}</td>
                            <td>${schedule.end_time}</td>
                            <td>${schedule.course_name}</td>
                            <td>${schedule.name}</td>
                            <td>${schedule.room_name}</td>
                            <td>${deleteButton}</td>
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

    // Function to remove schedule
    function removeSchedule(scheduleId) {
        $('#modal_delete form').attr('action', '/delete-schedule/' + scheduleId);
        $('#modal_delete').modal('show');
    }
    $('#modal_delete form').on('submit', function(e) {
        e.preventDefault();
        const action = $(this).attr('action');

        $.ajax({
            url: action,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#modal_delete').modal('hide');
                loadSchedulesFromDatabase();
            }
        });
        return false;
    });


</script>

@endsection
