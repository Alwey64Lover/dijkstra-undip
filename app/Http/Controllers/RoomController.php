<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataRoom = Room::get();
        return view('modules/dashboard/academic-division', compact('dataRoom'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('modules/academicdivision/add-room');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        Room::create([
            'type' => $request->type,
            'name' => $request->name,
            'capacity' => $request->capacity,
            'department' => $request->departement
        ]);

        return redirect('addrooms');

    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $data = Room::find($id);
        return view('modules/academicdivision/edit-room', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Cari data berdasarkan ID dan hapus
        $room = Room::find($id);
        $room->delete();

        // Redirect atau return response
        return redirect('addrooms');
    }

}
