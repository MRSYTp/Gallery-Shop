<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {   
        $categoryCount = Category::count();
        $productCount = Product::count();
        $userCount = User::count();
        $orderCount = Order::count();
        return view('admin.index',compact('categoryCount','productCount','userCount','orderCount'));
    }
}
