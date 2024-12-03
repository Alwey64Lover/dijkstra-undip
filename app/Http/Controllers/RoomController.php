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
        $data['columns'] = Room::all();

        return view('modules.academicdivision.table', $data);
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
            'department' => $request->departement,
            'status' => 'waiting',
        ]);

        return redirect('room');
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
    public function update(Request $request, $id)
    {
        $data = Room::find($id);
        $data['type'] = $request->type;
        $data['name'] = $request->name;
        $data['capacity'] = $request->capacity;
        $data['department'] = $request->departement;
        // kembali ke halaman
        $data->save();

        $dataRoom = Room::get();
        return redirect('room');

        // return view('modules/dashboard/academic-division', compact('dataRoom'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Cari data berdasarkan ID dan hapus
        // dd(vars: $id);
        $room = Room::find($id);
        // dd($room);
        $room->delete();

        // Redirect atau return response
        return redirect('addrooms');
    }

    public function submit($id){
        $room = Room::find($id)->update([
            'isSubmitted' => 'sudah'
        ]);
        return redirect()->back()->with('success', 'Room berhasil disubmit!');
    }

    public function accept(Request $request, $id){
        $room = Room::find($id);
        $room->update([
            'status' => 'accepted'
        ]);

        return redirect()->back()->with('success', 'Ruangan berhasil disetujui!');
    }

}
