<?php

namespace App\Http\Controllers;

use App\Helper\ResponseApi;
use App\Http\Requests\AvailableSeatsRequest;
use App\Http\Requests\BookRequest;
use App\Models\BusSeat;
use App\Models\Trip;
use App\Models\TripStation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeatController extends Controller
{

    private $responseApi;

    public function __construct(ResponseApi $responseApi)
    {
        $this->responseApi = $responseApi;
    }

    public function book(BookRequest $request)
    {
        $data = $request->validated();
        $bus_seat = BusSeat::find($data['seat_id']);
        if ($bus_seat->user_id) {
            return $this->responseApi->setError("this seat is already reserved")->returnJSON(422);
        }
        $bus_seat->user_id = auth()->id();
        $bus_seat->start_station_id = $data['start_station_id'];
        $bus_seat->end_station_id = $data['end_station_id'];
        $bus_seat->reserved_at = Carbon::now();
        $bus_seat->save();
        return $this->responseApi->setSuccess("Seat reserved Successfully")->setData($bus_seat)->returnJSON(200);
    }

    public function getAvailableSeats(AvailableSeatsRequest $request)
    {
        $data = $request->validated();
        //check trip exists for given destinations
        if (!$this->validateTripStations($data)) {
            return $this->responseApi->setError("there is no trip for specified stations")->returnJSON(422);
        }
        //get order of start station in trip

        $start_station_order = TripStation::where('trip_id', $data['trip_id'])
            ->where('station_id', $data['start_station_id'])->select('order')->first();
        //get all stations after start station

        $stations_after_start_station = TripStation::where('trip_id', $data['trip_id'])
            ->where('order', '>', $start_station_order->order)
            ->pluck('id')->toArray();
        //count users where end station in the list
        $available_seats = BusSeat::whereNotIn('end_station_id', $stations_after_start_station)
            ->orWhereNull('user_id')
            ->select('id as seat_id', 'seat_number')
            ->get();
        return $this->responseApi->setData($available_seats)->setSuccess("available seats retrieved successfully")->returnJSON(200);
    }

    public function validateTripStations($stations)
    {
        $trips = DB::select("SELECT * FROM trips
                    JOIN trip_station ts1 ON ts1.trip_id=trips.id
                    JOIN trip_station ts2 ON ts2.trip_id=trips.id
                    WHERE ts1.station_id = ${stations['start_station_id']}
                    AND ts2.station_id = ${stations['end_station_id']}
                    AND  ts1.order<ts2.order");
        return count($trips) > 0;
    }

}
