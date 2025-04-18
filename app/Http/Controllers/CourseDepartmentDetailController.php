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
            $data['courseclasses'] = CourseClass::whereHas('CourseDepartmentDetail', function($query) {
                $query->whereHas('courseDepartment', function($query){
                    $query->where('department_id', user()->department_id)
                            ->where('action_name', CourseDepartment::ACTIONS[1]);
                });
            })
            ->with([
                'CourseDepartmentDetail.course',
                'CourseDepartmentDetail.courseDepartment' => function($query) {
                    $query->join('academic_years', 'course_departments.academic_year_id', '=', 'academic_years.id')
                        ->select('course_departments.*', 'academic_years.name as academic_year_name');
                }
            ])
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

    public function schedule_check(Request $request)
    {
        $exists = CourseClass::whereHas('courseDepartmentDetail.courseDepartment', function($query) {
            $query->where('academic_year_id', request('academic_year_id'));
        })->whereHas('courseDepartmentDetail.course', function($query) use ($request) {
            $query->where('name', $request->course_name);
        })->where('name', $request->class_name)->exists();

        return response()->json(['exists' => $exists]);
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

    public function schedule_store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required',
            'course_department_detail_id' => 'required',
            'name' => 'required',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $schedule = CourseClass::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Schedule created successfully',
            'data' => $schedule
        ]);
    }

    public function checkCourseDepartmentStatus(Request $request)
    {
        try {
            $academicYearId = $request->academic_year_id;
            $isAccepted = CourseDepartment::where('academic_year_id', $academicYearId)
                ->where('action_name', 'accepted')
                ->exists();

            return response()->json(['is_accepted' => $isAccepted]);
        } catch (\Exception $e) {
            logError($e, actionMessage("failed", "retrieved"), 'schedule');
            abort(500);
        }
    }


    public function schedule_destroy($id)
    {
        try {
            $schedule = CourseClass::findOrFail($id);
            $schedule->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }

    public function checkRoomAvailability(Request $request)
    {
        $currentAcademicYear = AcademicYear::where('name', '2024/2025 Genap')->first();

        $isAvailable = !CourseClass::where('room_id', $request->room_id)
            ->whereHas('courseDepartmentDetail.courseDepartment', function($query) use ($currentAcademicYear) {
                $query->where('academic_year_id', $currentAcademicYear->id);
            })
            ->where('day', $request->day)
            ->where(function($query) use ($request) {
                $query->where(function($q) use ($request) {
                    $q->where('start_time', '<=', $request->start_time)
                    ->where('end_time', '>', $request->start_time);
                })->orWhere(function($q) use ($request) {
                    $q->where('start_time', '<', $request->end_time)
                    ->where('end_time', '>=', $request->end_time);
                })->orWhere(function($q) use ($request) {
                    $q->where('start_time', '>=', $request->start_time)
                    ->where('end_time', '<=', $request->end_time);
                });
            })
            ->exists();

        return response()->json(['isAvailable' => $isAvailable]);
    }


    public function display_schedules()
    {
        $currentAcademicYear = AcademicYear::where('name', '2024/2025 Genap')->first();

        $schedules = CourseClass::with(['room', 'courseDepartmentDetail.course', 'courseDepartmentDetail.courseDepartment'])
            ->whereHas('courseDepartmentDetail.courseDepartment', function($query) use ($currentAcademicYear) {
                $query->where('academic_year_id', $currentAcademicYear->id);
            })
            ->get()
            ->map(function($schedule) {
                return [
                    'id' => $schedule->id,
                    'start_time' => $schedule->start_time,
                    'end_time' => $schedule->end_time,
                    'course_name' => $schedule->courseDepartmentDetail->course->name,
                    'name' => $schedule->name,
                    'room_name' => $schedule->room->type . $schedule->room->name,
                    'day' => $schedule->day,
                    'is_submitted' => $schedule->courseDepartmentDetail->courseDepartment->is_submitted
                ];
            });

        return response()->json($schedules);
    }


    public function submitSchedule()
    {
        $currentAcademicYear = AcademicYear::where('name', '2024/2025 Genap')->first();

        CourseDepartment::where('academic_year_id', $currentAcademicYear->id)
            ->update(['is_submitted' => true]);

        return response()->json(['message' => 'Schedule submitted successfully']);
    }

    public function checkSubmissionStatus()
    {
        $currentAcademicYear = AcademicYear::where('name', '2024/2025 Genap')->first();
        $isSubmitted = CourseDepartment::where('academic_year_id', $currentAcademicYear->id)
            ->where('is_submitted', true)
            ->exists();

        return response()->json(['isSubmitted' => $isSubmitted]);
    }


    public function course_update(Request $request, $id)
    {
        $courseDepartmentDetail = CourseDepartmentDetail::findOrFail($id);

        $validated = $request->validate([
            'name' => 'string|max:255',
            'semester' => 'required|integer|min:1|max:8',
            'sks' => 'required|integer|min:1|max:6',
            'lecturer_ids' => 'required|array',
            'lecturer_ids.*' => 'exists:lecturers,id'
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
