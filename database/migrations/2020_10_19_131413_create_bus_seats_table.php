<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusSeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus_seats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bus_id');
            $table->string('seat_number')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('start_station_id')->nullable();
            $table->unsignedBigInteger('end_station_id')->nullable();
            $table->dateTime('reserved_at')->nullable();
            $table->foreign('bus_id')->on('buses')->references('id');
            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('start_station_id')->on('stations')->references('id');
            $table->foreign('end_station_id')->on('stations')->references('id');

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
        Schema::dropIfExists('bus_seats');
    }
}
