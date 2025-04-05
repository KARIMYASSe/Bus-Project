<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'start_station_id',
        'end_station_id'
    ];
    public function startStation()
    {
        return $this->belongsTo(Station::class, 'start_station_id');
    }
    public function endStation()
    {
        return $this->belongsTo(Station::class, 'end_station_id');
    }
    public function intermediateStation(){
        return $this->belongsToMany(Station::class, 'intermediate_station');
    }

    public function buses()
    {
        return $this->hasMany(Bus::class);
    }
    public function booking()
    {
        return $this->hasMany(Booking::class);
    }
}
