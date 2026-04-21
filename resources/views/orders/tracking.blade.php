@extends('layouts.app')

@section('title', 'Tra cứu đơn hàng — BO PC')

@section('content')
<div class="max-w-screen-lg mx-auto px-4 sm:px-6 lg:px-10 py-14">

    
    <div class="max-w-xl mb-10">
        <p class="text-[11px] font-semibold text-[#6a6a6a] uppercase mb-2">Hỗ trợ khách hàng</p>
        <h1 class="text-[28px] font-bold text-[#222222] tracking-tight leading-tight mb-3">Tra cứu đơn hàng</h1>
        <p class="text-[14px] text-[#6a6a6a] leading-relaxed">Nhập số điện thoại bạn đã dùng khi đặt hàng để xem trạng thái tất cả đơn hàng của mình.</p>
    </div>

    
    <div class="bg-white rounded-[20px] p-8 mb-10"
         style="box-shadow: rgba(0,0,0,0.02) 0px 0px 0px 1px, rgba(0,0,0,0.04) 0px 2px 6px, rgba(0,0,0,0.1) 0px 4px 8px;">

        <form action="{{ route('order.do_tracking') }}" method="POST">
            @csrf
            <label class="block text-[13px] font-semibold text-[#222222] mb-2" for="phone">
                Số điện thoại
            </label>
            <div class="flex gap-3">
                <input
                    id="phone"
                    type="text"
                    name="phone"
                    value="{{ $phone ?? old('phone') }}"
                    required
                    placeholder="VD: 0912 345 678"
                    autocomplete="tel"
                    class="flex-1 h-12 px-4 border border-[#c1c1c1] rounded-[8px] text-[14px] text-[#222222] placeholder-[#c1c1c1] font-medium bg-white focus:outline-none focus:border-[#222222] focus:ring-1 focus:ring-[#222222] transition-colors"
                >
                <button
                    type="submit"
                    class="h-12 px-8 bg-[#222222] text-white text-[14px] font-semibold rounded-[8px] hover:bg-[#ff385c] transition-colors whitespace-nowrap"
                >
                    Tra cứu
                </button>
            </div>

            @error('phone')
                <p class="mt-2 text-[13px] text-[#c13515] font-medium">{{ $message }}</p>
            @enderror
            @if(session('error'))
                <p class="mt-2 text-[13px] text-[#c13515] font-medium">{{ session('error') }}</p>
            @endif
        </form>
    </div>

    
    @if(isset($orders))
    <div>
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-[14px] font-bold text-[#222222] uppercase tracking-wide">
                Kết quả tra cứu
            </h2>
            <span class="text-[13px] text-[#6a6a6a]">Tìm thấy <span class="font-semibold text-[#222222]">{{ $orders->count() }}</span> đơn hàng</span>
        </div>

        @if($orders->isEmpty())
        <div class="bg-white rounded-[20px] px-8 py-16 text-center"
             style="box-shadow: rgba(0,0,0,0.02) 0px 0px 0px 1px, rgba(0,0,0,0.04) 0px 2px 6px, rgba(0,0,0,0.1) 0px 4px 8px;">
            <p class="text-[16px] font-semibold text-[#222222] mb-2">Không tìm thấy đơn hàng</p>
            <p class="text-[14px] text-[#6a6a6a]">Số điện thoại <span class="font-semibold text-[#222222]">{{ $phone }}</span> chưa có đơn hàng nào.</p>
        </div>
        @else

        <div class="space-y-4">
            @foreach($orders as $order)
            @php
                $statusMap = [
                    -1 => ['label' => 'Đang chờ',      'color' => '#c1c1c1'],
                     0 => ['label' => 'Chờ xác nhận',  'color' => '#d97706'],
                     1 => ['label' => 'Đã xác nhận',   'color' => '#2563eb'],
                     2 => ['label' => 'Đang giao',     'color' => '#7c3aed'],
                     3 => ['label' => 'Hoàn thành',    'color' => '#16a34a'],
                     4 => ['label' => 'Đã hủy',        'color' => '#c13515'],
                ];
                $s = $statusMap[$order->status] ?? $statusMap[0];
            @endphp

            <div class="bg-white rounded-[20px] overflow-hidden"
                 style="box-shadow: rgba(0,0,0,0.02) 0px 0px 0px 1px, rgba(0,0,0,0.04) 0px 2px 6px, rgba(0,0,0,0.08) 0px 4px 10px;">

                
                <div class="px-6 py-4 border-b border-[#f2f2f2] flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <span class="text-[13px] font-bold text-[#222222]">Đơn #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                        <span class="text-[#c1c1c1]">·</span>
                        <span class="text-[12px] text-[#6a6a6a]">{{ $order->created_at->format('d/m/Y, H:i') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full shrink-0" style="background: {{ $s['color'] }}"></span>
                        <span class="text-[12px] font-semibold text-[#222222]">{{ $s['label'] }}</span>
                    </div>
                </div>

                
                <div class="px-6 py-5 flex items-center gap-4">
                    @foreach($order->items->take(3) as $item)
                    <div class="w-12 h-12 rounded-[10px] border border-[#c1c1c1]/20 bg-[#f2f2f2] overflow-hidden flex items-center justify-center shrink-0">
                        @if($item->product && $item->product->primaryImage)
                            <img src="{{ $item->product->primaryImage->image_path }}" class="w-full h-full object-contain" alt="">
                        @else
                            <svg class="w-5 h-5 text-[#c1c1c1]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        @endif
                    </div>
                    @endforeach

                    @if($order->items->count() > 3)
                    <div class="w-12 h-12 rounded-[10px] bg-[#f2f2f2] flex items-center justify-center text-[12px] font-bold text-[#6a6a6a]">
                        +{{ $order->items->count() - 3 }}
                    </div>
                    @endif

                    <div class="flex-1 min-w-0 ml-1">
                        <p class="text-[14px] font-semibold text-[#222222] truncate">
                            {{ $order->items->first()->product->name ?? 'Sản phẩm' }}
                            @if($order->items->count() > 1)
                                <span class="font-normal text-[#6a6a6a]">và {{ $order->items->count() - 1 }} sản phẩm khác</span>
                            @endif
                        </p>
                        <p class="text-[12px] text-[#6a6a6a] mt-0.5">{{ $order->items->sum('quantity') }} sản phẩm</p>
                    </div>
                </div>

                
                <div class="px-6 py-4 border-t border-[#f2f2f2] flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-semibold text-[#6a6a6a] uppercase tracking-wide mb-0.5">Tổng thanh toán</p>
                        <p class="text-[17px] font-bold text-[#222222]">{{ number_format($order->total_price) }}đ</p>
                    </div>
                    <a href="{{ route('order.details', $order->id) }}?phone={{ $phone }}"
                       class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#222222] text-white text-[13px] font-semibold rounded-[8px] hover:bg-[#ff385c] transition-colors">
                        Xem chi tiết
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

            </div>
            @endforeach
        </div>

        @endif
    </div>
    @endif

    
    @if(!isset($orders))
    <div class="mt-4 px-1 flex items-start gap-3">
        <svg class="w-4 h-4 text-[#6a6a6a] shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p class="text-[13px] text-[#6a6a6a] leading-relaxed">
            Tra cứu dành cho khách mua hàng mà không đăng nhập tài khoản. Nếu bạn đã có tài khoản, hãy
            <a href="{{ route('orders.history') }}" class="text-[#222222] font-semibold underline hover:text-[#ff385c] transition-colors">xem đơn hàng của tôi</a>.
        </p>
    </div>
    @endif

</div>
@endsection