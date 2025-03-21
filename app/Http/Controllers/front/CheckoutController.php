<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CheckoutController extends Controller
{
    public function index()
    {
        $products = json_decode(Cookie::get('basket'), true) ?? [];

        $totalPrice = array_sum(array_column($products, 'price'));

        return view('frontend.checkout', compact('products', 'totalPrice'));
    }
}
