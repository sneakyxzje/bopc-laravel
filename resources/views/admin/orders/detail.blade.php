@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng #' . $order->id)

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="mb-4">
        <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:underline flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
        </a>
    </div>

    <div class="bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">Đơn hàng #{{ $order->id }}</h1>
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                {{ $order->status_name }}
            </span>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Thông tin giao hàng</h2>
                <div class="text-gray-800 space-y-2">
                    <p><strong>Người nhận:</strong> {{ $order->full_name }}</p>
                    <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                    <p><strong>Ghi chú:</strong> <span class="italic text-gray-600">{{ $order->note ?? 'Không có' }}</span></p>
                </div>
            </div>

            <div>
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Thanh toán</h2>
                <div class="text-gray-800 space-y-2">
                    <p><strong>Phương thức:</strong> {{ strtoupper($order->payment_method) }}</p>
                    <p><strong>Trạng thái tiền:</strong>
                        <span class="{{ $order->payment_status == 1 ? 'text-green-600' : 'text-red-600' }} font-medium">
                            {{ $order->payment_status == 1 ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                        </span>
                    </p>
                    <p><strong>Thời gian đặt:</strong> {{ $order->created_at->format('H:i d/m/Y') }}</p>
                </div>
            </div>
        </div>

        <div class="p-6 border-t border-gray-200">
            <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Danh sách sản phẩm</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-gray-400 text-xs uppercase border-b border-gray-100">
                            <th class="pb-3 font-medium">Sản phẩm</th>
                            <th class="pb-3 font-medium text-center">Số lượng</th>
                            <th class="pb-3 font-medium text-right">Đơn giá</th>
                            <th class="pb-3 font-medium text-right">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($order->items as $item)
                        <tr>
                            <td class="py-4">
                                <div class="font-bold text-gray-800">
                                    {{ $item->product->name ?? 'Sản phẩm đã xóa' }}
                                </div>

                                <div class="text-xs text-blue-600 font-medium">
                                    @if($item->variant)
                                    Cấu hình: {{ $item->variant->variant_name }}: {{ $item->variant->variant_value }}
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">x{{ $item->quantity }}</td>
                            <td class="text-right">{{ number_format($item->price) }}đ</td>
                            <td class="text-right font-bold">{{ number_format($item->price * $item->quantity) }}đ</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="text-lg">
                            <td colspan="3" class="pt-6 text-right font-semibold text-gray-600">Tổng cộng:</td>
                            <td class="pt-6 text-right font-bold text-red-600">{{ number_format($order->total_price) }}đ</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
            @if($order->status == 0)
            <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="1">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 transition">
                    Xác nhận đơn hàng
                </button>
            </form>
            @endif

            <button onclick="window.print()" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition">
                In hóa đơn
            </button>
        </div>
    </div>
</div>
@endsection