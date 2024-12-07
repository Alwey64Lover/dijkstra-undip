@extends('layouts.backend.app')

@section('title', 'Ruangan')

@include('assets.table.datatable')
@include('components.modal.modal-delete')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                @if (user()->role == 'academic_division')
                <a href="{{ route('add-room') }}" class="btn icon icon-left btn-success" data-bs-toggle-tooltip="tooltip" data-bs-placement="right" title="Add">
                    <i class="bi bi-plus-circle"></i>
                    Ruangan Baru
                </a>
                @endif
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
                                            @if (user()->role == 'academic_division')
                                                @if ($column->isSubmitted == 'belum')
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
                                                     <a href="{{ route('cancel-room', $column->id) }}" class="btn btn-danger"><i class="bi bi-x-circle"></i> Batalkan</a> Sudah submit
                                                @endif
                                            @else
                                                @if ($column->status == 'accepted')
                                                    Sudah Di Setujui
                                                @else
                                                    <a href="{{ route('academic-room.accept', $column->id) }}" class="btn icon icon-left btn-success" data-bs-toggle-tooltip="tooltip" data-bs-placement="bottom" title="Setujui">
                                                        <i class="bi bi-check2-circle"></i>
                                                        Setujui Ruang
                                                    </a>
                                                @endif
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
