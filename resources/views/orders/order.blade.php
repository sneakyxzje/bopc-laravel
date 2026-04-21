@extends('layouts.app')

@section('title', 'Thanh toán — BO PC')

@section('content')
<div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-10 py-12">
    
    
    <nav class="flex items-center gap-2 text-[12px] text-[#6a6a6a] mb-10 uppercase font-bold">
        <a href="{{ route('home') }}" class="hover:text-[#222222] transition-colors">Trang chủ</a>
        <span class="text-[#c1c1c1]">/</span>
        <a href="{{ route('cart.index') }}" class="hover:text-[#222222] transition-colors">Giỏ hàng</a>
        <span class="text-[#c1c1c1]">/</span>
        <span class="text-[#222222]">Thanh toán</span>
    </nav>

    <h1 class="text-[32px] font-bold text-[#222222] tracking-tight mb-10">Thông tin thanh toán</h1>

    <form action="{{ route('order.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            
            <div class="lg:col-span-8 space-y-8">
                <div class="bg-white rounded-[20px] p-8"
                     style="box-shadow: rgba(0,0,0,0.02) 0px 0px 0px 1px, rgba(0,0,0,0.04) 0px 2px 6px, rgba(0,0,0,0.1) 0px 4px 8px;">
                    
                    <h2 class="text-[18px] font-bold text-[#222222] mb-8 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full bg-[#222222] text-white flex items-center justify-center text-[14px]">1</span>
                        Địa chỉ nhận hàng
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-[13px] font-bold text-[#222222] uppercase px-1">Họ và tên</label>
                            <input type="text" name="full_name" required value="{{ Auth::check() ? Auth::user()->name : '' }}"
                                   class="block w-full h-12 px-4 border border-[#c1c1c1] rounded-[12px] text-[15px] focus:outline-none focus:border-[#222222] transition-colors placeholder-[#b0b0b0]"
                                   placeholder="VD: Nguyễn Văn A">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[13px] font-bold text-[#222222] uppercase px-1">Số điện thoại</label>
                            <input type="text" name="phone" required value="{{ Auth::check() ? Auth::user()->phone : '' }}"
                                   class="block w-full h-12 px-4 border border-[#c1c1c1] rounded-[12px] text-[15px] focus:outline-none focus:border-[#222222] transition-colors placeholder-[#b0b0b0]"
                                   placeholder="VD: 0912 345 678">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="block text-[13px] font-bold text-[#222222] uppercase px-1">Tỉnh / Thành phố</label>
                            <select id="province" name="province" required 
                                    class="block w-full h-12 px-4 border border-[#c1c1c1] rounded-[12px] text-[15px] focus:outline-none focus:border-[#222222] transition-colors bg-white">
                                <option value="">Chọn Tỉnh / Thành phố</option>
                            </select>
                            <input type="hidden" name="province_name" id="province_name">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[13px] font-bold text-[#222222] uppercase px-1">Quận / Huyện</label>
                            <select id="district" name="district" required disabled 
                                    class="block w-full h-12 px-4 border border-[#c1c1c1] rounded-[12px] text-[15px] focus:outline-none focus:border-[#222222] transition-colors bg-white disabled:bg-[#f7f7f7] disabled:text-[#b0b0b0]">
                                <option value="">Chọn Quận / Huyện</option>
                            </select>
                            <input type="hidden" name="district_name" id="district_name">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[13px] font-bold text-[#222222] uppercase px-1">Phường / Xã</label>
                            <select id="ward" name="ward" required disabled 
                                    class="block w-full h-12 px-4 border border-[#c1c1c1] rounded-[12px] text-[15px] focus:outline-none focus:border-[#222222] transition-colors bg-white disabled:bg-[#f7f7f7] disabled:text-[#b0b0b0]">
                                <option value="">Chọn Phường / Xã</option>
                            </select>
                            <input type="hidden" name="ward_name" id="ward_name">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[13px] font-bold text-[#222222] uppercase px-1">Số nhà, tên đường</label>
                            <input type="text" name="address" required 
                                   class="block w-full h-12 px-4 border border-[#c1c1c1] rounded-[12px] text-[15px] focus:outline-none focus:border-[#222222] transition-colors placeholder-[#b0b0b0]"
                                   placeholder="Ví dụ: 123 Đường ABC">
                        </div>

                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-[13px] font-bold text-[#222222] uppercase px-1">Ghi chú (nếu có)</label>
                            <textarea name="note" rows="3" 
                                      class="block w-full px-4 py-3 border border-[#c1c1c1] rounded-[12px] text-[15px] focus:outline-none focus:border-[#222222] transition-colors placeholder-[#b0b0b0]"
                                      placeholder="Lời nhắn cho shipper..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-[20px] p-8"
                     style="box-shadow: rgba(0,0,0,0.02) 0px 0px 0px 1px, rgba(0,0,0,0.04) 0px 2px 6px, rgba(0,0,0,0.1) 0px 4px 8px;">
                    
                    <h2 class="text-[18px] font-bold text-[#222222] mb-8 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full bg-[#222222] text-white flex items-center justify-center text-[14px]">2</span>
                        Phương thức thanh toán
                    </h2>

                    <div class="space-y-4">
                        <label class="relative flex items-center p-5 border-2 border-[#ebebeb] rounded-[16px] cursor-pointer hover:border-[#222222] transition-all group">
                            <input type="radio" name="payment_method" value="cod" checked class="w-5 h-5 text-[#222222] focus:ring-0">
                            <div class="ml-4">
                                <p class="text-[15px] font-bold text-[#222222]">Thanh toán khi nhận hàng (COD)</p>
                                <p class="text-[13px] text-[#6a6a6a]">Tiền mặt hoặc chuyển khoản khi nhận hàng</p>
                            </div>
                        </label>

                        <label class="relative flex items-center p-5 border-2 border-[#ebebeb] rounded-[16px] cursor-pointer hover:border-[#222222] transition-all group has-[:checked]:border-[#222222] has-[:checked]:bg-[#f7f7f7]">
                            <input type="radio" name="payment_method" value="vnpay" class="w-5 h-5 text-[#222222] focus:ring-0">
                            <div class="ml-4">
                                <p class="text-[15px] font-bold text-[#222222]">Thanh toán qua VNPay</p>
                                <p class="text-[13px] text-[#6a6a6a]">QR Code, Thẻ nội địa hoặc Thẻ quốc tế</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            
            <div class="lg:col-span-4">
                <div class="bg-white rounded-[20px] p-8 sticky top-28"
                     style="box-shadow: rgba(0,0,0,0.02) 0px 0px 0px 1px, rgba(0,0,0,0.04) 0px 2px 6px, rgba(0,0,0,0.1) 0px 4px 8px;">
                    
                    <h2 class="text-[16px] font-bold text-[#222222] mb-6">Đơn hàng của bạn</h2>

                    <div class="space-y-5 mb-8 max-h-[350px] overflow-y-auto pr-2 scrollbar-thin">
                        @foreach($carts as $item)
                        <div class="flex gap-4">
                            <div class="w-14 h-14 bg-[#f7f7f7] rounded-[10px] border border-[#f2f2f2] shrink-0 overflow-hidden p-1 flex items-center justify-center">
                                @if(isset($item->product->primaryImage))
                                    <img src="{{ $item->product->primaryImage->image_path }}" class="w-full h-full object-contain">
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[13px] font-bold text-[#222222] leading-tight line-clamp-2">{{ $item->product->name }}</p>
                                <div class="flex items-center justify-between mt-1">
                                    <p class="text-[11px] text-[#6a6a6a]">x{{ $item->quantity }} &middot; {{ $item->variant->variant_name ?? 'Mặc định' }}</p>
                                    <p class="text-[13px] font-bold text-[#222222]">{{ number_format($item->price * $item->quantity) }}đ</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="space-y-3.5 pt-6 border-t border-[#f2f2f2]">
                        <div class="flex justify-between items-center text-[14px]">
                            <span class="text-[#6a6a6a]">Tiền hàng</span>
                            <span class="font-bold text-[#222222]">{{ number_format($subtotal) }}đ</span>
                        </div>
                        <div class="flex justify-between items-center text-[14px]" id="shipping-info" style="display: none;">
                            <span class="text-[#6a6a6a]">Phí vận chuyển</span>
                            <span id="shipping-fee" class="font-bold text-emerald-600">Đang tính...</span>
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t border-[#f2f2f2]">
                            <span class="text-[16px] font-bold text-[#222222] uppercase tracking-wide">Tổng cộng</span>
                            <span id="total-price" data-subtotal="{{ $subtotal }}" class="text-[22px] font-bold text-[#ff385c]">
                                {{ number_format($subtotal) }}đ
                            </span>
                        </div>
                    </div>

                    <input type="hidden" name="shipping_fee" id="shipping_fee_input" value="0">
                    
                    <button type="submit" 
                            class="w-full mt-8 bg-[#222222] text-white py-4 rounded-[12px] text-[15px] font-bold hover:bg-[#ff385c] transition-colors shadow-lg shadow-black/10 flex items-center justify-center gap-3">
                        <span>XÁC NHẬN ĐẶT HÀNG</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </button>

                    <div class="mt-6 p-4 bg-emerald-50 rounded-[12px] border border-emerald-100 flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                        <p class="text-[11px] font-bold text-emerald-700 uppercase leading-none">Miễn phí lắp đặt tận nơi</p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    const host = "https://provinces.open-api.vn/api/";

    // 1. Lấy Tỉnh/Thành
    fetch(host + "?depth=1")
        .then(res => res.json())
        .then(data => {
            let html = '<option value="">Chọn Tỉnh / Thành phố</option>';
            data.forEach(item => {
                html += `<option value="${item.code}">${item.name}</option>`;
            });
            document.querySelector("#province").innerHTML = html;
        });

    // 2. Chọn Tỉnh -> Lấy Huyện
    document.querySelector("#province").addEventListener("change", function() {
        let provinceCode = this.value;
        let provinceName = this.options[this.selectedIndex].text;
        document.querySelector("#province_name").value = provinceName;

        if (provinceCode) {
            fetch(host + "p/" + provinceCode + "?depth=2")
                .then(res => res.json())
                .then(data => {
                    let html = '<option value="">Chọn Quận / Huyện</option>';
                    data.districts.forEach(item => {
                        html += `<option value="${item.code}">${item.name}</option>`;
                    });
                    document.querySelector("#district").innerHTML = html;
                    document.querySelector("#district").disabled = false;
                });
        }
    });

    document.querySelector("#district").addEventListener("change", function() {
        let districtCode = this.value;
        let districtName = this.options[this.selectedIndex].text;
        document.querySelector("#district_name").value = districtName;

        if (districtCode) {
            fetch(host + "d/" + districtCode + "?depth=2")
                .then(res => res.json())
                .then(data => {
                    let html = '<option value="">Chọn Phường / Xã</option>';
                    data.wards.forEach(item => {
                        html += `<option value="${item.code}">${item.name}</option>`;
                    });
                    document.querySelector("#ward").innerHTML = html;
                    document.querySelector("#ward").disabled = false;
                });
        }
    });

    document.querySelector("#ward").addEventListener("change", function() {
        let wardName = this.options[this.selectedIndex].text;
        document.querySelector("#ward_name").value = wardName;

        calculateShippingFee();
    });

    function calculateShippingFee() {
        const province = document.querySelector("#province_name").value;
        const district = document.querySelector("#district_name").value;
        const ward = document.querySelector("#ward_name").value;
        const address = document.querySelector('input[name="address"]').value;

        if (!province || !district || !ward) return;

        document.querySelector("#shipping-fee").innerText = "Đang tính...";
        document.querySelector("#shipping-info").style.display = "flex";

        fetch("{{ route('order.calculate.shipping') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    province: province,
                    district: district,
                    ward: ward,
                    address: address
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const fee = data.fee;
                    const subtotal = parseInt(document.querySelector("#total-price").dataset.subtotal);

                    document.querySelector("#shipping-fee").innerText = fee.toLocaleString('vi-VN') + "đ";

                    const total = subtotal + fee;
                    document.querySelector("#total-price").innerText = total.toLocaleString('vi-VN') + "đ";
                    document.querySelector("#shipping_fee_input").value = fee;
                } else {
                    document.querySelector("#shipping-fee").innerText = "Lỗi tính phí";
                }
            });

    }
</script>

@endsection