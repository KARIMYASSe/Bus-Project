<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'trip_id',
        'bus_id',
        'seat_id',
        'start_station_id',
        'end_station_id',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function trip(){
        return $this->belongsTo(Trip::class);
    }
    public function bus(){
        return $this->belongsTo(Bus::class);
    }
    public function seat(){
        return $this->belongsTo(Seat::class);
    }
    public function startstation(){
        return $this->belongsTo(Station::class,'start_station_id');
    }
    public function endstation(){
        return $this->belongsTo(Station::class,'end_station_id');
    }
}
