@extends('layouts.backend.app')
{{-- @dd($options) --}}
@section('title', 'IRS')

@section('content')
    <section class="section">
        <div class="card mb-2">
            <div class="card-header col-12 mb-3">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="avatar avatar-md2" >
                        <img src="{{ asset('assets/compiled/jpg/1.jpg') }}" alt="Avatar">
                    </div>
                    <h6 style="margin: 0">{{ $student->nim }}</h6>
                    <img src="{{ asset('storage/static/pipe.svg') }} ">
                    <h6 style="margin: 0">{{ $student->user->name }}</h6>
                    @if (isset($irsDetails->first()->irs))
                        @if ($irsDetails->first()->irs->action_name === '1')
                            <button class="ms-auto btn btn-primary">Cetak IRS</button>
                        @endif
                        {{-- @dd($irsDetails->first()->irs->herRegistration->academicYear->is_active) --}}
                        @if ($irsDetails->first()->irs->herRegistration->academicYear->is_active == 1)
                            @if($irsDetails->first()->irs->action_name != 1)
                                <a class="ms-auto" href='/irs/{{ $irsDetails->first()->irs->id }}/accept'>
                                    <button class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="bottom" title="IRS yang disetujui akan dijalankan mahasiswa untuk semester ini.">Setujui IRS</button>
                                </a>
                            @else
                                <a href='/irs/{{ $irsDetails->first()->irs->id }}/reject'>
                                    <button class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="IRS yang disetujui akan dijalankan mahasiswa untuk semester ini.">Batalkan IRS</button>
                                </a>
                            @endif
                        @endif
                    @endif
                </div>
                <div class="card-header col-12">
                    <div class="col-2">
                        <x-form-element :element="@$semester"/>
                    </div>
                </div>
                <button id="irs-button" class="ms-auto btn btn-primary rounded-pill me-2" style="width: 230.38px">IRS</button>
                <form action="/khs/{{ $student->nim }}"method="GET" style="display: inline;">
                    @csrf
                    <input type="hidden" name="nim" value="{{ $student->nim }}">
                    <button type="submit" class="ms-auto btn btn-outline-primary rounded-pill" style="width: 230.38px">KHS</button>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Mata Kuliah</th>
                                <th>Kelas</th>
                                <th>SKS</th>
                                <th>Ruang</th>
                                <th>Status</th>
                                <th>Dosen Pengampu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($irsDetails as $mk)
                                {{-- @dd($mk) --}}
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $mk->courseClass->courseDepartmentDetail->course->code }}</td>
                                    <td>{{ $mk->courseClass->courseDepartmentDetail->course->name }}</td>
                                    <td>{{ $mk->courseClass->name }}</td>
                                    <td>{{ $mk->courseClass->courseDepartmentDetail->sks }}</td>
                                    <td>{{ $mk->courseClass->room->type.$mk->courseClass->room->name }}</td>
                                    <td>{{ \App\Models\IrsDetail::RETRIEVAL_STATUS[$mk->retrieval_status] }}</td>
                                    <td>
                                        <ul>
                                            {{-- @dd($mk->courseClass->courseDepartmentDetail->lecturers) --}}
                                            @foreach($mk->courseClass->courseDepartmentDetail->lecturers as $lecturer)
                                                <li>{{ $lecturer->user->name }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    {{-- <x-modal.modal-setuju-irs/> --}}

    @push('js')
        <script>
            $('#semester').on('change', function(){
                const semester = $('#semester').val();

                window.location.href = (`{{ route('lecturer.irs', ['semester' => 'SEM', 'nim' => 'NIM']) }}`)
                .replace('SEM', semester)
                .replace('NIM', '{{ $student->nim }}');
            });
        </script>
    @endpush
@endsection
