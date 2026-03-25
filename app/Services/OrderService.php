<?php

namespace App\Services;

use App\Models\Order;

class OrderService
{
    // Default 10 page
    public function getAllOrders($perPage = 10)
    {
        return Order::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
}
