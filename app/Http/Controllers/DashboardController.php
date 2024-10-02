<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Course;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $dashboard = '';
        switch (user()->role) {
            case 'lecturer':
                 $dashboard = $this->lecturerIndex();
                break;

            case 'student':
                 $dashboard = $this->studentIndex();
                break;

            case 'head_of_department':
                $dashboard = $this->headOfDepartmentIndex();
                break;

            case 'academic_division':
                $dashboard = $this->academicDivisionIndex();
                break;

            case 'dean':
                $dashboard = $this->deanIndex();
                break;

            default:
                abort(404);
                break;
        }
        return $dashboard;
    }


    public function lecturerIndex(){
        try {
            $data["students"] = Student::orderBy('nim')->with(['lecturer', 'user'])->get();

            return view("modules.dashboard.lecturer", $data);
        } catch (\Exception $e) {
            logError($e, actionMessage("failed", "retrieved"), 'table');
            abort(500);
        }
    }

    public function deanIndex(){
        return view('modules.dashboard.dean');
    }

    public function studentIndex(){
        return view('modules.dashboard.student');
    }

    public function headOfDepartmentIndex(){
        // dump(Course::all());
        return view('modules.dashboard.headofdepartment',
    ['courses'=>Course::all()]);
    }
    public function academicDivisionIndex(){
        return view('modules.dashboard.academic-division', [
            "lecturer" => Lecturer::find(1)->lecturer,
            "students" => Lecturer::find(1)->students
        ]);
    }
}
