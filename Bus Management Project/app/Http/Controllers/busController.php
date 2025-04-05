<?php
namespace App\Http\Controllers;
use App\Models\Bus;
use App\Models\Seat;
use Illuminate\Http\Request;

class busController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'all_seats' => 'required|integer|min:1|max:12',
            'bus_number' => 'required|string|unique:buses,bus_number',
        ]);
        $bus = Bus::create([
            'trip_id' => $request->trip_id,
            'all_seats' => $request->all_seats,
            'bus_number' => $request->bus_number,
        ]);
        for ($i = 1; $i <= $bus->all_seats; $i++) {
            Seat::create([
                'bus_id' => $bus->id,
                'seat_Number' => $i
            ]);
        }
        return response()->json([
            'message' => 'bus is created',
            'Bus' => $bus
        ], 201);
    }
    public function index()
    {
        $buses = Bus::with([
            'trip.startStation:id,name',
            'trip.endStation:id,name'
        ])->get();
        return response()->json([
            'message' => 'all information about bus',
            'Bus' => $buses
        ], 200);
    }
    public function update(Request $request,$id)
    {
        $request->validate([
            'trip_id'=>'exists:trips,id',
            'bus_number'=>'string|unique:buses,bus_number',
            'all_seats'=>'integer|min:1|max:12',
        ]);
        $bus=Bus::findorfail($id);
        $bus->update([
            'trip_id'=>$request->trip_id??$bus->trip_id,
            'bus_number'=>$request->bus_number??$bus->bus_number,
            'all_seats'=>$request->all_seats??$bus->all_seas
        ]);
        return response()->json([
            'message' => 'bus is updated',
            'Bus' => $bus
        ], 200);
    }
    public function show($id)
    {
     $bus = Bus::with([
        'trip.startstation:id,name',
        'trip.endstation:id,name',
        'seats:id,bus_id,seat_Number',
     ])->find($id);   
        
        return response()->json([
            'message' => 'this is your bus',
            'Bus' => $bus
        ], 200);
    }
    public function destroy($id)
    {
     $bus = Bus::find($id);

     $bus->delete();   
        return response()->json(['message' => 'the bus is deleted'], 200);
    }
    
}
