{{-- @dd($dataRoom); --}}
@extends('layouts.backend.app')
@section('title', 'Dashboard')
@section('content')
    <section class="section dashboard" id="dashboard-container">
        <!-- Sidebar section -->
        <div class="sidebar">
            <table border="1px">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Id</th>
                        <th>Nama</th>
                        <th>Kon</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>data1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                    </tr>
                </tbody>
            </table>
            {{-- @foreach ($dataRoom as $data)

            @endforeach --}}
        </div>
    </section>
    <div id="form-container" style="display:none;"></div>
@endsection
