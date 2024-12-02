<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .card .card:hover {
        box-shadow: 0 0 15px rgba(13, 110, 253, 0.2) !important;
        transform: translateY(-2px);
    }
</style>
<link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/public/assets/styles/choices.css') }}">

@extends('layouts.backend.app')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Available Courses</h4>
        <div class="d-flex gap-2">
            <select class="form-select" id="academicYearSelect" style="width: auto;">
                <option value="">Select Academic Year</option>
                @foreach($academic_years as $year)
                    <option value="{{ $year->id }}" {{ $year->id == $latest_academic_year_id ? 'selected' : '' }}>
                        {{ $year->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary" id="addNewCourseBtn">Add New Courses</button>
        </div>
    </div>
    <div class="card-body">
        <div class="row row-cols-1 row-cols-md-4 g-4">
        </div>
    </div>
</div>

<div class="modal fade" id="editCourseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editCourseForm">
                    @csrf
                    <input type="hidden" id="edit_course_id" name="course_id">
                    <div class="mb-3">
                        <label class="form-label">Course Name</label>
                        <input type="text" class="form-control" id="edit_course_name" name="name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Semester</label>
                        <input type="number" class="form-control" id="edit_semester" name="semester" min="1" max="8" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">SKS</label>
                        <input type="number" class="form-control" id="edit_sks" name="sks" min="1" max="6" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lecturer</label>
                        {{-- <select class="form-select" id="edit_lecturer_id" name="lecturer_id">
                            <option value="">Pilih Dosen Pengampu</option>
                            @foreach($lecturers as $lecturer)
                                <option value="{{ $lecturer->user_id }}">{{ $lecturer->user->name }}</option>
                            @endforeach
                        </select> --}}

                        <select class="form-select choices multiple-remove" multiple="multiple" id="edit_lecturer_id" name="lecturer_ids[]" required>
                            <option value="">Pilih Dosen Pengampu</option>
                            @foreach ($lecturers as $lecture)
                                <option value="{{ $lecture->user_id }}">{{ $lecture->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-danger" id="deleteCourseBtn">Delete Course</button>
                        <button type="submit" class="btn btn-primary">Update Course</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
{{-- <script src="{{ asset('assets/static/js/pages/form-element-select.js')}}"></script> --}}

<script>
    $(document).ready(function(){
        function updateAddNewCoursesButton() {
            const selectedAcademicYear = $('#academicYearSelect').val();
            const addNewCoursesBtn = $('#addNewCourseBtn');

            if (selectedAcademicYear == '{{ $latest_academic_year_id }}') {
                addNewCoursesBtn.prop('disabled', false);
                addNewCoursesBtn.removeClass('btn-secondary').addClass('btn-primary');
            } else {
                addNewCoursesBtn.prop('disabled', true);
                addNewCoursesBtn.removeClass('btn-primary').addClass('btn-secondary');
            }
        }

        // Call on page load
        updateAddNewCoursesButton();

        // Update when academic year selection changes
        $('#academicYearSelect').change(function() {
            updateAddNewCoursesButton();
        });
    });

    $(document).ready(function(){
        const academicYearId = $('#academicYearSelect').val();
        $.ajax({
            url: '{{ route('filtercourse') }}',
            type: 'GET',
            data: { academic_year_id: academicYearId },
            success: function(response) {
                const courseContainer = $('.row-cols-1');
                courseContainer.empty();

                console.log(response, '1aaaa');

                response.courses.forEach(course => {
                    const courseCard = `
                        <div class="col">
                            <div class="card h-100 shadow-sm border border-primary course-card"
                                style="border-width: 2px !important; transition: all 0.3s ease; cursor: pointer;"
                                data-course-id="${course.id}"
                                data-course-name="${course.course.name}"
                                data-course-semester="${course.semester}"
                                data-course-sks="${course.sks}"
                                data-lecturer-id="${course.lecturer_ids}">
                                <div class="card-body">
                                    <h5 class="card-title">${course.course.name}</h5>
                                    <div class="d-flex justify-content-between mt-3">
                                        <span class="badge bg-light-primary">Semester ${course.semester}</span>
                                        <span class="badge bg-light-success">${course.sks} SKS</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    courseContainer.append(courseCard);
                });
            }
        });
        $(document).on('change', '#academicYearSelect', function() {
            if($('#addCourseModal').is(':visible')) {
                const selectedAcademicYear = $(this).val();
                reloadAddCourseForm(selectedAcademicYear);
            }
        });

        function reloadAddCourseForm(academicYearId) {
            $.ajax({
                url: '{{ route('newcourse', ['action' => 'create']) }}',
                type: 'GET',
                data: { academic_year_id: academicYearId },
                success: function(response) {
                    $('#addCourseModal .modal-body').html(response);
                }
            });
        }
            // let lecturerChoices = document.querySelectorAll('#lecturers')
            // var cobaLecturer
            // for (let i = 0; i < lecturerChoices.length; i++) {
            //     if (lecturerChoices[i].classList.contains("multiple-remove")) {
            //         cobaLecturer = new Choices(lecturerChoices[i], {
            //             delimiter: ",",
            //             editItems: true,
            //             maxItemCount: -1,
            //             removeItemButton: true,
            //         })
            //     } else {
            //         cobaLecturer = new Choices(lecturerChoices[i])
            //     }
            // }
        $('#addNewCourseBtn').click(function(){
            const selectedAcademicYear = $('#academicYearSelect').val();
            $.ajax({
                url: '{{ route('newcourse', ['action' => 'create']) }}',
                type: 'GET',
                data: { academic_year_id: selectedAcademicYear },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if(!$('#addCourseModal').length) {
                        let modal = `
                            <div class="modal fade" id="addCourseModal" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Add New Course</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            ${response}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        $('body').append(modal);
                    } else {
                        $('#addCourseModal .modal-body').html(response);
                    }

                    let lecturerChoices = document.querySelectorAll('#lecturers')
                    var cobaLecturer
                    for (let i = 0; i < lecturerChoices.length; i++) {
                        (new Choices(lecturerChoices[i])).destroy()
                        if (lecturerChoices[i].classList.contains("multiple-remove")) {
                            cobaLecturer = new Choices(lecturerChoices[i], {
                                delimiter: ",",
                                editItems: true,
                                maxItemCount: -1,
                                removeItemButton: true,
                            })
                        } else {
                            cobaLecturer = new Choices(lecturerChoices[i])
                        }
                    }

                    $('#addCourseModal').modal('show');

                    // Handle form submission
                    $('#addCourseModal form').on('submit', function(e) {
                        e.preventDefault();
                        const formData = $(this).serialize();
                        const selectedAcademicYear = $('#academicYearSelect').val();

                        $.ajax({
                            url: $(this).attr('action'),
                            type: 'POST',
                            data: formData + '&academic_year_id=' + selectedAcademicYear,
                            success: function(response) {
                                console.log('Add course response:', response);
                console.log(response, '2aaaa');

                                location.reload();
                                let newCard = `
                                    <div class="col">
                                        <div class="card h-100 shadow-sm border border-primary course-card"
                                            style="border-width: 2px !important; transition: all 0.3s ease; cursor: pointer;"
                                            data-course-id="${response.id}"
                                            data-course-name="${response.name}"
                                            data-course-semester="${response.semester}"
                                            data-course-sks="${response.sks}"
                                            data-lecturer-id="${response.lecturer_ids}">
                                            <div class="card-body">
                                                <h5 class="card-title">${response.name}</h5>
                                                <div class="d-flex justify-content-between mt-3">
                                                    <span class="badge bg-light-primary">Semester ${response.semester}</span>
                                                    <span class="badge bg-light-success">${response.sks} SKS</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                $('.row-cols-1').append(newCard);
                                $('#addCourseModal').modal('hide');
                            }
                        });
                     });
                }
            });
        });
        $('#academicYearSelect').change(function() {
            const academicYearId = $(this).val();
            $.ajax({
                url: '{{ route('filtercourse') }}',
                type: 'GET',
                data: { academic_year_id: academicYearId },
                success: function(response) {
                    const courseContainer = $('.row-cols-1');
                    courseContainer.empty();


                    response.courses.forEach(course => {
                        const courseCard = `
                            <div class="col">
                                <div class="card h-100 shadow-sm border border-primary course-card"
                                    style="border-width: 2px !important; transition: all 0.3s ease; cursor: pointer;"
                                    data-course-id="${course.id}"
                                    data-course-name="${course.course.name}"
                                    data-course-semester="${course.semester}"
                                    data-course-sks="${course.sks}"
                                    data-lecturer-id="${course.lecturer_ids}">
                                    <div class="card-body">
                                        <h5 class="card-title">${course.course.name}</h5>
                                        <div class="d-flex justify-content-between mt-3">
                                            <span class="badge bg-light-primary">Semester ${course.semester}</span>
                                            <span class="badge bg-light-success">${course.sks} SKS</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        courseContainer.append(courseCard);
                    });
                }
            });
        });



        let choices = document.querySelectorAll('#edit_lecturer_id')
        var initChoice
            for (let i = 0; i < choices.length; i++) {
                if (choices[i].classList.contains("multiple-remove")) {
                    initChoice = new Choices(choices[i], {
                        delimiter: ",",
                        editItems: true,
                        maxItemCount: -1,
                        removeItemButton: true,
                    })
                } else {
                    initChoice = new Choices(choices[i])
                }
            }

        $(document).on('click', '.course-card', function(){
            let courseId = $(this).data('course-id');
            let courseName = $(this).data('course-name');
            let semester = $(this).data('course-semester');
            let sks = $(this).data('course-sks');
            let lecturerId = ($(this).data('lecturer-id')).split(',');
            // Populate modal fields
            $('#edit_course_id').val(courseId);
            $('#edit_course_name').val(courseName);
            $('#edit_semester').val(semester);
            $('#edit_sks').val(sks);

            $('#editCourseModal').modal('show');
            // $('#edit_lecturer_id').val(lecturerId).trigger('change');

            initChoice.destroy();
            $('#edit_lecturer_id')?.choices?.destroy();

            let choices = document.querySelectorAll('#edit_lecturer_id')
            for (let i = 0; i < choices.length; i++) {
                if (choices[i].classList.contains("multiple-remove")) {
                    initChoice = new Choices(choices[i], {
                        delimiter: ",",
                        editItems: true,
                        maxItemCount: -1,
                        removeItemButton: true,
                    })
                } else {
                    initChoice = Choices(choices[i])
                }
            }

            $('#edit_lecturer_id').val(lecturerId).trigger('change');

            initChoice.setChoiceByValue(lecturerId);
        });



        // Handle form submission for updating
        $('#editCourseForm').on('submit', function(e){
            e.preventDefault();

            $.ajax({
                url: "{{ route('updatecourse', '') }}/" + $('#edit_course_id').val(),
                type: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

        $('#modal_delete form').on('submit', function(e) {
            e.preventDefault();
            let courseId = $('#edit_course_id').val();

            $.ajax({
                url: $(this).attr('action'),
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#modal_delete').modal('hide');
                    // Remove the course card from the DOM
                    $(`.course-card[data-course-id="${courseId}"]`).closest('.col').fadeOut(300, function() {
                        $(this).remove();
                    });
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });


        // Update the delete button click handler
        $('#deleteCourseBtn').click(function(){
            let courseId = $('#edit_course_id').val();
            console.log('Deleting course ID:', courseId);
            $('#modal_delete form').attr('action', "{{ route('deletecourse', '') }}/" + courseId);
            $('#modal_delete').modal('show');
            $('#editCourseModal').modal('hide');
        });
    });
</script>
@include('components.modal.modal-delete')
@endsection
