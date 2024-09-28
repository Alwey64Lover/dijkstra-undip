<style>
    .search{
        width: 15%;
        margin-right: 5%;
    }
    .search-icon{
        position: relative;
        width: 25px;
        height: auto;
        float: right;
        top: -30px;
        left:-10px
    }
    .table-contents{
        position: relative;
        height:40px;
        line-height:40px;
    }
    h6.search-label{
        position: relative;
        right: -12px;
    }
</style>

@extends('layouts.backend.app')
@section('title', 'Dashboard')

@section('content')
    <section class="section dashboard">
        <div class="card">
            {{-- Search bars [start] --}}
            <div class="card-body">
                <div class="input-group mb-3">
                    <div class="search nim">
                        <label for="search-nim">
                            <h6 class="search-label">NIM</h6>
                            <input type="text" class="form-control rounded-pill" id="search-nim" aria-describedby="basic-addon2" style="background-color: #D9D9D9">
                            <img class="search-icon" src="{{ asset('storage/static/magnifying-glass-solid.svg') }} " >
                        </label>
                    </div>
                    <div class="search nama">
                        <label for="search-nama">
                            <h6 class="search-label">Nama</h6>
                            <input type="text" class="form-control rounded-pill" id="search-nama" aria-describedby="basic-addon2" style="background-color: #D9D9D9">
                            <img class="search-icon" src="{{ asset('storage/static/magnifying-glass-solid.svg') }} ">
                        </label>
                    </div>
                    <div class="search nama">
                            <h6 class="search-label">Angkatan</h6>
                            <select class="form-control rounded-pill" aria-describedby="basic-addon2" style="background-color: #D9D9D9">
                                <option>2020</option>
                                <option>2021</option>
                                <option>2022</option>
                            </select>
                            <img class="search-icon" src="{{ asset('storage/static/arrow-down.svg') }} ">
                    </div>
                  </div>
            </div>
            {{-- Search bars [end] --}}

            {{-- List of Students [start] --}}
            <div class="container">
                <div class="row">
                    <div class="col-1">
                    </div>
                    <div class="col-2">
                        <h6>NIM</h6>
                    </div>
                    <div class="col-3">
                        <h6>Nama</h6>
                    </div>
                    <div class="col-2">
                        <h6>Angkatan</h6>
                    </div>
                    <div class="col">
                        <h6>Email</h6>
                    </div>
                    <div class="col-1">
                    </div>
                </div>
                <hr style="margin-top: -4px">
                @foreach ($students as $student)
                    <div class="row">
                        <div class="col-1">
                            <div class="avatar avatar-md2" >
                                <img src="{{ asset('assets/compiled/jpg/1.jpg') }}" alt="Avatar">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="table-contents">{{ $student->nim }}</div>
                        </div>
                        <div class="col-3">
                            <div class="table-contents">{{ $student->user->name }}</div>
                        </div>
                        <div class="col-2">
                            <div class="table-contents">{{ $student->year }}</div>
                        </div>
                        <div class="col">
                            <div class="table-contents">{{ $student->user->email }}</div>
                        </div>
                        <div class="col-1">
                            <button type="button" class="btn btn-primary">Detail</button>
                        </div>
                    </div>
                    <hr>
                    @endforeach

            </div>
            {{-- List of Students [end] --}}
        </div>
    </section>
@endsection
