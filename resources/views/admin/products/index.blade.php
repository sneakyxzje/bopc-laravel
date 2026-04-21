@extends('layouts.admin')

@section('title', 'Quản lý sản phẩm')
@section('page_title', 'Danh sách Sản phẩm')

@section('content')
<div class="">
    <div class="bg-white rounded-md shadow-sm border border-zinc-100 overflow-hidden relative">
        <div class="p-6 md:p-8 flex flex-col sm:flex-row sm:items-center justify-between gap-5 border-b border-zinc-50 relative z-10">
            
            <form action="{{ route('admin.products.index') }}" method="GET" class="w-full sm:max-w-md relative group">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-zinc-400 group-focus-within:text-primary">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm tên sản phẩm, mã SKU..."
                    class="w-full pl-11 pr-4 py-3 bg-zinc-50 border border-zinc-200 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
            </form>

            <div class="flex items-center gap-3 shrink-0">
                <button class="p-3 bg-zinc-50 text-zinc-600 rounded-md hover:bg-zinc-100 border border-zinc-200 shadow-sm" title="Bộ lọc">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                </button>
                <a href="{{ route('admin.products.trash') }}" class="p-3 bg-zinc-50 text-zinc-600 rounded-md hover:bg-red-50 hover:text-red-500 border border-zinc-200 shadow-sm flex items-center gap-2 text-xs font-bold" title="Thùng rác">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Thùng rác
                </a>
                <a href="{{ route('admin.products.create') }}" class="px-5 py-3 bg-primary text-white rounded-md text-sm font-bold hover:bg-primary-hover shadow-md shadow-primary/20 flex items-center gap-2">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    THÊM SẢN PHẨM
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-zinc-50/80">
                        <th class="px-6 py-4 text-[11px] font-black uppercase text-zinc-400 rounded-tl-md w-16">ID</th>
                        <th class="px-6 py-4 text-[11px] font-black uppercase text-zinc-400 w-96">Sản phẩm</th>
                        <th class="px-6 py-4 text-[11px] font-black uppercase text-zinc-400">Phân loại</th>
                        <th class="px-6 py-4 text-[11px] font-black uppercase text-zinc-400 text-center">Tồn kho / Biến thể</th>
                        <th class="px-6 py-4 text-[11px] font-black uppercase text-zinc-400 text-center">Hiển thị</th>
                        <th class="px-6 py-4 text-[11px] font-black uppercase text-zinc-400 text-right rounded-tr-md">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-50">
                    @forelse($products as $product)
                    <tr class="hover:bg-primary/5 group">
                        <td class="px-6 py-5">
                            <span class="text-sm font-black text-zinc-500">#{{ str_pad($product->id, 3, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-4">
                                
                                <div class="w-16 h-16 bg-white border border-zinc-100 rounded-md p-2 shrink-0 flex items-center justify-center overflow-hidden">
                                    @if($product->primaryImage && rtrim($product->primaryImage->image_path) != '')
                                    <img src="{{ $product->primaryImage->image_path }}" class="w-full h-full object-contain" alt="">
                                    @else
                                    <svg class="w-6 h-6 text-zinc-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    @endif
                                </div>
                                
                                <div>
                                    <p class="text-sm font-bold text-zinc-800 leading-tight mb-1 group-hover:text-primary line-clamp-2 max-w-[280px]" title="{{ $product->name }}">{{ $product->name }}</p>
                                    <p class="text-[11px] font-medium text-zinc-400 truncate max-w-[250px]">{{ $product->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="space-y-1">
                                <p class="text-xs font-bold text-zinc-700 bg-zinc-100 w-fit px-2 py-0.5 rounded-md">{{ $product->category->name ?? 'N/A' }}</p>
                                <p class="text-[11px] font-medium text-zinc-500 flex items-center gap-1">
                                    Thương hiệu: <span class="font-bold text-zinc-800">{{ $product->brand->name ?? 'N/A' }}</span>
                                </p>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            @php
                            $totalStock = $product->variants->sum('stock');
                            $variantCount = $product->variants->count();
                            @endphp
                            <p class="text-sm font-black text-zinc-800">{{ $totalStock }}</p>
                            <p class="text-[10px] uppercase font-bold text-zinc-400 mt-0.5">{{ $variantCount }} Cấu hình</p>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" disabled class="sr-only peer" {{ $product->is_active ? 'checked' : '' }}>
                                <div class="w-9 h-5 bg-zinc-200 peer-focus:outline-none rounded-md peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-zinc-300 after:border after:rounded-md after:h-4 after:w-4 peer-checked:bg-emerald-500 cursor-not-allowed"></div>
                            </label>
                        </td>
                        <td class="px-6 py-5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="p-2 bg-zinc-50 text-zinc-400 hover:text-primary hover:bg-primary/10 rounded-md" title="Chỉnh sửa">
                                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Xóa sản phẩm này? Sản phẩm sẽ vào Thùng rác và có thể khôi phục lại sau.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-zinc-50 text-zinc-400 hover:text-red-600 hover:bg-red-50 rounded-md" title="Xóa">
                                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="w-24 h-24 bg-zinc-50 rounded-md border border-zinc-100 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-zinc-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-black text-zinc-800 mb-1">Chưa có sản phẩm nào!</h3>
                            <p class="text-sm font-medium text-zinc-400 mb-6">Bạn có thể tạo sản phẩm đầu tiên bằng cách nhấn nút phía trên.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 bg-zinc-50/30 border-t border-zinc-100">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection