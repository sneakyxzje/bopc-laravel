@extends('layouts.app')

@section('title', 'Thanh toán')

@section('content')
<div class="container mx-auto mt-10 px-4 mb-20">
    <h1 class="text-3xl font-bold mb-8">Thông tin thanh toán</h1>

    <form action="{{ route('order.store') }}" method="POST">
        @csrf
        <div class="flex flex-col lg:flex-row gap-10">

            <div class="lg:w-2/3 bg-white p-6 rounded-lg shadow-sm border">
                <h2 class="text-xl font-semibold mb-5 border-b pb-2">Địa chỉ nhận hàng</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Họ và tên</label>
                        <input type="text" name="full_name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                        <input type="text" name="phone" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Địa chỉ cụ thể</label>
                        <input type="text" name="address" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Ghi chú (nếu có)</label>
                        <textarea name="note" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border"></textarea>
                    </div>
                </div>

                <h2 class="text-xl font-semibold mt-8 mb-5 border-b pb-2">Phương thức thanh toán</h2>
                <div class="space-y-3">
                    <label class="flex items-center p-3 border rounded-md cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="payment_method" value="cod" checked class="h-4 w-4 text-blue-600">
                        <span class="ml-3 font-medium text-gray-700">Thanh toán khi nhận hàng (COD)</span>
                    </label>
                    <label class="flex items-center p-3 border rounded-md cursor-pointer hover:bg-gray-50 border-blue-500 bg-blue-50">
                        <input type="radio" name="payment_method" value="vnpay" class="h-4 w-4 text-blue-600">
                        <span class="ml-3 font-medium text-gray-700">Thanh toán qua VNPay (QR Code / Thẻ ATM)</span>
                    </label>
                </div>
            </div>

            <div class="lg:w-1/3">
                <div class="bg-gray-50 p-6 rounded-lg shadow-sm border sticky top-5">
                    <h2 class="text-xl font-semibold mb-5">Đơn hàng của bạn</h2>

                    <div class="divide-y mb-5">
                        <div class="py-3 flex justify-between gap-4">
                            <div class="flex-1">
                                <p class="font-medium text-gray-800">Laptop Dell XPS 13</p>
                                <p class="text-sm text-gray-500 italic">Phiên bản: 16GB RAM - 512GB SSD</p>
                                <p class="text-sm text-gray-600">Số lượng: 1</p>
                            </div>
                            <span class="font-semibold">25.000.000đ</span>
                        </div>
                    </div>

                    <div class="border-t pt-4 space-y-2">
                        <div class="flex justify-between text-gray-600">
                            <span>Tạm tính:</span>
                            <span>25.000.000đ</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Phí vận chuyển:</span>
                            <span>Miễn phí</span>
                        </div>
                        <div class="flex justify-between text-xl font-bold text-red-600 pt-2 border-t">
                            <span>Tổng cộng:</span>
                            <span>25.000.000đ</span>
                        </div>
                    </div>

                    <button type="submit" class="w-full mt-6 bg-blue-600 text-white font-bold py-3 rounded-md hover:bg-blue-700 transition duration-300">
                        XÁC NHẬN ĐẶT HÀNG
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection