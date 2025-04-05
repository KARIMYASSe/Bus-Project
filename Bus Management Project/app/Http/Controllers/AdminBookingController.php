<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Seat;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminBookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            "trip_id" => 'required|exists:trips,id',
            "bus_id" => 'required|exists:buses,id',
            "seat_id" => 'required|exists:seats,id',
        ]);
        $seat = Seat::where('id', $request->seat_id)->where('bus_id', $request->bus_id)->first();
        if (!$seat) {
            return response()->json(['message' => 'invalid seat'], 400);
        };
        if ($seat->reserved) {
            return response()->json(['message' => 'sorry this seat is reserved'], 200);
        }
        $trip = Trip::find($request->trip_id);
        $booking = Booking::create([
            'trip_id' => $request->trip_id,
            'bus_id' => $request->bus_id,
            'seat_id' => $request->seat_id,
            'user_id' => Auth::user()->id,
            'start_station_id' => $trip->start_station_id,
            'end_station_id' => $trip->end_station_id,
        ]);
        $booking->load(['startstation', 'endstation', 'bus', 'seat', 'trip','user']);
        $seat->reserved = true;
        $seat->save();
        return response()->json([
            'message' => 'you booking done',
            'user_id' => $booking->user->id,
            'user_name' => $booking->user->name,
            'trip' => $booking->trip->id,
            'seat' => $booking->seat->seat_number,
            'bus_Number' => $booking->bus->bus_number,
            'trip_from' => $booking->startStation->name,
            'trip_to' => $booking->endStation->name,
            'intermediate_stations' => $booking->trip->intermediateStation->pluck('name'),
        ], 201);
    }
    public function index()
    {
        $booking = Booking::with([
            'trip.startStation',
            'trip.endStation',
            'trip.intermediateStation',
            'bus',
            'seat'
        ])->get();
        return response()->json([
            'message' => 'all of booking',
            'bookings'=>$booking
        ], 200);
    }
    public function show($id)
    {
        $booking = Booking::with([
            'trip.startStation',
            'trip.endStation',
            'trip.intermediateStation',
            'bus',
            'seat'
        ])->find($id);
        return response()->json([
            'message' => 'this is your booking',
            'trip' => $booking->trip->id,
            'seat' => $booking->seat->seat_number,
            'bus_Number' => $booking->bus->bus_number,
            'trip_from' => $booking->startStation->name,
            'trip_to' => $booking->endStation->name,
            'intermediate_stations' => $booking->trip->intermediateStation->pluck('name'),
        ], 200);
    }
    public function update(Request $request,$id){
        $request->validate([
            "trip_id" => 'required|exists:trips,id',
            "bus_id" => 'required|exists:buses,id',
            "seat_id" => 'required|exists:seats,id',
        ]);
        $booking=Booking::find($id);
        if(!$booking){
            return response()->json(['message' => 'booking is not found'], 404);
        }
        $seat = Seat::where('id', $request->seat_id)->where('bus_id', $request->bus_id)->first();
        if (!$seat) {
            return response()->json(['message' => 'invalid seat'], 400);
        };
        if ($seat->reserved) {
            return response()->json(['message' => 'sorry this seat is reserved'], 200);
        }
        $trip = Trip::find($request->trip_id);
        $booking->update([
            'trip_id' => $request->trip_id,
            'bus_id' => $request->bus_id,
            'seat_id' => $request->seat_id,
            'user_id' => Auth::user()->id,
            'start_station_id' => $trip->start_station_id,
            'end_station_id' => $trip->end_station_id,
        ]);
        if ($seat->id != $booking->seat_id) {
            $lastSeat = Seat::find($booking->seat_id);
            $lastSeat->reserved = false;
            $lastSeat->save();
            $seat->reserved = true;
            $seat->save();
        }
        return response()->json([
            'message' => 'you booking is updated',
            'user_id' => $booking->user->id,
            'user_name' => $booking->user->name,
            'trip' => $booking->trip->id,
            'seat' => $booking->seat->seat_number,
            'bus_Number' => $booking->bus->bus_number,
            'trip_from' => $booking->startStation->name,
            'trip_to' => $booking->endStation->name,
            'intermediate_stations' => $booking->trip->intermediateStation->pluck('name'),
        ], 200);
    }

    public function destroy($id){
        $booking = Booking::find($id);
        if(!$booking){
            return response()->json(['message'=>'this booking is not found']);
        };
        $seat=$booking->seat;
        if($seat){
            $seat->reserved=false;
            $seat->save();
        }
        $booking->delete();
        $booking->save();
        return response()->json(['message'=>'booking is deleted']);
    }
}
