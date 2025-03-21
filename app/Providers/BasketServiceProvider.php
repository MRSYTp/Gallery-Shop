<?php 

namespace App\Providers;

use Illuminate\Support\Facades\Cookie;

class BasketServiceProvider
{   


    public static function totalPrice(){
        $products = json_decode(Cookie::get('basket'), true) ?? [];
        return array_sum(array_column($products, 'price'));
    }

}