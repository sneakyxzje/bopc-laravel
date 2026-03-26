<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Product;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::with(['variants', 'images', 'category', 'brand'])->where('slug', $slug)->firstOrFail();
        return view('products.detail', compact('product'));
    }
}
