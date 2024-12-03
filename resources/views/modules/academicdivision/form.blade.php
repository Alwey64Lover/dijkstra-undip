@extends('layouts.backend.app')

@section('title', $title)

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ $title }}</h4>
            </div>

            <div class="card-content">
                <div class="card-body">
                    <form action="{{ route('simpan-room') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                          <label for="" class="form-label">Gedung</label>
                          <input type="text" name="type" class="form-control" value="">
                        </div>
                        <div class="mb-3">
                          <label for="" class="form-label">Nama</label>
                          <input type="text" name="name" class="form-control" value="">
                        </div>
                        <div class="mb-3">
                          <label for="" class="form-label">Kapasitas</label>
                          <input type="number" name="capacity" class="form-control" value="">
                        </div>
                        <div class="mb-3">
                            <label for="">Pilih Departemen</label>
                            <select name="departement" id="" class="form-control">
                                <option value="Informatika">Informatika</option>
                                <option value="Kimia">Kimia</option>
                                <option value="Fisika">Fisika</option>
                                <option value="Biologi">Biologi</option>
                                <option value="Statistika">Statistika</option>
                                <option value="Matematika">Matematika</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal">Simpan Data</button>
                        <a type="button" class="btn btn-outline-dark menu-link" href="{{ route('dashboard') }}">Batal</a>
                      </form>
                </div>
            </div>
        </div>
    </div>
@endsection
