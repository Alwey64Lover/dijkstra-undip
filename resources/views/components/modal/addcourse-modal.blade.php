<div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="courseModalLabel">Detail Mata Kuliah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="courseName"></p>
                <p id="courseStatus"></p>
                <p id="courseSks"></p>
                <p id="courseTime"></p>
                <p id="courseClass"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>

                <form action="" method="post" id="formHandleCourse">
                    @csrf
                    @method('patch')

                    <input type="hidden" name="courseClassId" value="">
                    <button type="submit" class="btn btn-primary" id="takeCourseBtn">Ambil</button>
                </form>
            </div>
        </div>
    </div>
</div>
