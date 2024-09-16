@extends('layouts.backend.app')

@section('title', $title)

@include('assets.table.datatable')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <x-button.button-add
                    :route="route($routes['form'], 'add')"
                />
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($columns as $column)
                                <tr>
                                    <td style="width: 75px">{{ $loop->iteration }}</td>
                                    <td>{{ $column->name }}</td>
                                    <td>{{ $column->email }}</td>
                                    <td style="width: 100px">
                                        <div class="d-flex justify-content-between">
                                            <x-button.button-edit
                                                :route="route($routes['form'], 'edit/'.$column->id)"
                                            />

                                            <x-button.button-delete
                                                :route="route($routes['action'], 'delete/'.$column->id)"
                                                :class="\Auth::user()->id == $column->id ? 'disabled' : ''"
                                            />
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <x-modal.modal-delete/>
@endsection
