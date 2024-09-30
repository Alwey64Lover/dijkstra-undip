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
                            <input type="text" class="form-control rounded-pill" id="search-nim" aria-describedby="basic-addon2" style="background-color: #D9D9D9">
                            <img class="search-icon" src="{{ asset('storage/static/magnifying-glass-solid.svg') }} " >
                        </label>
                    </div>
                    <div class="search name">
                        <label for="search-name">
                            <h6 class="search-label">Nama</h6>
                            <input type="text" class="form-control rounded-pill" id="search-name" aria-describedby="basic-addon2" style="background-color: #D9D9D9" onkeyup="searchStudentName()">
                            <img class="search-icon" src="{{ asset('storage/static/magnifying-glass-solid.svg') }} ">
                        </label>
                    </div>
                    <div class="search year">
                            <h6 class="search-label">Angkatan</h6>
                            <select class="form-control rounded-pill" aria-describedby="basic-addon2" style="background-color: #D9D9D9">
                                <option>2020</option>
                                <option>2021</option>
                                <option>2022</option>
                            </select>
                            <img class="search-icon" src="{{ asset('storage/static/arrow-down.svg') }} ">
                    </div>
                  </div>
            </div>
            {{-- Search bars [end] --}}

            {{-- List of Students [start] --}}
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
                @foreach ($students as $student)
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
                @endforeach
                </tbody>
            </table>
            {{-- List of Students [end] --}}
        </div>
    </section>

    <script>
        function getXMLHTTPRequest() {
            if (window.XMLHttpRequest) {
                return new XMLHttpRequest();
            } else {
                return new ActiveXObject("Microsoft.XMLHTTP");
            }
        }

        function searchStudentName() {
            console.log(@json($students));
            var originalData = Object.values(@json($students));
            console.log(originalData);
            var xmlhttp = getXMLHTTPRequest();

            var name = encodeURI(document.getElementById('search-name').value);
            var url = "dashboard/search?name=" + name;
            var inner = "tbody"

            // Validate
            if (name != "") {
                xmlhttp.open('GET', url, true);
                xmlhttp.onreadystatechange = function() {
                    if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)){
                        var students = JSON.parse(xmlhttp.responseText);
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
    </script>
@endsection
