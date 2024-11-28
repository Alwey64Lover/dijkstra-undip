<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    <div class="card h-100 shadow-sm border border-primary" style="border-width: 2px !important; transition: all 0.3s ease;">
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
    });

</script>
@endsection
