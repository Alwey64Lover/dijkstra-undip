<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }

    public function searchName(Request $request){
        
            $name = $request->input('name');

            $students = Student::whereHas('user', function ($q) use ($name) {
                $q->where('name', 'like', '%' . $name . '%');
            })->get();
            $output = "";
            foreach ($students as $row){
                $output .= "
                    <tr>
                        <th scope=\"row\">
                            <div class=\"avatar avatar-md2\" >
                                <img src=\"". asset('assets/compiled/jpg/1.jpg')."\" alt=\"Avatar\">
                            </div>
                        </th>
                        <td>
                            <div class=\"table-contents\">" .$row->nim ."</div>
                        </td>
                        <td>
                            <div class=\"table-contents\">". $row->user->name."</div>
                        </td>
                        <td>
                            <div class=\"table-contents\">". $row->year ."</div>
                        </td>
                        <td>
                            <div class=\"table-contents\">". $row->user->email."</div>
                        </td>
                        <td>
                            <button type=\"button\" class=\"btn btn-primary\">Detail</button>
                        </td>
                    </tr>";
            }
            return response($output, 200);
        
    }
}
