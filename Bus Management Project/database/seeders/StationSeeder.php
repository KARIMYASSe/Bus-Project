<?php

namespace Database\Seeders;

use App\Models\Station;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stations = ['Cairo', 'Giza', 'Fayoum', 'Minya', 'Assiut','Alexandria'];

        foreach ($stations as $station) {
            Station::create(['name' => $station]);
        }
    }
}
