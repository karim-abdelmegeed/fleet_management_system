<?php

namespace Database\Seeders;

use App\Models\Trip;
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
        $trip=new Trip();
        $trip->start_at=Carbon::now()->addDay();
        $trip->arrival_at=Carbon::now()->addDay()->addHours(3);
        $trip->save();
    }
}
