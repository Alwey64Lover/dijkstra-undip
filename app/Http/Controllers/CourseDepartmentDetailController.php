<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseDepartment;
use App\Models\CourseDepartmentDetail;
use App\Models\CourseClass;
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
            $data['lecturers'] = Lecturer::with('user')
            ->get();
            // dd( $data['lecturers']);
            return view('modules.courses.addcoursedeptdetail', $data);
        }catch(\Exception $e){
            logError($e, actionMessage("failed", "retrieved"), 'load schedule form');
            abort(500);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function action(Request $request, string $action, string $id = null)
    {
        // $request->validate([
        //     'course'
        // ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseDepartmentDetail $courseDepartmentDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourseDepartmentDetail $courseDepartmentDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function course_update(Request $request, $id)
    {
        $courseDepartmentDetail = CourseDepartmentDetail::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'semester' => 'required|integer|min:1|max:8',
            'sks' => 'required|integer|min:1|max:6',
            'lecturer_id' => 'required|exists:users,id'
        ]);

        $courseDepartmentDetail->course->update([
            'name' => $validated['name']
        ]);

        $courseDepartmentDetail->update([
            'semester' => $validated['semester'],
            'sks' => $validated['sks'],
            'lecturer_id' => $validated['lecturer_id']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Course updated successfully',
            'data' => $courseDepartmentDetail
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function course_destroy($id)
    {
        $courseDepartmentDetail = CourseDepartmentDetail::findOrFail($id);
        $courseDepartmentDetail->delete();

        return response()->json([
            'success' => true,
            'message' => 'Course deleted successfully'
        ]);
    }

    public function new_sched(Request $request){
        try{
            $data['existing_dept_courses'] = CourseDepartmentDetail::whereHas('courseDepartment', function($query){
                $query->where('department_id', user()->department_id);
            })->with(['course'])
            ->get();
            // dd($data['existing_dept_courses']);
            return view('modules.headofdepartment.newschedules', $data);
        }catch(\Exception $e){
            logError($e, actionMessage("failed", "retrieved"), 'load new schedule form');
            abort(500);
        }
    }
    public function display_course(Request $request){
        try{
            $data['existing_dept_courses'] = CourseDepartmentDetail::whereHas('courseDepartment', function($query){
                $query->where('department_id', user()->department_id);
            })->with(['course'])
            ->get();
            $data['lecturers'] = Lecturer::with('user')
            ->get();
            // dd($data['existing_dept_courses']);
            return view('modules.headofdepartment.displaycourses',$data);
        }catch(\Exception $e){
            logError($e, actionMessage("failed", "retrieved"), 'load add course form');
            abort(500);
        }
    }
    public function course_store(Request $request)
    {
        $courseDepartmentDetail = new CourseDepartmentDetail();
        $courseDepartmentDetail->course_department_id = CourseDepartment::inRandomOrder()->first()->id;
        $courseDepartmentDetail->course_id = $request->course_id;
        $courseDepartmentDetail->lecturer_ids = json_encode($request->lecturer_ids);
        $courseDepartmentDetail->status = $request->status;
        $courseDepartmentDetail->semester = $request->semester;
        $courseDepartmentDetail->sks = $request->sks;
        $courseDepartmentDetail->max_student = rand(40, 60);

        // dd($request->all(), $courseDepartmentDetail->toArray());
        $courseDepartmentDetail->save();

        return response()->json([
            'name' => $courseDepartmentDetail->course->name,
            'semester' => $courseDepartmentDetail->semester,
            'sks' => $courseDepartmentDetail->sks
        ]);
    }

}
