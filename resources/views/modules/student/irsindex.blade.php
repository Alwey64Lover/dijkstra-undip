@extends('layouts.backend.app')

@section('title', 'IRS')

@section('content')
    <section class="section">
        <div class="card mb-2">
            <div class="card-header col-12 d-flex align-items-center gap-2">
                <div class="col-2">
                    <select id="semester" name="semester" class="form-select">
                        @foreach ($semester['options'] as $key => $value)
                            <option value="{{ $key }}" {{ $key == $semester['value'] ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{-- href="{{ route('irs.cetak-pdf') }}" --}}
                <a href="/export-pdf" id="cetak-irs-btn" class="ms-auto btn btn-primary">
                    Cetak IRS
                </a>
            </div>
            <div class="card-body">
                <div id="table-content">
                    {!! $initialContent !!}
                </div>
            </div>
        </div>
    </section>
    @push('js')
    <script>
        $('#semester').on('change', function() {
            const semester = $(this).val();
            $.ajax({
                url:"{{route('irs.table')}}",
                type: "GET",
                data: { semester: semester },
                success: function(response){
                    $('#table-content').html(response.html);
                },
                error: function(xhr){
                    console.error('Error fetching data:', xhr);
                }
            });
        });
    </script>
    @endpush
@endsection
