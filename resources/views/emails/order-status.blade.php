<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật đơn hàng</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f8fafc; color: #1e293b; }
        .wrapper { max-width: 600px; margin: 40px auto; background: #fff; border: 1px solid #e2e8f0; }
        .header { background: #111827; padding: 28px 40px; }
        .header .logo { font-size: 22px; font-weight: 900; color: #fff; letter-spacing: -0.5px; }
        .header .logo span { color: #ef4444; }
        .hero { background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 32px 40px; }
        .status-badge { display: inline-block; padding: 6px 14px; border-radius: 4px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 16px; }
        .status-confirmed { background: #eff6ff; color: #2563eb; }
        .status-shipping  { background: #eef2ff; color: #4f46e5; }
        .status-completed { background: #f0fdf4; color: #16a34a; }
        .hero h1 { font-size: 20px; font-weight: 900; color: #111827; margin-bottom: 8px; }
        .hero p  { font-size: 14px; color: #64748b; line-height: 1.6; }
        .content { padding: 32px 40px; }
        .info-row { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f1f5f9; font-size: 13px; }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #94a3b8; font-weight: 600; }
        .info-value { color: #1e293b; font-weight: 700; text-align: right; }
        .divider { height: 1px; background: #f1f5f9; margin: 24px 0; }
        .total-row { display: flex; justify-content: space-between; align-items: center; padding: 16px 0; }
        .total-label { font-size: 13px; font-weight: 700; color: #64748b; text-transform: uppercase; }
        .total-value { font-size: 22px; font-weight: 900; color: #ef4444; }
        .items-table { width: 100%; border-collapse: collapse; margin: 16px 0; font-size: 13px; }
        .items-table th { text-align: left; padding: 10px 12px; background: #f8fafc; color: #94a3b8; font-size: 11px; font-weight: 700; text-transform: uppercase; border-bottom: 1px solid #e2e8f0; }
        .items-table td { padding: 12px; border-bottom: 1px solid #f1f5f9; color: #334155; font-weight: 600; }
        .items-table td:last-child { text-align: right; font-weight: 800; color: #111827; }
        .cta { text-align: center; padding: 32px 40px; }
        .btn { display: inline-block; padding: 14px 36px; background: #ef4444; color: #fff; text-decoration: none; font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; }
        .footer { background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 24px 40px; text-align: center; font-size: 12px; color: #94a3b8; line-height: 1.6; }
    </style>
</head>
<body>
<div class="wrapper">

    
    <div class="header">
        <div class="logo">Bo<span>PC</span></div>
    </div>

    
    <div class="hero">
        @php
            $badgeClass = match($order->status) {
                \App\Models\Order::STATUS_CONFIRMED => 'status-confirmed',
                \App\Models\Order::STATUS_SHIPPING  => 'status-shipping',
                default                             => 'status-completed',
            };
        @endphp
        <div class="status-badge {{ $badgeClass }}">{{ $statusLabel }}</div>
        <h1>Xin chào, {{ $order->full_name }}</h1>
        <p>{{ $statusMessage }}</p>
    </div>

    
    <div class="content">
        <div class="info-row">
            <span class="info-label">Mã đơn hàng</span>
            <span class="info-value">#{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Ngày đặt</span>
            <span class="info-value">{{ $order->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Phương thức thanh toán</span>
            <span class="info-value">{{ strtoupper($order->payment_method) }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Địa chỉ giao hàng</span>
            <span class="info-value">{{ $order->address }}, {{ $order->district }}, {{ $order->province }}</span>
        </div>

        <div class="divider"></div>

        
        <table class="items-table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th style="text-align:center">SL</th>
                    <th style="text-align:right">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        {{ $item->product->name ?? 'Sản phẩm' }}
                        @if($item->variant)
                            <br><span style="color:#94a3b8;font-size:11px;font-weight:600">{{ $item->variant->variant_name }}</span>
                        @endif
                    </td>
                    <td style="text-align:center">{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price * $item->quantity) }}đ</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="divider"></div>

        <div class="total-row">
            <span class="total-label">Tổng thanh toán</span>
            <span class="total-value">{{ number_format($order->total_price) }}đ</span>
        </div>
    </div>

    
    <div class="cta">
        <a href="{{ url('/theo-doi-don-hang') }}" class="btn">Theo dõi đơn hàng</a>
    </div>

    
    <div class="footer">
        <p>Cảm ơn bạn đã tin tưởng mua sắm tại <strong>BoPC</strong>.</p>
        <p style="margin-top:6px">Nếu cần hỗ trợ, vui lòng liên hệ hotline <strong>1900 1234</strong>.</p>
        <p style="margin-top:12px; color: #cbd5e1">© {{ date('Y') }} BoPC. All rights reserved.</p>
    </div>

</div>
</body>
</html>
