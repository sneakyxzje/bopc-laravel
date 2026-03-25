<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Định nghĩa các trạng thái đơn hàng
    const STATUS_AWAITING_PAYMENT = -1; // Khách đang ở trang VNPay, chưa biết trả hay chưa
    const STATUS_PENDING          = 0;  // Đã đặt xong (VNPay thành công hoặc chọn COD), chờ Admin duyệt
    const STATUS_CONFIRMED        = 1;  // Admin đã ấn nút xác nhận (Hàng chuẩn bị xuất kho)
    const STATUS_SHIPPING         = 2;  // Đã giao cho Shipper (GHTK đã lấy hàng)
    const STATUS_COMPLETED        = 3;  // Khách đã nhận hàng thành công
    const STATUS_CANCELLED        = 4;  // Đơn bị hủy (Khách hủy hoặc Admin hủy)

    // Định nghĩa trạng thái thanh toán
    const PAYMENT_UNPAID = 0;
    const PAYMENT_PAID = 1;
    const PAYMENT_FAILED = 2;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
