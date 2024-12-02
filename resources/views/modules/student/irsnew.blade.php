@extends('layouts.backend.app')

<style>
.container {
    padding-right: 0px;
    padding-left: 0px;
}
.course-card {
    padding: 10px;
    color: white;
    border-radius: 5px;
    margin-bottom: 5px;
    font-size: 0.9em;
    cursor: pointer;
}
.alert-info{
    height: 90px;
    padding-top: 10px;
}
.lead { color: #6f7071; }
.bg-success { background-color: #28a745 !important; } /* Green */
.bg-secondary2 { background-color: #eeeeee !important; } /* Gray */

.floating-button {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000; /* Pastikan elemen berada di atas konten lainnya */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.floating-button a {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 72px;
    height: 72px;
    font-size: 24px;
    text-decoration: none;
    background-color: #28a745; /* Warna hijau */
    transition: background-color 0.3s;
}

.floating-button a:hover {
    background-color: #218838; /* Warna hijau lebih gelap saat hover */
}

</style>

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/public/assets/styles/choices.css') }}">
@endpush

@section('content')
<div class="container card card-body">
    {{-- <div class="gap-3 mb-3"> --}}
        {{-- <select class="form-select" aria-label="Pilih Mata Kuliah">
            <option selected>Pilih Mata Kuliah</option>
            @php
                $groupedCourses = $availablecourses->groupBy(fn($course) => $course->courseClass->CourseDetail->semester);
            @endphp
            @foreach ($groupedCourses as $semester => $courses)
                <optgroup label="Semester {{ $semester }}">
                    @foreach ($courses as $course)
                        <option value="{{ $course->courseClass->CourseDetail->course->code }}">
                            {{ $course->courseClass->CourseDetail->course->name }} - {{ $course->courseClass->CourseDetail->sks }} SKS
                        </option>
                    @endforeach
                </optgroup>
            @endforeach
        </select> --}}
    @if (activeIrs()->is_submitted)
        <div class="alert alert-info bg-secondary2">
            <h3>
                <i class="bi bi-info-circle"></i>
                Info
            </h3>
            <p class="lead">
                IRS sudah disubmit. Apabila ingin merubah IRS, silahkan hubungi dosen wali.
            </p>
        </div>
    @else
        <div class="form-group choices-container">
            <select class="form-select choices multiple-remove" multiple="multiple" onchange="fetchCourseClass()" name="course_ids">
                <option value="" disabled>Pilih Mata Kuliah</option>
                @foreach ($availablecourses as $semester => $courseDetails)
                    <optgroup label="Semester {{ $semester }}">
                        @foreach ($courseDetails as $courseDetail)
                            @php
                                // Tentukan apakah course ini memiliki relasi di IrsDetail
                                $isNotRemoved = \App\Models\IrsDetail::
                                    where(function ($query) use($courseDetail) {
                                        $query->whereHas('courseClass', function($query) use($courseDetail) {
                                            $query->whereHas('courseDepartmentDetail', function($query) use($courseDetail) {
                                                $query->where('id', $courseDetail->id);
                                            });
                                        });
                                    })
                                    ->where('irs_id', activeIrs()->id)
                                    ->with('courseClass.CourseDepartmentDetail.course')
                                    ->first();
                            @endphp

                            <option value="{{ $courseDetail->id }}"
                                {{ in_array($courseDetail->id, json_decode($irsTemporaries->course_ids ?? '') ?? []) ? 'selected' : '' }}
                                data-custom-properties = '{"removed": {{ $isNotRemoved ? "false" : "true" }}}'
                            >
                                {{ $courseDetail->course->name }} - {{ $courseDetail->sks }} SKS
                            </option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>


        <div class="alert alert-info bg-secondary2">
            <h3>
                <i class="bi bi-info-circle"></i>
                Info
            </h3>
            <p class="lead">
                Mata Kuliah selain semester saat ini akan dibuka pada 8 Agustus 2024.
            </p>
        </div>
        <div class="col-12 d-flex align-items-center mb-3">
            <div class="col-10 d-flex gap-2">
                <span class="badge bg-success" style="width: 25px">  </span>Diambil
                <span class="badge bg-danger" style="width: 25px">  </span>Tidak bisa diambil, karena tabrakan
                <span class="badge bg-warning" style="width: 25px">  </span>Belum diambil
                <span class="badge bg-secondary" style="width: 25px">  </span>Tidak bisa diambil, karena sudah diambil di jadwal lain
            </div>
            <div class="col-2">
                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#submitIrs">
                    Submit IRS
                </button>
            </div>
        </div>
        <!-- Existing Timetable Table -->
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>WAKTU</th>
                        <th>SENIN</th>
                        <th>SELASA</th>
                        <th>RABU</th>
                        <th>KAMIS</th>
                        <th>JUM'AT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($timeSlots as $time)
                        <tr>
                            <td>{{ $time }}:00</td>
                            @foreach ($days as $keyDay => $day)
                                <td data-date="{{ $keyDay }} - {{$time}}" class="time-slot">
                                    {{-- @if (isset($schedule[$day][$time]))
                                        <div class="course-card bg-{{ $schedule[$day][$time]['color'] }}"
                                            data-name="{{ $schedule[$day][$time]['name'] }}"
                                            data-status="{{ $schedule[$day][$time]['status'] }}"
                                            data-sks="{{ $schedule[$day][$time]['sks'] }}"
                                            data-time="{{ $schedule[$day][$time]['time'] }}"
                                            data-class="{{ $schedule[$day][$time]['class'] }}">
                                            <strong>{{ $schedule[$day][$time]['name'] }}</strong><br>
                                            <span>{{ $schedule[$day][$time]['status'] }}</span><br>
                                            <span>{{ $schedule[$day][$time]['sks'] }} SKS</span><br>
                                            <span>{{ $schedule[$day][$time]['time'] }} (Kelas {{ $schedule[$day][$time]['class'] }})</span>
                                        </div>
                                    @endif --}}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="floating-button rounded-circle">
            <a href="#" class="btn btn-success rounded-circle">
                <div id="sks-counter">
                    0/24
                </div>
            </a>
        </div>
    @endif

    @include('components.modal.addcourse-modal')
    @include('components.modal.modal-submit-irs')
</div>
@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
<script src="{{ asset('assets/static/js/pages/form-element-select.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.30.1/moment.min.js"></script>
<script>
$(document).ready(function() {
    // Gunakan event delegation untuk menangani klik pada course-card
    $(document).on('click', '.course-card', function() {
        console.log($(this).data('status-color'));
        if ($(this).data('status-color') == 'success' || $(this).data('status-color') == 'warning') {
            const courseName = $(this).data('course-name');
            const sks = $(this).data('sks');
            const status = $(this).data('status');
            const time = $(this).data('time');
            const classCode = $(this).data('class');
            const courseClassId = $(this).data('course-id');
            const uriForm = $(this).data('uri-form');

            $('#courseName').text(courseName);
            $('#courseSKS').text(sks);
            $('#courseStatus').text(status);
            $('#courseTime').text(time);
            $('#courseClass').text(classCode);
            $('input[name="courseClassId"]').val(courseClassId);
            $('#formHandleCourse').attr('action', uriForm);

            $('#courseModal').modal('show');
        }
    });

    $(document).on('click focus', function(){
        styling()
    })

    $(document).on('focus', '.choices__inner', function() {
        styling()
    });

    fetchCourseClass();
});

function styling(){
    let options = $("select[name='course_ids'] option");

    options.each(function(index, option){
        let removed = $(option).data('custom-properties').removed;

        console.log($(option).data('custom-properties').removed)
        if(!removed){
            // $(option + ' .choices__button').hide();
            $('div[data-value="'+$(option).val()+'"]').removeAttr('data-deletable');
            $('div[data-value="'+$(option).val()+'"] .choices__button').hide();
        }
    });
}

function fetchCourseClass() {
    styling();

    const courseIds = $("select[name='course_ids']").val();

    $.ajax({
        url: "{{route('irs.get-course-class')}}",
        type: "GET",
        data: { courseIds: courseIds },
        beforeSend: function() {
            $('.time-slot').html('');
        },
        success: function(response) {
            let totalSks = 0;

            Object.entries(response).forEach(([date, courses]) => {
                let html = '';

                courses.forEach(course => {
                    totalSks += course.status_color == 'success' ? course?.course_department_detail?.sks : 0;
                    let uriForm = ("{{ route('irs.action', ':action') }}").replace(':action', course.status_color == 'success' ? 'delete' : 'add');
                    html += `
                        <div class="course-card bg-${course.status_color}"
                             data-course-id="${course?.id}"
                             data-course-name="${course?.course_department_detail?.course?.name}"
                             data-status="${course?.course_department_detail?.status == 'mandatory' ? 'wajib' : 'pilihan'}"
                             data-sks="${course.course_department_detail?.sks}"
                             data-time="${formatTime(course.start_time)} - ${formatTime(course.end_time)}"
                             data-class="${course.name}"
                             data-status-color="${course.status_color}"
                             data-uri-form="${uriForm}">
                            <strong>${course?.course_department_detail?.course?.name}</strong><br>
                            <span>${course?.course_department_detail?.status}</span><br>
                            <span>${course.course_department_detail?.sks} SKS</span><br>
                            <span>${formatTime(course.start_time)} - ${formatTime(course.end_time)} (Kelas ${course.name})</span>
                        </div>
                    `;
                });

                $('td[data-date="' + date + '"]').html(html);
            });


            $('#sks-counter').text(totalSks + '/24');
        },
        error: function(xhr) {
            console.error('Error fetching data:', xhr);
        }
    });
}function formatTime(time){
    return moment(time, 'HH:mm:ss').format('HH:mm')
}

</script>
@endpush
@endsection
