<style>
    .search{
        width: 15%;
        margin-right: 5%;
    }
    .search-icon{
        position: relative;
        width: 25px;
        height: auto;
        float: right;
        top: -30px;
        left:-10px
    }
    h6.search-label{
        position: relative;
        right: -12px;
    }
    .table {
    table-layout: fixed; /* Fixed layout for the table */
    width: 100%; /* Full width */
    }
    .table td {
    overflow: hidden; 
    white-space: nowrap; 
    text-overflow: ellipsis; /* Add ellipsis for overflowing text */
    }
</style>

@extends('layouts.backend.app')
@section('title', 'Dashboard')

@section('content')
    <section class="section dashboard">
        <div class="card">
            {{-- Search bars [start] --}}
            <div class="card-body">
                <div class="input-group mb-3">
                    <div class="search nim">
                        <label for="search-nim">
                            <h6 class="search-label">NIM</h6>
                            <input type="text" class="form-control rounded-pill" id="search-nim" aria-describedby="basic-addon2" style="background-color: #D9D9D9" onkeyup="searchStudent()">
                            <img class="search-icon" src="{{ asset('storage/static/magnifying-glass-solid.svg') }} " >
                        </label>
                    </div>
                    <div class="search name">
                        <label for="search-name">
                            <h6 class="search-label">Nama</h6>
                            <input type="text" class="form-control rounded-pill" id="search-name" aria-describedby="basic-addon2" style="background-color: #D9D9D9" onkeyup="searchStudent()">
                            <img class="search-icon" src="{{ asset('storage/static/magnifying-glass-solid.svg') }} ">
                        </label>
                    </div>
                    <div class="search year">
                            <h6 class="search-label">Angkatan</h6>
                            <select class="form-control rounded-pill" id="search-year" aria-describedby="basic-addon2" style="background-color: #D9D9D9" onchange="searchStudent()">
                                <option value="">Semua Angkatan</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                            </select>
                            <img class="search-icon" src="{{ asset('storage/static/arrow-down.svg') }} ">
                    </div>
                </div>
                {{-- Search bars [end] --}}

                {{-- List of Students [start] --}}
                <div class="ms-2 mb-3">Show 
                    <select class="form-select form-select-sm d-inline" name="rows-per-page" id="rows-per-page" aria-label=".form-select-sm example" style="width:60px;" onchange="searchStudent()">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select> Entries
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 5%"></th>
                            <th scope="col" style="width: 19%"><h6>NIM</h6></th>
                            <th scope="col" style="width: 19%"><h6>Nama</h6></th>
                            <th scope="col" style="width: 19%"><h6>Angkatan</h6></th>
                            <th scope="col" style="width: 19%"><h6>Email</h6></th>
                            <th scope="col" style="width: 7%"><h6></h6></th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                    {{-- @foreach ($students as $student)
                            <tr>
                                <th scope="row">
                                    <div class="avatar avatar-md2" >
                                        <img src="{{ asset('assets/compiled/jpg/1.jpg') }}" alt="Avatar">
                                    </div>
                                </th>
                                <td>
                                    <div class="table-contents">{{ $student->nim }}</div>
                                </td>
                                <td>
                                    <div class="table-contents">{{ $student->user->name }}</div>
                                </td>
                                <td>
                                    <div class="table-contents">{{ $student->year }}</div>
                                </td>
                                <td>
                                    <div class="table-contents">{{ $student->user->email }}</div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary">Detail</button>
                                </td>
                            </tr>
                    @endforeach --}}
                    </tbody>
                </table>
                <div class="ms-2 mt3" id="rows-info"></div>
                {{-- List of Students [end] --}}
                <div class="d-flex flex-row-reverse "><a id="pagination-links"></a></div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            searchStudent();
        });

        function searchStudent(page = 1) {

            let name = $('#search-name').val();
            let nim = $('#search-nim').val();
            let year = $('#search-year').val();
            let rows = $('#rows-per-page').val();
            $('#tbody').html('KONTOL');

            $.ajax({
                url: ("{{ route('students.search', ['lecturerId' => 'user()->lecturer->id']) }}"),
                data: {
                    "name": name,
                    "nim": nim,
                    "year": year,
                    "page": page, // Pass the current page number
                    "rows" : rows
                },
                cache: false,
                success: function(data) {
                    console.log(data);
                    let html = '';
                    data['students']['data'].forEach(function(student) {
                        html += 
                        `<tr>
                            <th scope="row">
                                <div class="avatar avatar-md2">
                                    <img src="{{ asset('assets/compiled/jpg/1.jpg') }}" alt="Avatar">
                                </div>
                            </th>
                            <td>
                                <div class="table-contents">${student.nim}</div>
                            </td>
                            <td>
                                <div class="table-contents">${student.user.name}</div>
                            </td>
                            <td>
                                <div class="table-contents">${student.year}</div>
                            </td>
                            <td>
                                <div class="table-contents">${student.user.email}</div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary">Detail</button>
                            </td>
                        </tr>`;
                    });

                    $('#tbody').html(html);
                    $('#rows-info').html('<div class="ms-2 mt-3">Showing ' + data['students']['from'] + ' to ' + data['students']['to'] + ' of ' + data['students']['total'] + ' entries</div>');
                    $('#pagination-links').html(data['pagination']['links']); // Update the pagination links
                    $('#pagination-links a').on('click', function(e) {
                        e.preventDefault(); // Prevent default link behavior
                        let url = $(this).attr('href'); // Get the URL from the link
                        console.log(url);
                        let page = url.split('page=')[1]; // Extract page number from URL
                        searchStudent(page); // Call searchStudent with the new page
                    });
                },
                error: function(error) {
                    console.error(error);
                }
            });
}


        // function getXMLHTTPRequest() {
        //     if (window.XMLHttpRequest) {
        //         return new XMLHttpRequest();
        //     } else {
        //         return new ActiveXObject("Microsoft.XMLHTTP");
        //     }
        // }

        // function searchStudent() {
        //     var originalData = Object.values( {{--@json($students) --}});
        //     var xmlhttp = getXMLHTTPRequest();

        //     nim = encodeURI(document.getElementById('search-nim').value);
        //     name = encodeURI(document.getElementById('search-name').value);
        //     year = encodeURI(document.getElementById('search-year').value);
        //     var url = "dashboard/search?nim=" + nim + "&name=" + name + "&year=" + year;
        //     var inner = "tbody"

        //     if (nim != "" || name != "" || year != "all") {
        //         xmlhttp.open('GET', url, true);
        //         xmlhttp.onreadystatechange = function() {
        //             if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)){
        //                 var students = JSON.parse(xmlhttp.responseText);
        //                 console.log(students);
        //                 document.getElementById(inner).innerHTML = '';

        //                 students.forEach(function(student){
        //                     document.getElementById(inner).innerHTML += `<tr>
        //                     <th scope="row">
        //                         <div class="avatar avatar-md2">
        //                             <img src="{{ asset('assets/compiled/jpg/1.jpg') }}" alt="Avatar">
        //                         </div>
        //                     </th>
        //                     <td>
        //                         <div class="table-contents">${student.nim}</div>
        //                     </td>
        //                     <td>
        //                         <div class="table-contents">${student.user.name}</div>
        //                     </td>
        //                     <td>
        //                         <div class="table-contents">${student.year}</div>
        //                     </td>
        //                     <td>
        //                         <div class="table-contents">${student.user.email}</div>
        //                     </td>
        //                     <td>
        //                         <button type="button" class="btn btn-primary">Detail</button>
        //                     </td>
        //                 </tr>`;
        //                 })
        //             }
        //             return false;
        //         }
        //         xmlhttp.send(null);
        //     }else{
        //         populateTable(originalData);
        //     }
        // }

        // function populateTable(students) {
        //     document.getElementById('tbody').innerHTML = '';

        //     students.forEach(function(student) {
        //         document.getElementById('tbody').innerHTML += `
        //             <tr>
        //                 <th scope="row">
        //                     <div class="avatar avatar-md2">
        //                         <img src="{{ asset('assets/compiled/jpg/1.jpg') }}" alt="Avatar">
        //                     </div>
        //                 </th>
        //                 <td>
        //                     <div class="table-contents">${student.nim}</div>
        //                 </td>
        //                 <td>
        //                     <div class="table-contents">${student.user.name}</div>
        //                 </td>
        //                 <td>
        //                     <div class="table-contents">${student.year}</div>
        //                 </td>
        //                 <td>
        //                     <div class="table-contents">${student.user.email}</div>
        //                 </td>
        //                 <td>
        //                     <button type="button" class="btn btn-primary">Detail</button>
        //                 </td>
        //             </tr>`;
        //     });
        // }
    </script>
@endsection
