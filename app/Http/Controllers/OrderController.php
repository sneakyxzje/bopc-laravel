<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
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
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id());
        return view("orders.order", compact('cartItems'));
    }
    public function store(Request $request)
    {
        if (!Auth::check()) {
            Auth::loginUsingId(1);
        }

        $order = Order::create([
            'user_id'        => Auth::id(),
            'full_name'      => $request->full_name,
            'phone'          => $request->phone,
            'address'        => $request->address,
            'note'           => $request->note,
            'total_price'    => 14900000, // Hardcore tạm, sau này sẽ là Cart::total()
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
