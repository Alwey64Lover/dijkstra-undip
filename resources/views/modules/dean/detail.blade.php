@extends('layouts.backend.app')
@include('components.modal.modal-delete')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">Jadwal Mata Kuliah Tahun Ajaran {{academicYear()->name}} - Departemen {{ @$courseDepartment->department->name }}</h4>

            @if ($courseDepartment->is_submitted)
                @if($courseDepartment->action_name != 'accepted')
                    <a class="ms-auto" href='{{ route('department-schedule.accept-or-reject', ['status' => 'accepted', 'id' => $courseDepartment->id]) }}'>
                        <button class="btn btn-success" >Setujui Jadwal</button>
                    </a>
                @else
                    <a href='{{ route('department-schedule.accept-or-reject', ['status' => 'waiting', 'id' => $courseDepartment->id]) }}'>
                        <button class="btn btn-danger">Batalkan Jadwal</button>
                    </a>
                @endif
            @endif
        </div>
        <div class="card-body">
            @php
                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                $hari = ['Monday'=>'Senin', 'Tuesday'=>'Selasa', 'Wednesday'=>'Rabu', 'Thursday'=>'Kamis', 'Friday'=>'Jumat'];
            @endphp

            @foreach($days as $day)
                <div class="day-section mb-4">
                    <div class="d-flex align-items-center mb-2">
                        <h5 class="text-primary mb-0 me-2">{{ $hari[$day] }}</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Waktu Mulai</th>
                                    <th>Waktu Selesai</th>
                                    <th>Mata Kuliah</th>
                                    <th>Kelas</th>
                                    <th>Ruangan</th>
                                </tr>
                            </thead>
                            <tbody id="schedule-{{ $day }}">
                                <!-- Dynamic content will be added here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection


<script>
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
                academic_year_id: '{{academicYearId()}}' // Add this line
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
    function loadSchedulesFromDatabase() {
        $.ajax({
            url: '/get-schedules-dean',
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
                            <button class="btn btn-sm ${schedule.is_submitted ? 'btn-secondary' : 'btn-danger'}"
                                    ${schedule.is_submitted ? 'disabled' : ''}
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
