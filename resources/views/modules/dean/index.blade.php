{{-- @dd($students) --}}
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
                                    <h6 class="text-muted font-semibold">Sudah submit schedule</h6>
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
                                    <h6 class="text-muted font-semibold">Belum submit schedule</h6>
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
                {{-- @dd($filled) --}}
                <form action="{{ route('department-schedule.accept-some') }}" method="post">
                    @csrf
                    <div class="d-flex justify-content-end">
                        <a class="ms-auto text-end accept-irs d-none" href='#'>
                            <button class="btn btn-success mb-4" data-bs-toggle="tooltip" data-bs-placement="bottom" title="IRS yang disetujui akan dijalankan mahasiswa untuk semester ini.">Setujui Jadwal</button>
                        </a>
                    </div>
                    <div class="table-responsive">

                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" name="allChecked" class="form-check-input">
                                    </th>
                                    <th>Department</th>
                                    @if ($filled === 'filled')
                                        <th>Status Jadwal</th>
                                    @endif
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($courseDepartments as $courseDepartment)
                                    <tr>
                                        <td>
                                            @if ($courseDepartment->action_name !== 'accepted')
                                                <input type="checkbox" name="is_submitted[{{ $courseDepartment->id }}]" class="form-check-input is-submitted">
                                            @endif
                                        </td>
                                        <td>{{ @$courseDepartment->department->name }}</td>
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
            $('#filled').on('change', function(){
                const filled = $('#filled').val();
                // console.log(filled);

                window.location.href = (`{{ route('department-schedule.index', ['filled' => 'FILLED']) }}`).replace('FILLED', filled)
            });

            setTimeout(() => {
                if ($('.is-submitted').length == 0) {
                    $('th[aria-controls="DataTables_Table_0"]').eq(0).removeClass('sorting').removeClass('sorting_asc');
                    $('input[name="allChecked"]').addClass('d-none');
                }
            }, 200);

            $('input[name="allChecked"]').on('change', function(){
                const isChecked = $(this).prop('checked');
                $('input[name^="is_submitted"]').prop('checked', isChecked).trigger('change');
            });

            $('.is-submitted').on('change', function () {
                if ($('.is-submitted:checked').length > 0) {
                    $('.accept-irs').removeClass('d-none');
                } else {
                    $('.accept-irs').addClass('d-none');
                    $('input[name="allChecked"]').prop('checked', false);
                }

                if ($(this).prop('checked') === false) {
                    $('input[name="allChecked"]').prop('checked', false);
                }
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
