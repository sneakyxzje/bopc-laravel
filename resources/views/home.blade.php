@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
<div class="max-w-[1780px] mx-auto px-4 sm:px-6 lg:px-10 py-12 space-y-24">
    
    <div class="w-full flex flex-col gap-4">
        
        @if(isset($sliders) && $sliders->count() > 0)
        <div class="relative w-full h-[200px] sm:h-[300px] md:h-[450px] lg:h-[550px] rounded-md overflow-hidden bg-[#f7f7f7] group shadow-sm" x-data="{ currentSlide: 0, slides: {{ $sliders->count() }} }" x-init="setInterval(() => { currentSlide = currentSlide === slides - 1 ? 0 : currentSlide + 1 }, 5000)">
            <div class="flex h-full transition-transform duration-500 ease-out" :style="'transform: translateX(-' + (currentSlide * 100) + '%)'">
                @foreach($sliders as $slider)
                <div class="w-full h-full shrink-0 relative">
                    <a href="{{ $slider->link ?? '#' }}" class="block w-full h-full">
                        <img src="{{ $slider->image_path }}" class="w-full h-full object-cover sm:object-fill" alt="Banner">
                    </a>
                </div>
                @endforeach
            </div>

            @if($sliders->count() > 1)
            
            <button @click="currentSlide = currentSlide === 0 ? slides - 1 : currentSlide - 1" class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/50 hover:bg-white text-near-black rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all z-10 backdrop-blur-sm shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button @click="currentSlide = currentSlide === slides - 1 ? 0 : currentSlide + 1" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/50 hover:bg-white text-near-black rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all z-10 backdrop-blur-sm shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center gap-2 z-10">
                @foreach($sliders as $index => $slider)
                <button @click="currentSlide = {{ $index }}" :class="currentSlide === {{ $index }} ? 'bg-primary w-6' : 'bg-white/60 hover:bg-white w-2'" class="h-2 rounded-full transition-all duration-300"></button>
                @endforeach
            </div>
            @endif
        </div>
        @else
        
        <div class="relative w-full h-[350px] md:h-[550px] rounded-md overflow-hidden card-airbnb border border-[#f2f2f2] bg-[#f7f7f7] group">
            <div class="absolute inset-0 bg-gradient-to-br from-near-black via-zinc-900 to-primary/20 flex flex-col items-center justify-center text-center px-6">
                <div class="space-y-6">
                    <h1 class="text-4xl md:text-7xl font-black text-white uppercase leading-none">
                        High Performance <span class="text-primary italic">Custom PC</span>
                    </h1>
                </div>
            </div>
        </div>
        @endif

        
        @if(isset($statics) && $statics->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-4 mt-2">
            @foreach($statics as $static)
            <div class="rounded-md overflow-hidden shadow-sm hover:shadow-md transition-shadow relative ">
                <a href="{{ $static->link ?? '#' }}" class="block w-full h-full">
                    <img src="{{ $static->image_path }}" class="w-full h-full object-cover md:object-fill" alt="Sub Banner">
                </a>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    @php
    $sections = [
    ['category_slug' => 'ban-chay', 'title' => 'Sản phẩm bán chạy', 'subtitle' => 'Những dòng sản phẩm được tin dùng nhất', 'data' => $bestSellers],
    ['category_slug' => 'moi-ve', 'title' => 'Sản phẩm mới về', 'subtitle' => 'Cập nhật công nghệ mới nhất trong tháng', 'data' => $newArrivals],
    ['category_slug' => 'pc-gaming', 'title' => 'PC Gaming bán chạy', 'subtitle' => 'Chiến game đỉnh cao với cấu hình tối ưu', 'data' => $pcGaming],
    ['category_slug' => 'laptop-gaming', 'title' => 'Laptop Gaming bán chạy', 'subtitle' => 'Sức mạnh di động hoàn hảo', 'data' => $laptopGaming],
    ['category_slug' => 'monitors', 'title' => 'Màn hình bán chạy', 'subtitle' => 'Trải nghiệm thị giác sống động', 'data' => $monitors],
    ['category_slug' => 'pc-mini', 'title' => 'Sản phẩm PC Mini', 'subtitle' => 'Nhỏ gọn nhưng cực kỳ mạnh mẽ', 'data' => $pcMini],
    ['category_slug' => 'parts', 'title' => 'Linh kiện máy tính', 'subtitle' => 'Nâng cấp sức mạnh cho dàn máy của bạn', 'data' => $parts],
    ];
    @endphp

    @foreach($sections as $section)
    @if($section['data']->isNotEmpty())
    <section>
        
        <div class="flex flex-wrap sm:flex-nowrap items-center justify-between border-b-2 border-primary mb-6 pb-0">
            <div class="flex flex-wrap sm:flex-nowrap items-end gap-2 sm:gap-6 w-full sm:w-auto">
                <div class="bg-primary text-white px-5 sm:px-8 py-2 font-black uppercase text-sm md:text-base relative overflow-visible shadow-sm">
                    <span class="relative z-10">{{ $section['title'] }}</span>
                    
                    <div class="absolute top-0 -right-3 bottom-0 w-6 bg-primary -skew-x-[20deg] z-0 shadow-sm border-r border-t border-primary"></div>
                    
                    <div class="absolute top-0 -right-6 bottom-0 w-6 bg-near-black -skew-x-[20deg] -z-10 shadow-sm"></div>
                </div>

                
                <div class="hidden lg:flex items-center gap-1.5 pb-1.5 pl-6">
                    <a href="#" class="px-3 py-1 bg-[#f7f7f7] border border-[#f2f2f2] hover:border-[#ebebeb] text-secondary-gray hover:text-near-black transition-colors text-[10px] font-bold uppercase">Giảm sốc</a>
                    <a href="#" class="px-3 py-1 bg-[#f7f7f7] border border-[#f2f2f2] hover:border-[#ebebeb] text-secondary-gray hover:text-near-black transition-colors text-[10px] font-bold uppercase">Khuyến mãi Mới</a>
                </div>
            </div>
            <a href="{{ route('category.show', $section['category_slug']) }}" class="text-xs font-black text-secondary-gray hover:text-primary transition-colors pb-2 whitespace-nowrap mt-2 sm:mt-0 flex items-center gap-1 group">
                Xem tất cả
                <svg class="w-3 h-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        
        <div class="relative"
            x-data="{ 
                scrollNext() { $refs.slider{{ $loop->index }}.scrollBy({ left: 300, behavior: 'smooth' }) }, 
                scrollPrev() { $refs.slider{{ $loop->index }}.scrollBy({ left: -300, behavior: 'smooth' }) }
             }"
            x-init="
                let interval = setInterval(() => {
                    const slider = $refs.slider{{ $loop->index }};
                    if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 10) {
                        slider.scrollTo({ left: 0, behavior: 'smooth' });
                    } else {
                        slider.scrollBy({ left: 300, behavior: 'smooth' });
                    }
                }, 4000);
                $el.addEventListener('mouseenter', () => clearInterval(interval));
                $el.addEventListener('mouseleave', () => {
                    interval = setInterval(() => {
                        const slider = $refs.slider{{ $loop->index }};
                        if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 10) {
                            slider.scrollTo({ left: 0, behavior: 'smooth' });
                        } else {
                            slider.scrollBy({ left: 300, behavior: 'smooth' });
                        }
                    }, 4000);
                });
             ">

            
            <button @click="scrollPrev" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-3 2xl:-translate-x-5 w-10 h-10 bg-white/90 border border-[#ebebeb] text-near-black hover:text-primary hover:border-primary rounded-full flex items-center justify-center transition-all z-20 shadow-xl hidden md:flex active:scale-95">
                <svg class="w-5 h-5 ml-0.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            
            <button @click="scrollNext" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-3 2xl:translate-x-5 w-10 h-10 bg-white/90 border border-[#ebebeb] text-near-black hover:text-primary hover:border-primary rounded-full flex items-center justify-center transition-all z-20 shadow-xl hidden md:flex active:scale-95">
                <svg class="w-5 h-5 mr-0.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            
            <div x-ref="slider{{ $loop->index }}" class="flex overflow-x-auto snap-x snap-mandatory gap-4 pb-4 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                @foreach($section['data'] as $product)
                
                <div class="snap-start shrink-0 w-[180px] sm:w-[200px] md:w-[220px] xl:w-[280px]">
                    <a href="{{ route('product.detail', $product->slug) }}" class="group bg-white border border-[#f2f2f2] hover:border-[#ebebeb] hover:shadow-lg p-3 sm:p-4 transition-all duration-300 flex flex-col h-full no-underline text-inherit relative rounded-none">

                        
                        
                        <div class="relative aspect-square mb-4 bg-white overflow-hidden flex items-center justify-center">
                            @if($product->primaryImage)
                            <img src="{{ $product->primaryImage->image_path }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                            <div class="flex flex-col items-center gap-2 text-secondary-gray/20">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                                    <path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            @endif
                        </div>

                        <div class="px-0.5 pb-1 flex-1 flex flex-col justify-between">
                            
                            <h3 class="text-[12px] xl:text-[13px] font-bold text-near-black line-clamp-2 min-h-[2.4rem] xl:min-h-[2.6rem] leading-tight mb-3 group-hover:text-primary transition-colors">
                                {{ $product->name }}
                            </h3>

                            
                            <div class="mb-5 relative">
                                
                                @if($product->final_min_price < $product->variants_min_price && $product->variants_min_price > 0)
                                    @php
                                    $discountPct = round((($product->variants_min_price - $product->final_min_price) / $product->variants_min_price) * 100);
                                    @endphp
                                    <span class="absolute right-0 top-0 bg-red-600 text-white text-[10px] font-black px-1.5 py-0.5 rounded-sm">
                                        -{{ $discountPct }}%
                                    </span>
                                    @endif

                                    <div class="flex items-end gap-2">
                                        <span class="text-sm xl:text-base font-black text-red-600">{{ number_format($product->final_min_price) }}₫</span>
                                    </div>
                                    @if($product->final_min_price < $product->variants_min_price)
                                        <span class="line-through text-[11px] font-bold text-secondary-gray/60 block mt-0.5">{{ number_format($product->variants_min_price) }}₫</span>
                                        @else
                                        <span class="block mt-0.5 h-[16px]"></span> 
                                        @endif
                            </div>

                            
                            <div class="flex items-center justify-between border-t border-[#f2f2f2] pt-3">
                                <span class="flex items-center gap-1.5 text-[10px] sm:text-[11px] font-black text-near-black/70 hover:text-primary transition-colors group/cart"><svg class="w-4 h-4 text-blue-800 group-hover/cart:text-primary" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M7 18c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2m10 0c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2m-1.45-5c.78 0 1.45-.58 1.63-1.3l2.8-10.4A1.002 1.002 0 0019.02 0H5.21L4.27-2H0v2h2.24l2.87 11.45c-.5.85-.35 1.95.42 2.55C6.01 14.39 6.78 15 7.66 15h11.19a.998.998 0 100-2H7.66c-.19 0-.36-.08-.47-.21a.503.503 0 01-.06-.52z" />
                                    </svg> THÊM VÀO GIỎ</span>
                                <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[9px] font-bold rounded-sm">Còn hàng</span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    @endforeach

</div>
@endsection