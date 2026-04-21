<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;

class OrderController extends Controller
{
    protected $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(\Illuminate\Http\Request $request)
    {
        $query = Order::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        $orders = $query->latest()->paginate(10);

        $stats = [
            'total_count'    => Order::count(),
            'pending_count'  => Order::where('status', Order::STATUS_PENDING)->count(),
            'shipping_count' => Order::where('status', Order::STATUS_SHIPPING)->count(),
            'revenue'        => Order::where('payment_status', Order::PAYMENT_PAID)->sum('total_price'),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    public function detail($id)
    {
        $order = Order::with(['items.product', 'items.variant'])->findOrFail($id);
        return view('admin.orders.detail', compact('order'));
    }

    public function updateStatus($id, \Illuminate\Http\Request $request)
    {
        $order = Order::with(['items.product', 'items.variant', 'user'])->findOrFail($id);
        $newStatus = $request->status;

        // 1. Duyệt đơn (Xác nhận)
        if ($newStatus == Order::STATUS_CONFIRMED) {
            if ($order->payment_method == 'vnpay' && $order->payment_status != Order::PAYMENT_PAID) {
                return back()->with('error', 'Không thể duyệt đơn thanh toán qua VNPay chưa được thanh toán!');
            }
            $order->update(['status' => Order::STATUS_CONFIRMED]);
            return back()->with('success', 'Đã xác nhận đơn hàng #' . $order->id . '!');
        }

        // 2. Chuyển đơn (Đang giao)
        if ($newStatus == Order::STATUS_SHIPPING) {
            $order->update(['status' => Order::STATUS_SHIPPING]);
            return back()->with('success', 'Đơn hàng #' . $order->id . ' đang được vận chuyển!');
        }

        // 3. Hoàn thành đơn hàng
        if ($newStatus == Order::STATUS_COMPLETED) {
            $order->update([
                'status'         => Order::STATUS_COMPLETED,
                'payment_status' => Order::PAYMENT_PAID
            ]);
            return back()->with('success', 'Đơn hàng #' . $order->id . ' đã hoàn thành!');
        }

        return back()->with('error', 'Thao tác không hợp lệ!');
    }
}
