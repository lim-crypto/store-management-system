<?php

namespace App\Http\Controllers\User;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentRequest;
use App\Mail\Mail;
use App\Model\Appointment;
use App\Model\Service;
use App\Model\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appointments = auth()->user()->appointments;
        $events = [];
        foreach ($appointments as $appointment) {
            if ($appointment->status != 'cancelled') {
                $events[] = \Calendar::event(
                    $appointment->service, //event title
                    false, //full day event?
                    new \DateTime($appointment->date), //start time (you can also use Carbon instead of DateTime)
                    new \DateTime($appointment->date), //end time (you can also use Carbon instead of DateTime)
                    'stringEventId' //optionally, you can specify an event ID
                );
            }
        }
        $calendar = \Calendar::addEvents($events); //add an array with addEvents
        $services = Service::all();
        foreach ($services as $service) {
            $service->offer = json_decode($service->offer);
        }
        $data = Helper::bookedDates();
        $disabledDates = $data['disabledDates'];
        $dates = $data['dates'];
        return view('user.appointments.index', compact('appointments', 'calendar', 'services', 'disabledDates', 'dates'));
    }

    public function create()
    {
        $services = Service::all();
        foreach ($services as $service) {
            $service->offer = json_decode($service->offer);
        }
        $data = Helper::bookedDates();
        $disabledDates = $data['disabledDates'];
        $dates = $data['dates'];
        return view('user.appointments.create', compact('dates', 'services', 'disabledDates'));
    }

    public function store(AppointmentRequest $request)
    {
        $dateIsAvailable = Helper::checkDateAvailability($request->date, $request->time);
        if ($dateIsAvailable == false) {
            return redirect()->back()->with('error', 'Date is not available');
        }
        $appointment = new Appointment;
        $appointment->user_id = auth()->user()->id;
        $appointment->service = $request->service;
        $appointment->offer = $request->offer;
        $appointment->date = date('Y-m-d H:i:s', strtotime("$request->date $request->time"));
        $appointment->save();
        // update user information
        Helper::updateUserInfo($request->first_name, $request->last_name, $request->contact_number);
        $details = [
            'title' =>  $appointment->service . ' ' . $appointment->offer,
            'date' => $appointment->date,
            'body' => 'Appointment has been made successfully, Please wait for approval',

        ];
        // send to user
        \Mail::to(auth()->user()->email)->send(new Mail('Appointment', $details));
        $details['body'] = 'New Appointment click the link below';
        $details['link'] = route('appointment', $appointment->id);
        // send to admin
        \Mail::to(env("MAIL_USERNAME", "premiumkennel123@gmail.com"))->send(new Mail('New Appointment', $details));
        return redirect()->route('user.appointments')->with('thanks', 'Appointment has been made successfully, Please wait for approval');
    }

    public function cancel(Appointment $appointment)
    {
        $appointment->status = 'cancelled';
        $appointment->save();
        $details = [
            'title' =>  $appointment->service . ' ' . $appointment->offer,
            'date' => $appointment->date,
            'body' => 'Reservation has been Cancelled',
        ];
        // send to admin
        \Mail::to(env("MAIL_USERNAME", "premiumkennel123@gmail.com"))->send(new Mail('Appointment Cancelled', $details));
        return redirect()->route('user.appointments')->with('success', 'Appointment cancelled successfully');
    }
}
