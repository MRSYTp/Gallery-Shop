<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function all()
    {   
        $orders = Order::paginate(10);
        return view('admin.order-all', compact('orders'));
    }
}
