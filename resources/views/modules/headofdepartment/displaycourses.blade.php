<style>
    .card .card:hover {
        box-shadow: 0 0 15px rgba(13, 110, 253, 0.2) !important;
        transform: translateY(-2px);
    }
</style>
@extends('layouts.backend.app')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Available Courses</h4>
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
@endsection
