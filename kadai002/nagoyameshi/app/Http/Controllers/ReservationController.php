<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    //予約
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'time' => 'required',
            'num_of_ppl' => 'required'
        ]);

        $reservation = new Reservation();
        $reservation->date = $request->input('date');
        $reservation->time = $request->input('time');
        $reservation->num_of_ppl = $request->input('num_of_ppl');
        $reservation->restaurant_id = $request->input('restaurant_id');
        $reservation->user_id = Auth::user()->id;
        $reservation->save();

        return to_route('mypage')->with('reservation', '予約が完了しました。');
    }
}
