{{-- @dd($departments) --}}
@extends('layouts.backend.app')

@section('title', 'Jadwal Department')

@include('assets.table.datatable')

@section('content')
    <section class="section">
        <div class='row'>
            <div class="col">
                <a href="{{ route('department-schedule.index', ['filled' => 'filled']) }}">
                    <div class="card count shadow-sm" style="{{ isset($filled) && $filled === 'filled' ? 'background-color: #f0f0f0;' : '' }}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <div class="stats-icon mb-2">
                                        <i class="bi bi-award-fill"></i>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <h6 class="text-muted font-semibold">Sudah submit Jadwal</h6>
                                    <h4 class="font-semibold mb-0 value">{{ $countFilled }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('department-schedule.index', ['filled' => 'notFilled']) }}">
                    <div class="card count shadow-sm" style="{{ isset($filled) && $filled === 'notFilled' ? 'background-color: #f0f0f0;' : '' }}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <div class="stats-icon mb-2">
                                        <i class="bi bi-person-video3"></i>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <h6 class="text-muted font-semibold">Belum submit Jadwal</h6>
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
                <form action="{{ route('department-schedule.accept-some') }}" method="post">
                    @csrf
                    <div class="d-flex justify-content-end">
                        @if ($filled === "filled")
                            <button disabled id="select-button" class="btn btn-success mb-4" data-bs-toggle="tooltip" data-bs-placement="bottom" title="IRS yang disetujui akan dijalankan mahasiswa untuk semester ini.">Setujui Jadwal</button>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table id="datatable" class="table">
                            <thead>
                                <tr>
                                    @if ($filled === 'filled')
                                        <th>
                                            <input type="checkbox" id="select-all" class="form-check-input">
                                        </th>
                                    @endif
                                    <th>Departemen</th>
                                    <th>Kepala Departemen</th>
                                    <th>Email</th>
                                    @if ($filled === 'filled')
                                        <th>Status Jadwal</th>
                                    @endif
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($courseDepartments as $courseDepartment)
                                    <tr>
                                        @if ($filled === 'filled')
                                            <td>
                                                @if ($courseDepartment->action_name !== 'accepted')
                                                    <input type="checkbox" data-department-id={{ $courseDepartment->id }} class="form-check-input select-row">
                                                @endif
                                            </td>
                                        @endif
                                        <td>{{ @$courseDepartment->department->name }}</td>
                                        <td>{{ @$courseDepartment->department->users->where('role', 'head_of_department')->first()->name }}</td>
                                        <td>{{ @$courseDepartment->department->users->where('role', 'head_of_department')->first()->email }}</td>
                                            @if ($filled === 'filled')
                                                <td>
                                                    @if ($courseDepartment->action_name === 'accepted')
                                                        <p class="text-success">Sudah disetujui</p>
                                                    @else
                                                        <p class="text-danger">Belum disetujui</p>
                                                    @endif
                                                </td>
                                            @endif
                                        <td>
                                            <a href="{{ route('department-schedule.show', $courseDepartment->id) }}"><button class="btn btn-primary" type="button">Detail</button></a>
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

            let selectedDepartments = new Set(), allDepartments = new Set(@json($courseDepartments->pluck('id')));

            $('#select-all').on('change', function () {
                const isChecked = $(this).is(':checked');
                $('.select-row').each(function () {
                    $(this).prop('checked', isChecked);
                });
                selectedDepartments = new Set(isChecked ? allDepartments : []);
                $('#select-button').prop('disabled', !isChecked);
            });

            $('#datatable').on('change', '.select-row', function () {
                const departmentId = $(this).data('department-id');

                $(this).is(':checked') ? selectedDepartments.add(departmentId) : selectedDepartments.delete(departmentId);
                
                $('#select-all').prop('checked', selectedDepartments.size === allDepartments.size);
                $('#select-button').prop('disabled', selectedStudents.size == 0);
            })

            $('#datatable').on('draw.dt', function () {
                $('.select-row').each(function(){
                    $(this).prop('checked', selectedDepartments.has($(this).data('department-id')));
                });
            });

            $('form').on('submit', function () {
                $('<input>')
                    .attr('type', 'hidden')
                    .attr('name', 'selectedDepartments')
                    .val(Array.from(selectedDepartments).join(','))
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
