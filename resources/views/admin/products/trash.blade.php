@extends('layouts.admin')

@section('title', 'Thùng rác - Sản phẩm đã xóa')
@section('page_title', 'Thùng rác Sản phẩm')

@section('content')
<div class="">
    <div class="bg-white rounded-md shadow-sm border border-[#f2f2f2] overflow-hidden">
        <div class="p-6 md:p-8 flex flex-col sm:flex-row sm:items-center justify-between gap-5 border-b border-[#f2f2f2]">
            <div>
                <h2 class="text-lg font-black text-near-black">Thùng rác</h2>
                <p class="text-xs font-bold text-secondary-gray mt-0.5">Các sản phẩm đã xóa. Có thể khôi phục lại bất cứ lúc nào.</p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2.5 text-xs font-black text-secondary-gray hover:text-near-black bg-[#f7f7f7] border border-[#ebebeb] rounded-md flex items-center gap-2 transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Quay lại danh sách
            </a>
        </div>

        @if(session('success'))
        <div class="mx-6 mt-6 p-4 bg-emerald-50 text-emerald-700 rounded-md border border-emerald-100 text-sm font-bold flex items-center gap-2">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#f7f7f7]">
                        <th class="px-6 py-4 text-[11px] font-black uppercase text-secondary-gray w-16">ID</th>
                        <th class="px-6 py-4 text-[11px] font-black uppercase text-secondary-gray w-96">Sản phẩm</th>
                        <th class="px-6 py-4 text-[11px] font-black uppercase text-secondary-gray">Phân loại</th>
                        <th class="px-6 py-4 text-[11px] font-black uppercase text-secondary-gray text-center">Đã xóa lúc</th>
                        <th class="px-6 py-4 text-[11px] font-black uppercase text-secondary-gray text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f7f7f7]">
                    @forelse($products as $product)
                    <tr class="hover:bg-[#fafafa] group">
                        <td class="px-6 py-5">
                            <span class="text-sm font-black text-secondary-gray">#{{ str_pad($product->id, 3, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 bg-[#f7f7f7] border border-[#ebebeb] rounded-md p-2 shrink-0 flex items-center justify-center overflow-hidden opacity-60">
                                    @if($product->primaryImage && rtrim($product->primaryImage->image_path) != '')
                                    <img src="{{ $product->primaryImage->image_path }}" class="w-full h-full object-contain grayscale" alt="">
                                    @else
                                    <svg class="w-6 h-6 text-secondary-gray/30" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-secondary-gray line-clamp-2 max-w-[280px] line-through" title="{{ $product->name }}">{{ $product->name }}</p>
                                    <p class="text-[11px] font-medium text-secondary-gray/50 truncate max-w-[250px]">{{ $product->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-xs font-bold text-secondary-gray bg-[#f7f7f7] w-fit px-2 py-0.5 rounded-md">{{ $product->category->name ?? 'N/A' }}</p>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <p class="text-xs font-bold text-near-black">{{ $product->deleted_at->format('d/m/Y') }}</p>
                            <p class="text-[10px] text-secondary-gray mt-0.5">{{ $product->deleted_at->format('H:i') }}</p>
                        </td>
                        <td class="px-6 py-5 text-right">
                            <form action="{{ route('admin.products.restore', $product->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-4 py-2 bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white text-[11px] font-black uppercase border border-emerald-100 hover:border-emerald-500 rounded-md transition-all" title="Khôi phục sản phẩm">
                                    Khôi phục
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="w-20 h-20 bg-[#f7f7f7] rounded-md border border-[#ebebeb] flex items-center justify-center mx-auto mb-4">
                                <svg class="w-9 h-9 text-secondary-gray/30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </div>
                            <h3 class="text-base font-black text-near-black mb-1">Thùng rác trống!</h3>
                            <p class="text-sm font-medium text-secondary-gray">Không có sản phẩm nào đã bị xóa.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 bg-[#f7f7f7]/50 border-t border-[#f2f2f2]">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
