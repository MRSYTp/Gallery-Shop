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
}