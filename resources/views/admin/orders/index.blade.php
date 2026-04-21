@extends('layouts.admin')

@section('title', 'Quản lý đơn hàng')
@section('page_title', 'Danh sách đơn hàng')

@section('content')
<div class="space-y-8">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-md shadow-sm border border-zinc-100 flex items-center gap-4">

            <div>
                <p class="text-xs font-bold text-zinc-400 uppercase">Tổng đơn hàng</p>
                <p class="text-2xl font-black text-zinc-800">{{ number_format($stats['total_count']) }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-md shadow-sm border border-zinc-100 flex items-center gap-4">

            <div>
                <p class="text-xs font-bold text-zinc-400 uppercase">Chờ xét duyệt</p>
                <p class="text-2xl font-black text-zinc-800">{{ number_format($stats['pending_count']) }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-md shadow-sm border border-zinc-100 flex items-center gap-4">

            <div>
                <p class="text-xs font-bold text-zinc-400 uppercase">Đang giao hàng</p>
                <p class="text-2xl font-black text-zinc-800">{{ number_format($stats['shipping_count']) }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-md shadow-sm border border-zinc-100 flex items-center gap-4">
            <div>
                <p class="text-xs font-bold text-zinc-400 uppercase">Doanh thu thật</p>
                <p class="text-2xl font-black text-emerald-600">{{ number_format($stats['revenue']) }}đ</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-md shadow-sm border border-zinc-100 overflow-hidden">

        <div class="p-6 border-b border-zinc-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="relative max-w-sm w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-zinc-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8" />
                        <path d="M21 21l-4.35-4.35" />
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm đơn hàng, khách hàng..."
                    class="w-full pl-10 pr-4 py-2.5 bg-zinc-50 border-none rounded-md text-sm focus:ring-2 focus:ring-primary/20 font-medium">
            </form>

            <div class="flex items-center gap-2">
                <button class="px-4 py-2.5 bg-white border border-zinc-200 rounded-md text-xs font-bold text-zinc-600 hover:bg-primary/5 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 4.5h18m-18 5h18m-18 5h18m-18 5h18" />
                    </svg>
                    LỌC DỮ LIỆU
                </button>
                <button class="px-4 py-2.5 bg-primary text-white rounded-md text-xs font-bold hover:bg-primary-hover flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4" />
                    </svg>
                    TẠO ĐƠN MỚI
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-zinc-50/80">
                        <th class="px-6 py-4 text-[11px] font-black uppercase text-zinc-400">Đơn hàng</th>
                        <th class="px-6 py-4 text-[11px] font-black uppercase text-zinc-400">Khách hàng</th>
                        <th class="px-6 py-4 text-[11px] font-black uppercase text-zinc-400">Ngày đặt</th>
                        <th class="px-6 py-4 text-[11px] font-black uppercase text-zinc-400">Thanh toán</th>
                        <th class="px-6 py-4 text-[11px] font-black uppercase text-zinc-400">Trạng thái</th>
                        <th class="px-6 py-4 text-[11px] font-black uppercase text-zinc-400 text-right">Tổng tiền</th>
                        <th class="px-6 py-4 text-[11px] font-black uppercase text-zinc-400 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-50">
                    @foreach($orders as $order)
                    <tr class="hover:bg-primary/5 group border-transparent">
                        <td class="px-6 py-5">
                            <span class="text-sm font-black text-zinc-800">#{{ $order->id }}</span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div>
                                    <p class="text-sm font-bold text-zinc-800 leading-none mb-1">{{ $order->full_name }}</p>
                                    <p class="text-xs text-zinc-400 font-medium">{{ $order->phone }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-xs font-bold text-zinc-600 truncate max-w-[100px]">{{ $order->created_at->format('d/m/Y') }}</p>
                            <p class="text-[10px] text-zinc-400 font-medium">{{ $order->created_at->format('H:i') }}</p>
                        </td>
                        <td class="px-6 py-5">
                            @if($order->payment_status == 1)
                            <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-md bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase">
                                Đã trả
                            </span>
                            @elseif($order->payment_status == 2)
                            <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-md bg-red-50 text-red-600 text-[10px] font-black uppercase">
                                Lỗi
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-md bg-zinc-100 text-zinc-500 text-[10px] font-black uppercase">
                                Chờ
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            @php
                            $statusMap = [
                            -1 => ['label' => 'Thanh toán', 'bg' => 'bg-zinc-100', 'text' => 'text-zinc-500'],
                            0 => ['label' => 'Chờ duyệt', 'bg' => 'bg-amber-50', 'text' => 'text-amber-600'],
                            1 => ['label' => 'Xác nhận', 'bg' => 'bg-blue-50', 'text' => 'text-blue-600'],
                            2 => ['label' => 'Đang giao', 'bg' => 'bg-indigo-50', 'text' => 'text-indigo-600'],
                            3 => ['label' => 'Thành công', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-600'],
                            4 => ['label' => 'Đã hủy', 'bg' => 'bg-red-50', 'text' => 'text-red-600'],
                            ][rawurlencode($order->status)] ?? ['label' => 'N/A', 'bg' => 'bg-zinc-100', 'text' => 'text-zinc-400'];
                            @endphp
                            <span class="inline-block py-1 px-3 rounded-md {{ $statusMap['bg'] }} {{ $statusMap['text'] }} text-[10px] font-black uppercase">
                                {{ $statusMap['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-right">
                            <span class="text-sm font-black text-zinc-800">{{ number_format($order->total_price) }}đ</span>
                        </td>
                        <td class="px-6 py-5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.orders.detail', $order->id) }}"
                                    class="p-2 bg-zinc-50 text-zinc-400 hover:text-primary hover:bg-primary/10 rounded-md" title="Chi tiết">
                                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                @if($order->status <= 0)
                                @php
                                    $isVnPayUnpaid = ($order->payment_method == 'vnpay' && $order->payment_status != \App\Models\Order::PAYMENT_PAID);
                                @endphp
                                <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="status" value="1">
                                    <button type="{{ $isVnPayUnpaid ? 'button' : 'submit' }}" 
                                            @if($isVnPayUnpaid) disabled @endif
                                            class="p-2 rounded-md {{ $isVnPayUnpaid ? 'bg-zinc-100 text-zinc-300 cursor-not-allowed' : 'bg-zinc-50 text-zinc-400 hover:text-emerald-600 hover:bg-emerald-50' }}" 
                                            title="{{ $isVnPayUnpaid ? 'Chờ thanh toán VNPay' : 'Duyệt đơn' }}">
                                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            @if($isVnPayUnpaid)
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            @endif
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-6 bg-zinc-50/30 border-t border-zinc-100">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection