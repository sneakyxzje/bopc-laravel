<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $baseQuery = Product::with(['primaryImage', 'category'])
            ->addSelect([
                'final_min_price' => ProductVariant::selectRaw('MIN(CASE WHEN sale_price IS NOT NULL AND sale_price > 0 THEN sale_price ELSE price END)')
                    ->whereColumn('product_id', 'products.id'),
                'final_max_price' => ProductVariant::selectRaw('MAX(CASE WHEN sale_price IS NOT NULL AND sale_price > 0 THEN sale_price ELSE price END)')
                    ->whereColumn('product_id', 'products.id')
            ])
            ->withMin('variants', 'price')
            ->withCount(['orderItems as total_sales' => function ($query) {
                $query->select(DB::raw('sum(quantity)'));
            }])
            ->where('is_active', true);

        // 1. Sản phẩm bán chạy 
        $bestSellers = (clone $baseQuery)
            ->having('total_sales', '>', 5)
            ->orderByDesc('total_sales')
            ->take(8)
            ->get();

        // 2. Sản phẩm mới về 
        $newArrivals = (clone $baseQuery)
            ->where('updated_at', '>=', now()->subDays(30))
            ->latest()
            ->take(8)
            ->get();

        // 3. PC Gaming bán chạy
        $pcGaming = (clone $baseQuery)
            ->whereHas('category', fn($q) => $q->where('slug', 'pc-gaming'))
            ->orderByDesc('total_sales')
            ->take(8)
            ->get();

        // 4. Laptop Gaming bán chạy
        $laptopGaming = (clone $baseQuery)
            ->whereHas('category', fn($q) => $q->where('slug', 'laptop-gaming'))
            ->orderByDesc('total_sales')
            ->take(8)
            ->get();

        // 5. Màn hình bán chạy
        $monitors = (clone $baseQuery)
            ->whereHas('category', fn($q) => $q->where('slug', 'monitors'))
            ->orderByDesc('total_sales')
            ->take(8)
            ->get();

        // 6. PC Mini
        $pcMini = (clone $baseQuery)
            ->whereHas('category', fn($q) => $q->where('slug', 'pc-mini'))
            ->orderByDesc('total_sales')
            ->take(8)
            ->get();

        // 7. Linh kiện máy tính
        $parts = (clone $baseQuery)
            ->whereHas('category', fn($q) => $q->where('slug', 'parts'))
            ->latest()
            ->take(8)
            ->get();

        $sliders = \App\Models\Banner::where('type', 'slider')->where('is_active', true)->orderBy('order')->get();
        $statics = \App\Models\Banner::where('type', 'static')->where('is_active', true)->orderBy('order')->take(3)->get();

        return view('home', compact('bestSellers', 'newArrivals', 'pcGaming', 'laptopGaming', 'monitors', 'sliders', 'statics', 'pcMini', 'parts'));
    }
}
