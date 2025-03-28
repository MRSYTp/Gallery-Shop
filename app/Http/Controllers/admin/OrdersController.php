<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function all(Request $request) 
    {
        $query = Order::query();
        
        $orders = $query->paginate(10);


        if ($request->search) {
            $query->whereHas('user', function ($query) use ($request) {
                $query->where('users.name', 'like', '%' . $request->search . '%');
            });

            $orders = $query->paginate(10);
        }
    
        return view('admin.order-all', compact('orders'));
    }
}
