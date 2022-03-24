<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Model\Category;
use App\Model\Order;
use App\Model\Product;

class ProductController extends Controller
{
    //admin controller
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }
    public function store(ProductRequest $request)
    {
        $product = new Product();
        $product->category_id = $request->category;
        $product->image = $product->saveImage($request->image);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->is_featured = $request->is_featured;
        $product->save();
        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }
    public function update(ProductRequest $request, Product $product)
    {
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->category_id = $request->category;
        $product->quantity = $request->quantity;
        $product->is_featured = $request->is_featured;
        if ($request->hasFile('image')) {
            $product->deleteImage($product->image);
            $product->image = $product->saveImage($request->image);
        }
        $product->save();
        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }
    public function destroy(Product $product)
    {
        //can't delete product if it has orders ,  orders and products has no relationship  because we used json data to store product_id(s) with quantity in orders table
        $orders = Order::all();
        foreach ($orders as $order) {
            $order->products = json_decode($order->products);
            foreach ($order->products as $item) {
                if ($product->id == $item->id) {
                    return redirect()->route('products.index')->with('error', 'You cannot delete product');
                }
            }
        }

        $product->deleteImage($product->image);
        if ($product->delete()) {
            return redirect()->route('products.index')->with('success', 'Product deleted successfully');
        }
    }
}
