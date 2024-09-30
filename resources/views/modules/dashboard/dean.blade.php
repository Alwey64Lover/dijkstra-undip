<style>
    .avatar{
        display: flex;
    align-items: center; 
    }
    img{
        margin-right: 10px;
    }
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
                            <h6 class="search-label">Departemen</h6>
                            <input type="text" class="form-control rounded-pill" id="search-nim" aria-describedby="basic-addon2" style="background-color: #D9D9D9" onkeyup="searchStudent()">
                            <img class="search-icon" src="{{ asset('storage/static/magnifying-glass-solid.svg') }} " >
                        </label>
                    </div>
                    <div class="search name">
                        <label for="search-name">
                            <h6 class="search-label">Nama Ketua</h6>
                            <input type="text" class="form-control rounded-pill" id="search-name" aria-describedby="basic-addon2" style="background-color: #D9D9D9" onkeyup="searchStudent()">
                            <img class="search-icon" src="{{ asset('storage/static/magnifying-glass-solid.svg') }} ">
                        </label>
                    </div>
                  </div>
            </div>
            {{-- Search bars [end] --}}

            {{-- List of Students [start] --}}
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" style="width: 19%"><h6>Departemen</h6></th>
                        <th scope="col" style="width: 19%"><h6>Ketua</h6></th>
                        <th scope="col" style="width: 19%"><h6>Email</h6></th>
                        <th scope="col" style="width: 7%"><h6></h6></th>
                    </tr>
                </thead>
                <tbody id="tbody">
                {{-- @foreach ($students as $student) --}}
                        <tr>
                            <td>
                                <div class="table-contents">Informatika</div>
                            </td>
                            <td>
                                <div class="table-contents">
                                    <div class="avatar avatar-md2" >
                                        <img src="{{ asset('assets/compiled/jpg/1.jpg') }}" alt="Avatar">
                                    </div>
                                    Alponso Raka Buming Raka
                                </div>
                            </td>
                            <td>
                                <div class="table-contents">'fufufafa@informatics.undip.ac.id'</div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary">Lihat Jadwal</button>
                            </td>
                        </tr>
                {{-- @endforeach --}}
                </tbody>
            </table>
            {{-- List of Students [end] --}}
        </div>
    </section>

    {{-- <script>
        function getXMLHTTPRequest() {
            if (window.XMLHttpRequest) {
                return new XMLHttpRequest();
            } else {
                return new ActiveXObject("Microsoft.XMLHTTP");
            }
        }

        function searchStudent() {
            var originalData = Object.values(@json($students));
            var xmlhttp = getXMLHTTPRequest();

            nim = encodeURI(document.getElementById('search-nim').value);
            name = encodeURI(document.getElementById('search-name').value);
            year = encodeURI(document.getElementById('search-year').value);
            var url = "dashboard/search?nim=" + nim + "&name=" + name + "&year=" + year;
            var inner = "tbody"

            if (nim != "" || name != "" || year != "all") {
                xmlhttp.open('GET', url, true);
                xmlhttp.onreadystatechange = function() {
                    if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)){
                        var students = JSON.parse(xmlhttp.responseText);
                        console.log(students);
                        document.getElementById(inner).innerHTML = '';

                        students.forEach(function(student){
                            document.getElementById(inner).innerHTML += `<tr>
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
                        })
                    }
                    return false;
                }
                xmlhttp.send(null);
            }else{
                populateTable(originalData);
            }
        }

        function populateTable(students) {
            document.getElementById('tbody').innerHTML = '';

            students.forEach(function(student) {
                document.getElementById('tbody').innerHTML += `
                    <tr>
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
        }
    </script> --}}
@endsection
