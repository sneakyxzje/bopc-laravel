@extends('layouts.admin')

@section('title', 'Order Details #' . $order->id)
@section('page_title', 'Chi tiết đơn hàng')

@section('content')
<div class=" mx-auto pb-20 px-4 sm:px-0" x-data="{ 
    copy(text) {
        navigator.clipboard.writeText(text);
        alert('Đã copy mã đơn hàng!');
    }
}">

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

        <div class="lg:col-span-7 space-y-12">

            <section>
                <div class="flex items-center justify-between mb-8">
                    <h1 class="text-3xl font-black text-zinc-900 tracking-tight">Chi tiết đơn hàng</h1>

                    @if($order->status == \App\Models\Order::STATUS_PENDING)
                    @php $isVnPayUnpaid = ($order->payment_method == 'vnpay' && $order->payment_status != \App\Models\Order::PAYMENT_PAID); @endphp
                    <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="{{ \App\Models\Order::STATUS_CONFIRMED }}">
                        @if($isVnPayUnpaid)
                        <button type="button" disabled class="px-6 bg-zinc-100 border border-zinc-200 text-zinc-400 text-sm font-bold py-3 rounded-md cursor-not-allowed flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Chờ thanh toán VNPay
                        </button>
                        @else
                        <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-primary-hover text-white text-sm font-bold rounded-md flex items-center justify-center gap-2 uppercase transition-colors">
                            Xác nhận đơn hàng
                        </button>
                        @endif
                    </form>
                    @elseif($order->status == \App\Models\Order::STATUS_CONFIRMED)
                    <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="{{ \App\Models\Order::STATUS_SHIPPING }}">
                        <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-primary-hover text-white text-sm font-bold rounded-md flex items-center justify-center gap-2 uppercase transition-colors">
                            Chuyển đơn (Đang giao)
                        </button>
                    </form>
                    @elseif($order->status == \App\Models\Order::STATUS_SHIPPING)
                    <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="{{ \App\Models\Order::STATUS_COMPLETED }}">
                        <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-primary-hover text-white text-sm font-bold rounded-md flex items-center justify-center gap-2 uppercase transition-colors">
                            Hoàn thành đơn hàng
                        </button>
                    </form>
                    @endif
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between text-sm py-1">
                        <span class="text-zinc-400 font-medium">Mã đơn hàng</span>
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-zinc-800">ORD-{{ str_pad($order->id, 10, '0', STR_PAD_LEFT) }}</span>
                            <button @click="copy('ORD-{{ $order->id }}')" class="text-zinc-300 hover:text-primary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-sm py-1">
                        <span class="text-zinc-400 font-medium">Ngày đặt</span>
                        <span class="font-bold text-zinc-800">{{ $order->created_at->format('jS F Y | g:i A') }}</span>
                    </div>

                    <div class="flex items-center justify-between text-sm py-1">
                        <span class="text-zinc-400 font-medium">Trạng thái thanh toán</span>
                        @if($order->payment_status == 1)
                        <span class="px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-600 text-[11px] font-black flex items-center gap-1 leading-none uppercase">
                            Đã thanh toán
                        </span>
                        @else
                        <span class="px-2 py-0.5 rounded-md bg-amber-50 text-amber-600 text-[11px] font-black flex items-center gap-1 leading-none uppercase">
                            Đang chờ
                        </span>
                        @endif
                    </div>

                    <div class="flex items-center justify-between text-sm py-1 border-b border-zinc-100 pb-4">
                        <span class="text-zinc-400 font-medium">Số tiền</span>
                        <span class="font-black text-zinc-900 text-lg">{{ number_format($order->total_price) }}đ</span>
                    </div>

                    <div class="flex items-center justify-between text-sm py-1 mt-4">
                        <span class="text-zinc-400 font-medium">Phương thức thanh toán</span>
                        <span class="font-bold text-zinc-800 uppercase italic">{{ $order->payment_method }}</span>
                    </div>

                    <div class="flex items-center justify-between text-sm py-1">
                        <span class="text-zinc-400 font-medium">Trạng thái giao hàng</span>
                        @php
                        $statusLabel = [
                        -1 => 'Đang chờ', 0 => 'Chờ duyệt', 1 => 'Đã xác nhận',
                        2 => 'Đang giao', 3 => 'Hoàn thành', 4 => 'Đã hủy'
                        ][$order->status] ?? 'Không xác định';
                        $statusBg = [
                        -1 => 'bg-zinc-100 text-zinc-500', 0 => 'bg-amber-50 text-amber-600',
                        1 => 'bg-blue-50 text-blue-600', 2 => 'bg-indigo-50 text-indigo-600',
                        3 => 'bg-emerald-50 text-emerald-600', 4 => 'bg-red-50 text-red-600'
                        ][$order->status] ?? 'bg-zinc-50 text-zinc-400';
                        @endphp
                        <span class="px-2.5 py-0.5 rounded-md {{ $statusBg }} text-[11px] font-black flex items-center gap-1 leading-none uppercase">
                            {{ $statusLabel }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between text-sm py-1">
                        <span class="text-zinc-400 font-medium uppercase text-[10px]">Estimated Delivery</span>
                        <span class="font-bold text-zinc-800">N/A</span>
                    </div>
                </div>
            </section>

            <section class="pt-8">
                <h3 class="text-sm font-black text-zinc-900 mb-6 uppercase">Sản phẩm đơn hàng ({{ count($order->items) }})</h3>
                <div class="space-y-6">
                    @foreach($order->items as $item)
                    <div class="flex items-center justify-between group">
                        <div class="flex items-center gap-5">
                            <div class="w-14 h-14 bg-zinc-50 rounded-md flex items-center justify-center p-2 border border-zinc-100">
                                @if($item->product && $item->product->primaryImage)
                                <img src="{{ $item->product->primaryImage->image_path }}" class="w-full h-full object-contain">
                                @else
                                <svg class="w-6 h-6 text-zinc-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                @endif
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-zinc-800 leading-none mb-1">{{ $item->product->name ?? 'Product Deleted' }}</h4>
                                <p class="text-[11px] font-medium text-zinc-400">{{ $item->variant->variant_value ?? 'Standard Version' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-16">
                            <span class="text-sm font-bold text-zinc-800 px-8">x{{ $item->quantity }}</span>
                            <span class="text-sm font-black text-zinc-800 w-24 text-right">{{ number_format($item->price) }}đ</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>

            <section class="pt-12">
                <h3 class="text-sm font-black text-zinc-900 mb-8 uppercase">Lịch sử hoạt động</h3>
                <div class="space-y-8 pl-2">
                    <div class="relative pl-10 border-l-2 border-zinc-100 pb-2 last:pb-0">
                        <div class="absolute -left-[11px] top-0 w-5 h-5 bg-white border-2 border-zinc-200 rounded-md flex items-center justify-center">
                            <div class="w-1.5 h-1.5 bg-zinc-400 rounded-md"></div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-zinc-50 text-zinc-400 rounded-md flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-zinc-700 leading-none mb-1">Đơn hàng được tạo</p>
                                <p class="text-[11px] font-medium text-zinc-400">{{ $order->created_at->format('jS F Y | g:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    @if($order->status >= 1)
                    <div class="relative pl-10 border-l-2 border-zinc-100 pb-2 last:pb-0">
                        <div class="absolute -left-[11px] top-0 w-5 h-5 bg-white border-2 border-emerald-200 rounded-md flex items-center justify-center">
                            <div class="w-1.5 h-1.5 bg-emerald-500 rounded-md"></div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-emerald-50 text-emerald-500 rounded-md flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-zinc-700 leading-none mb-1">Đơn hàng đã xác nhận</p>
                                <p class="text-[11px] font-medium text-zinc-400">{{ $order->updated_at->format('jS F Y | g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </section>

        </div>

        <div class="lg:col-span-5 space-y-12 bg-zinc-50/20 p-8 rounded-md border border-zinc-100 h-fit">

            <section>
                <h3 class="text-[13px] font-black text-zinc-400 uppercase  mb-8 border-b border-zinc-100 pb-4">Thông tin khách hàng</h3>
                <div class="space-y-6">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-zinc-400 font-medium">Họ và tên</span>
                        <div class="flex items-center gap-2">

                            <span class="font-bold text-zinc-800">{{ $order->full_name }}</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-zinc-400 font-medium">Địa chỉ Email</span>
                        <span class="font-bold text-zinc-800">{{ $order->user->email ?? 'Guest Order' }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-zinc-400 font-medium">Số điện thoại</span>
                        <span class="font-bold text-zinc-800">{{ $order->phone }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-zinc-400 font-medium shrink-0">Ghi chú đơn</span>
                        <span class="font-bold text-zinc-800 max-w-[200px] text-right truncate italic">"{{ $order->note ?? 'Trống' }}"</span>
                    </div>
                </div>
            </section>

            <section class="pt-4 border-t border-zinc-100">
                <h3 class="text-[13px] font-black text-zinc-400 uppercase mb-8 border-b border-zinc-100 pb-4">Địa chỉ giao hàng</h3>
                <div class="space-y-6">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-zinc-400 font-medium">Quốc gia/Vùng</span>
                        <span class="font-bold text-zinc-800 uppercase text-[11px]">Việt Nam</span>
                    </div>
                    <div class="flex flex-col gap-1 text-sm bg-zinc-50 p-3 rounded-md border border-zinc-100">
                        <div class="flex items-start justify-between">
                            <span class="text-zinc-500 font-medium shrink-0 w-24">Địa chỉ</span>
                            <span class="font-bold text-zinc-800 text-right">{{ $order->address }}</span>
                        </div>
                        <div class="flex items-start justify-between">
                            <span class="text-zinc-500 font-medium shrink-0 w-24">Phường/Xã</span>
                            <span class="font-bold text-zinc-800 text-right">{{ $order->ward ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-start justify-between">
                            <span class="text-zinc-500 font-medium shrink-0 w-24">Quận/Huyện</span>
                            <span class="font-bold text-zinc-800 text-right">{{ $order->district ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-start justify-between">
                            <span class="text-zinc-500 font-medium shrink-0 w-24">Tỉnh/Thành</span>
                            <span class="font-bold text-zinc-800 text-right">{{ $order->province ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="pt-4 border-t border-zinc-100">
                <h3 class="text-[13px] font-black text-zinc-400 uppercase mb-8 border-b border-zinc-100 pb-4">Tóm tắt thanh toán</h3>
                <div class="space-y-5">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-zinc-400 font-medium">Tạm tính</span>
                        <span class="font-bold text-zinc-800">{{ number_format($order->total_price - ($order->shipping_fee ?? 0)) }}đ</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-zinc-400 font-medium">Phí vận chuyển</span>
                        <span class="font-bold text-emerald-600">{{ number_format($order->shipping_fee ?? 0) }}đ</span>
                    </div>
                    <div class="flex items-center justify-between text-sm text-[11px]">
                        <span class="text-zinc-400 font-medium uppercase">VAT (0%)</span>
                        <span class="font-bold text-zinc-800">0đ</span>
                    </div>

                    <div class="flex items-center justify-between text-base pt-6 border-t border-zinc-200">
                        <span class="text-zinc-400 font-black uppercase text-[11px]">Tổng thanh toán</span>
                        <span class="font-black text-primary text-xl">{{ number_format($order->total_price) }}đ</span>
                    </div>
                </div>

                <div class="mt-8 p-6 bg-white border border-zinc-100 rounded-md flex items-center justify-between shadow-sm">
                    <span class="text-[11px] font-black text-zinc-400 uppercase">Payment Method</span>
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-black text-zinc-800 uppercase italic">{{ $order->payment_method }}</span>

                        @if(strtolower($order->payment_method) == 'vnpay')
                        <div class="w-12 h-8 bg-white border border-zinc-100 rounded-md flex items-center justify-center p-1 shadow-sm">
                            <img src="https://cdn.haitrieu.com/wp-content/uploads/2022/10/Icon-VNPAY-QR.png" alt="VNPay" class="w-full h-full object-contain">
                        </div>
                        @else
                        <div class="w-8 h-8 bg-zinc-900 text-white rounded-md flex items-center justify-center font-black text-[8px] italic px-0.5">
                            CASH
                        </div>
                        @endif
                    </div>
                </div>
        </div>

        </section>

    </div>

</div>

</div>
@endsection