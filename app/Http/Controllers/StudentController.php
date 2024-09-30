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

    public function search(Request $request){
            $nim = $request->input('nim');
            $name = $request->input('name');
            $year = $request->input('year');

            $students = Student::with(['user']);

            // Apply filters conditionally
            if (!empty($nim)) {
                $students->where('nim', 'like', '%' . $nim . '%'); // Filter by NIM if provided
            }

            if (!empty($name)) {
                $students->whereHas('user', function ($q) use ($name) {
                    $q->where('name', 'like', '%' . $name . '%'); // Filter by name if provided
                });
            }

            if ($year != "all") {
                $students->where('year', '=', $year); // Filter by year if provided
            }

            // Order by NIM and get the results
            $students = $students->orderBy('nim')->get();

            return response()->json($students, 200);
    }
}
