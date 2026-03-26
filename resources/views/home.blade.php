@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
<div class="max-w-screen-xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tight">SẢN PHẨM MỚI</h2>
            <div class="h-1 w-20 bg-[#0e4d3d] mt-1 rounded-full"></div>
        </div>
        <a href="#" class="text-xs font-bold text-[#0e4d3d] uppercase tracking-widest hover:underline transition-all">Xem tất cả</a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($products as $product)
        <a href="{{ route('product.detail', $product->slug) }}" class="group relative bg-white border border-slate-100 rounded-md p-3 hover:shadow-2xl hover:shadow-slate-200/60 transition-all duration-300  block no-underline text-inherit">
            <div class="relative aspect-square mb-4 bg-slate-50/50 rounded-2xl overflow-hidden flex items-center justify-center group-hover:bg-[#e8f5e9]/30 transition-colors">
                @if($product->primaryImage)
                <img src="{{ $product->primaryImage->image_path }}" alt="{{ $product->name }}" class="w-full h-full object-contain mix-blend-multiply transition-transform duration-500 group-hover:scale-110">
                @else
                <div class="flex flex-col items-center gap-3 text-slate-300 group-hover:text-[#0e4d3d]/30 transition-colors">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                @endif
            </div>
            <div class="px-1 pb-2">
                <div class="text-[10px] font-bold text-[#0e4d3d] uppercase mb-1 opacity-70">
                    {{ $product->category->name ?? 'Linh kiện' }}
                </div>
                <h3 class="text-sm font-bold text-slate-800 line-clamp-2 min-h-[2.5rem] leading-tight mb-2 group-hover:text-[#0e4d3d] transition-colors">
                    {{ $product->name }}
                </h3>

                <div class="flex flex-col mb-4">
                    @if($product->final_min_price < $product->variants_min_price)
                        <div class="flex items-center gap-1.5 grayscale opacity-40 text-[15px] mb-0.5">
                            <span class="line-through">{{ number_format($product->variants_min_price) }}đ</span>
                        </div>
                        @endif

                        <div class="flex items-center gap-1">

                            <span class="text-lg font-black text-red-500">{{ number_format($product->final_min_price) }}đ</span>
                        </div>


                </div>

                <div class="block w-full text-center py-2.5 text-white text-[11px] font-black text-[#0e4d3d] uppercase  rounded-xl bg-[#0e4d3d]  transition-all shadow-sm">
                    Xem chi tiết
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <div class="mt-12">
        {{ $products->links() }}
    </div>
</div>
@endsection