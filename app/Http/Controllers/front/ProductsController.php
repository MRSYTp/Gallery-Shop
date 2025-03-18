<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {   
        $products = Product::all();
        $categories = Category::all();

        return view('frontend.index' , compact('products' , 'categories'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        $relatedProducts = Product::where('category_id' , $product->category_id)->take(4)->get();

        return view('frontend.single' , compact('product' , 'relatedProducts'));
    }
}
