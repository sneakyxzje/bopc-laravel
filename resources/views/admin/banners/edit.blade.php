@extends('layouts.admin')

@section('title', 'Cập Nhật Banner')
@section('page_title', 'Cập Nhật Banner #' . $banner->id)

@section('content')
<div class="max-w-4xl mx-auto" x-data="bannerUpload('{{ $banner->image_path }}')">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-black text-near-black tracking-tight">Cập Nhật Banner</h2>
        <a href="{{ route('admin.banners.index') }}" class="text-sm font-bold text-secondary-gray hover:text-primary transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Quay lại
        </a>
    </div>

    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf
        @method('PUT')

        
        <div class="lg:col-span-2">
            <div class="bg-white border border-[#f2f2f2] rounded-md shadow-sm p-6 mb-6">
                <label class="block text-sm font-black text-near-black mb-4 uppercase">Hình ảnh hiển thị</label>
                
                
                <div class="relative border-2 border-dashed border-[#ebebeb] rounded-lg bg-[#f7f7f7] hover:bg-[#f2f2f2] transition-colors cursor-pointer overflow-hidden flex flex-col items-center justify-center p-6"
                     :class="previewUrl ? 'border-primary bg-primary/5 p-2' : ''"
                     @dragover.prevent="$el.classList.add('border-primary', 'bg-primary/5')"
                     @dragleave.prevent="$el.classList.remove('border-primary', 'bg-primary/5')"
                     @drop.prevent="handleDrop($event); $el.classList.remove('border-primary', 'bg-primary/5')"
                     @click="$refs.fileInput.click()">
                    
                    <input type="file" name="image_path" x-ref="fileInput" @change="previewImage" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10 hidden">
                    
                    <template x-if="!previewUrl">
                        <div class="text-center pointer-events-none">
                            <svg class="mx-auto h-12 w-12 text-secondary-gray/30 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="text-sm font-bold text-primary">Click để thay ảnh khác hoặc kéo thả vào đây</p>
                            <p class="text-[11px] text-secondary-gray/50 mt-1 uppercase">PNG, JPG, WEBP lên đến 5MB</p>
                        </div>
                    </template>

                    <template x-if="previewUrl">
                        <div class="relative w-full">
                            <img :src="previewUrl" class="w-full object-contain rounded-md shadow-sm max-h-[400px]">
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity rounded-md">
                                <span class="bg-white text-near-black text-xs font-bold px-4 py-2 rounded shadow-sm">Đổi ảnh khác</span>
                            </div>
                        </div>
                    </template>
                </div>
                @error('image_path')
                    <p class="mt-2 text-sm text-red-500 font-medium flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p>
                @enderror
            </div>
        </div>

        
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white border border-[#f2f2f2] rounded-md shadow-sm p-6">
                <h3 class="text-sm font-black text-near-black mb-6 uppercase border-b border-[#f2f2f2] pb-3">Thuộc Tính Banner</h3>
                
                <div class="space-y-5">
                    <div>
                        <label class="block text-[11px] uppercase font-black text-secondary-gray mb-2">Loại Banner <span class="text-red-500">*</span></label>
                        <select name="type" required class="w-full px-4 py-3 bg-[#f7f7f7] border border-[#ebebeb] rounded-md focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-sm font-bold text-near-black transition-colors">
                            <option value="slider" {{ $banner->type == 'slider' ? 'selected' : '' }}>Banner Chính (Slider to)</option>
                            <option value="static" {{ $banner->type == 'static' ? 'selected' : '' }}>Banner Phụ (3 khối tĩnh)</option>
                        </select>
                        @error('type')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase font-black text-secondary-gray mb-2">Đường Dẫn Đích (Link)</label>
                        <input type="url" name="link" value="{{ $banner->link }}" placeholder="https://..." class="w-full px-4 py-3 bg-[#f7f7f7] border border-[#ebebeb] rounded-md focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-sm font-bold text-near-black transition-colors">
                        @error('link')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase font-black text-secondary-gray mb-2">Thứ tự ưu tiên</label>
                        <input type="number" name="order" value="{{ $banner->order }}" min="0" class="w-full px-4 py-3 bg-[#f7f7f7] border border-[#ebebeb] rounded-md focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-sm font-bold text-near-black transition-colors">
                        @error('order')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div class="pt-4 border-t border-[#f2f2f2] flex items-center justify-between">
                        <label class="text-[11px] uppercase font-black text-secondary-gray">Trạng Thái Đăng</label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ $banner->is_active ? 'checked' : '' }} class="sr-only peer">
                            <div class="relative w-11 h-6 bg-[#ebebeb] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                        </label>
                    </div>
                </div>

                <div class="pt-8 flex flex-col gap-3">
                    <button type="submit" class="w-full py-3 bg-primary text-white text-sm font-black uppercase rounded-md hover:bg-primary-hover transition-colors shadow-lg shadow-primary/30 active:scale-[0.98]">
                        Lưu Thay Đổi
                    </button>
                    <a href="{{ route('admin.banners.index') }}" class="w-full py-3 bg-[#f7f7f7] text-secondary-gray text-center text-sm font-black uppercase rounded-md hover:bg-[#ebebeb] transition-colors block">
                        Huỷ Bỏ
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('bannerUpload', (initialImage) => ({
            previewUrl: initialImage || null,
            previewImage(event) {
                const file = event.target.files[0];
                if (file) {
                    this.previewUrl = URL.createObjectURL(file);
                }
            },
            handleDrop(event) {
                const file = event.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    this.$refs.fileInput.files = event.dataTransfer.files;
                    this.previewUrl = URL.createObjectURL(file);
                }
            }
        }))
    })
</script>
@endsection
