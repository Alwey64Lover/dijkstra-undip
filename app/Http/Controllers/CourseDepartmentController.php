<?php

namespace App\Http\Controllers;

use App\Models\CourseDepartment;
use Illuminate\Http\Request;

class CourseDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['filled'] = $request->filled ?? null;
        $data['countFilled'] = CourseDepartment::where('academic_year_id', academicYearId())
            ->where('is_submitted', 1)
            ->count();

        $data['countNotFilled'] = CourseDepartment::where('academic_year_id', academicYearId())
            ->where('is_submitted', 0)
            ->count();

        $data['courseDepartments'] = CourseDepartment::where('academic_year_id', academicYearId())
            ->where(function($q) use($data){
                if (isset($data['filled']) && in_array($data['filled'], ['filled', 'notFilled'])) {
                    $q->where('is_submitted', $data['filled'] == 'filled' ? 1 : 0);
                }
            })
            ->with('department')
            ->get();

        return view('modules.dean.index', $data);
    }

    public function acceptSome(Request $request){
        foreach (explode(',', $request->input('selectedDepartments', '')) as $i => $departmentId) {
            CourseDepartment::find($departmentId)
            ->update([
                'action_name' => 'accepted',
                'action_at' => now()
            ]);
        }

        return redirect()->back()->with('success', 'Jadwal Department berhasil disetujui!');
    }

    public function show($id) {
        $data['courseDepartment'] = CourseDepartment::with('department')->find($id);
        return view('modules.dean.detail', $data);
    }

    public function acceptOrReject($id, $status) {
        CourseDepartment::find($id)->update([
            'action_name' => $status,
            'action_at' => now()
        ]);

        return redirect()->back()->with('success', 'Jadwal Department berhasil '. ($status == 'accepted' ? 'disetujui' : 'ditolak') .'!');
    }
}
