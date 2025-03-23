<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function orderDetails(Request $request)
    {
        if(!$request->ajax())
        {
            return response()->json(['error' => 'Invalid request'], 400);
        }

        $orderItems = OrderItem::where('order_id' , $request->order_id)->get();
        if($orderItems->isEmpty())
        {
            return response()->json(['error' => 'No order items found'], 404);
        }

        $products = [];
        foreach($orderItems as $item)
        {
            $products[] = [
                'title' => $item->product->title,
                'category' => $item->product->category->title,
                'thumbnail_url' => $item->product->thumbnail_url,
                'demo_url' => route('admin.products.downloadDemo' , $item->product->id),
                'source_url' => route('admin.products.downloadSource' , $item->product->id),
                'amount' => $item->product->price,
            ];
        }

        return response()->json($products);
    }
}
