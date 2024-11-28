<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .card .card:hover {
        box-shadow: 0 0 15px rgba(13, 110, 253, 0.2) !important;
        transform: translateY(-2px);
    }
</style>
@extends('layouts.backend.app')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Available Courses</h4>
        <button type="submit" class="btn btn-primary" id="addNewCourseBtn">Add New Courses</button>
    </div>
    <div class="card-body">
        <div class="row row-cols-1 row-cols-md-4 g-4">
            @foreach($existing_dept_courses as $course)
                <div class="col">
                    <div class="card h-100 shadow-sm border border-primary course-card"
                        style="border-width: 2px !important; transition: all 0.3s ease; cursor: pointer;"
                        data-course-id="{{ $course->id }}"
                        data-course-name="{{ $course->course->name }}"
                        data-course-semester="{{ $course->semester }}"
                        data-course-sks="{{ $course->sks }}"
                        data-lecturer-id="{{ $course->lecturer_id }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $course->course->name }}</h5>
                            <div class="d-flex justify-content-between mt-3">
                                <span class="badge bg-light-primary">Semester {{ $course->semester }}</span>
                                <span class="badge bg-light-success">{{ $course->sks }} SKS</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
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
                        <select class="form-select" id="edit_lecturer_id" name="lecturer_id">
                            <option value="">Pilih Dosen Pengampu</option>
                            @foreach($lecturers as $lecturer)
                                <option value="{{ $lecturer->user_id }}">{{ $lecturer->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Update Course</button>
                        <button type="button" class="btn btn-danger" id="deleteCourseBtn">Delete Course</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#addNewCourseBtn').click(function(){
            $.ajax({
                url: '{{ route('newcourse', ['action' => 'create']) }}',
                type: 'GET',
                success: function(response) {
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

                    if(!$('#addCourseModal').length) {
                        $('body').append(modal);
                    }

                    $('#addCourseModal').modal('show');

                    // Handle form submission
                    $('#addCourseModal form').on('submit', function(e) {
                        e.preventDefault();
                        $.ajax({
                            url: $(this).attr('action'),
                            type: 'POST',
                            data: $(this).serialize(),
                            success: function(response) {
                                // Add new course card
                                let newCard = `
                                    <div class="col">
                                        <div class="card h-100 shadow-sm border border-primary" style="border-width: 2px !important; transition: all 0.3s ease;">
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
        $('.course-card').click(function(){
            let courseId = $(this).data('course-id');
            let courseName = $(this).data('course-name');
            let semester = $(this).data('course-semester');
            let sks = $(this).data('course-sks');
            let lecturerId = $(this).data('course-lecturer-id')

            // Populate modal fields
            $('#edit_course_id').val(courseId);
            $('#edit_course_name').val(courseName);
            $('#edit_semester').val(semester);
            $('#edit_sks').val(sks);
            $('#edit_lecturer_id').val(lecturerId);

            $('#editCourseModal').modal('show');
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

        // Handle delete button click
        $('#deleteCourseBtn').click(function(){
            if(confirm('Are you sure you want to delete this course?')){
                $.ajax({
                    url: "{{ route('deletecourse', '') }}/" + $('#edit_course_id').val(),
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response){
                        location.reload();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });


    });
</script>
@endsection
