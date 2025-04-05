<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = [
        'trip_id',
        'all_seats',
        'bus_number',
    ];
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
