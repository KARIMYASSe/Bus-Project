<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $fillable = ['name'];
    public function first_trips(){
        return $this->hasMany(Trip::class,'start_station_id');
    }
    public function end_trips(){
        return $this->hasMany(Trip::class,'end_station_id
');
    }
    public function intermediate_trips(){
        return $this->hasMany(Trip::class,'IntermediateStation_id');
    }
    public function bookingsStartStation()
{
    return $this->hasMany(Booking::class, 'start_station_id');
}
public function bookingsAsEndStation()
{
    return $this->hasMany(Booking::class, 'end_station_id');
}
}
