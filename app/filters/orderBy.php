<?php 

namespace App\Filters;

use App\Models\Product;

class orderBy {

    public function newest()
    {
        return Product::orderBy('created_at', 'desc')->get();
    }

    public function popular()
    {
        return Product::all();
    }

    public function priceAsc()
    {
        return Product::orderBy('price', 'asc')->get();
    }

    public function priceDesc()
    {
        return Product::orderBy('price', 'desc')->get();
    }
        
}