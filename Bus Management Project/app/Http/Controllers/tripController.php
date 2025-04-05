<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\Trip;
use Illuminate\Http\Request;

class tripController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'StartStation' => 'required|string|exists:stations,name',
            'EndStation' => 'required|string|exists:stations,name',
            'intermediateStation' => 'array',
            'intermediateStation.*' => 'exists:stations,name',
        ]);

        $StartStation = Station::where('name', $request->StartStation)->first();
        $EndStation = Station::where('name', $request->EndStation)->first();
        $trip = Trip::create([
            'start_station_id' => $StartStation->id,
            'end_station_id' => $EndStation->id,
        ]);

        if ($request->has('IntermediateStation')) {
            $intermediateStations = Station::whereIn('name', $request->IntermediateStation)->pluck('id');
            $trip->intermediateStation()->sync($intermediateStations);
        }
        $trip = $trip->load([
            'startStation:id,name',
            'endStation:id,name',
            'intermediateStation:id,name'
        ]);

        return response()->json([
            'Message' => 'trip is created',
            'trip' => $trip
        ], 201);
    }
    public function index()
    {
        $trip = Trip::with([
            'startStation:id,name',
            'endStation:id,name',
            'intermediateStation:id,name',
        ])->get();
        return response()->json(
            [
                'Message' => 'this is the trip',
                'trips' => $trip
            ],
            200
        );
    }
    public function update(Request $request,$id){
        $trip=Trip::find($id);
        if(!$trip){
            return response()->json(["message"=>"this trip not found"],404);
        };
        $request->validate([
            'StartStation' => 'required|string|exists:stations,name',
            'EndStation' => 'required|string|exists:stations,name',
            'intermediateStation' => 'array',
            'intermediateStation.*' => 'exists:stations,name',
        ]);
        $StartStation = Station::where('name',$request->StartStation)->first();
        $EndStation = Station::where('name',$request->EndStation)->first();
        $trip->update([
        'start_station_id' => $StartStation->id,
            'end_station_id' => $EndStation->id,
        ]);
        if ($request->has('IntermediateStation')) {
            $intermediateStation_Id = Station::whereIn('name', $request->IntermediateStation)->pluck('id');
            $trip->intermediateStation()->sync($intermediateStation_Id);
        }
        $trip->load(['StartStation:id,name','EndStation:id,name','intermediateStation:id,name']);
        return response()->json([
            'message'=>'trip is updated well',
            'trip'=>$trip,
        ],201);
    }
    public function show($id){
        $trip = Trip::with([
            'startStation:id,name',
            'endStation:id,name',
            'intermediateStation:id,name',
        ])->find($id);
        if(!$trip){
            return response()->json(['message'=>'this trip not found'],404);
        };
        return response()->json([
            "message" => 'this the your trip id',
            "station" => $trip
        ], 201);
    }
    public function destroy($id){
        $trip = Trip::find($id);
        if(!$trip){
            return response()->json(['message'=>'this trip not found'],404);
        };
        $trip->delete();
        return response()->json([ "message" => 'the trip is deleted',], 201);
    }
}
