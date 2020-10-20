<?php

namespace App\Http\Controllers;

use App\Http\Requests\AvailableSeatsRequest;
use App\Http\Requests\BookRequest;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function book(BookRequest $request)
    {

    }

    public function getAvailableSeats(AvailableSeatsRequest $request){

    }
}
