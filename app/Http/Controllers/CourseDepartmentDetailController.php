<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseDepartment;
use App\Models\CourseDepartmentDetail;
use App\Models\CourseClass;
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
            // dd( $data);
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
    public function update(Request $request, CourseDepartmentDetail $courseDepartmentDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseDepartmentDetail $courseDepartmentDetail)
    {
        //
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
            // dd($data['existing_dept_courses']);
            return view('modules.headofdepartment.displaycourses',$data);
        }catch(\Exception $e){
            logError($e, actionMessage("failed", "retrieved"), 'load add course form');
            abort(500);
        }
    }
}
