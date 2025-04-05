<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = [
        'bus_id',
        'seat_Number',
        'reserved',
    ];
    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
    public function booking()
    {
        return $this->hasMany(Booking::class);
    }
}
