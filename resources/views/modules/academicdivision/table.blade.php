@extends('layouts.backend.app')

@section('title', 'Ruangan')

@include('assets.table.datatable')
@include('components.modal.modal-delete')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <a href="{{ route('add-room') }}" class="btn icon icon-left btn-success" data-bs-toggle-tooltip="tooltip" data-bs-placement="right" title="Add">
                    <i class="bi bi-plus-circle"></i>
                    New Room
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kapasitas</th>
                                <th>Departemen</th>
                                <th style="width: 300px"></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($columns as $column)
                                <tr>
                                    <td style="width: 75px">{{ $loop->iteration }}</td>
                                    <td>{{ $column->type }}{{ $column->name }}</td>
                                    <td>{{ $column->capacity }}</td>
                                    <td>{{ $column->department }}</td>
                                    <td >
                                        <div>
                                            @if ($column->isSubmitted == 'sudah')
                                            <button
                                            class="btn btn-danger"
                                            data-id="{{ $column->id }}"
                                            onclick="deleteRoom(this)"
                                        >
                                            <i class="bi bi-trash"></i>
                                            Hapus
                                        </button>

                                        <a href="{{ route('edit-room', $column->id) }}"
                                                class="btn btn-warning"><i class="bi bi-pen"
                                            ></i>
                                            Edit
                                        </a>

                                        <a href="{{ route('room.submit', $column->id) }}" class="btn icon icon-left btn-primary" data-bs-toggle-tooltip="tooltip" data-bs-placement="bottom" title="Submit">
                                            <i class="bi bi-check2-circle"></i>
                                            Submit Ruang
                                        </a>
                                            @else
                                                Sudah Submit
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>


    <script>
        function deleteRoom(button) {
            const roomId = $(button).data('id'); // Ambil ID dari atribut data-id
            console.log("Room ID:", roomId);
            $('#modal_delete form').attr('action', '/delete/' + roomId);
            $('#modal_delete').modal('show');
        }
    </script>
@endsection
