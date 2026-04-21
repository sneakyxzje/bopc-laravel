@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
<div class=" min-h-screen pb-20">
    <div class="max-w-screen-xl mx-auto px-4 py-8">

        <nav class="flex items-center gap-2 text-xs font-bold text-secondary-gray mb-8 uppercase">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Trang chủ</a>
            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                <path d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-near-black">Giỏ hàng</span>
        </nav>

        <h1 class="text-3xl font-black text-near-black mb-10">
            Giỏ hàng của bạn
            @if(!$allCartItems->isEmpty())
            <span class="text-base font-bold text-secondary-gray/40 ml-2">({{ $allCartItems->count() }} sản phẩm)</span>
            @endif
        </h1>

        @if($allCartItems->isEmpty())
        <div class="card-airbnb bg-white flex flex-col items-center justify-center py-24 px-6 text-center border border-[#f2f2f2]">
            <div class="w-24 h-24 bg-[#f7f7f7] rounded-md flex items-center justify-center mb-8">
                <svg class="w-10 h-10 text-secondary-gray/20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="9" cy="21" r="1" /><circle cx="20" cy="21" r="1" />
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                </svg>
            </div>
            <h2 class="text-xl font-bold text-near-black mb-3">Giỏ hàng đang trống</h2>
            <p class="text-sm text-secondary-gray mb-10 font-medium">Bạn chưa chọn được cấu hình PC nào ưng ý sao?</p>
            <a href="{{ route('home') }}"
                class="btn-airbnb-brand px-10 py-4 text-sm font-bold shadow-lg shadow-primary/20">
                Tiếp tục khám phá
            </a>
        </div>

        @else
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10"
             x-data="{
                items: {{ $allCartItems->map(fn($item) => ['id' => $item->id, 'price' => (float)$item->price, 'quantity' => (int)$item->quantity])->toJson() }},
                loading: false,
                get subtotal() {
                    return this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                },
                formatCurrency(amount) {
                    return new Intl.NumberFormat('vi-VN').format(amount) + 'đ';
                },
                async updateQty(itemId, newQty) {
                    if (newQty < 1 || this.loading) return;
                    
                    const item = this.items.find(i => i.id === itemId);
                    if (!item) return;

                    const oldQty = item.quantity;
                    item.quantity = newQty;
                    this.loading = true;

                    try {
                        const response = await fetch('/cart/update/' + itemId, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ quantity: newQty })
                        });

                        const data = await response.json();
                        if (!data.success) throw new Error();
                    } catch (error) {
                        item.quantity = oldQty;
                        alert('Không thể cập nhật số lượng!');
                    } finally {
                        this.loading = false;
                    }
                }
             }">

            <div class="lg:col-span-8 space-y-4">

                <div class="hidden md:grid grid-cols-12 gap-4 px-6 py-2 text-[10px] font-black text-secondary-gray uppercase">
                    <div class="col-span-12 lg:col-span-5">Sản phẩm</div>
                    <div class="col-span-3">Cấu hình</div>
                    <div class="col-span-2 text-center">Số lượng</div>
                    <div class="col-span-2 text-right">Tổng tiền</div>
                </div>

                @foreach($cartItems as $index => $item)
                <div class="card-airbnb bg-white p-5 sm:p-6 flex gap-4 sm:gap-6 items-start border border-[#f2f2f2] transition-all hover:border-[#222222]/10">

                    
                    <div class="w-20 h-20 sm:w-24 sm:h-24 bg-[#f7f7f7] border border-[#f2f2f2] rounded-md overflow-hidden shrink-0 flex items-center justify-center p-2">
                        @if(isset($item->product->primaryImage))
                        <img src="{{ $item->product->primaryImage->image_path }}"
                            alt="{{ $item->product->name }}"
                            class="w-full h-full object-contain mix-blend-multiply">
                        @else
                        <svg class="w-8 h-8 text-[#e2e8f0]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        @endif
                    </div>

                    
                    <div class="flex-1 min-w-0 flex flex-col gap-3">
                        
                        <div>
                            <a href="{{ route('product.detail', $item->product->slug) }}" class="text-[14px] sm:text-[15px] font-bold text-near-black leading-tight line-clamp-2 hover:text-primary transition-colors">
                                {{ $item->product->name }}
                            </a>
                            <p class="text-[10px] font-bold text-secondary-gray mt-1 uppercase">SKU: {{ $item->variant->sku ?? '—' }}</p>
                        </div>

                        
                        <span class="self-start inline-block text-[10px] font-black text-near-black bg-[#f7f7f7] border border-[#ebebeb] px-3 py-1.5 rounded-md uppercase">
                            {{ $item->variant->variant_name ?? 'Mặc định' }}
                        </span>

                        
                        <div class="flex items-center justify-between gap-4 flex-wrap">
                            
                            <div class="flex items-center gap-3 bg-[#f7f7f7] p-1 rounded-md border border-[#ebebeb]">
                                <button @click="updateQty({{ $item->id }}, items[{{ $index }}].quantity - 1)"
                                    :disabled="items[{{ $index }}].quantity <= 1 || loading"
                                    class="w-8 h-8 flex items-center justify-center rounded hover:bg-white text-near-black font-bold text-base transition disabled:opacity-30">
                                    −
                                </button>
                                <span class="w-8 text-center font-bold text-sm text-near-black" x-text="items[{{ $index }}].quantity"></span>
                                <button @click="updateQty({{ $item->id }}, items[{{ $index }}].quantity + 1)"
                                    :disabled="loading"
                                    class="w-8 h-8 flex items-center justify-center rounded hover:bg-white text-near-black font-bold text-base transition disabled:opacity-30">
                                    +
                                </button>
                            </div>

                            
                            <div class="flex items-center gap-3 ml-auto">
                                <span class="text-base font-black text-near-black"
                                    x-text="formatCurrency(items[{{ $index }}].quantity * items[{{ $index }}].price)">
                                </span>
                                <form method="POST" action="{{ route('cart.remove', $item->id) }}" onsubmit="return confirm('Loại bỏ sản phẩm này khỏi giỏ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-9 h-9 flex items-center justify-center text-secondary-gray/40 hover:text-primary hover:bg-primary/5 rounded-md transition-all"
                                        title="Xóa sản phẩm">
                                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                @endforeach

                <div class="pt-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center gap-2 text-xs font-bold text-secondary-gray hover:text-near-black uppercase transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M19 12H5M12 19l-7-7 7-7" />
                        </svg>
                        Tiếp tục mua hàng
                    </a>

                    @if($cartItems->hasPages())
                    <div class="flex items-center gap-1.5">
                        
                        @if($cartItems->onFirstPage())
                            <span class="w-8 h-8 flex items-center justify-center text-secondary-gray/30 border border-[#f2f2f2] rounded cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
                            </span>
                        @else
                            <a href="{{ $cartItems->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center text-secondary-gray border border-[#ebebeb] rounded hover:border-primary hover:text-primary transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
                            </a>
                        @endif

                        
                        @foreach($cartItems->getUrlRange(1, $cartItems->lastPage()) as $page => $url)
                            @if($page == $cartItems->currentPage())
                                <span class="w-8 h-8 flex items-center justify-center text-[12px] font-black text-white bg-primary border border-primary rounded">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center text-[12px] font-black text-near-black border border-[#ebebeb] rounded hover:border-primary hover:text-primary transition-colors">{{ $page }}</a>
                            @endif
                        @endforeach

                        
                        @if($cartItems->hasMorePages())
                            <a href="{{ $cartItems->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center text-secondary-gray border border-[#ebebeb] rounded hover:border-primary hover:text-primary transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                            </a>
                        @else
                            <span class="w-8 h-8 flex items-center justify-center text-secondary-gray/30 border border-[#f2f2f2] rounded cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                            </span>
                        @endif
                    </div>
                    @endif
                </div>

            </div>

            <div class="lg:col-span-4">
                <div class="card-airbnb bg-white p-8 sticky top-24 space-y-8 border border-[#f2f2f2]">

                    <h2 class="text-[10px] font-bold text-near-black uppercase mb-4">Chi phí dự tính</h2>

                    <div class="space-y-4 max-h-[300px] overflow-y-auto pr-2 scrollbar-none">
                        <template x-for="(item, index) in items" :key="item.id">
                            <div class="flex items-start justify-between gap-4 text-sm font-medium">
                                <span class="text-secondary-gray leading-tight line-clamp-1 flex-1">
                                    
                                    @foreach($cartItems as $idx => $it)
                                        <span x-show="{{ $idx }} == index" class="font-bold text-near-black">{{ $it->product->name }}</span>
                                    @endforeach
                                    <span class="text-secondary-gray/40 ml-1 font-bold" x-text="'×' + item.quantity"></span>
                                </span>
                                <span class="text-near-black font-bold whitespace-nowrap"
                                    x-text="formatCurrency(item.quantity * item.price)">
                                </span>
                            </div>
                        </template>
                    </div>

                    <div class="border-t border-[#f2f2f2] pt-6 space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-bold text-secondary-gray">Tạm tính</span>
                            <span class="text-sm font-bold text-near-black" x-text="formatCurrency(subtotal)"></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-bold text-secondary-gray">Giao hàng</span>
                            <span class="text-sm font-bold text-emerald-600 uppercase">Miễn phí</span>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-6 flex justify-between items-center">
                        <span class="text-base font-bold text-near-black uppercase">Tổng tiền</span>
                        <span class="text-2xl font-bold text-primary" x-text="formatCurrency(subtotal)"></span>
                    </div>

                    <div class="p-4 bg-emerald-50 rounded-md border border-emerald-100 flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M5 13l4 4L19 7" />
                        </svg>
                        <p class="text-[11px] font-bold text-emerald-700 uppercase leading-none">Miễn phí lắp đặt tận nơi</p>
                    </div>

                    <a href="{{ route('order.checkout') }}"
                        class="btn-airbnb-brand w-full py-5 text-base font-bold shadow-lg shadow-primary/20 flex items-center justify-center gap-3">
                        <span>ĐẶT HÀNG NGAY</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </a>

                </div>
            </div>

        </div>
        @endif

    </div>
</div>
@endsection