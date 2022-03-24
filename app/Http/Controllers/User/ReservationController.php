<?php

namespace App\Http\Controllers\User;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationRequest;
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
        $reservations = Reservation::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        foreach ($reservations as $reservation) {
            $reservation->pet->images = json_decode($reservation->pet->images);
        }
        return view('user.reservations.index', compact('reservations'));
    }
    public function show(Reservation $reservation)
    {
        $reservation->pet->images = json_decode($reservation->pet->images);
        return view('user.reservations.show', compact('reservation'));
    }

    public function create(Pet $pet)
    {
        $data = Helper::bookedDates();
        $disabledDates = $data['disabledDates'];
        $dates = $data['dates'];
        return view('user.reservations.create', compact('pet', 'disabledDates', 'dates'));
    }

    public function store(ReservationRequest $request)
    {
        $petIsAvailable =  Helper::checkPetStatus($request->pet_id);
        $dateIsAvailable = Helper::checkDateAvailability($request->date, $request->time);
        if ($petIsAvailable == false) {
            return redirect()->route('pets')->with('error', 'Pet is not available');
        }
        if ($dateIsAvailable == false) {
            return redirect()->back()->with('error', 'Date is not available');
        }
        $reservation = new Reservation;
        $reservation->pet_id = $request->pet_id;
        $reservation->user_id = auth()->user()->id;
        $reservation->date = date('Y-m-d H:i:s', strtotime("$request->date $request->time"));
        $reservation->expiration_date = date('Y-m-d H:i:s', strtotime("+7 day", strtotime(now())));
        $reservation->save();
        // update pet status
        Helper::updatePetStatus($request->pet_id, 'reserved');
        // update user information
        Helper::updateUserInfo($request->first_name , $request->last_name, $request->contact_number);
        $details = [
            'title' => $reservation->pet->type->name . ' - ' . $reservation->pet->breed->name . ' - ' . $reservation->pet->name,
            'date' =>  $reservation->date,
            'body' => 'Reservation has been made successfully, Please wait for approval',
        ];
        // send mail to user
        \Mail::to(auth()->user()->email)->send(new Mail('Reservation', $details));
        $details['body'] = "New Reservation click the link below";
        $details['link'] = route('reservation', $reservation->id);
        // send mail to admin
        \Mail::to(env("MAIL_USERNAME", "premiumkennel123@gmail.com"))->send(new Mail('New Reservation', $details));
        return redirect()->route('user.reservations')->with('thanks', 'Reservation has been made successfully, Please wait for approval');
    }

    // cancel reservation
    public function cancel(Reservation $reservation)
    {
        if ($reservation->status == 'pending') {
            $reservation->status = 'cancelled';
            $reservation->save();
            Helper::updatePetStatus($reservation->pet_id, 'cancelled');
            $details = [
                'title' => $reservation->pet->type->name . ' - ' . $reservation->pet->breed->name . ' - ' . $reservation->pet->name,
                'date' =>  $reservation->date,
                'body' => 'Reservation has been Cancelled',
            ];
            \Mail::to(env("MAIL_USERNAME", "premiumkennel123@gmail.com"))->send(new Mail('Reservation Cancelled', $details));
            return redirect()->back()->with('success', 'Reservation cancelled successfully');
        }
        return redirect()->back()->with('error', 'Reservation cannot be cancelled');
    }
}
