<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'images.*' => 'nullable|image|max:2048', // 2MB max
        ]);

        $user = Auth::user();
        $productId = $request->product_id;

        // 1. Kiểm tra xem người dùng đã mua sản phẩm này chưa 
        $hasPurchased = Order::where('user_id', $user->id)
            ->where('status', Order::STATUS_COMPLETED)
            ->whereHas('items', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })->exists();

        if (!$hasPurchased) {
            return back()->with('error', 'Bạn chỉ có thể đánh giá sản phẩm sau khi đã mua và nhận hàng thành công!');
        }

        // 2. Kiểm tra xem đã đánh giá chưa 
        $alreadyReviewed = ProductReview::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi!');
        }

        // 3. Xử lý upload ảnh 
        $imageUrls = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filePath = $image->getRealPath();
                $uploadResult = app('App\Services\CloudinaryService')->upload($filePath);
                $imageUrls[] = $uploadResult['secure_url'];
            }
        }

        // 4. Lưu review
        ProductReview::create([
            'user_id' => $user->id,
            'product_id' => $productId,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'images' => $imageUrls,
            'status' => 'active',
        ]);

        return back()->with('success', 'Cảm ơn bạn đã gửi đánh giá tuyệt vời!');
    }
}
