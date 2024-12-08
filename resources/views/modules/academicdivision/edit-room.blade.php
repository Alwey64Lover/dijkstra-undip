@extends('layouts.backend.app')
@section('title', 'Dashboard')
@section('content')
    <section class="section dashboard" id="dashboard-container">
        <!-- Sidebar section -->
        <div class="sidebar">
            <form action="{{ route('update-room', $data->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                  <label for="" class="form-label">Gedung</label>
                  <input type="text" name="type" class="form-control" value="{{ $data->type }}">
                </div>
                <div class="mb-3">
                  <label for="" class="form-label">Nama</label>
                  <input type="text" name="name" class="form-control" value="{{ $data->name }}">
                </div>
                <div class="mb-3">
                  <label for="" class="form-label">Kapasitas</label>
                  <input type="number" name="capacity" class="form-control" value="{{ $data->capacity }}">
                </div>
                <div class="mb-3">
                    <label for="">Pilih Departemen</label>
                    <select name="departement" id="">
                        <option value="Informatika">Informatika</option>
                        <option value="Kimia">Kimia</option>
                        <option value="Fisika">Fisika</option>
                        <option value="Biologi">Biologi</option>
                        <option value="Statistika">Statistika</option>
                        <option value="Matematika">Matematika</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" >Simpan Data</button>
                <a type="button" class="btn btn-outline-dark menu-link" href="{{ route('dashboard') }}">Batal</a>
              </form>
        </div>
    </section>
    <!-- Modal -->

@endsection
