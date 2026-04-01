@extends('layouts.app')

@section('title', ($product->name ?? 'Chi tiết sản phẩm'))

@section('content')
<div class="bg-white min-h-screen pb-20" x-data="{
    selectedVariant: {{ $product->variants->isNotEmpty() ? $product->variants->first() : 'null' }},
    quantity: 1,
    activeTab: 'desc',
    selectedUpgrades: {},
    toggleUpgrade(group, option) {
        if (this.selectedUpgrades[group] === option) {
            delete this.selectedUpgrades[group];
        } else {
            this.selectedUpgrades[group] = option;
        }
    },
    isSelectedUpgrade(group, option) {
        return this.selectedUpgrades[group] === option;
    }
}">
    <div class="max-w-screen-xl mx-auto px-4 py-6">
        <nav class="flex items-center gap-2 text-xs font-medium text-slate-400 mb-6">
            <a href="{{ route('home') }}" class="hover:text-[#0e4d3d] transition-colors whitespace-nowrap">Trang chủ</a>
            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 5l7 7-7 7" />
            </svg>
            <a href="#" class="hover:text-[#0e4d3d] transition-colors whitespace-nowrap">{{ $product->category->name ?? 'Sản phẩm' }}</a>
            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-slate-600 truncate">{{ $product->name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <div class="lg:col-span-6">
                <div class="sticky top-24 space-y-3">
                    <div class="aspect-square bg-white border border-slate-200 rounded-2xl overflow-hidden flex items-center justify-center">
                        @if($product->primaryImage)
                        <img src="{{ $product->primaryImage->image_path }}"
                            alt="{{ $product->name }}"
                            class="w-full h-full object-cover">
                        @else
                        <div class="flex flex-col items-center gap-4 text-slate-200">
                            <svg class="w-28 h-28" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        @endif
                    </div>

                    <div class="grid grid-cols-5 gap-2">
                        @for($i = 1; $i <= 5; $i++)
                            <div class="aspect-square bg-white border border-slate-200 rounded-xl hover:border-[#0e4d3d] cursor-pointer transition-all">
                    </div>
                    @endfor
                </div>
            </div>
        </div>

        <div class="lg:col-span-6 space-y-4">

            <h1 class="text-xl sm:text-2xl font-bold text-slate-800 leading-snug">
                {{ $product->name }}
            </h1>

            <div class="rounded-md overflow-hidden border border-slate-200">
                <div class="flex items-center justify-between px-5 py-4 bg-[#fff3f0]">
                    <span class="text-3xl font-black text-red-500 tracking-tight"
                        x-text="selectedVariant
                                  ? new Intl.NumberFormat('vi-VN').format(selectedVariant.sale_price ?? selectedVariant.price) + 'đ'
                                  : 'Liên hệ'">
                    </span>
                    <template x-if="selectedVariant && selectedVariant.sale_price">
                        <div class="text-right">
                            <div class="text-base text-slate-400 line-through font-medium"
                                x-text="new Intl.NumberFormat('vi-VN').format(selectedVariant.price) + 'đ'">
                            </div>
                            <div class="text-xs font-bold text-slate-500 mt-0.5"
                                x-text="'Tiết kiệm: ' + new Intl.NumberFormat('vi-VN').format(selectedVariant.price - selectedVariant.sale_price) + 'Đ'">
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- <div class="flex items-center gap-3 flex-wrap">
                <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-700 bg-amber-50 border border-amber-200 px-3 py-1.5 rounded-lg">
                    <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Bảo hành: 36 Tháng
                </span>
                <button type="button" class="inline-flex items-center gap-1.5 text-xs font-bold text-white bg-[#0e4d3d] px-4 py-1.5 rounded-lg hover:bg-[#0a3d31] transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                    </svg>
                    TƯ VẤN NÂNG CẤP
                </button>
            </div> -->

            <div class="bg-white border border-slate-200 rounded-md p-4 space-y-2">
                <p class="text-sm font-bold text-slate-700 mb-3">Mô tả sản phẩm</p>
                @php
                $lines = array_filter(explode("\n", $product->description ?? ''));
                @endphp
                @forelse($lines as $line)
                <div class="flex items-start gap-2 text-sm text-slate-600">
                    <svg class="w-4 h-4 text-[#0e4d3d] shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>{{ trim($line) }}</span>
                </div>
                @empty
                <p class="text-sm text-slate-500">{{ $product->description }}</p>
                @endforelse
            </div>

            @if($product->variants->count() > 0)
            <div class="border border-slate-200 rounded-md overflow-hidden">
                <div class="flex items-center gap-2 px-4 py-3 bg-slate-50 border-b border-slate-200">
                    <svg class="w-4 h-4 text-[#0e4d3d]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="text-sm font-black text-slate-800 uppercase tracking-wide">UPGRADE</span>
                </div>

                <div class="divide-y divide-slate-100">
                    @foreach($product->variants->groupBy('group_name') as $groupName => $groupVariants)
                    <div class="flex items-center gap-4 px-4 py-3">
                        <span class="text-sm font-bold text-slate-700 w-28 shrink-0">
                            {{ $groupName ?: 'Cấu hình' }}
                        </span>
                        <div class="flex items-center gap-2 flex-wrap">
                            @foreach($groupVariants as $variant)
                            <button
                                type="button"
                                @click="selectedVariant = {{ $variant }}"
                                :class="selectedVariant && selectedVariant.id === {{ $variant->id }}
                                        ? 'border-red-400 bg-red-50 text-red-600 after:content-[\'\'] relative'
                                        : 'border-slate-300 text-slate-700 hover:border-slate-400'"
                                class="relative text-xs font-semibold px-3 py-1.5 border rounded-lg transition-all">
                                {{ $variant->variant_name }}
                                <span x-show="selectedVariant && selectedVariant.id === {{ $variant->id }}"
                                    class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-red-500 rounded-full flex items-center justify-center">
                                    <svg class="w-2 h-2 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="border border-slate-200 rounded-md overflow-hidden">
                <div class="flex items-center gap-2 px-4 py-3 bg-slate-50 border-b border-slate-200">
                    <svg class="w-4 h-4 text-[#0e4d3d]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                    </svg>
                    <span class="text-sm font-black text-slate-800 uppercase tracking-wide">KHUYẾN MÃI</span>
                </div>
                <div class="px-4 py-3 space-y-2">
                    @isset($product->promotions)
                    @forelse($product->promotions as $promo)
                    <div class="flex items-start gap-2 text-sm">
                        <svg class="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 2a2 2 0 00-2 2v14l3.5-2 3.5 2 3.5-2 3.5 2V4a2 2 0 00-2-2H5zm4.707 3.707a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L8.414 10l1.293-1.293zM11 6.586l1.293-1.293a1 1 0 111.414 1.414L12.414 10l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-slate-600">{{ $promo->description }}</span>
                    </div>
                    @empty
                    <p class="text-xs text-slate-400 italic">Hiện chưa có khuyến mãi đặc biệt.</p>
                    @endforelse
                    @else
                    <p class="text-xs text-slate-400 italic">Hiện chưa có khuyến mãi đặc biệt.</p>

                    @endisset
                </div>
            </div>

            <form action="{{ route('order.buyNow') }}" method="POST">
                @csrf
                <input type="hidden" name="variant_id" :value="selectedVariant ? selectedVariant.id : ''">
                <input type="hidden" name="quantity" :value="quantity">

                <div class="flex items-center gap-4 mb-4">
                    <span class="text-sm font-bold text-slate-700">Số lượng:</span>
                    <div class="flex items-center border border-slate-300 rounded-lg overflow-hidden">
                        <button type="button" @click="if(quantity > 1) quantity--"
                            class="w-9 h-9 flex items-center justify-center text-slate-600 hover:bg-slate-100 transition text-lg font-bold border-r border-slate-300">
                            −
                        </button>
                        <span class="w-12 text-center text-sm font-bold text-slate-800" x-text="quantity"></span>
                        <button type="button" @click="quantity++"
                            class="w-9 h-9 flex items-center justify-center text-slate-600 hover:bg-slate-100 transition text-lg font-bold border-l border-slate-300">
                            +
                        </button>
                    </div>
                </div>

                <div class="space-y-3">
                    <button type="submit" name="action" value="buy_now"
                        class="w-full py-4 rounded-md text-base font-bold uppercase  text-white bg-[#0e4d3d] cursor-pointer rounded-xl hover:bg-[#0a3d31] transition shadow-lg shadow-green-900/15 flex flex-col items-center justify-center">
                        <span>ĐẶT MUA NGAY</span>
                    </button>

                    <div class="grid grid-cols-2 gap-3">
                        <button type="submit" name="action" value="add_to_cart"
                            class="py-3 cursor-pointer border-1 border-[#0e4d3d] text-[#0e4d3d] rounded-md font-bold text-xs uppercase  hover:bg-green-50 transition flex items-center justify-center gap-2">
                            THÊM VÀO GIỎ
                        </button>
                        <button type="button"
                            class="py-3 border-1 cursor-pointer bg-[#1877f2]  text-white rounded-md font-bold text-xs uppercase  hover:bg-[#0251b7] transition flex items-center justify-center gap-2">
                            TRẢ GÓP QUA HỒ SƠ
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <div class="mt-14">
        <div class="flex items-center gap-0 border-b-2 border-slate-100 mb-6 overflow-x-auto scrollbar-none">
            <button @click="activeTab = 'desc'"
                :class="activeTab === 'desc' ? 'text-[#0e4d3d] border-b-2 border-[#0e4d3d] -mb-0.5 bg-white' : 'text-slate-400 hover:text-slate-600'"
                class="px-6 py-3 text-xs font-black uppercase  transition-all whitespace-nowrap">
                Mô tả sản phẩm
            </button>
            <button @click="activeTab = 'spec'"
                :class="activeTab === 'spec' ? 'text-[#0e4d3d] border-b-2 border-[#0e4d3d] -mb-0.5 bg-white' : 'text-slate-400 hover:text-slate-600'"
                class="px-6 py-3 text-xs font-black uppercase  transition-all whitespace-nowrap">
                Thông số kỹ thuật
            </button>
        </div>

        <div x-show="activeTab === 'desc'"
            class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-100 shadow-sm text-slate-600 leading-relaxed">
            <div class="prose prose-slate max-w-none text-sm">
                {!! nl2br(e($product->description)) !!}
            </div>
        </div>

        <div x-show="activeTab === 'spec'"
            class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-100 shadow-sm overflow-x-auto">
            <table class="w-full text-sm">
                <tbody class="divide-y divide-slate-100">
                    @foreach($product->variants as $variant)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 font-bold text-slate-800 w-1/3">{{ $variant->variant_name }}</td>
                        <td class="py-3 text-slate-500">{{ $variant->sku }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
</div>
@endsection