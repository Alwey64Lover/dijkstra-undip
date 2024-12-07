{{-- @dd($students) --}}
@extends('layouts.backend.app')

@section('title', 'Dashboard')

@include('assets.table.datatable')

@section('content')
    <section class="section">

            <div class='row'>
                <div class="col">
                    <a href="{{ route('dashboard', ['filled' => 'filled']) }}">
                        <div class="card count shadow-sm" style="{{ isset($filled) && $filled === 'filled' ? 'background-color: #f0f0f0;' : '' }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="stats-icon mb-2">
                                            <i class="bi bi-award-fill"></i>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <h6 class="text-muted font-semibold">Sudah mengisi IRS</h6>
                                        <h4 class="font-semibold mb-0 value">{{ $countFilled }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="{{ route('dashboard', ['filled' => 'notFilled']) }}">
                        <div class="card count shadow-sm" style="{{ isset($filled) && $filled === 'notFilled' ? 'background-color: #f0f0f0;' : '' }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="stats-icon mb-2">
                                            <i class="bi bi-person-video3"></i>
                                        </div>
                                    </div>

                                    <div class="col-9">
                                        <h6 class="text-muted font-semibold">Belum mengisi IRS</h6>
                                        <h4 class="font-semibold mb-0 value">{{ $countNotFilled }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            @if (isset($filled))
                <div class="card card-body">
                    <form action="{{ route('irs.accept-some') }}" method="post">
                        @csrf
                        <div class="d-flex justify-content-end">
                            @if ($filled === "filled")
                                <button disabled id="select-button" class="btn btn-success mb-4" data-bs-toggle="tooltip" data-bs-placement="bottom" title="IRS yang disetujui akan dijalankan mahasiswa untuk semester ini.">Setujui IRS</button>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table id="datatable" class="table">
                                <thead>
                                    <tr>
                                        @if($filled === 'filled')
                                            <th>
                                                <input type="checkbox" id="select-all" class="form-check-input">
                                            </th>
                                        @endif
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Angkatan</th>
                                        <th>Email</th>
                                        @if ($filled === 'filled')
                                            <th>Status IRS</th>
                                        @endif
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($students as $student)
                                        <tr>
                                            @if($filled === 'filled')
                                                <td>
                                                    @if (activeIrs($student->id)->status_name !== 'accepted')
                                                        <input type="checkbox" data-student-id={{ $student->id }} class="form-check-input select-row">
                                                    @endif
                                                </td>
                                            @endif
                                            <td>{{ $student->nim }}</td>
                                            <td>{{ $student->user->name }}</td>
                                            <td>{{ $student->year }}</td>
                                            <td>{{ $student->user->email }}</td>
                                            @if ($filled === 'filled')
                                            <td>
                                                @if (activeIrs($student->id)->action_name === '1')
                                                    <p class="text-success">Sudah disetujui</p>
                                                @else
                                                <p class="text-danger">Belum disetujui</p>
                                                @endif
                                            </td>
                                            @endif
                                            <td>
                                                <a href="irs/{{ $student->id }}"><button class="btn btn-primary" type="button">Detail</button></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            @endif

    </section>

    @push('js')
        <script>
            $('#datatable').DataTable({
                    columnDefs: [{
                        orderable: false,
                        targets: 0
                    }],
                    responsive: false
                });

            let selectedStudents = new Set(), allStudents = new Set(@json($students->pluck('id')));

            $('#select-all').on('change', function () {
                const isChecked = $(this).is(':checked');
                $('.select-row').each(function () {
                    $(this).prop('checked', isChecked);
                });
                selectedStudents = new Set(isChecked ? allStudents : []);
                $('#select-button').prop('disabled', !isChecked);
            });

            $('#datatable').on('change', '.select-row', function () {
                const studentId = $(this).data('student-id');

                $(this).is(':checked') ? selectedStudents.add(studentId) : selectedStudents.delete(studentId);
                
                $('#select-all').prop('checked', selectedStudents.size === allStudents.size);
                $('#select-button').prop('disabled', selectedStudents.size == 0);
            })

            $('#datatable').on('draw.dt', function () {
                $('.select-row').each(function(){
                    $(this).prop('checked', selectedStudents.has($(this).data('student-id')));
                });
            });

            $('form').on('submit', function () {
                $('<input>')
                    .attr('type', 'hidden')
                    .attr('name', 'selectedStudents')
                    .val(Array.from(selectedStudents).join(','))
                    .appendTo($(this));
            });
        </script>
    @endpush

    @push('css')
        <style>
            .card.count:hover {
                background-color: #f0f0f0; /* Change to your preferred color */
                transition: background-color 0.3s;
            }
        </style>
    @endpush
@endsection
