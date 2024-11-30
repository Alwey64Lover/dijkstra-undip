<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Course;
use App\Models\User;
use App\Models\CourseDepartment;
use App\Models\CourseDepartmentDetail;
use App\Models\CourseClass;
use App\Models\Department;
use App\Models\Room;
use App\Models\Lecturer;
use Illuminate\Http\Request;

class CourseDepartmentDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function table(Request $request)
    {
        try {
            $data['courseclasses'] = CourseClass::whereHas('courseDepartmentDetail', function($query) {
                $query->whereHas('courseDepartment', function($query){
                    $query->where('department_id', user()->department_id);
                });
            })
            ->with('courseDepartmentDetail.course')
            ->get();
            // dd( $data['courseclasses']);
            return view('modules.headofdepartment.schedules', $data);
        } catch (\Exception $e) {
            logError($e, actionMessage("failed", "retrieved"), 'schedule');
            abort(500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function form(string $action, string $id = null)
    {
        try{
            $data['allcourses'] = Course::get();
            $data['coursestatuses'] = CourseDepartmentDetail::STATUSES;
            $data['lecturers'] = Lecturer::with('user')->get();
            $data['existing_dept_courses'] = CourseDepartmentDetail::whereHas('courseDepartment', function($query){
                $query->where('department_id', user()->department_id)
                    ->where('academic_year_id', request('academic_year_id')); // Add this line
            })->with(['course', 'courseDepartment'])
            ->get();

            return view('modules.courses.addcoursedeptdetail', $data);
        }catch(\Exception $e){
            logError($e, actionMessage("failed", "retrieved"), 'load schedule form');
            abort(500);
        }
    }

    public function new_sched(Request $request){
        try{
            $data['latest_academic_year'] = AcademicYear::orderBy('id', 'desc')->first();
            $data['dept'] = Department::where('id',user()->department_id)->get();
            $data['existing_dept_courses'] = CourseDepartmentDetail::whereHas('courseDepartment', function($query){
                $query->where('department_id', user()->department_id);
            })->with(['course'])
            ->get();
            $data['roomavailable'] = Room::where('department', $data['dept']->select('name'))->get();
            // dd($data['latest_academic_year']);
            return view('modules.headofdepartment.newschedules', $data);
        }catch(\Exception $e){
            logError($e, actionMessage("failed", "retrieved"), 'load new schedule form');
            abort(500);
        }
    }

    public function filter(Request $request)
    {
        $academicYearId = $request->academic_year_id;
        $courses = CourseDepartmentDetail::whereHas('courseDepartment', function($query) use ($academicYearId) {
            $query->where('academic_year_id', $academicYearId);
        })->with('course')->get();

        return response()->json(['courses' => $courses]);
    }


    public function display_course(Request $request){
        try{
            $latest_academic_year = AcademicYear::orderBy('id', 'desc')->first();
            $data['existing_dept_courses'] = CourseDepartmentDetail::whereHas('courseDepartment', function($query){
                $query->where('department_id', user()->department_id);
            })->with(['course'])
            ->get();
            $data['lecturers'] = Lecturer::with('user')
            ->get();
            $data['academic_years'] = AcademicYear::get();
            $data['latest_academic_year_id'] = $latest_academic_year->id;
            // dd($data['academic_years']);
            return view('modules.headofdepartment.displaycourses',$data);
        }catch(\Exception $e){
            logError($e, actionMessage("failed", "retrieved"), 'load add course form');
            abort(500);
        }
    }
    public function course_store(Request $request)
    {
        $courseDepartmentDetail = new CourseDepartmentDetail();

        // Get course department based on selected academic year
        $courseDepartmentDetail->course_department_id = CourseDepartment::where('academic_year_id', $request->academic_year_id)
            ->first()
            ->id;

        $courseDepartmentDetail->course_id = $request->course_id;
        $courseDepartmentDetail->lecturer_ids = $request->lecturer_ids;
        $courseDepartmentDetail->status = $request->status;
        $courseDepartmentDetail->semester = $request->semester;
        $courseDepartmentDetail->sks = $request->sks;
        $courseDepartmentDetail->max_student = rand(40, 60);

        $courseDepartmentDetail->save();

        return response()->json([
            'name' => $courseDepartmentDetail->course->name,
            'semester' => $courseDepartmentDetail->semester,
            'sks' => $courseDepartmentDetail->sks
        ]);
    }

    public function course_update(Request $request, $id)
    {
        $courseDepartmentDetail = CourseDepartmentDetail::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'semester' => 'required|integer|min:1|max:8',
            'sks' => 'required|integer|min:1|max:6',
            'lecturer_ids' => 'required|array',
            'lecturer_ids.*' => 'exists:users,id'
        ]);

        $courseDepartmentDetail->course->update([
            'name' => $validated['name']
        ]);

        $courseDepartmentDetail->update([
            'semester' => $validated['semester'],
            'sks' => $validated['sks'],
            'lecturer_ids' => $validated['lecturer_ids']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Course updated successfully',
            'data' => $courseDepartmentDetail
        ]);
    }
    public function course_destroy($id)
    {
        $courseDepartmentDetail = CourseDepartmentDetail::findOrFail($id);
        $courseDepartmentDetail->delete();

        return response()->json([
            'success' => true,
            'message' => 'Course deleted successfully'
        ]);
    }

}
