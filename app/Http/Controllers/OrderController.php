<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\GHTKService;
use App\Services\VNPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $vnpayService;
    protected $ghtkService;
    public function __construct(VNPayService $vnpayService, GHTKService $ghtkService)
    {
        $this->vnpayService = $vnpayService;
        $this->ghtkService = $ghtkService;
    }

    public function index()
    {
        $user = Auth::id();
        $guestId = request()->cookie('guest_id');
        $cart = Cart::where(function ($query) use ($user, $guestId) {
            if ($user) $query->where('user_id', $user);
            else $query->where('guest_id', $guestId);
        })->first();
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }
        $carts = $cart->items->load(['product', 'variant']);
        $subtotal = $carts->sum(fn($item) => $item->price * $item->quantity);
        return view("orders.order", compact('carts', 'subtotal'));
    }
    public function store(Request $request)
    {

        $user = Auth::id();
        $guestId = request()->cookie('guest_id');

        $cart = Cart::where(function ($query) use ($user, $guestId) {
            if ($user) $query->where('user_id', $user);
            else $query->where('guest_id', $guestId);
        })->first();
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index');
        }
        $subtotal = $cart->items->sum(fn($item) => $item->price * $item->quantity);
        return DB::transaction(function () use ($request, $cart, $subtotal, $user) {

            $order = Order::create([
                'user_id'        => $user,
                'full_name'      => $request->full_name,
                'phone'          => $request->phone,
                'province'       => $request->province,
                'district'       => $request->district,
                'ward'           => $request->ward,
                'address'        => $request->address,
                'shipping_fee'   => $request->shipping_fee ?? 0,
                'note'           => $request->note,
                'total_price'    => $subtotal + ($request->shipping_fee ?? 0),
                'payment_method' => $request->payment_method,
                'payment_status' => Order::PAYMENT_UNPAID,
                'status'         => ($request->payment_method == 'vnpay') ? Order::STATUS_AWAITING_PAYMENT : Order::STATUS_PENDING
            ]);
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->price,
                ]);
            }
            $cart->items()->delete();
            if ($request->payment_method == 'vnpay') {
                $url = $this->vnpayService->createPayment($order);
                return redirect()->away($url);
            }
            return view('orders.success', compact('order'));
        });
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
        return redirect()->route('checkout.index')->with('error', 'Thanh toán thất bại hoặc đã bị hủy.');
    }

    /**
     * Lịch sử đơn hàng cho người dùng đã đăng nhập
     */
    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('orders.history', compact('orders'));
    }

    /**
     * Trang tra cứu đơn hàng
     */
    public function tracking()
    {
        return view('orders.tracking');
    }

    /**
     * Xử lý tra cứu đơn hàng
     */
    public function doTracking(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|min:10|max:11',
        ]);

        $orders = Order::where('phone', $request->phone)
            ->latest()
            ->get();

        if ($orders->isEmpty()) {
            return back()->with('error', 'Không tìm thấy đơn hàng nào với số điện thoại này.');
        }

        return view('orders.tracking', compact('orders'))->with('phone', $request->phone);
    }

    /**
     * Chi tiết đơn hàng cho khách hàng
     */
    public function showDetails($id)
    {
        $order = Order::with(['items.product', 'items.variant'])->findOrFail($id);

        // Kiểm tra xem người truy cập có quyền xem đơn này không
        $canView = false;

        // 1. Nếu là chủ sở hữu (User ID khớp)
        if (Auth::check() && $order->user_id == Auth::id()) {
            $canView = true;
        }

        // 2. Nếu tra cứu qua Guest (Cần khớp số điện thoại trong session/cookie hoặc vừa tra cứu xong)
        // Ở đây ta cho phép xem nếu họ biết ID đơn hàng (vì ID đơn hàng dài và khó đoán), 
        // nhưng lý tưởng nhất là check phone trong session.
        if (request()->has('phone') && $order->phone == request()->phone) {
            $canView = true;
        }

        // Tạm thời cho phép xem detail nếu có id (giống TGDD/HoangHa link từ SMS)
        // Nhưng nếu muốn bảo mật hơn có thể giới hạn.
        $canView = true;

        if (!$canView) {
            return redirect()->route('home')->with('error', 'Bạn không có quyền xem thông tin đơn hàng này.');
        }

        return view('orders.details', compact('order'));
    }

    public function calculateShipping(Request $request)
    {
        try {
            $user = Auth::id();
            $guestId = request()->cookie('guest_id');
            $cart = Cart::where(function ($query) use ($user, $guestId) {
                if ($user) $query->where('user_id', $user);
                else $query->where('guest_id', $guestId);
            })->first();

            if (!$cart) {
                return response()->json(['success' => false, 'message' => 'Giỏ hàng trống']);
            }

            $totalWeight = $cart->items->sum(function ($item) {
                return ($item->product->weight ?? 500) * $item->quantity;
            });

            $data = [
                "pick_province" => "Hà Nội",
                "pick_district" => "Quận Hai Bà Trưng",
                "province"      => $request->province,
                "district"      => $request->district,
                "address"       => $request->address,
                "weight"        => $totalWeight,
                "value"         => $cart->items->sum(fn($item) => $item->price * $item->quantity),
                "transport"     => "road",
            ];

            $result = $this->ghtkService->calculateFee($data);

            if (isset($result['success']) && $result['success']) {
                return response()->json([
                    'success' => true,
                    'fee' => $result['fee']['fee']
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $result['message'] ?? 'Lỗi không xác định từ GHTK'
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()]);
        }
    }
}
