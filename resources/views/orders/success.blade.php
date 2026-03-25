@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 80px;"></i>
                    </div>

                    <h2 class="text-uppercase fw-bold text-success">Đặt hàng thành công!</h2>
                    <p class="text-muted">Cảm ơn bạn đã tin tưởng <strong>BộPC</strong>. Đơn hàng của bạn đang được xử lý.</p>

                    <hr class="my-4">

                    <div class="text-start mb-4">
                        <h5 class="fw-bold mb-3">Chi tiết đơn hàng:</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-muted">Mã đơn hàng:</td>
                                <td class="fw-bold text-end">#{{ $order->id }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Người nhận:</td>
                                <td class="fw-bold text-end">{{ $order->full_name }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Số điện thoại:</td>
                                <td class="fw-bold text-end">{{ $order->phone }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Hình thức thanh toán:</td>
                                <td class="fw-bold text-end text-uppercase">
                                    <span class="badge bg-info">{{ ($order->payment_method) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Trạng thái thanh toán:</td>
                                <td class="fw-bold text-end">
                                    @if($order->payment_status == \App\Models\Order::PAYMENT_PAID)
                                    <span class="text-success"><i class="fas fa-check-double"></i> Đã thanh toán qua VNPay</span>
                                    @else
                                    <span class="text-warning">Chờ thanh toán (COD)</span>
                                    @endif
                                </td>
                            </tr>
                            <tr class="border-top">
                                <td class="fs-5 fw-bold">Tổng tiền:</td>
                                <td class="fs-5 fw-bold text-end text-danger">
                                    {{ number_format($order->total_price) }}đ
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="d-grid gap-2 d-md-block">
                        <a href="{{ url('/') }}" class="btn btn-outline-primary px-4 me-md-2">Tiếp tục mua sắm</a>
                        <a href="#" class="btn btn-primary px-4">Theo dõi đơn hàng</a>
                    </div>
                </div>
            </div>

            <p class="mt-4 text-muted small italic">Mọi thắc mắc vui lòng liên hệ Hotline: xxx.xxxx</p>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection