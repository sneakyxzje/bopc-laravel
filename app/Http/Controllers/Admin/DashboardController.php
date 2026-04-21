<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_revenue' => \App\Models\Order::where('payment_status', 1)->sum('total_price'),
            'total_orders'  => \App\Models\Order::count(),
            'total_customers' => \App\Models\User::count(),
            'pending_orders' => \App\Models\Order::where('status', 0)->count(),
            'low_stock_products' => \App\Models\Product::whereHas('variants', function ($q) {
                $q->where('stock', '<=', 5);
            })->count(),
        ];

        $recent_orders = \App\Models\Order::latest()->take(5)->get();

        $revenue_data = [];
        $labels = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $labels[] = $month->format('M Y');
            $revenue_data[] = \App\Models\Order::where('payment_status', 1)
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('total_price');
        }

        return view('admin.dashboard', compact('stats', 'recent_orders', 'revenue_data', 'labels'));
    }
}
