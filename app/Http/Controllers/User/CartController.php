<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Model\Product;
use Illuminate\Http\Request;


class CartController extends Controller
{
    public function index()
    {
        $products = \Cart::session(auth()->id())->getContent()->sortBy('id');
        $shipping = 50;
        $cartSubTotal = \Cart::session(auth()->id())->getSubtotal();
        $cartFinalTotal = $cartSubTotal + $shipping;
        $data = [
            'products' => $products,
            'cartSubTotal' => $cartSubTotal,
            'cartFinalTotal' => $cartFinalTotal,
            'shippingFee' => $shipping,
        ];
        return view('user.carts.index')->with($data);
    }

    public function add(Product $product, Request $request)
    {
        \Cart::session(auth()->id())->add(array(
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $request->quantity? : 1,
            'attributes' => array(
                'image' => $product->image,
            ),
        ));
        // return redirect()->back();
        return redirect()->back()->with('success','An item successfully added to cart');
    }

    public function update(Request $request, Product $product)
    {
        \Cart::session(auth()->user()->id)->update($product->id,[
            'quantity' => array(
                'relative' => false,
                'value' => $request->quantity,
            )
        ]);
        return redirect()->back()->with('success', 'An item quantity has been updated successfuly');

    }

    public function remove(Product $product){
        \Cart::session(auth()->id())->remove($product->id);
        return redirect()->back()->with('success', 'A cart item has been removed successfully');
    }
}
