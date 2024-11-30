{{-- @dd($dataRoom); --}}
@extends('layouts.backend.app')
@section('title', 'Dashboard')
@section('content')
    <section class="section dashboard" id="dashboard-container">
        <h2>Selamat Datang</h2>
        <!-- Sidebar section -->
        <div class="sidebar">
            <table class="table table-striped table-hover" style="table-layout: fixed">
                <thead class="bg-primary">
                    <tr>
                        <th class="text-light">No</th>
                        <th class="text-light">Nama</th>
                        <th class="text-light">Kapasitas</th>
                        <th class="text-light">Departemen</th>
                        <th class="text-light"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataRoom as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->type }}{{ $data->name }}</td>
                            <td>{{ $data->capacity }}</td>
                            <td>{{ $data->department }}</td>
                            <td style="text-align:right;">
                                <a href=""
                                    class="btn btn-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteModal"
                                    data-id="{{ $data->id }}"
                                ><i class="bi bi-trash"></i></a>
                                <a href=""
                                    class="btn btn-warning"><i class="bi bi-pen"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal"
                                    data-id="{{ $data->id }}"
                                    data-name="{{ $data->name }}"
                                    data-type="{{ $data->type }}"
                                    data-capacity="{{ $data->capacity }}"
                                    data-department="{{ $data->department }}"
                                ></i></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
    <div id="form-container" style="display:none;"></div>

    <!-- Modal Edit -->
    {{-- <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="editName" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editCapacity" class="form-label">Kapasitas</label>
                            <input type="number" class="form-control" id="editCapacity" name="capacity" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDepartment" class="form-label">Departemen</label>
                            <input type="text" class="form-control" id="editDepartment" name="department" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data ini?</b> ?</p>
                    <form id="deleteForm" method="POST" action="{{ route('room-destroy', ['id' => $data->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
