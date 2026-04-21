<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::id();
        $guestId = request()->cookie('guest_id');

        $cart = Cart::where(function ($query) use ($user, $guestId) {
            if ($user) {
                $query->where('user_id', $user);
            } else {
                $query->where('guest_id', $guestId);
            }
        })->first();

        if (!$cart) {
            $cart = Cart::create([
                'user_id' => $user,
                'guest_id' => $user ? null : $guestId
            ]);
        }
        $allCartItems = CartItem::with(['variant', 'product'])->where('cart_id', $cart->id)->get();

        $cartItems = CartItem::with(['variant', 'product'])
            ->where('cart_id', $cart->id)
            ->paginate(5)
            ->withQueryString();

        return view('carts.index', compact('cartItems', 'allCartItems'));
    }

    public function addItem(Request $request)
    {
        $user = Auth::id();
        $guestId = request()->cookie('guest_id');

        $cart = Cart::where(function ($query) use ($user, $guestId) {
            if ($user) $query->where('user_id', $user);
            else $query->where('guest_id', $guestId);
        })->first();

        if (!$cart) {
            $cart = Cart::create([
                'user_id' => $user,
                'guest_id' => $user ? null : $guestId
            ]);
        }

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->where('variant_id', $request->variant_id)
            ->first();
        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'variant_id' => $request->variant_id,
                'quantity' => $request->quantity,
            ]);
        }
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã thêm vào giỏ hàng!',
            ]);
        }
        return redirect()->route('cart.index')->with('success', 'Đã thêm vào giỏ hàng!');
    }

    public function updateItem(Request $request, $id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->update(['quantity' => $request->quantity]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thành công!'
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Cập nhật giỏ hàng thành công!');
    }

    public function removeItem($id)
    {
        CartItem::findOrFail($id)->delete();
        return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }
}
