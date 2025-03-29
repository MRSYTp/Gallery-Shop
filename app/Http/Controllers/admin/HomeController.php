<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\SalesService;

class HomeController extends Controller
{
    protected $salesService;

    public function __construct(SalesService $salesService)
    {
        $this->salesService = $salesService;
    }

    public function index()
    {
        $categoryCount = Category::count();
        $productCount = Product::count();
        $userCount = User::count();
        $orderCount = Order::count();
        $totalSellPrice = Order::where('status' , 'paid')->sum('amount');
        $salesData = $this->salesService->getMonthlySalesData();
        $monthPercentage = $this->salesService->getMonthPercentage();


        return view('admin.index', compact(
            'categoryCount',
            'productCount',
            'userCount',
            'orderCount',
            'totalSellPrice',
            'salesData',
            'monthPercentage'
        ));
    }
}
