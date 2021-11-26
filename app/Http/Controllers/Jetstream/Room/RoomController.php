<?php

namespace App\Http\Controllers\Jetstream\Room;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Room\RoomRequest;
use App\Models\Room;
use Inertia\Inertia;


class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = (int) $request->get('per_page') > 0 ? (int) $request->get('per_page') : 15;
        $page = (int) $request->get('page') > 0 ? (int) $request->get('page') : 1;
        $queries = ['search', 'page'];
        return Inertia::render('Room/Index', [
            'rooms' => Room::applyFilters($request->only($queries))
                ->paginateData($limit),
            'filtersRooms' => $request->all($queries),
            'start' => $limit * ($page - 1),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Room/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\RoomRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomRequest $request)
    {
        Room::createRoom($request);

        return redirect()->route('rooms.index')->with('success', 'Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        return Inertia::render('Room/Edit', [
            'room' => $room
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoomRequest $request, Room $room)
    {
        $room->updateRoom($request);

        return redirect()->route('rooms.index')->with('success', 'Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
