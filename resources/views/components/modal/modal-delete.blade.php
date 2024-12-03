<div class="modal fade text-left" id="modal_delete" role="dialog"
    aria-labelledby="myModalLabelDelete" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
        role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title white" id="myModalLabelDelete">Hapus Data
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                Apakah anda yakin ingin menghapus data?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary"
                    data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Tidak</span>
                </button>

                <form action="" method="POST">
                    @method('DELETE')
                    @csrf

                    <button type="submit" class="btn btn-danger ms-1" data-bs-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Ya</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


