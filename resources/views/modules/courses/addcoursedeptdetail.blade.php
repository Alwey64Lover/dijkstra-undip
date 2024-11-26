<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mt-5" id="form-container">
    <h2 class="text-center mb-4">Tambahkan Mata Kuliah Baru</h2>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="">
                        {{-- {{ route('CourseDepartmentDetail.store') }} --}}
                    @csrf

                        <div class="form-group mb-3">
                            <label for="course">Pilih Mata Kuliah</label>
                            <select class="form-select" id="course" name="course_id" required>
                                <option value="">Pilih mata kuliah</option>
                                @foreach($allcourses as $course)
                                    <option value="{{ $course->id }}">{{ $course->code }} - {{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="course">Pilih Semester</label>
                            <select class="form-select" id="semester" name="semester_id" required>
                                <option value="">Pilih Semester</option>
                                @for ($i = 1; $i <= 7; $i++)
                                    <option value="{{ $i }}">Semester {{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="course">Status Mata Kuliah</label>
                            <select class="form-select" id="semester" name="semester_id" required>
                                <option value="">Pilih Status Mata Kuliah</option>
                                @foreach ($coursestatuses as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="class_name">Nama Kelas</label>
                            <input type="text" class="form-control" id="class_name" name="class_name" required placeholder="Masukkan nama kelas">
                        </div>

                        <div class="form-group mb-3">
                            <label for="start_time">Waktu Mulai</label>
                            <input type="time" class="form-control" id="start_time" name="start_time" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="end_time">Waktu Selesai</label>
                            <input type="time" class="form-control" id="end_time" name="end_time" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Tambah Mata Kuliah</button>
                        <button type="button" class="btn btn-secondary" id="cancel-button">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
