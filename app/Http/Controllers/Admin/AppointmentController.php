<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\Mail;
use App\Model\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::all();
        return view('admin.appointments.index', compact('appointments'));
    }
    public function show(Appointment $appointment)
    {
        return view('admin.appointments.show', compact('appointment'));
    }
    public function status(Request $request, Appointment $appointment)
    {
        $appointment->status = $request->status;
        $appointment->save();
        $details = [
            'title' =>  $appointment->service .' '. $appointment->offer,
            'date'=> $appointment->date,
            'body' => 'Your appointment is '. $appointment->status ,

        ];
        \Mail::to($appointment->user->email)->send(new Mail('Appointment Updates',$details));
        return redirect()->back()->with('success', 'Status updated successfully');
    }

    public function appointmentByStatus($status)
    {
        $appointments = Appointment::where('status', $status)->get();
        return view('admin.appointments.index', compact('appointments'));
    }
}
