<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\Student;
use App\Models\Khs;
use App\Models\HerRegistration;
use Illuminate\Http\Request;

class LecturerController extends Controller
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
    public function show(Lecturer $lecturer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lecturer $lecturer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lecturer $lecturer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lecturer $lecturer)
    {
        //
    }

    function showStudentIrs(Request $request) {
        $student = Student::where('nim', $request->nim)->first();
        return view('modules.lecturer.irs', [
            "title" => "IRS",
            "student" => $student
        ]);
    }

    function showStudentKhs(Request $request) {
        $student = Student::where('nim', $request->nim)->first();
        $semester_request = $request->semester ?? '';
        $khs = Khs::whereHas('irsDetail.irs.herRegistration', function ($query) use ($student, $semester_request){
            $query->where('student_id', $student->id);
            if (filled($semester_request)) {
                $query->where('semester', $semester_request);
            }
        })
        ->with(['irsDetail.irs.herRegistration'])
        ->with(['irsDetail.courseClass.courseDepartmentDetail.course'])
        ->get();

        $semester = [
            'type' => 'select',
            'id' => 'semester',
            'name' => 'semester',
            'disabledPlaceholder' => 1,
            'value' => $semester_request,
            'options' => HerRegistration::where('student_id', $student->id)
                        ->orderBy('semester')
                        ->pluck('semester', 'semester')
                        ->mapWithKeys(function ($semester) {
                            return [$semester => "Semester ".$semester];
                        })
                        ->toArray()
        ];
        return view('modules.lecturer.khs', [
            "title" => "KHS",
            "student" => $student,
            "khs" => $khs,
            "semester" => $semester
        ]);
    }
}
