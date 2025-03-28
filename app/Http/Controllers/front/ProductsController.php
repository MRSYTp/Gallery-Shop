<?php

namespace App\Http\Controllers\front;

use App\Filters\orderBy;
use App\Filters\Price;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(Request $request)
    {   
        $products = Product::all();

        if($request->has('search')){

            $products = Product::where('title' , 'like' , '%'.$request->search.'%')->get();

        }

        if($request->has('orderby')){

            $products = $this->orderingProducts($request->orderby) ?? $products;

        }

        if($request->has('price')){

            $products = $this->filteringbyPrice($request->price);

        }
        
        $categories = Category::all();

        return view('frontend.index' , compact('products' , 'categories'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $ProductID = $product->id;

        $relatedProducts = Product::where('category_id' , $product->category_id)->take(4)->get();

        $relatedProducts = $relatedProducts->filter(function($product) use ($ProductID){
            return $product->id !== $ProductID;
        });


        return view('frontend.single' , compact('product' , 'relatedProducts'));
    }

    private function orderingProducts($orderBy)
    {

        $orderbyObj = new orderBy();

        if(!method_exists($orderbyObj , $orderBy)){
           return null;
        }

        return $orderbyObj->$orderBy();
    }

    private function filteringbyPrice($value)
    {
        $priceObj = new Price();

        return $priceObj->between($value);
    }
}
