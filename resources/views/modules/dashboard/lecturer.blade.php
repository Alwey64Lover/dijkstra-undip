@extends('layouts.backend.app')
@section('title', 'Dashboard')

@section('content')
    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <div class="input-group mb-3">
                    <div class="search nim " style="width: 15%; margin-right: 5%">
                        <h6>NIM</h6>
                        <input type="text" class="form-control" aria-describedby="basic-addon2">
                        <img src="{{ asset('storage/static/magnifying-glass-solid.svg') }} " style=" position: relative; width: 25px; height: auto; float: right; top: -30px; left:-10px">
                    </div>
                    <div class="search nama" style="width: 15%; margin-right: 5%">
                        <h6>Nama</h6>
                        <input type="text" class="form-control" aria-describedby="basic-addon2">
                        <img src="{{ asset('storage/static/magnifying-glass-solid.svg') }} " style=" position: relative; width: 25px; height: auto; float: right; top: -30px; left:-10px">
                    </div>
                    <div class="search nama" style="width: 15%; margin-right: 5%">
                        <h6>Angkatan</h6>
                        <select class="form-control" aria-describedby="basic-addon2">
                            <option>2020</option>
                            <option>2021</option>
                            <option>2022</option>
                        </select>
                        <img src="{{ asset('storage/static/arrow-down.svg') }} " style=" position: relative; width: 25px; height: auto; float: right; top: -30px; left:-10px">
                    </div>
                  </div>
            </div>
        </div>
    </section>
@endsection
