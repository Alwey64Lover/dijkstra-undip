<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Course;
use App\Models\CourseClass;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $data = [
        'title' => 'Dashboard',
    ];

    public function index(Request $request){
        $dashboard = '';
        switch (user()->role) {
            case 'lecturer':
                 $dashboard = $this->lecturerIndex($request);
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


    public function lecturerIndex(Request $request){
        $data = $this->data;

        try {
            $year = $request->year ?? '';

            $data['year'] = [
                'type' => 'select',
                'id' => 'year',
                'name' => 'year',
                'placeholder' => 'Semua Angkatan',
                'value' => $year,
                'options' => Student::orderBy('year')
                    ->pluck('year', 'year')
                    ->toArray()
            ];

            $data["students"] = Student::where('academic_advisor_id', user()->lecturer->id)
                ->where(function ($query) use($year) {
                    if (filled($year)) {
                        $query->where('year', $year);
                    }
                })
                ->orderBy('nim')
                ->with(['lecturer', 'user'])
                ->get();

            return view("modules.dashboard.lecturer", $data);
        } catch (\Exception $e) {
            logError($e, actionMessage("failed", "open"), 'index');
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
        try {
            $data['courseclasses'] = CourseClass::whereHas('courseDepartmentDetail', function($query) {
                $query->whereHas('courseDepartment', function($query){
                    $query->where('department_id', user()->department_id);
                });
            })
            ->with('courseDepartmentDetail.course')
            ->get();
            return view('modules.dashboard.headofdepartment', $data);
        } catch (\Exception $e) {
            logError($e, actionMessage("failed", "retrieved"), 'dashboard');
            abort(500);
        }
    }
    public function academicDivisionIndex(){
        return view('modules.dashboard.academic-division', [
            'students' => Student::all()
        ]);
    }
}
