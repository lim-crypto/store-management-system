<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\Mail;
use App\Model\Order;
use App\Model\Product;
use App\Model\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $products = \Cart::session(auth()->id())->getContent()->sortBy('id');
        $cartSubTotal = \Cart::session(auth()->id())->getSubtotal();
        $shippingFee = 50;
        $cartFinalTotal = $cartSubTotal + $shippingFee;
        $shippingAddresses = auth()->user()->shipping_addresses;
        return view('user.orders.checkout', compact('products', 'cartSubTotal', 'cartFinalTotal', 'shippingFee', 'shippingAddresses'));
    }

    public function store(Request $request)
    {
        $products = \Cart::session(auth()->id())->getContent()->sortBy('id');
        $cartSubTotal = \Cart::session(auth()->id())->getSubtotal();
        $shippingFee = 50;
        $cartFinalTotal = $cartSubTotal + $shippingFee;

        $order = new Order();
        $order->order_id =  (string) Str::uuid();
        $order->user_id = auth()->user()->id;
        $order->products = $products;
        $order->products = json_encode($order->products);
        $order->subTotal = $cartSubTotal;
        $order->shippingFee = $shippingFee;
        $order->total = $cartFinalTotal;
        $order->shipping_address =  $request->shippingAddress;
        $order->payment_method = $request->paymentMethod;
        $order->payment_status = $request->paymentStatus;
        $order->transaction_id = $request->transaction_id;

        $order->save();

        foreach ($products as $product) {
            Product::where('id', $product->id)->get()->first()->decrement('quantity', $product->quantity);
        }

        \Cart::session(auth()->id())->clear();
        $details = [
            'title' => ' Order id : ' . $order->order_id,
            'date' =>  $order->created_at,
            'body' => 'Order has been made successfully, Please wait for delivery',
        ];
        if ($order->transaction_id != null) {
            $details['transaction_id'] = $order->transaction_id;
        }
        // send mail to user
        \Mail::to(auth()->user()->email)->send(new Mail('Order', $details));
        $details['body'] = "New Order click the link below";
        $details['link'] =  route('order', $order->id);
        //send mail to admin
        \Mail::to(env("MAIL_USERNAME", "premiumkennel123@gmail.com"))->send(new Mail('New Order', $details));
        return redirect()->route('orders.index')->with('success', 'Order has been placed successfully!');
    }
}
