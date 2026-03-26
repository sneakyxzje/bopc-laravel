@extends('layouts.app')

@section('title', 'Quản lý đơn hàng')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Quản lý đơn hàng</h1>
        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
            Tổng số: {{ $orders->total() }} đơn hàng
        </span>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Mã Đơn</th>
                    <th class="py-3 px-6 text-left">Khách hàng</th>
                    <th class="py-3 px-6 text-left">Ngày đặt</th>
                    <th class="py-3 px-6 text-center">Tổng tiền</th>
                    <th class="py-3 px-6 text-center">Thanh toán</th>
                    <th class="py-3 px-6 text-center">Trạng thái</th>
                    <th class="py-3 px-6 text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach($orders as $order)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <span class="font-medium">#{{ $order->id }}</span>
                    </td>
                    <td class="py-3 px-6 text-left">
                        <div class="flex flex-col">
                            <span class="font-bold text-gray-800">{{ $order->full_name }}</span>
                            <span class="text-xs text-gray-500">{{ $order->phone }}</span>
                        </div>
                    </td>
                    <td class="py-3 px-6 text-left text-xs">
                        {{ $order->created_at->format('H:i d/m/Y') }}
                    </td>
                    <td class="py-3 px-6 text-center font-semibold text-red-600">
                        {{ number_format($order->total_price) }}đ
                    </td>
                    <td class="py-3 px-6 text-center">
                        @if($order->payment_status == 1)
                        <span class="bg-green-200 text-green-700 py-1 px-3 rounded-full text-xs">Đã trả</span>
                        @else
                        <span class="bg-yellow-200 text-yellow-700 py-1 px-3 rounded-full text-xs">Chưa trả</span>
                        @endif
                    </td>
                    <td class="py-3 px-6 text-center">
                        @php
                        $statusClasses = [
                        -1 => 'bg-gray-200 text-gray-600', // Đang chờ quẹt thẻ
                        0 => 'bg-blue-200 text-blue-700', // Chờ xác nhận (COD)
                        1 => 'bg-indigo-200 text-indigo-700', // Đã xác nhận
                        2 => 'bg-orange-200 text-orange-700', // Đang giao
                        3 => 'bg-green-200 text-green-700', // Hoàn thành
                        4 => 'bg-red-200 text-red-700', // Đã hủy
                        ];
                        $statusNames = [
                        -1 => 'Chờ thanh toán',
                        0 => 'Chờ duyệt',
                        1 => 'Đã xác nhận',
                        2 => 'Đang giao',
                        3 => 'Thành công',
                        4 => 'Đã hủy'
                        ];
                        @endphp
                        <span class="{{ $statusClasses[$order->status] ?? 'bg-gray-100' }} py-1 px-3 rounded-full text-xs font-semibold">
                            {{ $statusNames[$order->status] ?? 'Không xác định' }}
                        </span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center space-x-2">
                            <a href="{{ route('admin.orders.detail', $order->id) }}" class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="status" value="1">
                                <button type="submit" class="w-4 mr-2 transform hover:text-green-500 hover:scale-110">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection