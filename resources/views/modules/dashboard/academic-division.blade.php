{{-- @dd($dataRoom); --}}
@extends('layouts.backend.app')
@section('title', 'Dashboard')
@section('content')
    <section class="section dashboard" id="dashboard-container">
        <!-- Sidebar section -->
        <div class="sidebar">
            <table class="table table-striped table-hover" style="table-layout: fixed">
                <thead class="bg-primary">
                    <tr>
                        <th class="text-light">No</th>
                        <th class="text-light">Nama</th>
                        <th class="text-light">Kapasitas</th>
                        <th class="text-light">Departemen</th>
                        <th class="text-light"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataRoom as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->type }}{{ $data->name }}</td>
                            <td>{{ $data->capacity }}</td>
                            <td>{{ $data->department }}</td>
                            <td style="text-align:right;">
                                <a href="" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                                <a href="" class="btn btn-warning"><i class="bi bi-pen"></i></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
    <div id="form-container" style="display:none;"></div>
@endsection
