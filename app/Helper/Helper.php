<?php

namespace App\Helper;

use App\Model\Appointment;
use App\Model\Pet;
use App\Model\Reservation;
use App\Model\User;
use Illuminate\Support\Facades\Storage;

class Helper
{
    // save image
    public static  function saveImage($image, $name, $folder)
    {
        if ($image) {
            $imageName = $name . '_' .  $image->getClientOriginalName();
            $image->storeAs('images/' . $folder, $imageName, 'public');
            return $imageName;
        }
        return;
    }
    // delete image
    public static  function deleteImage($image, $folder)
    {
        if ($image) {
            Storage::delete('/public/images/' . $folder . '/' . $image);
        }
        return;
    }



    public static function checkPetReservation()
    {   //check if pet reservation is expired
        $reservations = Reservation::where('status', 'pending')->orWhere('status', 'approved')->get();
        foreach ($reservations as $reservation) {
            if ($reservation->expiration_date < now()->format('Y-m-d H:i:s')) {
                $reservation->status = 'expired';
                $reservation->save();
                // update pet status
                self::updatePetStatus($reservation->pet_id, 'expired');
            }
        }
        return;
    }

    public static function bookedDates()
    {

        $reservations = Reservation::where('user_id', '!=', auth()->id())->where('status', 'pending')->orWhere('status', 'approved')->orWhere('status', 'completed')->get();
        $appointments = Appointment::where('user_id', '!=', auth()->id())->where('status', 'pending')->orWhere('status', 'approved')->orWhere('status', 'completed')->get();
        $dates = [];
        $booked = [];
        $disabledDates = [];
        foreach ($reservations as $reservation) {
            $dates[] = $reservation->date;
            $booked[] = date('Y-m-d', strtotime($reservation->date));
        }
        foreach ($appointments as $appointment) {
            $dates[] = $appointment->date;
            $booked[] = date('Y-m-d', strtotime($appointment->date));
        }
        $booked = array_count_values($booked);
        foreach ($booked as $date => $count) {
            if ($count > 7) {
                $disabledDates[] = $date;
            }
        }
        $data = [
            'disabledDates' => json_encode($disabledDates),
            'dates' => json_encode($dates)
        ];
        return $data;
    }
    public static function checkDateAvailability($date, $time)
    {
        $date_time = date('Y-m-d H:i:s', strtotime("$date $time"));
        $reservations = Reservation::where('user_id', '!=', auth()->id())->where('date', $date_time)->where('status', 'pending')->get();
        $appointments = Appointment::where('user_id', '!=', auth()->id())->where('date', $date_time)->where('status', 'pending')->get();
        if (count($reservations) > 0 || count($appointments) > 0) {
            return false;
        }
        return true;
    }
    public static function checkPetStatus($pet_id)
    {
        $pet = Pet::find($pet_id);
        if ($pet->status != 'available') {
            return false;
        }
        return true;
    }

    public static function updatePetStatus($pet_id, $status)
    {
        $pet = Pet::find($pet_id);
        if ($status == 'reserved') {
            $pet->status = 'reserved';
            $pet->user_id = auth()->user()->id;
            $pet->save();
        }
        if ($status == 'rejected' || $status == 'cancelled' || $status == 'expired') {
            $pet->status = 'available';
            $pet->user_id = null;
            $pet->save();
        }
        if ($status == 'completed') {
            $pet->status = 'adopted';
            $pet->save();
        }
        return;
    }
    public static function updateUserInfo($first_name, $last_name, $contact_number)
    {
        $user = User::find(auth()->user()->id);
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->contact_number = $contact_number;
        $user->save();
        return;
    }
}
