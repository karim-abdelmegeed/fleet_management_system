<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Station;
use App\Models\Trip;
use App\Models\TripStation;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trip = new Trip();
        $trip->bus_id = Bus::first()->id;
        $trip->start_at = Carbon::now()->addDay();
        $trip->arrival_at = Carbon::now()->addDay()->addHours(3);
        $trip->save();
        $trip_stations = [];
        $stations = Station::pluck('id')->toArray();
        foreach ($stations as $key => $station) {
            array_push($trip_stations, ['trip_id' => $trip->id, 'station_id' => $station, 'order' => $key]);
        }
        TripStation::insert($trip_stations);
    }
}
