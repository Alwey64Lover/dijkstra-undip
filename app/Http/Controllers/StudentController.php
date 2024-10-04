<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\Student;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Nullable;

class StudentController extends Controller
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
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }

    public function search(Request $request, string | null $lecturerId = null) {
        try {
            $data["students"] = Student::where('academic_advisor_id', user()->lecturer->id)
                ->where(function($query) use($request){
                    $query->whereHas('user', function($query) use($request){
                            $query->where('name', 'like', "%{$request->name}%");
                        })
                        ->where('nim', 'like', "%{$request->nim}%")
                        ->where('year', 'like', "%{$request->year}%");
                })
                ->orderBy('nim')
                ->with(['lecturer', 'user'])
                ->paginate(5);
    
            // Create a new instance of the LengthAwarePaginator to preserve query parameters
            $data['pagination'] = [
                'links' => $data['students']->appends($request->query())->links()->render(),
            ];
            
        } catch (\Exception $e) {
            logError($e, actionMessage("failed", "search"), 'index');
            abort(500);
        }
    
        return response()->json($data, 200);
    }
    
}
