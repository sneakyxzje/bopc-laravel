@extends('layouts.admin')

@section('title', 'Cấu hình Giao diện Banners')
@section('page_title', 'Cấu hình Giao diện Banners')

@section('content')
<div class="space-y-10" x-data="{ activeTab: 'slider' }">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-black text-near-black tracking-tight">Banners Management</h2>
        <a href="{{ route('admin.banners.create') }}" class="px-5 py-2.5 bg-primary text-white text-sm font-bold rounded-md hover:bg-primary-hover transition-colors shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tải lên banner mới
        </a>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 text-emerald-600 rounded-md border border-emerald-100 text-sm font-bold flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
        {{ session('success') }}
    </div>
    @endif

    
    <div class="flex border-b border-[#ebebeb]">
        <button @click="activeTab = 'slider'" :class="activeTab === 'slider' ? 'border-primary text-primary' : 'border-transparent text-secondary-gray hover:text-near-black hover:border-secondary-gray/20'" class="whitespace-nowrap pb-4 px-6 border-b-2 font-bold text-sm transition-colors uppercase">
            Banner Chính
        </button>
        <button @click="activeTab = 'static'" :class="activeTab === 'static' ? 'border-primary text-primary' : 'border-transparent text-secondary-gray hover:text-near-black hover:border-secondary-gray/20'" class="whitespace-nowrap pb-4 px-6 border-b-2 font-bold text-sm transition-colors uppercase">
            Banner Phụ
        </button>
    </div>

    <div x-show="activeTab === 'slider'" class="space-y-6 animate-in slide-in-from-bottom-2 fade-in duration-300">


        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            @php $sliders = $banners->where('type', 'slider'); @endphp
            @forelse($sliders as $banner)
            <div class="bg-white rounded-md border {{ $banner->is_active ? 'border-[#ebebeb]' : 'border-red-200 border-dashed' }} overflow-hidden group shadow-sm flex flex-col">
                <div class="relative w-full aspect-[21/9] bg-[#f7f7f7] flex items-center justify-center overflow-hidden">
                    <img src="{{ $banner->image_path }}" class="w-full h-full object-cover {{ !$banner->is_active ? 'opacity-50 grayscale' : '' }}" alt="Slider Banner">

                    @if(!$banner->is_active)
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="px-3 py-1 bg-red-600 text-white text-xs font-black uppercase rounded shadow-lg">Đã ẩn</span>
                    </div>
                    @endif

                    
                    <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity flex gap-2">
                        <a href="{{ route('admin.banners.edit', $banner->id) }}" class="p-2 bg-white text-near-black hover:text-primary rounded shadow-md transition-colors" title="Chỉnh sửa">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Xoá vĩnh viễn banner này?');" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 bg-white text-near-black hover:text-red-600 rounded shadow-md transition-colors" title="Xoá">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="p-4 flex-1 flex flex-col justify-between gap-4">
                    <div class="flex items-center justify-between text-sm">
                        <span class="font-bold text-near-black">Thứ tự hiển thị: <span class="bg-[#f7f7f7] px-2 py-0.5 rounded text-primary">{{ $banner->order }}</span></span>
                    </div>
                    @if($banner->link)
                    <a href="{{ $banner->link }}" target="_blank" class="text-xs text-blue-500 hover:underline truncate">{{ $banner->link }}</a>
                    @else
                    <span class="text-xs text-secondary-gray/50 italic">Không có link chèn</span>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 text-center text-secondary-gray border-2 border-dashed border-[#ebebeb] rounded-md">
                Chưa có Banner Slider nào. Hãy thêm để thu hút khách hàng!
            </div>
            @endforelse
        </div>
    </div>

    <div x-show="activeTab === 'static'" class="space-y-6 animate-in slide-in-from-bottom-2 fade-in duration-300" style="display: none;">


        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            @php $statics = $banners->where('type', 'static'); @endphp
            @forelse($statics as $banner)
            <div class="bg-white rounded-md border {{ $banner->is_active ? 'border-[#ebebeb] hover:border-primary/50 hover:shadow-md transition-all' : 'border-red-200 border-dashed' }} overflow-hidden group flex flex-col relative">
                <div class="relative w-full aspect-[21/6] bg-[#f7f7f7] flex items-center justify-center overflow-hidden">
                    <img src="{{ $banner->image_path }}" class="w-full h-full object-cover {{ !$banner->is_active ? 'opacity-50 grayscale' : '' }}" alt="Static Banner">

                    @if(!$banner->is_active)
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="px-2 py-0.5 bg-red-600 text-white text-[10px] font-black uppercase rounded shadow-lg">Tạm Ẩn</span>
                    </div>
                    @endif
                </div>

                <div class="p-3 bg-[#f7f7f7] border-t border-[#f2f2f2] flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-black text-secondary-gray uppercase">Thứ tự: </span>
                        <span class="text-xs font-black text-primary">{{ $banner->order }}</span>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.banners.edit', $banner->id) }}" class="text-secondary-gray hover:text-primary transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </a>
                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Xoá vĩnh viễn banner này?');" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-secondary-gray hover:text-red-500 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 text-center text-secondary-gray border-2 border-dashed border-[#ebebeb] rounded-md">
                Chưa có Banner Phụ (Tĩnh) nào được thiết lập.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection