@extends('layouts.app')

@section('title', $category->name . ' - Danh sách sản phẩm')

@section('content')
<div class="max-w-[1780px] mx-auto px-4 sm:px-6 lg:px-10 py-8 lg:py-12">
    
    <nav class="flex text-sm mb-6 pb-4 border-b border-slate-100" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="inline-flex items-center text-secondary-gray/80 hover:text-primary transition-colors font-bold uppercase text-[11px]">
                    Trang chủ
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-secondary-gray/40 mx-1" aria-hidden="true" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg>
                    <span class="text-near-black font-black uppercase text-[11px] ml-1 md:ml-2">{{ $category->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="flex flex-col lg:flex-row gap-8 items-start" x-data="filterSystem()">
        
        
        <aside class="w-full lg:w-[240px] xl:w-[280px] shrink-0 space-y-6">
            <form id="filterForm" action="{{ url()->current() }}" method="GET" x-ref="form">
                <input type="hidden" name="sort" :value="sortSelected">

                
                <div class="border border-slate-200 bg-white">
                    <h3 class="bg-near-black text-white text-[12px] font-black uppercase px-4 py-3 border-b border-slate-200">
                        Lọc Sản Phẩm
                    </h3>
                    
                    <div class="p-4 space-y-2">
                        <a href="{{ route('category.show', $category->slug) }}" class="block text-sm font-black {{ request()->route('slug') == $category->slug ? 'text-primary' : 'text-near-black' }} uppercase pb-2 border-b border-slate-100">
                            {{ $category->name }}
                        </a>
                        
                        @if($categoriesList->count() > 0)
                        <ul class="space-y-2 pt-2">
                            @foreach($categoriesList as $cat)
                                @if($cat->id !== $category->id && $cat->slug !== 'ban-chay' && $cat->slug !== 'moi-ve')
                                <li>
                                    <a href="{{ route('category.show', $cat->slug) }}" class="flex items-center text-[12px] font-bold text-secondary-gray hover:text-primary transition-colors uppercase">
                                        <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>
                                        {{ $cat->name }}
                                        <span class="ml-auto text-secondary-gray/50">({{ $cat->products_count }})</span>
                                    </a>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>

                
                <div class="mt-6">
                    <h4 class="text-sm font-black text-near-black uppercase mb-4 pl-1">Khoảng Giá</h4>
                    <ul class="space-y-3 px-1">
                        @php
                            $selectedPrices = explode(',', request('price', ''));
                            $priceRanges = [
                                '0-10' => 'Dưới 10 triệu',
                                '10-15' => '10 triệu - 15 triệu',
                                '15-20' => '15 triệu - 20 triệu',
                                '20-25' => '20 triệu - 25 triệu',
                                '25-35' => '25 triệu - 35 triệu',
                                '35-45' => '35 triệu - 45 triệu',
                                '45-60' => '45 triệu - 60 triệu',
                                '60-80' => '60 triệu - 80 triệu',
                                '80-100' => '80 triệu - 100 triệu',
                                '100-max' => 'Trên 100 triệu'
                            ];
                        @endphp

                        @foreach($priceRanges as $val => $label)
                        <li>
                            <label class="flex items-center cursor-pointer group relative">
                                <input type="checkbox" 
                                       value="{{ $val }}" 
                                       @change="updatePrices"
                                       {{ in_array($val, $selectedPrices) ? 'checked' : '' }}
                                       class="price-checkbox peer sr-only">
                                
                                <div class="w-4 h-4 border-2 border-near-black/10 bg-white rounded-sm peer-checked:bg-primary peer-checked:border-primary peer-focus:ring-2 peer-focus:ring-primary/30 flex items-center justify-center transition-colors">
                                    <svg class="w-2.5 h-2.5 text-white scale-0 peer-checked:scale-100 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>

                                <span class="ml-3 text-[12px] font-bold text-black group-hover:text-primary peer-checked:text-primary transition-colors uppercase">{{ $label }}</span>
                            </label>
                        </li>
                        @endforeach
                        <input type="hidden" name="price" x-ref="priceInput" value="{{ request('price') }}">
                    </ul>
                </div>

                
                @if($allBrands->count() > 0)
                <div class="mt-8 pt-6 border-t border-slate-200">
                    <h4 class="text-sm font-black text-near-black uppercase mb-4 pl-1">Thương Hiệu</h4>
                    <ul class="space-y-3 px-1">
                        @php
                            $selectedBrands = explode(',', request('brands', ''));
                        @endphp
                        @foreach($allBrands as $brand)
                        <li>
                            <label class="flex items-center cursor-pointer group relative">
                                <input type="checkbox" 
                                       value="{{ $brand->id }}"
                                       @change="updateBrands"
                                       {{ in_array($brand->id, $selectedBrands) ? 'checked' : '' }}
                                       class="brand-checkbox peer sr-only">

                                <div class="w-4 h-4 border-2 border-slate-300 bg-white rounded-sm peer-checked:bg-primary peer-checked:border-primary peer-focus:ring-2 peer-focus:ring-primary/30 flex items-center justify-center transition-colors">
                                    <svg class="w-2.5 h-2.5 text-white scale-0 peer-checked:scale-100 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>

                                <span class="ml-3 text-[12px] font-bold text-black group-hover:text-primary peer-checked:text-primary transition-colors uppercase">{{ $brand->name }}</span>
                            </label>
                        </li>
                        @endforeach
                        <input type="hidden" name="brands" x-ref="brandInput" value="{{ request('brands') }}">
                    </ul>
                </div>
                @endif
                
            </form>
        </aside>

        
        <main class="flex-1">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 pb-4 border-b border-slate-100 gap-4">
                <div class="text-sm font-bold text-near-black uppercase">
                    Tìm thấy <span class="text-primary font-black">{{ $products->total() }}</span> sản phẩm
                </div>

                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-secondary-gray uppercase">Sắp xếp theo</span>
                    <select x-model="sortSelected" @change="submitForm" class="bg-white border border-slate-200 text-near-black text-xs font-bold rounded focus:ring-primary focus:border-primary block p-2 cursor-pointer shadow-sm">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Tên A-Z</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Tên Z-A</option>
                    </select>
                </div>
            </div>

            @if($products->count() > 0)
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 md:gap-4 xl:gap-5">
                @foreach($products as $product)
                @php $firstVariant = $product->variants->first() ?? null; @endphp
                <div class="w-full" x-data="{ loading: false, done: false }">
                    <a href="{{ route('product.detail', $product->slug) }}" class="group bg-white border border-[#f2f2f2] hover:border-[#ebebeb] hover:shadow-xl p-3 sm:p-4 transition-all duration-300 flex flex-col h-full no-underline text-inherit relative rounded-none hover:-translate-y-1">
                        
                        
                        <div class="relative aspect-square mb-4 bg-white overflow-hidden flex items-center justify-center p-2">
                            @if($product->primaryImage)
                                <img src="{{ $product->primaryImage->image_path }}" alt="{{ $product->name }}" class="max-w-full max-h-full object-contain transition-transform duration-700 group-hover:scale-105">
                            @else
                                <div class="flex flex-col items-center gap-2 text-secondary-gray/30">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                </div>
                            @endif
                        </div>

                        <div class="px-0.5 pb-1 flex-1 flex flex-col justify-between">
                            
                            <h3 class="text-[12px] xl:text-[13px] font-bold text-near-black line-clamp-2 min-h-[2.4rem] xl:min-h-[2.6rem] leading-tight mb-3 group-hover:text-primary transition-colors">
                                {{ $product->name }}
                            </h3>

                            
                            <div class="mb-5 relative">
                                @if($product->final_min_price < $product->variants_min_price && $product->variants_min_price > 0)
                                    @php $discountPct = round((($product->variants_min_price - $product->final_min_price) / $product->variants_min_price) * 100); @endphp
                                    <span class="absolute right-0 top-0 bg-red-600 text-white text-[10px] font-black px-1.5 py-0.5 rounded-sm">-{{ $discountPct }}%</span>
                                @endif
                                <div class="flex items-end gap-2">
                                    <span class="text-sm xl:text-base font-black text-red-600">{{ number_format($product->final_min_price) }}₫</span>
                                </div>
                                @if($product->final_min_price < $product->variants_min_price)
                                    <span class="line-through text-[11px] font-bold text-secondary-gray/50 block mt-0.5">{{ number_format($product->variants_min_price) }}₫</span>
                                @else
                                    <span class="block mt-0.5 h-[16px]"></span>
                                @endif
                            </div>

                            
                            <div class="flex items-center justify-between border-t border-[#f2f2f2] pt-3">
                                @if($firstVariant)
                                <button
                                    type="button"
                                    @click.prevent.stop="
                                        if (loading || done) return;
                                        loading = true;
                                        fetch('{{ route('cart.add') }}', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Accept': 'application/json'
                                            },
                                            body: JSON.stringify({
                                                product_id: {{ $product->id }},
                                                variant_id: {{ $firstVariant->id }},
                                                quantity: 1
                                            })
                                        })
                                        .then(r => r.json())
                                        .then(data => {
                                            loading = false;
                                            if (data.success) {
                                                done = true;
                                                window.showCartToast && window.showCartToast('{{ addslashes($product->name) }}');
                                                setTimeout(() => done = false, 2500);
                                            }
                                        })
                                        .catch(() => { loading = false; })
                                    "
                                    class="flex items-center gap-1.5 text-[10px] sm:text-[11px] font-black transition-colors"
                                    :class="done ? 'text-emerald-600' : 'text-near-black/70 hover:text-primary'"
                                >
                                    <template x-if="loading">
                                        <svg class="w-4 h-4 animate-spin text-secondary-gray/50" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg>
                                    </template>
                                    <template x-if="done && !loading">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    </template>
                                    <template x-if="!loading && !done">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M7 18c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2m10 0c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2m-1.45-5c.78 0 1.45-.58 1.63-1.3l2.8-10.4A1.002 1.002 0 0019.02 0H5.21L4.27-2H0v2h2.24l2.87 11.45c-.5.85-.35 1.95.42 2.55C6.01 14.39 6.78 15 7.66 15h11.19a.998.998 0 100-2H7.66c-.19 0-.36-.08-.47-.21a.503.503 0 01-.06-.52z"/></svg>
                                    </template>
                                    <span x-text="done ? 'Đã thêm!' : 'THÊM VÀO GIỎ'"></span>
                                </button>
                                @else
                                <span class="text-[10px] sm:text-[11px] font-black text-secondary-gray/50">Chọn phiên bản</span>
                                @endif
                                <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[9px] font-bold rounded-sm">Còn hàng</span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            
            <div class="mt-12 flex justify-center">
                {{ $products->links() }}
            </div>
            @else
            
            <div class="text-center py-24 bg-white border border-slate-100 rounded-lg">
                <svg class="w-16 h-16 text-secondary-gray/20 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <h3 class="text-lg font-black text-near-black mb-2">Không tìm thấy sản phẩm</h3>
                <p class="text-sm font-bold text-secondary-gray/80">Rất tiếc bộ lọc của bạn không khớp với sản phẩm nào. Vui lòng thử lại với tiêu chí khác.</p>
                <a href="{{ url()->current() }}" class="mt-6 inline-block bg-primary text-white text-xs font-black uppercase px-6 py-3 rounded hover:bg-primary-hover transition-colors">
                    Xoá bộ lọc
                </a>
            </div>
            @endif
        </main>
    </div>
</div>


<div id="cart-toast-container" class="fixed bottom-6 right-6 z-[9999] flex flex-col gap-3 pointer-events-none"></div>

<script>
    window.showCartToast = function(productName) {
        const container = document.getElementById('cart-toast-container');
        const toast = document.createElement('div');
        toast.className = 'pointer-events-auto flex items-center gap-3 bg-near-black text-white px-5 py-4 shadow-2xl text-sm font-bold max-w-[300px] opacity-0 translate-y-3 transition-all duration-300';
        toast.innerHTML = `
            <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            <div class="flex-1 min-w-0">
                <p class="text-[10px] text-secondary-gray font-bold uppercase mb-0.5">Đã thêm vào giỏ hàng</p>
                <p class="truncate text-[12px] font-black">${productName}</p>
            </div>
            <a href="{{ route('cart.index') }}" class="ml-2 shrink-0 text-[11px] font-black text-primary hover:underline uppercase">Xem →</a>
        `;
        container.appendChild(toast);
        requestAnimationFrame(() => requestAnimationFrame(() => {
            toast.classList.remove('opacity-0', 'translate-y-3');
        }));
        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-y-3');
            setTimeout(() => toast.remove(), 320);
        }, 3500);
    };

    document.addEventListener('alpine:init', () => {
        Alpine.data('filterSystem', () => ({
            sortSelected: '{{ request('sort', 'newest') }}',
            updatePrices() {
                const values = Array.from(document.querySelectorAll('.price-checkbox:checked')).map(cb => cb.value);
                this.$refs.priceInput.value = values.join(',');
                this.submitForm();
            },
            updateBrands() {
                const values = Array.from(document.querySelectorAll('.brand-checkbox:checked')).map(cb => cb.value);
                this.$refs.brandInput.value = values.join(',');
                this.submitForm();
            },
            submitForm() {
                if (!this.$refs.priceInput.value) this.$refs.priceInput.disabled = true;
                if (!this.$refs.brandInput.value) this.$refs.brandInput.disabled = true;
                this.$refs.form.submit();
            }
        }))
    })
</script>
@endsection
