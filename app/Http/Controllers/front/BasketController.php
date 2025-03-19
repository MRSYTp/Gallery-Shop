<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class BasketController extends Controller
{
    public $expireTime = 60 * 24 * 2;


    public function add($id)
    {
        $product = Product::findOrFail($id);


        if(!$product){
            return redirect()->back()->with('error', 'Product not found');
        }

        $basket = json_decode(Cookie::get('basket'), true);

        if(!$basket){
            $basket = [
                $product->id => [
                    'title' => $product->title,
                    'price' => $product->price,
                    'demo_url' => $product->demo_url,
                ]
            ];

            Cookie::queue(Cookie::make('basket', json_encode($basket), $this->expireTime));

            return back()->with('success', 'Product added to basket');
        }

        if(isset($basket[$product->id])){
            return back()->with('error', 'Product already in basket');
        }

        $basket[$product->id] = [
            'title' => $product->title,
            'price' => $product->price,
            'demo_url' => $product->demo_url,
        ];

        Cookie::queue(Cookie::make('basket', json_encode($basket), $this->expireTime));

        return back()->with('success', 'Product added to basket');

    }

    public function remove($id)
    {
        $basket = json_decode(Cookie::get('basket'), true);

        if (isset($basket[$id])) {
            unset($basket[$id]);
        }

        Cookie::queue(Cookie::make('basket', json_encode($basket), $this->expireTime));

        return back();
    }
}
