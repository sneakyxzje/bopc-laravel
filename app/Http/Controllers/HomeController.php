<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with(['primaryImage', 'category'])
            ->addSelect([
                'final_min_price' => ProductVariant::selectRaw('MIN(CASE WHEN sale_price IS NOT NULL AND sale_price > 0 THEN sale_price ELSE price END)')
                    ->whereColumn('product_id', 'products.id')
            ])
            ->addSelect([
                'final_max_price' => ProductVariant::selectRaw('MAX(CASE WHEN sale_price IS NOT NULL AND sale_price > 0 THEN sale_price ELSE price END)')
                    ->whereColumn('product_id', 'products.id')
            ])
            ->withMin('variants', 'price')
            ->where('is_active', true)
            ->paginate(12);

        return view('home', compact('products'));
    }
}
