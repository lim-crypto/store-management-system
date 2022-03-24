<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\Product;

class ProductController extends Controller
{
    public function getProducts()
    {
        $categories = Category::all();
        $products = Product::where('quantity', '>', 0)->paginate(12);
        return view('products.index', compact('products', 'categories'));
    }
    public function getProductByCategory($category_id)
    {
        $categories = Category::all();
        $products = Product::where('category_id', $category_id)->where('quantity', '>', 0)->paginate(12);
        return view('products.index', compact('products', 'categories'));
    }
    public function getProduct(Product $product)
    {
        $products = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->where('quantity', '>', 0)->paginate(8);
        return view('products.show', compact('product', 'products'));
    }

}
