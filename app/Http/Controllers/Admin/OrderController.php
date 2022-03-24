<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\Mail;
use App\Model\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all()->sortByDesc('created_at');
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->products = json_decode($order->products);
        return view('admin.orders.show', compact('order'));
    }
    public function updateStatus(Request $request, Order $order)
    {
        $this->validate($request, [
            'status' => 'required',
        ]);
        $order->status = $request->status;
        if ($order->status == 'packed') {
            $order->packed_at = now();
        } elseif ($request->status == 'shipped') {
            $order->shipped_at = now();
        } elseif ($request->status == 'delivered') {
            $order->delivered_at = now();
        } elseif ($request->status == 'cancelled') {
            $order->cancelled_at = now();
        }
        $order->save();

        $details = [
            'title' => ' Order id : ' . $order->order_id,
            'date' =>  $order->created_at,
            'body' => 'Your order has been ' . $order->status,
        ];
        if ($order->transaction_id != null) {
            $details['transaction_id'] = $order->transaction_id;
        }
        // send mail to user
        \Mail::to($order->user->email)->send(new Mail('Order Updates', $details));

        return  redirect()->back()->with('success', 'Order status updated successfully');
    }
}
