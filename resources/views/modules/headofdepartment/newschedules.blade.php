@extends('layouts.backend.app')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Course Schedule Genap 2025/2026</h4>
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
                                <th>Time</th>
                                <th>Course</th>
                                <th>Class</th>
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
                                    <input type="text" class="form-control" name="course_name" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Class</label>
                                    <input type="text" class="form-control" name="class" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Start Time</label>
                                    <select class="form-control" name="start_time" required>
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
    function addCourse(day) {
        const form = document.getElementById(`courseForm${day}`);
        const scheduleBody = document.getElementById(`schedule-${day}`);

        const startTime = form.start_time.value;
        const courseName = form.course_name.value;
        const className = form.class.value;

        const newRow = `
            <tr data-time="${startTime}">
                <td>${startTime}</td>
                <td>${courseName}</td>
                <td>${className}</td>
                <td>
                    <button class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `;

        // Add the new row
        scheduleBody.insertAdjacentHTML('beforeend', newRow);

        // Sort all rows by time
        const rows = Array.from(scheduleBody.getElementsByTagName('tr'));
        rows.sort((a, b) => {
            const timeA = a.getAttribute('data-time');
            const timeB = b.getAttribute('data-time');
            return timeA.localeCompare(timeB);
        });

        // Clear and re-append sorted rows
        scheduleBody.innerHTML = '';
        rows.forEach(row => scheduleBody.appendChild(row));

        $(`#addCourseModal${day}`).modal('hide');
        form.reset();
    }
</script>

@endsection
