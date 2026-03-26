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

    public function index()
    {
        $orders = $this->orderService->getAllOrders(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function detail($id)
    {
        $order = Order::with(['items.product', 'items.variant'])->findOrFail($id);
        return view('admin.orders.detail', compact('order'));
    }
}
