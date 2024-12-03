<?php

namespace App\Http\Controllers;

use App\Models\HerRegistration;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\Khs;
use App\Models\Irs;
use App\Models\IrsDetail;
use Exception;
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

    function showStudentIrs(string $nim, Request $request) {
        $data['student'] = Student::where('nim', $nim)->first();

        try{
            if ($data['student']->lecturer != user()->lecturer)
                throw new Exception("Unauthorized access");

            $data['options'] = HerRegistration::where('student_id', $data['student']->id)
            // ->has('irss.irsDetails.khss')
            ->orderBy('semester')
            ->pluck('semester', 'semester')
            ->mapWithKeys(function ($semester) {
                return [$semester => "Semester ".$semester];
            })
            ->toArray();

            $data['semester_request'] = $request->semester ?? collect(array_keys($data['options']))->last();

            $data['irsDetails'] = IrsDetail::whereHas('irs.herRegistration', function ($query) use ($data){
                    $query->where('student_id', $data['student']->id)
                    ->where('semester', $data['semester_request']);
            })
            ->with(['irs.herRegistration'])
            ->with(['courseClass.courseDepartmentDetail.course'])
            ->with(['courseClass.courseDepartmentDetail.lecturers.user'])
            ->with(['courseClass.room'])
            ->get();

            $data['semester'] = [
                'type' => 'select',
                'id' => 'semester',
                'name' => 'semester',
                'disabledPlaceholder' => 1,
                'value' => $data['semester_request'],
                'options' => $data['options']
            ];

            return view('modules.lecturer.irs', $data);
        }catch (Exception $e){
            logError($e, actionMessage("failed", "open"), 'index');
            abort(500);
        }
    }

    function showStudentKhs(string $nim, Request $request) {
        $data['student'] = Student::where('nim', $nim)->first();

        $data['options'] = HerRegistration::where('student_id', $data['student']->id)
        ->has('irs')
        ->orderBy('semester')
        ->pluck('semester', 'semester')
        ->mapWithKeys(function ($semester) {
            return [$semester => "Semester ".$semester];
        })
        ->toArray();

        $data['semester_request'] = $request->semester ?? collect(array_keys($data['options']))->last();

        $data['khs'] = Khs::whereHas('irsDetail.irs.herRegistration', function ($query) use ($data){
            $query->where('student_id', $data['student']->id);
        })
        ->with(['irsDetail.irs.herRegistration'])
        ->with(['irsDetail.courseClass.courseDepartmentDetail.course'])
        ->get();

        $data['total_bobot_all'] = $data['total_sks_all'] = 0;

        foreach($data['khs'] as $mk){
            $data['total_bobot_all'] += bobot($mk->score)*$mk->irsDetail->courseClass->courseDepartmentDetail->sks;
            $data['total_sks_all'] += $mk->irsDetail->courseClass->courseDepartmentDetail->sks;
        }

        $data['khs'] = $data['khs']->filter(function ($item) use ($data) {
            return $item->irsDetail->irs->herRegistration->semester == $data['semester_request'];
        });

        $data['total_bobot_sem'] = $data['total_sks_sem'] = 0;

        foreach($data['khs'] as $mk){
            $data['total_bobot_sem'] += bobot($mk->score)*$mk->irsDetail->courseClass->courseDepartmentDetail->sks;
            $data['total_sks_sem'] += $mk->irsDetail->courseClass->courseDepartmentDetail->sks;
        }

        $data['semester'] = [
            'type' => 'select',
            'id' => 'semester',
            'name' => 'semester',
            'disabledPlaceholder' => 1,
            'value' => $data['semester_request'],
            'options' => $data['options']
        ];
        return view('modules.lecturer.khs', $data);
    }
}
