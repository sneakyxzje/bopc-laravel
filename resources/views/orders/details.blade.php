@extends('layouts.app')

@section('title', 'Đơn hàng #' . str_pad($order->id, 6, '0', STR_PAD_LEFT) . ' — BO PC')

@section('content')
<div class="max-w-screen-lg mx-auto px-4 sm:px-6 lg:px-10 py-12">

    
    <nav class="flex items-center gap-2 text-[12px] text-[#6a6a6a] mb-10">
        <a href="{{ route('home') }}" class="hover:text-[#222222] transition-colors font-medium">Trang chủ</a>
        <span class="text-[#c1c1c1]">/</span>
        @auth
            <a href="{{ route('orders.history') }}" class="hover:text-[#222222] transition-colors font-medium">Đơn hàng của tôi</a>
        @else
            <a href="{{ route('order.tracking') }}" class="hover:text-[#222222] transition-colors font-medium">Tra cứu đơn hàng</a>
        @endauth
        <span class="text-[#c1c1c1]">/</span>
        <span class="text-[#222222] font-semibold">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
    </nav>

    
    @php
        $statusMap = [
            -1 => ['label' => 'Đang chờ',       'color' => '#c1c1c1'],
             0 => ['label' => 'Chờ xác nhận',   'color' => '#d97706'],
             1 => ['label' => 'Đã xác nhận',    'color' => '#2563eb'],
             2 => ['label' => 'Đang giao hàng', 'color' => '#7c3aed'],
             3 => ['label' => 'Giao thành công','color' => '#16a34a'],
             4 => ['label' => 'Đã hủy',         'color' => '#c13515'],
        ];
        $s = $statusMap[$order->status] ?? $statusMap[0];
    @endphp

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 pb-8 border-b border-[#c1c1c1]/30">
        <div>
            <h1 class="text-[26px] font-bold text-[#222222] tracking-tight">
                Đơn hàng <span class="text-[#6a6a6a] font-semibold">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
            </h1>
            <p class="text-[13px] text-[#6a6a6a] mt-1">Đặt lúc {{ $order->created_at->format('H:i, ngày d/m/Y') }}</p>
        </div>
        <div class="flex items-center gap-2.5 self-start sm:self-auto px-4 py-2.5 bg-white rounded-[14px]"
             style="box-shadow: rgba(0,0,0,0.02) 0px 0px 0px 1px, rgba(0,0,0,0.04) 0px 2px 6px, rgba(0,0,0,0.08) 0px 4px 10px;">
            <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background: {{ $s['color'] }}"></span>
            <span class="text-[13px] font-semibold text-[#222222]">{{ $s['label'] }}</span>
        </div>
    </div>

    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        
        <div class="lg:col-span-2 space-y-6">

            
            <div class="bg-white rounded-[20px] overflow-hidden"
                 style="box-shadow: rgba(0,0,0,0.02) 0px 0px 0px 1px, rgba(0,0,0,0.04) 0px 2px 6px, rgba(0,0,0,0.08) 0px 4px 10px;">

                <div class="px-6 py-5 border-b border-[#f2f2f2]">
                    <h2 class="text-[13px] font-bold text-[#222222] uppercase tracking-wide">Tiến trình đơn hàng</h2>
                </div>

                @php
                    $steps = [
                        ['label' => 'Đặt hàng thành công',  'desc' => 'Đơn hàng đã được tiếp nhận.', 'minStatus' => -99],
                        ['label' => 'Đã xác nhận',          'desc' => 'Admin đã duyệt và chuẩn bị xuất kho.',  'minStatus' => 1],
                        ['label' => 'Đang vận chuyển',      'desc' => 'Kiện hàng đã được bàn giao vận chuyển.','minStatus' => 2],
                        ['label' => 'Giao thành công',      'desc' => 'Đơn hàng đã đến tay bạn.', 'minStatus' => 3],
                    ];
                    $activeStep = 0;
                    if ($order->status >= 1) $activeStep = 1;
                    if ($order->status >= 2) $activeStep = 2;
                    if ($order->status >= 3) $activeStep = 3;
                @endphp

                <div class="px-6 py-8">
                    <div class="relative">
                        
                        <div class="absolute left-4 top-5 bottom-5 w-px bg-[#f2f2f2]"></div>

                        <div class="space-y-7">
                            @foreach($steps as $i => $step)
                            @php $done = ($i <= $activeStep); @endphp
                            <div class="relative flex items-start gap-5">
                                
                                <div class="relative z-10 w-9 h-9 rounded-full shrink-0 flex items-center justify-center
                                    {{ $done ? 'bg-[#222222]' : 'bg-white border-2 border-[#c1c1c1]/50' }}">
                                    @if($done)
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    @else
                                        <span class="w-2 h-2 rounded-full bg-[#c1c1c1]/60"></span>
                                    @endif
                                </div>

                                
                                <div class="pt-1.5 flex-1">
                                    <p class="text-[14px] font-semibold leading-tight {{ $done ? 'text-[#222222]' : 'text-[#c1c1c1]' }}">
                                        {{ $step['label'] }}
                                    </p>
                                    @if($done)
                                    <p class="text-[13px] text-[#6a6a6a] mt-1 leading-relaxed">{{ $step['desc'] }}</p>
                                    @if($i === 0)
                                    <p class="text-[12px] text-[#6a6a6a]/60 mt-0.5">{{ $order->created_at->format('H:i, d/m/Y') }}</p>
                                    @endif
                                    @endif
                                    
                                    @if($i === 3 && $done && $order->items->first()?->product)
                                    <a href="{{ route('product.detail', $order->items->first()->product->slug) }}#tab-container"
                                       class="inline-block mt-3 text-[13px] font-semibold text-[#ff385c] hover:underline">
                                        Viết đánh giá sản phẩm →
                                    </a>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="bg-white rounded-[20px] overflow-hidden"
                 style="box-shadow: rgba(0,0,0,0.02) 0px 0px 0px 1px, rgba(0,0,0,0.04) 0px 2px 6px, rgba(0,0,0,0.08) 0px 4px 10px;">

                <div class="px-6 py-5 border-b border-[#f2f2f2]">
                    <h2 class="text-[13px] font-bold text-[#222222] uppercase tracking-wide">
                        Sản phẩm đã đặt <span class="text-[#6a6a6a] font-semibold normal-case tracking-normal">({{ $order->items->count() }} sản phẩm)</span>
                    </h2>
                </div>

                <div class="divide-y divide-[#f2f2f2]">
                    @foreach($order->items as $item)
                    <div class="px-6 py-5 flex items-center gap-4">
                        <div class="w-16 h-16 rounded-[14px] bg-[#f2f2f2] border border-[#c1c1c1]/20 overflow-hidden flex items-center justify-center shrink-0">
                            @if($item->product && $item->product->primaryImage)
                                <img src="{{ $item->product->primaryImage->image_path }}" class="w-full h-full object-contain" alt="">
                            @else
                                <svg class="w-6 h-6 text-[#c1c1c1]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[14px] font-semibold text-[#222222] leading-tight line-clamp-2">
                                {{ $item->product->name ?? 'Sản phẩm đã xóa' }}
                            </p>
                            <p class="text-[12px] text-[#6a6a6a] mt-1 uppercase tracking-wide">
                                {{ $item->variant->variant_name ?? 'Mặc định' }} &middot; x{{ $item->quantity }}
                            </p>
                        </div>
                        <div class="text-[15px] font-bold text-[#222222] shrink-0">
                            {{ number_format($item->price * $item->quantity) }}đ
                        </div>
                    </div>
                    @endforeach
                </div>

                
                <div class="px-6 py-5 bg-[#f2f2f2]/40 space-y-3">
                    <div class="flex justify-between text-[13px] text-[#6a6a6a]">
                        <span>Tạm tính</span>
                        <span class="font-semibold text-[#222222]">{{ number_format($order->total_price - ($order->shipping_fee ?? 0)) }}đ</span>
                    </div>
                    <div class="flex justify-between text-[13px] text-[#6a6a6a]">
                        <span>Phí vận chuyển</span>
                        <span class="font-semibold text-[#222222]">
                            {{ ($order->shipping_fee ?? 0) == 0 ? 'Miễn phí' : number_format($order->shipping_fee) . 'đ' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center pt-3 border-t border-[#c1c1c1]/30">
                        <span class="text-[15px] font-bold text-[#222222]">Tổng thanh toán</span>
                        <span class="text-[20px] font-bold text-[#222222]">{{ number_format($order->total_price) }}đ</span>
                    </div>
                </div>
            </div>

        </div>

        
        <div class="space-y-5">

            
            <div class="bg-white rounded-[20px] overflow-hidden"
                 style="box-shadow: rgba(0,0,0,0.02) 0px 0px 0px 1px, rgba(0,0,0,0.04) 0px 2px 6px, rgba(0,0,0,0.08) 0px 4px 10px;">
                <div class="px-5 py-4 border-b border-[#f2f2f2]">
                    <h3 class="text-[12px] font-bold text-[#222222] uppercase tracking-wide">Thông tin giao hàng</h3>
                </div>
                <div class="px-5 py-5 space-y-4">
                    <div>
                        <p class="text-[11px] font-semibold text-[#6a6a6a] uppercase mb-1.5">Người nhận</p>
                        <p class="text-[15px] font-bold text-[#222222]">{{ $order->full_name }}</p>
                        <p class="text-[13px] text-[#6a6a6a] mt-0.5">{{ $order->phone }}</p>
                    </div>
                    <div class="border-t border-[#f2f2f2] pt-4">
                        <p class="text-[11px] font-semibold text-[#6a6a6a] uppercase mb-1.5">Địa chỉ</p>
                        <p class="text-[13px] text-[#222222] leading-relaxed">
                            {{ $order->address }},<br>
                            {{ $order->ward }}, {{ $order->district }},<br>
                            {{ $order->province }}
                        </p>
                    </div>
                    @if($order->note)
                    <div class="border-t border-[#f2f2f2] pt-4">
                        <p class="text-[11px] font-semibold text-[#6a6a6a] uppercase mb-1.5">Ghi chú</p>
                        <p class="text-[13px] text-[#6a6a6a] italic">{{ $order->note }}</p>
                    </div>
                    @endif
                </div>
            </div>

            
            <div class="bg-white rounded-[20px] overflow-hidden"
                 style="box-shadow: rgba(0,0,0,0.02) 0px 0px 0px 1px, rgba(0,0,0,0.04) 0px 2px 6px, rgba(0,0,0,0.08) 0px 4px 10px;">
                <div class="px-5 py-4 border-b border-[#f2f2f2]">
                    <h3 class="text-[12px] font-bold text-[#222222] uppercase tracking-wide">Thanh toán</h3>
                </div>
                <div class="px-5 py-5 space-y-3.5">
                    <div class="flex justify-between items-center">
                        <span class="text-[13px] text-[#6a6a6a]">Phương thức</span>
                        <span class="text-[13px] font-bold text-[#222222] uppercase">{{ $order->payment_method }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[13px] text-[#6a6a6a]">Trạng thái</span>
                        <div class="flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full {{ $order->payment_status == 1 ? 'bg-[#16a34a]' : 'bg-[#d97706]' }}"></span>
                            <span class="text-[13px] font-semibold {{ $order->payment_status == 1 ? 'text-[#16a34a]' : 'text-[#d97706]' }}">
                                {{ $order->payment_status == 1 ? 'Đã thanh toán' : 'Thanh toán khi nhận hàng' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="bg-white rounded-[20px] px-5 py-5"
                 style="box-shadow: rgba(0,0,0,0.02) 0px 0px 0px 1px, rgba(0,0,0,0.04) 0px 2px 6px, rgba(0,0,0,0.08) 0px 4px 10px;">
                <p class="text-[13px] font-semibold text-[#222222] mb-1">Cần hỗ trợ?</p>
                <p class="text-[13px] text-[#6a6a6a] leading-relaxed">Gọi hotline <span class="font-semibold text-[#222222]">0123 456 789</span><br>Thứ 2 – CN, 8:00 – 22:00</p>
            </div>

            
            @auth
                <a href="{{ route('orders.history') }}"
                   class="flex items-center justify-center gap-2 w-full px-6 py-3 border-2 border-[#222222] text-[13px] font-semibold text-[#222222] rounded-[8px] hover:bg-[#222222] hover:text-white transition-colors">
                    Quay lại danh sách đơn hàng
                </a>
            @else
                <a href="{{ route('order.tracking') }}"
                   class="flex items-center justify-center gap-2 w-full px-6 py-3 border-2 border-[#222222] text-[13px] font-semibold text-[#222222] rounded-[8px] hover:bg-[#222222] hover:text-white transition-colors">
                    Tra cứu đơn hàng khác
                </a>
            @endauth

        </div>
    </div>
</div>
@endsection