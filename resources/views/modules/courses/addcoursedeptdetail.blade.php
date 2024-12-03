<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mt-5" id="form-container">
    <h2 class="text-center mb-4">Tambahkan Mata Kuliah Baru</h2>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('storecourse') }}">
                    @csrf

                        <div class="form-group mb-3">
                            <label for="course">Nama Mata Kuliah</label>
                            <select class="form-select" name="course_id" id="name">
                                <option value="">Pilih Mata Kuliah yang Tersedia</option>
                                @foreach ($allcourses as $course)
                                    @php
                                        $isExisting = $existing_dept_courses->contains(function($existingCourse) use ($course) {
                                            return $existingCourse->course_id == $course->id;
                                        });
                                    @endphp
                                    @if(!$isExisting)
                                        <option value="{{$course->id}}">{{$course->code}} - {{$course->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group mb-3">
                            <label for="course">Semester</label>
                            <select class="form-select" id="semester" name="semester" required>
                                <option value="">Pilih Semester</option>
                                @for ($i = 1; $i <= 8; $i++)
                                    <option value="{{ $i }}">Semester {{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="course">Status Mata Kuliah</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="">Pilih Status Mata Kuliah</option>
                                @foreach ($coursestatuses as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="course">SKS</label>
                            <select class="form-select" name="sks">
                                <option value="">Pilih Besaran SKS</option>
                                @for ($i = 1; $i <= 6; $i++)
                                    <option value="{{ $i }}">{{ $i }} SKS</option>
                                @endfor
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="course">Dosen Pengampu</label>
                            {{-- <select class="form-select" >
                                <option value="">Pilih Dosen Pengampu</option>
                                @foreach ($lecturers as $lecture)
                                    <option value="{{ $lecture->user_id }}">{{ $lecture->user->name }}</option>
                                @endforeach
                            </select> --}}

                            <select class="form-select choices multiple-remove" multiple="multiple" id="lecturers" name="lecturer_ids[]" required>
                                <option value="">Pilih Dosen Pengampu</option>
                                @foreach ($lecturers as $lecture)
                                    <option value="{{ $lecture->id }}">{{ $lecture->user->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <button type="submit" class="btn btn-primary">Tambah Mata Kuliah</button>
                        <button type="button" class="btn btn-secondary" id="cancel-button" data-bs-dismiss="modal">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

</script>
