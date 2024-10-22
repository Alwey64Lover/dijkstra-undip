@extends('layouts.backend.app')

@section('title', 'Tambah Mata Kuliah')

@section('content')
    @include('modules.courses.addcoursedeptdetail')
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var cancelBtn = document.getElementById('cancel-button');
        var formContainer = document.getElementById('form-container');

        cancelBtn.addEventListener('click', function (event) {
            event.preventDefault();
            window.location.href = '/dashboard';
        });
    });
</script>
