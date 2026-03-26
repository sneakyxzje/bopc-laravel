<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductVariant;
use App\Services\VNPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $vnpayService;

    public function __construct(VNPayService $vnpayService)
    {
        $this->vnpayService = $vnpayService;
    }

    public function buyNow(Request $request)
    {
        session(['buy_now' => [
            'variant_id' => $request->variant_id,
            'quantity' => $request->quantity
        ]]);
        return redirect()->route('order.checkout');
    }
    public function index()
    {
        $buyNow = session('buy_now');
        if (!$buyNow) return redirect()->route('home');
        $variant = ProductVariant::with('product')->findOrFail($buyNow['variant_id']);

        $item = (object)[
            'product' => $variant->product,
            'variant' => $variant,
            'quantity' => $buyNow['quantity'],
            'price' => $variant->sale_price ?? $variant->price
        ];
        $carts = collect([$item]);
        $subtotal = $carts->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return view("orders.order", compact('carts', 'subtotal'));
    }
    public function store(Request $request)
    {
        $buyNow = session('buy_now');
        $variant = ProductVariant::findOrFail($buyNow['variant_id']);
        $totalPrice = ($variant->sale_price ?? $variant->price) * $buyNow['quantity'];
        $order = Order::create([
            'user_id'        => Auth::id() ?? null,
            'full_name'      => $request->full_name,
            'phone'          => $request->phone,
            'address'        => $request->address,
            'note'           => $request->note,
            'total_price'    => $totalPrice,
            'payment_method' => $request->payment_method, // 'vnpay' hoặc 'cod'
            'payment_status' => Order::PAYMENT_UNPAID, // Mặc định là 0 (Chưa thanh toán)
            'status'         => ($request->payment_method == 'vnpay') ? Order::STATUS_AWAITING_PAYMENT : Order::STATUS_PENDING
        ]);
        if ($request->payment_method == 'vnpay') {
            $url = $this->vnpayService->createPayment($order);
            return redirect()->away($url);
        }
    }

    public function vnpayReturn(Request $request)
    {
        if ($request->vnp_ResponseCode == '00') {
            $order =  Order::find($request->vnp_TxnRef);

            if ($order) {
                $order->update([
                    'payment_status' => Order::PAYMENT_PAID,
                    'status' => Order::STATUS_PENDING
                ]);

                return view('orders.success', compact('order'))->with('msg', "Successfully");
            }
        }
        return redirect()->route('checkout.index')->with('error', 'Failed.');
    }
}
