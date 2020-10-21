<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\BusSeat;
use App\Models\Station;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BusSeatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bus_seats = [];
        $bus_id = Bus::first()->id;
        for ($i = 1; $i <=12; $i++) {
            array_push($bus_seats, ['bus_id' => $bus_id, 'seat_number' => '#' . $i]);
        }
        BusSeat::insert($bus_seats);
    }
}
