<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Lecturer;
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

            default:
                abort(404);
                break;
        }
        return $dashboard;
    }


    public function lecturerIndex(){
        return view('modules.dashboard.lecturer', [
            "lecturer" => user()->lecturer,
            "students" => user()->lecturer->students
        ]);
    }

    public function studentIndex(){
        return view('modules.dashboard.student');
    }

    public function headOfDepartmentIndex(){
        return view('modules.dashboard.headofdepartment');
    }
    public function academicDivisionIndex(){
        return view('modules.dashboard.academic-division', [
            "lecturer" => Lecturer::find(1)->lecturer,
            "students" => Lecturer::find(1)->students
        ]);
    }
}
