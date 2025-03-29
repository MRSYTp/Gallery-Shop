<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class SalesService
{
    public function getMonthlySalesData()
    {
        $currentMonth = Carbon::now()->startOfMonth();
        $months = [];

        for ($i = 6; $i >= 0; $i--) {
            $month = $currentMonth->copy()->subMonths($i);
            $months['thisYear'][] = $month->format('Y-m');
            $months['lastYear'][] = $month->subYear()->format('Y-m');
        }

        $salesData = Order::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(amount) as total")
            ->whereBetween('created_at', [$currentMonth->copy()->subMonths(6), $currentMonth->endOfMonth()])
            ->where('status' , 'paid')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();



        $lastYearSalesData = Order::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(amount) as total")
            ->whereBetween('created_at', [
                $currentMonth->copy()->subMonths(6)->subYear(),
                $currentMonth->copy()->endOfMonth()->subYear()
            ])
            ->where('status' , 'paid')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();



        $currentYearSales = [];
        $previousYearSales = [];

        foreach ($months['thisYear'] as $month) {
            $currentYearSales[] = $salesData[$month] ?? 0;
        }

        foreach ($months['lastYear'] as $month) {
            $previousYearSales[] = $lastYearSalesData[$month] ?? 0;
        }

        
        return [
            'labels' => array_map(fn($m) => Carbon::parse($m . '-01')->format('M'), $months['thisYear']),
            'currentYear' => $currentYearSales,
            'previousYear' => $previousYearSales,
        ];
    }

    public function getMonthPercentage()
    {

        $currentMonth = Carbon::now()->startOfMonth();

        $monthlyTotalPrice = Order::whereMonth('created_at' , $currentMonth->month)
        ->whereYear('created_at' , Carbon::now()->year)
        ->where('status' , 'paid')
        ->sum('amount');

        $lastMonthTotalPrice = Order::whereMonth('created_at' ,  $currentMonth->subMonth()->month)
        ->whereYear('created_at' , Carbon::now()->subMonth()->year)
        ->where('status' , 'paid')
        ->sum('amount');


        $growthPercentage = 0;

        if ($lastMonthTotalPrice > 0) {
            $growthPercentage = (($monthlyTotalPrice - $lastMonthTotalPrice) / $lastMonthTotalPrice) * 100;
            $growthPercentage = round($growthPercentage, 1);
        }

        return $growthPercentage;
    }
}