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
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col"><h6>NIM</h6></th>
                        <th scope="col"><h6>Nama</h6></th>
                        <th scope="col"><h6>Angkatan</h6></th>
                        <th scope="col"><h6>Email</h6></th>
                        <th scope="col"><h6></h6></th>
                    </tr>
                </thead>
                @foreach ($students as $student)
                    <tbody>
                        <tr>
                            <th scope="row">
                                <div class="avatar avatar-md2" >
                                    <img src="{{ asset('assets/compiled/jpg/1.jpg') }}" alt="Avatar">
                                </div>
                            </th>
                            <td>
                                <div class="table-contents">{{ $student->nim }}</div>
                            </td>
                            <td>
                                <div class="table-contents">{{ $student->user->name }}</div>
                            </td>
                            <td>
                                <div class="table-contents">{{ $student->year }}</div>
                            </td>
                            <td>
                                <div class="table-contents">{{ $student->user->email }}</div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary">Detail</button>
                            </td>
                        </tr>
                @endforeach
                </tbody>
            </table>
            {{-- List of Students [end] --}}
        </div>
    </section>
@endsection
