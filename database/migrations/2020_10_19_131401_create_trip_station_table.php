<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripStationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_station', function (Blueprint $table) {
            $table->id();
            $table->integer('order');
            $table->unsignedBigInteger('trip_id');
            $table->unsignedBigInteger('station_id');
            $table->foreign('trip_id')->on('trips')->references('id');
            $table->foreign('station_id')->on('stations')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trip_station');
    }
}
