@extends('layouts.app')

@section('title', 'Đặt hàng thành công — BO PC')

@section('content')
<div class="max-w-screen-md mx-auto px-4 py-20 min-h-[70vh] flex flex-col items-center">
    
    <div class="w-full bg-white rounded-[20px] p-10 text-center"
         style="box-shadow: rgba(0,0,0,0.02) 0px 0px 0px 1px, rgba(0,0,0,0.04) 0px 2px 6px, rgba(0,0,0,0.1) 0px 4px 10px;">
        
        
        <div class="w-24 h-24 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-8 animate-bounce">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <h1 class="text-[32px] font-bold text-[#222222] tracking-tight mb-3">Đặt hàng thành công!</h1>
        <p class="text-[15px] text-[#6a6a6a] leading-relaxed mb-10 max-w-md mx-auto">
            Cảm ơn <span class="font-bold text-[#222222]">{{ $order->full_name }}</span> đã tin tưởng BoPC. Đơn hàng của bạn đang được xử lý và sẽ sớm đến tay bạn.
        </p>

        <div class="bg-[#f7f7f7] rounded-[16px] p-6 text-left space-y-4 mb-10">
            <h2 class="text-[13px] font-bold text-[#222222] uppercase tracking-wide border-b border-[#ebebeb] pb-3">Chi tiết đơn hàng</h2>
            
            <div class="space-y-3">
                <div class="flex justify-between items-center text-[14px]">
                    <span class="text-[#6a6a6a]">Mã đơn hàng</span>
                    <span class="font-bold text-[#222222]">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="flex justify-between items-center text-[14px]">
                    <span class="text-[#6a6a6a]">Số điện thoại</span>
                    <span class="font-bold text-[#222222]">{{ $order->phone }}</span>
                </div>
                <div class="flex justify-between items-center text-[14px]">
                    <span class="text-[#6a6a6a]">Thanh toán</span>
                    <span class="font-bold text-[#222222] uppercase">{{ $order->payment_method }}</span>
                </div>
                <div class="flex justify-between items-center text-[14px]">
                    <span class="text-[#6a6a6a]">Trạng thái</span>
                    <span class="font-bold {{ $order->payment_status == 1 ? 'text-emerald-600' : 'text-orange-600' }}">
                        {{ $order->payment_status == 1 ? 'Đã thanh toán' : 'Chờ thanh toán (COD)' }}
                    </span>
                </div>
                <div class="flex justify-between items-center pt-3 border-t border-[#ebebeb]">
                    <span class="text-[16px] font-bold text-[#222222]">Tổng thanh toán</span>
                    <span class="text-[18px] font-bold text-[#ff385c]">{{ number_format($order->total_price) }}đ</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('home') }}" 
               class="flex-1 px-8 py-4 bg-[#222222] text-white text-[15px] font-bold rounded-[12px] hover:bg-black transition-colors shadow-lg shadow-black/10">
                Tiếp tục mua sắm
            </a>
            <a href="{{ route('order.tracking') }}?phone={{ $order->phone }}" 
               class="flex-1 px-8 py-4 border-2 border-[#222222] text-[#222222] text-[15px] font-bold rounded-[12px] hover:bg-[#f7f7f7] transition-colors">
                Theo dõi đơn hàng
            </a>
        </div>

    </div>

    <p class="mt-10 text-[13px] text-[#6a6a6a] italic">
        Mọi thắc mắc vui lòng liên hệ Hotline: <span class="font-bold text-[#222222]">0123 456 789</span>
    </p>

</div>
@endsection