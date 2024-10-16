{{-- @dd($khs) --}}

@extends('layouts.backend.app')

@include('assets.table.datatable')

@section('title', $title)

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header col-12 mb-3">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="avatar avatar-md2" >
                        <img src="{{ asset('assets/compiled/jpg/1.jpg') }}" alt="Avatar">
                    </div>
                    <h6 style="margin: 0">{{ $student->nim }}</h6>
                    <img src="{{ asset('storage/static/pipe.svg') }} ">
                    <h6 style="margin: 0">{{ $student->user->name }}</h6>
                    <button class="ms-auto btn btn-primary">Cetak Transkrip Keseluruhan</button>
                </div>
                <select class="form-select mb-5" aria-label="Default select example" style="width: 230.38px">
                    <option>Semester 1</option>
                    <option>Semester 2</option>
                    <option>Semester 3</option>
                    <option selected>Semester 4</option>
                </select>
                <a href="./irs"><button id="irs-button" class="ms-auto btn btn-outline-primary rounded-pill me-2" style="width: 230.38px">IRS</button></a>
                <button id="khs-button" class="ms-auto btn btn-primary rounded-pill" style="width: 230.38px">KHS</button>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Mata Kuliah</th>
                                <th>Status</th>
                                <th>SKS</th>
                                <th>Nilai (Bobot)</th>
                                <th>SKS x Bobot</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($khs as $mk)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>kontol</td>
                                    <td>kontol</td>
                                    <td>kontol</td>
                                    <td>kontol</td>
                                    <td>{{ $mk->score }}</td>
                                    <td>kontol</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Data tidak ada</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

{{-- <div class="input-group mb-3">
    <div class="search nim">
        <label for="search-nim">
            <h6 class="search-label">NIM</h6>
            <input type="text" class="form-control rounded-pill" id="search-nim" aria-describedby="basic-addon2" style="background-color: #D9D9D9" onkeyup="searchStudent()">
            <img class="search-icon" src="{{ asset('storage/static/magnifying-glass-solid.svg') }} " >
        </label>
    </div>
    <div class="search name">
        <label for="search-name">
            <h6 class="search-label">Nama</h6>
            <input type="text" class="form-control rounded-pill" id="search-name" aria-describedby="basic-addon2" style="background-color: #D9D9D9" onkeyup="searchStudent()">
            <img class="search-icon" src="{{ asset('storage/static/magnifying-glass-solid.svg') }} ">
        </label>
    </div>
    <div class="search year">
            <h6 class="search-label">Angkatan</h6>
            <select class="form-control rounded-pill" id="search-year" aria-describedby="basic-addon2" style="background-color: #D9D9D9" onchange="searchStudent()">
                <option value="">Semua Angkatan</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
            </select>
            <img class="search-icon" src="{{ asset('storage/static/arrow-down.svg') }} ">
    </div>
</div> --}}