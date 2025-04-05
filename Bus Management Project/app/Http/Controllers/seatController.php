<?php

namespace App\Http\Controllers;

use App\Models\Seat;
use Illuminate\Http\Request;

class seatController extends Controller
{
    public function index(){
        $seat=Seat::with(['bus:id,bus_number'])->get();
        return response()->json([
            'message'=>'all seats',
            'seats'=>$seat,
        ],201);
    }
    public function show($id){
        $seat=Seat::with(['bus:id,bus_number'])->find($id);
        if(!$seat){
            return response()->json(['message'=>'this id is not found'],404);
        };
        return response()->json([
            'message'=>'this the seat',
            'seats'=>$seat,
        ],201);
    }
    public function update(Request $request,$id){
        $seat=Seat::find($id);
        if(!$seat){
            return response()->json(['message'=>'this id is not found'],404);
        };
        $request->validate([
            'reserved'=>'required|boolean'
        ]);
        $seat->reserved = $request->reserved;
        $seat->save();  

        return response()->json([
            'message'=>'type of seat is updated',
            'seats'=>$seat,
        ],201);
    }
}
