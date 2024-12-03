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
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
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
                                        <td>{{ $student->nim }}</td>
                                        <td>{{ $student->user->name }}</td>
                                        <td>{{ $student->year }}</td>
                                        <td>{{ $student->user->email }}</td>
                                        @if ($filled === 'filled')
                                        <td>
                                            @if ($student->herRegistrations->where('academicYear.is_active', 1)->first()->irs->action_name === 1)
                                                <p class="text-success">Sudah disetujui</p>
                                            @else
                                            <p class="text-danger">Belum disetujui</p>
                                            @endif
                                        </td>
                                        @endif
                                        <td>
                                            <a href="irs/{{ $student->nim }}"><button class="btn btn-primary">Detail</button></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

    </section>

    @push('js')
        <script>
            $('#filled').on('change', function(){
                const filled = $('#filled').val();
                // console.log(filled);

                window.location.href = (`{{ route('dashboard', ['filled' => 'FILLED']) }}`).replace('FILLED', filled)
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
