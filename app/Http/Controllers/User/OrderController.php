<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders->sortByDesc('created_at');
        foreach ($orders as $order) {
            $order->products = json_decode($order->products);
        }
        return view('user.orders.index', compact('orders'));
    }
    public function show(Order $order)
    {
        $order->products = json_decode($order->products);
        return view('user.orders.show', compact('order'));
    }
    public function printOrder(Order $order)
    {
        $order->products = json_decode($order->products);
        return view('user.orders.printOrder', compact('order'));
    }

    public function cancelOrder(Order $order)
    {
        if (auth()->user()->id == $order->user_id) {

            if ($order->status == 'pending') {
                $order->status = 'cancelled';
                $order->cancelled_at = now();
                $order->save();

                $products = json_decode($order->products);
                foreach ($products as $product) {
                    Product::where('id', $product->id)->get()->first()->increment('quantity', $product->quantity);
                }

                return redirect()->route('orders.index')->with('success', 'Order has been cancelled successfully!');
            } else {
                return redirect()->route('orders.index')->with('error', 'You cannot cancel this order!');
            }
        } else {
            return redirect()->route('orders.index')->with('error', 'You are not authorized to cancel this order!');
        }
    }

}
