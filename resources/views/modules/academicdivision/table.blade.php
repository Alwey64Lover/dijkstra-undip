@extends('layouts.backend.app')

@section('title', 'Ruangan')

{{-- @include('assets.table.datatable') --}}
@include('components.modal.modal-delete')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/compiled/css/table-datatable-jquery.css') }}">

<script src="{{ asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>

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
                <form action="{{ route('academic-room.accept-some') }}" method="post">
                    @csrf
                    <div class="d-flex justify-content-end">
                        <button disabled id="select-button" class="btn btn-success mb-4" data-bs-toggle="tooltip" data-bs-placement="bottom" title="IRS yang disetujui akan dijalankan mahasiswa untuk semester ini.">Setujui Ruangan Terpilih</button>
                    </div>
                    <div class="table-responsive">
                        <table id="datatable" class="table">
                            <thead>
                                <tr>
                                    @if (user()->role === 'dean')
                                        <th>
                                            <input type="checkbox" id="select-all" class="form-check-input">
                                        </th>
                                    @endif
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
                                        @if (user()->role === "dean")
                                            <td>
                                                @if($column->status != "accepted")
                                                    <input type="checkbox" data-room-id={{ $column->id }} class="form-check-input select-row">
                                                @endif
                                            </td>
                                        @endif
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
                </form>
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

        @if (
            user()->role === "dean"
        )
        $('#datatable').DataTable({
            order: [[1, 'asc']],
            columnDefs: [{
                orderable: false,
                targets: 0
            }],
            responsive: false
        });
        @else
        $('#datatable').DataTable({
            responsive: false
        });
        @endif

        let selectedRooms = new Set(), allRooms = new Set(@json($columns->where('status','!=', 'accepted')->pluck('id')));

        $('#select-all').on('change', function () {
            const isChecked = $(this).is(':checked');
            $('.select-row').each(function () {
                $(this).prop('checked', isChecked);
            });
            selectedRooms = new Set(isChecked ? allRooms : []);
            $('#select-button').prop('disabled', !isChecked);
        });

        $('#datatable').on('change', '.select-row', function () {
            const roomId = $(this).data('room-id');

            $(this).is(':checked') ? selectedRooms.add(roomId) : selectedRooms.delete(roomId);

            console.log(selectedRooms,allRooms)
            $('#select-all').prop('checked', selectedRooms.size === allRooms.size);
            $('#select-button').prop('disabled', selectedRooms.size == 0);
        })

        $('#datatable').on('draw.dt', function () {
            $('.select-row').each(function(){
                $(this).prop('checked', selectedRooms.has($(this).data('room-id')));
            });
        });

        $('form').on('submit', function () {
            $('<input>')
                .attr('type', 'hidden')
                .attr('name', 'selectedRooms')
                .val(Array.from(selectedRooms).join(','))
                .appendTo($(this));
        });
    </script>
@endsection
