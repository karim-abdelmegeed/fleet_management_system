<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::insert(['name'=>'super','email'=>'super@gmail.com','password'=>bcrypt('123456')]);
         \App\Models\User::factory(10)->create();
         $this->call(StationSeeder::class);
         $this->call(BusSeeder::class);
         $this->call(TripSeeder::class);
         $this->call(BusSeatsSeeder::class);
    }
}
