<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="bg-primary text-white text-uppercase">No</th>
                <th class="bg-primary text-white text-uppercase">Kode</th>
                <th class="bg-primary text-white text-uppercase">Mata Kuliah</th>
                <th class="bg-primary text-white text-uppercase">Kelas</th>
                <th class="bg-primary text-white text-uppercase">SKS</th>
                <th class="bg-primary text-white text-uppercase">Ruang</th>
                <th class="bg-primary text-white text-uppercase">Status</th>
                <th class="bg-primary text-white text-uppercase">Nama Dosen</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($irsmhs as $mk)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $mk->courseClass->CourseDepartmentDetail->course->code }}</td>
                    <td>{{ $mk->courseClass->CourseDepartmentDetail->course->name }}</td>
                    <td>{{ $mk->courseClass->name }}</td>
                    <td>{{ $mk->courseClass->CourseDepartmentDetail->sks }}</td>
                    <td>{{ $mk->courseClass->room->name }}</td>
                    <td>{{ \App\Models\IrsDetail::RETRIEVAL_STATUS[$mk->retrieval_status] }}</td>
                    <td>
                        @foreach($mk->courseClass->CourseDepartmentDetail->lecturers as $lecturer)
                        <ul>
                            <li>{{ $lecturer->user->name }}</li>
                        </ul>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
