<?php

namespace App\Http\Controllers;

use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:200|unique:stations,name',
        ]);
        $station = Station::create([
            'name' => $request->name,
        ]);
        return response()->json([
            "message" => 'stations is created',
            "station" => $station
        ], 201);
    }
    public function index()
    {
        $station = Station::all();
        return response()->json([
            "message" => 'all stations',
            "station" => $station
        ], 201);
    }
    public function show($id)
    {
        $station = Station::find($id);
        if (!$station) {
            return response()->json(['message' => 'this id is not found'], 400);
        };
        return response()->json([
            "message" => 'this the id',
            "station" => $station
        ], 201);
    }
    public function update(Request $request, $id)
    {
        $station = Station::find($id);
        if (!$station) {
            return response()->json(['message' => 'this id is not found'], 400);
        };
        $request->validate([
            'name' => 'required|max:200|unique:stations,name',
        ]);

        $station ->update([
            'name' => $request->name,
        ]);

        return response()->json([
            "message" => 'update is done',
            "station" => $station
        ], 201);
    }
    public function destroy(Request $request, $id)
    {
        $station = Station::find($id);
        if (!$station) {
            return response()->json(['message' => 'this id is not found'], 400);
        };

        $station ->delete();

        return response()->json([
            "message" => 'delete station is done'
        ], 201);
    }
}
