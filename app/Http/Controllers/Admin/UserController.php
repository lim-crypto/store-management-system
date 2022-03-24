<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\User;
use Illuminate\Http\Request;
use App\Helper\Helper;
use App\Model\Product;

class UserController extends Controller
{
    public function index()
    {
        // $users = User::all()->except(auth()->user()->id); // except admin
        $users = User::where('is_admin', 0)->get();
        return view('admin.users.index', compact('users'));
    }
    public function ban(User $user)
    {
        // cancel user reservations
        foreach ($user->reservations as $reservation) {
            if ($reservation->date > now()->format('Y-m-d H:i:s')) {
                $reservation->status = 'cancelled';
                $reservation->save();
                Helper::updatePetStatus($reservation->pet_id, 'cancelled');
            }
        }
        // cancel  user appointments
        foreach ($user->appointments as $appointment) {
            if ($appointment->date > now()->format('Y-m-d H:i:s')) {
                $appointment->status = 'cancelled';
                $appointment->save();
            }
        }
        // cancal user orders
        foreach ($user->orders as $order) {
            if ($order->payment_status == null && $order->status != 'delivered') {
                $order->status = 'cancelled';
                $order->save();
                $products = json_decode($order->products);
                foreach ($products as $product) {
                    Product::where('id', $product->id)->get()->first()->increment('quantity', $product->quantity);
                }
            }
        }
        session()->flash('message','Reservations and appointments of the user has been removed or cancelled successfully!');
        // if user has paid orders, then he cannot be banned
        if ($user->orders->where('status', '!=', 'delivered')->where('payment_status', 'Paid')->count() > 0) {
            return redirect()->back()->with('error', 'You cannot ban this user! , because he/she has paid orders which are not delivered yet!');
        }
        $user->is_active = false;
        $user->save();

        $details = [
            'title' => 'Account Deactivated',
            'date' => now(),
            'body' => 'Your account has been deactivated'
        ];
        \Mail::to($user->email)->send(new \App\Mail\Mail('Account Deactivated',  $details));
        return redirect()->back()->with('success', 'User successfully banned');
    }
}
