@extends('layouts.app')

@section('title', ($product->name ?? 'Chi tiết sản phẩm'))

@section('content')
<div class=" min-h-screen pb-20" x-data="{
    selectedVariant: {{ $product->variants->isNotEmpty() ? $product->variants->first() : 'null' }},
    quantity: 1,
    activeTab: '{{ request()->has('rating') ? 'reviews' : 'desc' }}',
    mainImage: '{{ $product->primaryImage->image_path ?? ($product->images->first()->image_path ?? '') }}'
}">
    <div class="max-w-screen-xl mx-auto px-4 py-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <nav class="flex items-center gap-2 text-xs font-medium text-secondary-gray/70">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors whitespace-nowrap">Trang chủ</a>
                <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 5l7 7-7 7" />
                </svg>
                <a href="#" class="hover:text-primary transition-colors whitespace-nowrap">{{ $product->category->name ?? 'Sản phẩm' }}</a>
                <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-near-black font-semibold truncate">{{ $product->name }}</span>
            </nav>

            <div class="flex items-center gap-3">
                <div class="flex items-center text-amber-400">
                    @php $avgRating = round($product->reviews_avg_rating ?? 0, 1); @endphp
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-3.5 h-3.5 {{ $i <= $avgRating ? 'fill-current' : 'text-near-black/10' }}" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        @endfor
                        <span class="ml-2 text-xs font-black text-near-black">{{ $avgRating }}</span>
                </div>
                <div class="h-4 w-px bg-near-black/10"></div>
                <button @click="activeTab = 'reviews'; document.getElementById('tab-container').scrollIntoView({behavior: 'smooth'})" class="text-xs font-bold text-secondary-gray hover:text-primary transition-colors hover:underline cursor-pointer">{{ $product->reviews_count ?? 0 }} Đánh giá</button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-6">
                <div class="space-y-4">
                    <div class="aspect-square w-full bg-white border border-[#f2f2f2] rounded-md overflow-hidden flex items-center justify-center shadow-sm transition-all duration-300 relative">
                        <template x-if="mainImage">
                            <img :src="mainImage"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover">
                        </template>
                        <template x-if="!mainImage">
                            <div class="flex flex-col items-center gap-4 text-near-black/10">
                                <svg class="w-8 h-8 text-secondary-gray/20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </template>
                    </div>

                    @if($product->images->count() > 0)
                    <div class="grid grid-cols-5 gap-3 sm:gap-4">
                        @foreach($product->images as $image)
                        <button @click="mainImage = '{{ $image->image_path }}'"
                            :class="mainImage === '{{ $image->image_path }}' ? 'border-primary ring-1 ring-primary/20' : 'border-[#f2f2f2] hover:border-primary/20 opacity-70 hover:opacity-100'"
                            class="aspect-square bg-white border rounded-md overflow-hidden p-2 transition-all duration-300 flex items-center justify-center active:scale-95 cursor-pointer shadow-sm">
                            <img src="{{ $image->image_path }}" class="max-w-full max-h-full object-contain">
                        </button>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            
            <div class="lg:col-span-6 space-y-6">
                <div class="pb-4 border-b border-[#ebebeb]">
                    <div class="text-[10px] font-black text-primary uppercase mb-2">{{ $product->brand->name ?? 'Thương hiệu' }}</div>
                    <h1 class="text-2xl sm:text-3xl font-black text-near-black leading-tight">
                        {{ $product->name }}
                    </h1>
                </div>

                <div class="rounded-md overflow-hidden border border-[#ebebeb] bg-white shadow-sm">
                    <div class="flex items-center justify-between px-6 py-6 bg-primary ">
                        <div class="space-y-1">
                            <p class="text-[11px] font-black text-white/80 uppercase leading-none">Giá ưu đãi</p>
                            <span class="text-3xl font-black text-white"
                                x-text="selectedVariant
                                        ? new Intl.NumberFormat('vi-VN').format(selectedVariant.sale_price ?? selectedVariant.price) + 'đ'
                                        : 'Liên hệ'">
                            </span>
                        </div>
                        <template x-if="selectedVariant && selectedVariant.sale_price">
                            <div class="text-right">
                                <div class="text-base text-white/60 line-through font-bold"
                                    x-text="new Intl.NumberFormat('vi-VN').format(selectedVariant.price) + 'đ'">
                                </div>
                                <div class="inline-block bg-white text-primary text-[10px] font-black px-2 py-1 rounded-md mt-1"
                                    x-text="'-' + Math.round((selectedVariant.price - selectedVariant.sale_price) / selectedVariant.price * 100) + '% OFF'">
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="bg-white border border-[#ebebeb] rounded-md p-6 space-y-4 shadow-sm">
                    <p class="text-xs font-black text-near-black uppercase mb-2 flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-primary rounded-md"></span>
                        Đặc điểm nổi bật
                    </p>
                    <div class="space-y-3">
                        @php
                        $lines = array_filter(explode("\n", $product->description ?? ''));
                        @endphp
                        @forelse(array_slice($lines, 0, 5) as $line)
                        <div class="flex items-start gap-3 text-[13px] font-bold text-secondary-gray leading-snug">
                            <svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                <path d="M5 13l4 4L19 7" />
                            </svg>
                            <span>{{ trim($line) }}</span>
                        </div>
                        @empty
                        <p class="text-sm text-secondary-gray italic">Chưa có thông tin giới thiệu.</p>
                        @endforelse
                    </div>
                </div>

                @if($product->variants->count() > 0)
                <div class="border border-[#ebebeb] rounded-md overflow-hidden bg-white shadow-sm">
                    <div class="flex items-center gap-2 px-6 py-4 bg-[#f7f7f7] border-b border-[#ebebeb]">
                        <span class="text-xs font-black text-near-black uppercase">Cấu hình có sẵn</span>
                    </div>

                    <div class="divide-y divide-[#f2f2f2] px-6 py-2">
                        @foreach($product->variants->groupBy('group_name') as $groupName => $groupVariants)
                        <div class="py-4">
                            <span class="block text-[10px] font-black text-secondary-gray uppercase mb-3 italic">
                                {{ $groupName ?: 'Chọn phiên bản phù hợp' }}
                            </span>
                            <div class="flex items-center gap-3 flex-wrap">
                                @foreach($groupVariants as $variant)
                                <button type="button" @click="selectedVariant = {{ $variant }}"
                                    :class="selectedVariant && selectedVariant.id === {{ $variant->id }}
                                            ? 'border-primary bg-primary text-white shadow-md'
                                            : 'border-[#ebebeb] text-near-black hover:border-primary/50 hover:bg-[#f7f7f7]'"
                                    class="relative text-xs font-bold px-5 py-3 border-2 rounded-md transition-all active:scale-95 cursor-pointer">
                                    {{ $variant->variant_name }}
                                </button>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <form action="{{ route('cart.add') }}" method="POST" class="pt-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="variant_id" :value="selectedVariant ? selectedVariant.id : ''">
                    <input type="hidden" name="quantity" :value="quantity">

                    <div class="flex items-center gap-6 mb-8">
                        <span class="text-xs font-black text-near-black uppercase">Số lượng</span>
                        <div class="flex items-center justify-center bg-white p-1 rounded-md border border-[#ebebeb] shadow-sm">
                            <button type="button" @click="if(quantity > 1) quantity--"
                                class="w-10 h-10 flex items-center cursor-pointer justify-center rounded-md hover:bg-[#f7f7f7] text-near-black font-black transition-all active:scale-90">−</button>

                            <input type="number" x-model="quantity"
                                class="w-12 text-center bg-transparent border-none focus:ring-0 font-black text-near-black p-0 appearance-none"
                                readonly>

                            <button type="button" @click="quantity++"
                                class="w-10 h-10 flex items-center cursor-pointer justify-center rounded-md hover:bg-[#f7f7f7] text-near-black font-black transition-all active:scale-90">+</button>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <button type="submit" name="action" value="add_to_cart"
                            class="w-full cursor-pointer py-5 rounded-md text-sm font-black uppercase text-white bg-primary hover:bg-primary-hover transition-all duration-300 shadow-lg shadow-primary/20 flex items-center justify-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Thêm vào giỏ hàng
                        </button>
                    </div>
                </form>
            </div>
        </div>

        
        <div id="tab-container" class="mt-24">
            <div class="flex items-center gap-2 border-b border-[#ebebeb] mb-10 overflow-x-auto scrollbar-none whitespace-nowrap">
                <button @click="activeTab = 'desc'"
                    :class="activeTab === 'desc' ? 'text-primary border-b-[3px] border-primary pb-5' : 'text-secondary-gray/60 hover:text-near-black pb-5'"
                    class="px-8 text-xs font-black uppercase transition-all cursor-pointer">Mô tả sản phẩm</button>
                <button @click="activeTab = 'spec'"
                    :class="activeTab === 'spec' ? 'text-primary border-b-[3px] border-primary pb-5' : 'text-secondary-gray/60 hover:text-near-black pb-5'"
                    class="px-8 text-xs font-black uppercase transition-all cursor-pointer">Thông số kỹ thuật</button>
                <button @click="activeTab = 'reviews'"
                    :class="activeTab === 'reviews' ? 'text-primary border-b-[3px] border-primary pb-5' : 'text-secondary-gray/60 hover:text-near-black pb-5'"
                    class="px-8 text-xs font-black uppercase transition-all cursor-pointer">Đánh giá ({{ $product->reviews_count }})</button>
            </div>

            <div x-show="activeTab === 'desc'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                class="bg-white rounded-md p-8 sm:p-12 border border-[#ebebeb] shadow-sm">
                <div class="prose prose-zinc max-w-none text-secondary-gray text-[15px] leading-relaxed">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>

            <div x-show="activeTab === 'spec'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                class="bg-white rounded-md p-8 sm:p-12 border border-[#ebebeb] shadow-sm overflow-x-auto hover:border-[#ebebeb] transition-colors">
                <table class="w-full text-sm">
                    <tbody class="divide-y divide-[#f2f2f2]">
                        @foreach($product->variants as $variant)
                        <tr class="hover:bg-[#f7f7f7]/50 transition-colors group">
                            <td class="py-5 pr-6 font-bold text-near-black w-1/3">{{ $variant->variant_name }}</td>
                            <td class="py-5 text-secondary-gray font-bold text-[11px] font-mono group-hover:text-primary transition-colors">{{ $variant->sku }}</td>
                        </tr>
                        @endforeach
                        @if($product->variants->isEmpty())
                        <tr>
                            <td colspan="2" class="py-8 text-center text-secondary-gray italic">Chưa có thông số chi tiết cho sản phẩm này.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            
            <div x-show="activeTab === 'reviews'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="space-y-6">

                
                <div class="bg-[#fffbf8] border border-[#fbe7db] p-8 flex flex-col md:flex-row items-center gap-8">
                    
                    <div class="text-center md:w-40">
                        <div class="text-2xl font-bold text-primary">
                            <span class="text-3xl">{{ round($product->reviews_avg_rating ?? 0, 1) }}</span> trên 5
                        </div>
                        <div class="flex items-center justify-center text-primary mt-2">
                            @php $avg = round($product->reviews_avg_rating ?? 0); @endphp
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= $avg ? 'fill-current' : 'text-near-black/5' }}" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                @endfor
                        </div>
                    </div>

                    
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('product.detail', $product->slug) }}#tab-container"
                            class="px-5 py-2 text-sm border {{ !request()->has('rating') ? 'border-primary bg-white text-primary' : 'border-[#ebebeb] bg-white text-near-black hover:border-primary' }} min-w-[80px] text-center">
                            Tất cả
                        </a>
                        @for($i = 5; $i >= 1; $i--)
                        <a href="{{ route('product.detail', $product->slug) }}?rating={{ $i }}#tab-container"
                            class="px-5 py-2 text-sm border {{ request('rating') == $i ? 'border-primary bg-white text-primary' : 'border-[#ebebeb] bg-white text-near-black hover:border-primary' }} min-w-[80px] text-center">
                            {{ $i }} Sao ({{ $ratingDistribution[$i] ?? 0 }})
                        </a>
                        @endfor
                    </div>
                </div>

                
                <div class="divide-y divide-[#f2f2f2] bg-white border border-[#ebebeb]">
                    @forelse($reviews as $review)
                    <div class="p-6">
                        <div class="flex flex-col gap-2">
                            
                            <div class="flex flex-col gap-1">
                                <div class="text-xs font-bold text-near-black">
                                    {{ $review->user->name }}
                                </div>
                                <div class="flex items-center text-primary">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-2.5 h-2.5 {{ $i <= $review->rating ? 'fill-current' : 'text-near-black/5' }}" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                        @endfor
                                </div>
                            </div>

                            
                            <div class="text-[10px] text-secondary-gray/60 space-y-1">
                                <div>{{ $review->created_at->format('Y-m-d H:i') }} | Phân loại hàng: Chính hãng</div>
                                <div class="text-emerald-600 flex items-center gap-1 font-medium">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M5 13l4 4L19 7" />
                                    </svg>
                                    Người mua thực tế
                                </div>
                            </div>

                            
                            <div class="mt-3 text-sm text-near-black leading-relaxed whitespace-pre-line">{{ $review->comment }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="py-20 text-center text-secondary-gray/40">
                        <p class="text-sm">Chưa có đánh giá nào cho sản phẩm này</p>
                    </div>
                    @endforelse

                    @if($reviews->hasPages())
                    <div class="p-6 border-t border-[#f2f2f2]">
                        {{ $reviews->links() }}
                    </div>
                    @endif
                </div>

                
                @if($canReview)
                <div class="bg-white border border-[#ebebeb] p-8">
                    <h3 class="text-lg font-bold text-near-black mb-6">ĐÁNH GIÁ SẢN PHẨM</h3>
                    <form action="{{ route('reviews.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="flex items-center gap-4">
                            <span class="text-sm text-secondary-gray">Chất lượng sản phẩm:</span>
                            <div class="flex items-center gap-1" x-data="{ rating: 5, hover: 0 }">
                                <template x-for="i in 5">
                                    <button type="button" @click="rating = i" @mouseenter="hover = i" @mouseleave="hover = 0" class="focus:outline-none cursor-pointer">
                                        <svg class="w-6 h-6 transition-colors" :class="(hover || rating) >= i ? 'text-primary' : 'text-zinc-200'" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </button>
                                </template>
                                <input type="hidden" name="rating" :value="rating">
                            </div>
                        </div>

                        <div>
                            <textarea name="comment" rows="4" required
                                class="w-full border border-[#ebebeb] rounded-none p-4 text-sm focus:border-primary outline-none transition-all placeholder:text-zinc-300"
                                placeholder="Hãy chia sẻ nhận xét về sản phẩm này nhé!"></textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-10 py-3 bg-primary text-white text-sm font-medium hover:bg-primary/90 transition-all cursor-pointer">Gửi Đánh Giá</button>
                        </div>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>

<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

    .scrollbar-none::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-none {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
@endsection