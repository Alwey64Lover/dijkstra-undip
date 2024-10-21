<?php

namespace App\Http\Controllers;

use App\Models\CourseDepartmentDetail;
use Illuminate\Http\Request;

class CourseDepartmentDetailController extends Controller
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
        if(request()->ajax()){
            return view('modules.courses.addcoursedeptdetail');
        }else{
            return view('modules.courses.addcoursedeptdetailfull');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
}
