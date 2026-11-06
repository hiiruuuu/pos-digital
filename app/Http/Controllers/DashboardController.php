<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Ringkasan (Metric Cards)
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('grand_total');

        // 2. Data Grafik Pendapatan Bulanan (Eloquent Aggregation)
        $monthlyRevenue = Order::select(
            DB::raw('SUM(grand_total) as total'),
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month")
        )
            ->where('status', 'completed')
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->get();

        $labels = $monthlyRevenue->pluck('month'); // Contoh: ['2026-05', '2026-06']
        $data = $monthlyRevenue->pluck('total');   // Contoh: [1500000, 3200000]

        return view('dashboard', compact('totalProducts', 'totalOrders', 'totalRevenue', 'labels', 'data'));
    }

    public function pos()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('pos.index', compact('products'));
    }
}
