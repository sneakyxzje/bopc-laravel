<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::with(['variants', 'images', 'category', 'brand'])
            ->withCount(['reviews' => function ($q) {
                $q->where('status', 'active');
            }])
            ->withAvg(['reviews' => function ($q) {
                $q->where('status', 'active');
            }], 'rating')
            ->where('slug', $slug)
            ->firstOrFail();

        $reviewsQuery = $product->reviews()->where('status', 'active')->with('user')->latest();

        if (request()->has('rating')) {
            $reviewsQuery->where('rating', request()->rating);
        }

        $reviews = $reviewsQuery->paginate(10)->withQueryString();

        $ratingDistribution = $product->reviews()
            ->where('status', 'active')
            ->select('rating', \DB::raw('count(*) as total'))
            ->groupBy('rating')
            ->pluck('total', 'rating')
            ->toArray();

        // Đảm bảo đủ từ 1-5 sao
        for ($i = 1; $i <= 5; $i++) {
            if (!isset($ratingDistribution[$i])) $ratingDistribution[$i] = 0;
        }

        $canReview = false;
        $orderInfo = null;
        if (Auth::check()) {
            $user = Auth::user();
            // Đã hoàn thành đơn hàng và chưa đánh giá
            $hasPurchased = \App\Models\Order::where('user_id', $user->id)
                ->where('status', \App\Models\Order::STATUS_COMPLETED)
                ->whereHas('items', function ($query) use ($product) {
                    $query->where('product_id', $product->id);
                })->exists();

            $alreadyReviewed = \App\Models\ProductReview::where('user_id', $user->id)
                ->where('product_id', $product->id)
                ->exists();

            if ($hasPurchased && !$alreadyReviewed) {
                $canReview = true;
            }
        }

        return view('products.detail', compact('product', 'reviews', 'canReview', 'ratingDistribution'));
    }

    public function search(\Illuminate\Http\Request $request)
    {
        $query = Product::where('is_active', true);

        if ($request->filled('cat')) {
            $catSlug = $request->cat;
            $query->whereHas('category', function ($q) use ($catSlug) {
                $q->where('slug', $catSlug)
                    ->orWhereHas('parent', function ($q2) use ($catSlug) {
                        $q2->where('slug', $catSlug);
                    });
            });
        }

        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where('name', 'like', "%{$keyword}%");
        }

        $query->with(['primaryImage', 'category', 'variants'])
            ->addSelect([
                'final_min_price' => \App\Models\ProductVariant::selectRaw('MIN(CASE WHEN sale_price IS NOT NULL AND sale_price > 0 THEN sale_price ELSE price END)')
                    ->whereColumn('product_id', 'products.id'),
                'final_max_price' => \App\Models\ProductVariant::selectRaw('MAX(CASE WHEN sale_price IS NOT NULL AND sale_price > 0 THEN sale_price ELSE price END)')
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
                $query->latest();
                break;
        }

        $products = $query->paginate(20)->withQueryString();

        $category = new \App\Models\Category(['name' => 'Kết quả tìm kiếm cho: ' . ($request->q ?: 'Tất cả'), 'slug' => 'tim-kiem']);
        $allBrands = \App\Models\Brand::all();
        $categoriesList = \App\Models\Category::whereNull('parent_id')
            ->with(['children' => function ($q) {
                $q->withCount('products');
            }])
            ->withCount('products')
            ->get();

        return view('categories.show', compact('category', 'products', 'allBrands', 'categoriesList'));
    }
}
