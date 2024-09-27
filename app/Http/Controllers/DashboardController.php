<?php

namespace App\Http\Controllers;

use App\Models\Student;
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

            default:
                abort(404);
                break;
        }
        return $dashboard;
    }


    public function lecturerIndex(){
        return view('modules.dashboard.lecturer', [
            "students" => Student::all() 
        ]);
    }

    public function studentIndex(){
        return view('modules.dashboard.student');
    }
}
