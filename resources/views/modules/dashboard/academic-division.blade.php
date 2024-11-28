{{-- @dd($dataRoom); --}}
@extends('layouts.backend.app')
@section('title', 'Dashboard')
@section('content')
    <section class="section dashboard" id="dashboard-container">
        <!-- Sidebar section -->
        <div class="sidebar">
            <table class="table table-striped table-hover">
                <thead class="bg-primary">
                    <tr>
                        <th class="text-light">No</th>
                        <th class="text-light">Ruang</th>
                        <th class="text-light">Kapasitas</th>
                        <th class="text-light">Departemen</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($dataRoom as $data)
                        <tr>
                            <td>a</td>
                            <td>b</td>
                            <td>c</td>
                            <td>d</td>
                        </tr>
                    @endforeach --}}
                </tbody>
            </table>
        </div>
    </section>
    <div id="form-container" style="display:none;"></div>
@endsection
