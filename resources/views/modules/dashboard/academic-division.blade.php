@extends('layouts.backend.app')
@section('title', 'Dashboard')
@include('components.modal.modal-delete')
@section('content')
    <section class="section dashboard" id="dashboard-container">
        <div class="container">
            <div class="row">
              <div class="col">
                <h2>Selamat Datang</h2>
              </div>
              <div class="col">
                <a href="" class="btn btn-primary"><i class="bi bi-check2-circle"></i>  Approve</a>
              </div>
            </div>
          </div>
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
                                <button
                                    class="btn btn-danger"
                                    data-id="{{ $data->id }}"
                                    onclick="deleteRoom(this)"
                                >
                                    <i class="bi bi-trash"></i>
                                </button>
                                <a href="{{ route('edit-room', $data->id) }}"
                                    class="btn btn-warning"><i class="bi bi-pen"
                                ></i></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
    <div id="form-container" style="display:none;"></div>

<script>
    function deleteRoom(button) {
        const roomId = $(button).data('id'); // Ambil ID dari atribut data-id
        console.log("Room ID:", roomId);
        $('#modal_delete form').attr('action', '/delete/' + roomId);
        $('#modal_delete').modal('show');
    }
    // $('#modal_delete form').on('submit', function(e) {
    //     e.preventDefault();
    //     const action = $(this).attr('action');

    //     $.ajax({
    //         url: action,
    //         type: 'DELETE',
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: function(response) {
    //             $('#modal_delete').modal('hide');
    //             ();
    //         }
    //     });
    //     return  false;
    // });
</script>
@endsection
