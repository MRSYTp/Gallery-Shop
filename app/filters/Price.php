<?php 

namespace App\Filters;

use App\Models\Product;

class Price {



    public function between($prices)
    {
        $prices = $this->estandardizePrice($prices);

        
        if(count($prices) != 2){
            return null;
        }

        $products = Product::whereBetween('price' , $prices)->get();

        return $products;
    }

    private function estandardizePrice($price)
    {
        $price = explode('-' , $price);

        $price = array_map(function($item){
            $item = trim($item);
            if(is_numeric($item)){ 
                return $item * 1000;
            }

            return null;

        } , $price);

        $price = array_filter($price , function($item){
            return $item != null;
        });


        return $price;
    }
}
