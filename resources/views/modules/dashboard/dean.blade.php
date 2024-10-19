{{-- @dd($departments) --}}
@extends('layouts.backend.app')

@section('title', "Dashboard")

@include('assets.table.datatable')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header col-12">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Departemen</th>
                                <th>Kepala Departemen</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($departments as $department)
                                <tr>
                                    <td>{{ $department->name }}</td>
                                    <td>
                                        <div class="avatar avatar-md2" >
                                            <img src="{{ asset('assets/compiled/jpg/1.jpg') }}" alt="Avatar">
                                        </div>
                                        {{ $department->users->first()->name }}
                                    </td>
                                    <td>{{ $department->users->first()->email }}</td>
                                    <td>
                                        <form action="{{ route('lecturer.irs') }}" method="POST" style="display: inline">
                                            @csrf
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
@endsection
