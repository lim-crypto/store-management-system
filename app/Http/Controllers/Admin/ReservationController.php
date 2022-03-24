<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Mail\Mail;
use App\Model\Pet;
use App\Model\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function __construct()
    {
        Helper::checkPetReservation();
    }

    public function index()
    {
        $reservations = Reservation::all();
        return view('admin.reservations.index', compact('reservations'));
    }

    public function show(Reservation $reservation)
    {
        $reservation->pet->images = json_decode($reservation->pet->images);
        return view('admin.reservations.show', compact('reservation'));
    }
    public function update(Request $request, Reservation $reservation)
    {
        // update status
        $reservation->status = $request->status;
        $reservation->save();
        // update pet status
        Helper::updatePetStatus($reservation->pet_id, $request->status);
        $details = [
            'title' =>  $reservation->service .' '. $reservation->offer,
            'date'=> $reservation->date,
            'body' => 'Your reservation is '. $reservation->status ,

        ];
        \Mail::to($reservation->user->email)->send(new Mail('Reservation Updates',$details));
        return redirect()->back()->with('success', 'Status updated successfully');
    }

    public function reservationByStatus($status)
    {
        $reservations = Reservation::where('status', $status)->get();
        return view('admin.reservations.index', compact('reservations'));
    }
}
