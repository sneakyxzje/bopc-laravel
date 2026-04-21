<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function show($slug, Request $request)
    {
        if ($slug === 'ban-chay') {
            $category = new Category(['name' => 'Sản phẩm bán chạy', 'slug' => 'ban-chay']);
            $query = Product::where('is_active', true)
                ->withCount(['orderItems as total_sales' => function ($q) {
                    $q->select(DB::raw('sum(quantity)'));
                }])
                ->having('total_sales', '>', 5);
        } elseif ($slug === 'moi-ve') {
            $category = new Category(['name' => 'Sản phẩm mới về', 'slug' => 'moi-ve']);
            $query = Product::where('is_active', true)
                ->where('updated_at', '>=', now()->subDays(30));
        } else {
            $category = Category::where('slug', $slug)->firstOrFail();
            $query = Product::where('is_active', true)->where('category_id', $category->id);
        }

        $query->with(['primaryImage', 'category', 'variants'])
            ->addSelect([
                'final_min_price' => ProductVariant::selectRaw('MIN(CASE WHEN sale_price IS NOT NULL AND sale_price > 0 THEN sale_price ELSE price END)')
                    ->whereColumn('product_id', 'products.id'),
                'final_max_price' => ProductVariant::selectRaw('MAX(CASE WHEN sale_price IS NOT NULL AND sale_price > 0 THEN sale_price ELSE price END)')
                    ->whereColumn('product_id', 'products.id')
            ])
            ->withMin('variants', 'price');

        if ($request->filled('brands')) {
            $brandIds = explode(',', $request->brands);
            $query->whereIn('brand_id', $brandIds);
        }

        if ($request->filled('price')) {
            $priceRanges = explode(',', $request->price);
            $havingSqls = [];
            $bindings = [];

            foreach ($priceRanges as $range) {
                [$min, $max] = explode('-', $range);
                if ($max === 'max') {
                    $havingSqls[] = 'final_min_price >= ?';
                    $bindings[] = $min * 1000000;
                } else {
                    $havingSqls[] = '(final_min_price BETWEEN ? AND ?)';
                    $bindings[] = $min * 1000000;
                    $bindings[] = $max * 1000000;
                }
            }

            if (!empty($havingSqls)) {
                $query->havingRaw('(' . implode(' OR ', $havingSqls) . ')', $bindings);
            }
        }

        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('final_min_price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('final_min_price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'newest':
            default:
                if ($slug !== 'ban-chay') {
                    $query->latest();
                } else {
                    $query->orderByDesc('total_sales');
                }
                break;
        }
        $products = $query->paginate(20)->withQueryString();
        $allBrands = Brand::all();
        $categoriesList = Category::whereNull('parent_id')
            ->with(['children' => function ($q) {
                $q->withCount('products');
            }])
            ->withCount('products')
            ->get();

        return view('categories.show', compact('category', 'products', 'allBrands', 'categoriesList'));
    }
}
