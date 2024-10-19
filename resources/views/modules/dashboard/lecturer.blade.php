{{-- @dd($students) --}}
@extends('layouts.backend.app')

@section('title', $title)

@include('assets.table.datatable')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header col-12">
                <div class="col-2">
                    <x-form-element :element="@$year"/>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Angkatan</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($students as $student)
                                <tr>
                                    <td>{{ $student->nim }}</td>
                                    <td>{{ @$student->user->name }}</td>
                                    <td>{{ $student->year }}</td>
                                    <td>{{ @$student->user->email }}</td>
                                    <td>
                                        <form action="{{ route('lecturer.irs') }}" method="POST" style="display: inline">
                                            @csrf
                                            <input type="hidden" name="nim" value="{{ $student->nim }}">
                                            <button type="submit" class="btn btn-primary">Detail</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Data tidak ada</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    @push('js')
        <script>
            $('#year').on('change', function(){
                const year = $('#year').val();

                window.location.href = (`{{ route('dashboard', ['year' => 'YEAR']) }}`).replace('YEAR', year);
            });
        </script>
    @endpush
@endsection
