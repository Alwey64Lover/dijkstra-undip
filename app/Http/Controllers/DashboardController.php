<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Course;
use App\Models\CourseClass;
use App\Models\Department;
use App\Models\Room;
use App\Models\User;
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
            $filled = $request->filled ?? '';

            if (filled($filled))
                $data['filled'] = $filled;

            $data['countFilled'] = Student::where('academic_advisor_id', user()->lecturer->id)
            ->whereHas('herRegistrations', function($query){
                $query->whereHas('academicYear', function($query){
                    $query->where('is_active', 1);
                })
                ->whereHas('irs', function($query){
                    $query->where('is_submitted', 1);
                });
            })
            ->count();

            $data['countNotFilled'] = Student::where('academic_advisor_id', user()->lecturer->id)
            ->whereHas('herRegistrations', function($query){
                $query->whereHas('academicYear', function($query){
                    $query->where('is_active', 1);
                })
                ->whereHas('irs', function($query){
                    $query->where('is_submitted', 0);
                });
            })
            ->with(['lecturer', 'user', 'herRegistrations.irs', 'herRegistrations.academicYear'])
            ->count();

            $data["students"] = Student::where('academic_advisor_id', user()->lecturer->id)
                ->where(function ($query) use($filled) {
                    $query->whereHas('herRegistrations', function($query) use($filled){
                        $query->whereHas('academicYear', function($query){
                            $query->where('is_active', 1);
                        });
                        if (filled($filled)) {
                            $query->whereHas('irs', function($query) use ($filled){
                                if ($filled === 'filled'){
                                    $query->where('is_submitted', 1);
                                }
                                else{
                                    $query->where('is_submitted', 0);
                                }
                            });
                        }
                    });
                })
                ->orderBy('nim')
                ->with(['lecturer', 'user', 'herRegistrations.irs.irsDetails', 'herRegistrations.academicYear'])
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
            $data['username'] = User::where('role', 'head_of_department')->get()->first();
            // dd($data['username']);
            return view('modules.dashboard.headofdepartment', $data);
        } catch (\Exception $e) {
            logError($e, actionMessage("failed", "retrieved"), 'dashboard');
            abort(500);
        }
    }
    public function academicDivisionIndex(){
        try {
            $dataRoom = Room::get();
            // dd($dataRoom);
            return view('modules/dashboard/academic-division', compact('dataRoom'));
        } catch (\Exception $e) {
            logError($e, actionMessage("failed", "retrieved"), 'dashboard');
            abort(500);
        }
    }
}

