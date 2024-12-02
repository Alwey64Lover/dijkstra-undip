<div>
    <h2 style="text-align: center; font-family: 'times new roman';">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET DAN TEKNOLOGI
        FAKULTAS SAINS DAN MATEMATIKA
        UNIVERSITAS DIPONEGORO</h2>
        <h4 style="text-align: center">Isian Rencana Studi</h4>
    <p>Nama : {{ $studentName }}</p>
    <p>NIM : {{ $studentNim }}</p>
    <p>Semester: {{ $latestSemester }}</p>
</div>
<div class="table-responsive">
    <table style="border-collapse:collapse;" border="1px">
        <thead>
            <tr>
                <th style="padding:10px">No</th>
                <th style="padding:10px">Kode</th>
                <th style="padding:10px">Mata Kuliah</th>
                <th style="padding:10px">Kelas</th>
                <th style="padding:10px">SKS</th>
                <th style="padding:10px">Ruang</th>
                <th style="padding:10px">Status</th>
                <th style="padding:10px">Nama Dosen</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($irsmhs as $mk)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $mk->courseClass->CourseDepartmentDetail->course->code }}</td>
                    <td>{{ $mk->courseClass->CourseDepartmentDetail->course->name }}</td>
                    <td style="text-align: center">{{ $mk->courseClass->name }}</td>
                    <td style="text-align: center">{{ $mk->courseClass->CourseDepartmentDetail->sks }}</td>
                    <td style="text-align: center">{{ $mk->courseClass->room->name }}</td>
                    <td style="text-align: center">{{ \App\Models\IrsDetail::RETRIEVAL_STATUS[$mk->retrieval_status] }}</td>
                    <td>
                        @foreach($mk->courseClass->CourseDepartmentDetail->lecturers as $lecturer)
                        <ul>
                            <li style="margin:0px; padding:0px;">{{ $lecturer->user->name }}</li>
                        </ul>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
