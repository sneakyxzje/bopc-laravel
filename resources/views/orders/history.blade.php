@extends('layouts.app')

@section('title', 'Đơn hàng của tôi — BO PC')

@section('content')
<div class="max-w-screen-lg mx-auto px-4 py-12 min-h-[70vh]">

    
    <div class="mb-10 border-b border-[#c1c1c1]/40 pb-8">
        <p class="text-xs font-bold text-[#6a6a6a] uppercase mb-2">Tài khoản</p>
        <h1 class="text-[28px] font-bold text-[#222222] tracking-tight leading-snug">Đơn hàng của tôi</h1>
        <p class="text-sm text-[#6a6a6a] mt-1">Xin chào, <span class="font-semibold text-[#222222]">{{ Auth::user()->name }}</span> — tổng <span class="font-semibold">{{ $orders->total() }}</span> đơn hàng</p>
    </div>

    @forelse($orders as $order)
    @php
        $statusMap = [
            -1 => ['label' => 'Đang chờ',     'dot' => '#c1c1c1'],
             0 => ['label' => 'Chờ duyệt',    'dot' => '#d97706'],
             1 => ['label' => 'Đã xác nhận',  'dot' => '#2563eb'],
             2 => ['label' => 'Đang giao',    'dot' => '#7c3aed'],
             3 => ['label' => 'Hoàn thành',   'dot' => '#16a34a'],
             4 => ['label' => 'Đã hủy',       'dot' => '#c13515'],
        ];
        $s = $statusMap[$order->status] ?? $statusMap[0];
    @endphp

    <div class="bg-white mb-4 overflow-hidden rounded-[20px]"
         style="box-shadow: rgba(0,0,0,0.02) 0px 0px 0px 1px, rgba(0,0,0,0.04) 0px 2px 6px, rgba(0,0,0,0.08) 0px 4px 10px;">

        
        <div class="flex items-center justify-between px-6 py-4 border-b border-[#f2f2f2]">
            <div class="flex items-center gap-4">
                <span class="text-[13px] font-bold text-[#222222]">Đơn #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                <span class="text-[#c1c1c1]">·</span>
                <span class="text-[12px] text-[#6a6a6a]">{{ $order->created_at->format('d/m/Y, H:i') }}</span>
            </div>

            
            <div class="flex items-center gap-2">
                <span class="inline-block w-2 h-2 rounded-full" style="background: {{ $s['dot'] }}"></span>
                <span class="text-[12px] font-semibold text-[#222222]">{{ $s['label'] }}</span>
            </div>
        </div>

        
        <div class="px-6 py-5">
            <div class="flex items-center gap-4">
                @foreach($order->items->take(2) as $item)
                <div class="w-14 h-14 rounded-[14px] bg-[#f2f2f2] overflow-hidden flex items-center justify-center shrink-0 border border-[#c1c1c1]/20">
                    @if($item->product && $item->product->primaryImage)
                        <img src="{{ $item->product->primaryImage->image_path }}" class="w-full h-full object-contain" alt="">
                    @else
                        <svg class="w-6 h-6 text-[#c1c1c1]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    @endif
                </div>
                @endforeach

                @if($order->items->count() > 2)
                <div class="w-14 h-14 rounded-[14px] bg-[#f2f2f2] flex items-center justify-center text-[12px] font-bold text-[#6a6a6a]">
                    +{{ $order->items->count() - 2 }}
                </div>
                @endif

                <div class="ml-2 min-w-0 flex-1">
                    <p class="text-[14px] font-semibold text-[#222222] truncate leading-tight">
                        {{ $order->items->first()->product->name ?? 'Sản phẩm' }}
                        @if($order->items->count() > 1)
                            <span class="text-[#6a6a6a] font-normal">và {{ $order->items->count() - 1 }} sản phẩm khác</span>
                        @endif
                    </p>
                    <p class="text-[12px] text-[#6a6a6a] mt-0.5">{{ $order->items->sum('quantity') }} sản phẩm</p>
                </div>
            </div>
        </div>

        
        <div class="flex items-center justify-between px-6 py-4 border-t border-[#f2f2f2]">
            <div>
                <p class="text-[11px] font-semibold text-[#6a6a6a] uppercase tracking-wide mb-0.5">Tổng thanh toán</p>
                <p class="text-[18px] font-bold text-[#222222] tracking-tight">{{ number_format($order->total_price) }}<span class="text-[14px]">đ</span></p>
            </div>
            <a href="{{ route('order.details', $order->id) }}"
               class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#222222] text-white text-[13px] font-semibold rounded-[8px] hover:bg-[#ff385c] transition-colors">
                Xem chi tiết
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
    @empty
    <div class="text-center py-24 bg-white rounded-[20px]"
         style="box-shadow: rgba(0,0,0,0.02) 0px 0px 0px 1px, rgba(0,0,0,0.04) 0px 2px 6px, rgba(0,0,0,0.08) 0px 4px 10px;">
        <p class="text-[16px] font-semibold text-[#222222] mb-2">Bạn chưa có đơn hàng nào</p>
        <p class="text-[14px] text-[#6a6a6a] mb-8">Hãy khám phá các cấu hình PC và laptop gaming tại BoPC.</p>
        <a href="{{ route('home') }}"
           class="inline-flex items-center gap-2 px-8 py-3 bg-[#222222] text-white text-[14px] font-semibold rounded-[8px] hover:bg-[#ff385c] transition-colors">
            Bắt đầu mua sắm
        </a>
    </div>
    @endforelse

    
    @if($orders->hasPages())
    <div class="mt-8 flex items-center justify-center gap-1.5">
        @if($orders->onFirstPage())
            <span class="w-9 h-9 flex items-center justify-center border border-[#c1c1c1]/50 rounded-[8px] text-[#c1c1c1] cursor-not-allowed">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
            </span>
        @else
            <a href="{{ $orders->previousPageUrl() }}" class="w-9 h-9 flex items-center justify-center border border-[#c1c1c1]/50 rounded-[8px] text-[#6a6a6a] hover:border-[#222222] hover:text-[#222222] transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
            </a>
        @endif

        @foreach($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
            @if($page == $orders->currentPage())
                <span class="w-9 h-9 flex items-center justify-center bg-[#222222] text-white text-[13px] font-bold rounded-[8px]">{{ $page }}</span>
            @else
                <a href="{{ $url }}" class="w-9 h-9 flex items-center justify-center border border-[#c1c1c1]/50 text-[#6a6a6a] text-[13px] font-semibold rounded-[8px] hover:border-[#222222] hover:text-[#222222] transition-colors">{{ $page }}</a>
            @endif
        @endforeach

        @if($orders->hasMorePages())
            <a href="{{ $orders->nextPageUrl() }}" class="w-9 h-9 flex items-center justify-center border border-[#c1c1c1]/50 rounded-[8px] text-[#6a6a6a] hover:border-[#222222] hover:text-[#222222] transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
            </a>
        @else
            <span class="w-9 h-9 flex items-center justify-center border border-[#c1c1c1]/50 rounded-[8px] text-[#c1c1c1] cursor-not-allowed">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
            </span>
        @endif
    </div>
    @endif

</div>
@endsection
