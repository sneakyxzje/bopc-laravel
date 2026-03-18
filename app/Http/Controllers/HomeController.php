<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = \App\Models\Product::with(['category', 'brand', 'attributes'])->get();

        $firstOrder = \App\Models\Order::with('items')->first();

        return view('home', compact('products', 'firstOrder'));
    }
}
