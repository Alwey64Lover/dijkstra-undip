{{-- @dd($khs) --}}

@extends('layouts.backend.app')

@include('assets.table.datatable')

@section('title', 'KHS')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header col-12 mb-3">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="avatar avatar-md2" >
                        <img src="{{ asset('assets/compiled/jpg/1.jpg') }}" alt="Avatar">
                    </div>
                    <h6 style="margin: 0">{{ $student->nim }}</h6>
                    <img src="{{ asset('storage/static/pipe.svg') }} ">
                    <h6 style="margin: 0">{{ $student->user->name }}</h6>
                    <button class="ms-auto btn btn-primary">Cetak Transkrip Keseluruhan</button>
                </div>
                <div class="card-header col-12">
                    <div class="col-2">
                        <x-form-element :element="@$semester"/>
                    </div>
                </div>
                {{-- <select id="semester" class="form-select mb-5" aria-label="Default select example" style="width: 230.38px">
                    <option value="1">Semester 1</option>
                    <option value="2">Semester 2</option>
                    <option value="3">Semester 3</option>
                    <option value="4" selected>Semester 4</option>
                </select> --}}
                <form action="{{ route('lecturer.irs') }}"method="POST" style="display: inline;">
                    @csrf
                    <input type="hidden" name="nim" value="{{ $student->nim }}">
                    <button type="submit" class="ms-auto btn btn-outline-primary rounded-pill" style="width: 230.38px">IRS</button>
                </form>
                <button id="khs-button" class="ms-auto btn btn-primary rounded-pill" style="width: 230.38px">KHS</button>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Mata Kuliah</th>
                                <th>Status</th>
                                <th>SKS</th>
                                <th>Nilai (Bobot)</th>
                                <th>SKS x Bobot</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($khs as $mk)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $mk->irsDetail->courseClass->courseDepartmentDetail->course->code }}</td>
                                    <td>{{ $mk->irsDetail->courseClass->courseDepartmentDetail->course->name }}</td>
                                    <td>kontol</td>
                                    <td>{{ $mk->irsDetail->courseClass->courseDepartmentDetail->sks }}</td>
                                    <td>{{ scoreToGrade($mk->score) }} ({{ bobot($mk->score) }})</td>
                                    <td>{{ bobot($mk->score)*$mk->irsDetail->courseClass->courseDepartmentDetail->sks }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-inline-flex align-items-start w-50">
                    <div class="grid mt-4 me-auto">
                        <h5>IP Semester&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;: {{ $total_bobot_sem/($total_sks_sem == 0 ? 1 : $total_sks_sem) }}</h5>
                        {{ $total_bobot_sem.'/'.$total_sks_sem }} <br>
                        Total (SKS x Bobot) / Total SKS
                    </div>
                    <div class="grid mt-4">
                        <h5>IP Kumulatif&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;: {{ $total_bobot_all/($total_sks_all == 0 ? 1 : $total_sks_all) }}</h5>
                        {{ $total_bobot_all.'/'.$total_sks_all }} <br>
                        Total (SKS x Bobot) semua semester <br>/ Total SKS semua semester
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('js')
    <script>
        $('#semester').on('change', function() {
            const semester = $('#semester').val(); // Get the selected semester
    
            // Create a form programmatically
            const form = $('<form>', {
                method: 'POST',
                action: "{{ route('lecturer.khs') }}", // The route for the POST request
            });
    
            // Append CSRF token
            form.append($('<input>', {
                type: 'hidden',
                name: '_token',
                value: '{{ csrf_token() }}' // CSRF token for security
            }));
    
            // Append the student NIM
            form.append($('<input>', {
                type: 'hidden',
                name: 'nim',
                value: '{{ $student->nim }}' // Include the student NIM
            }));
    
            // Append the selected semester
            form.append($('<input>', {
                type: 'hidden',
                name: 'semester',
                value: semester // The selected semester
            }));
    
            // Append the form to the body and submit
            $(document.body).append(form);
            form.submit(); // Submit the form
        });
    </script>
    @endpush
@endsection