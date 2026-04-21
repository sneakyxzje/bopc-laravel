@extends('layouts.admin')

@section('title', 'Quản lý thương hiệu')
@section('page_title', 'Thương hiệu Sản phẩm')

@section('content')
<div class="mx-auto pb-20 px-4 sm:px-0" x-data="{ 
    showModal: false, 
    editMode: false, 
    brand: { id: '', name: '', logo_path: '' },
    openCreate() {
        this.editMode = false;
        this.brand = { id: '', name: '', logo_path: '' };
        this.showModal = true;
    },
    openEdit(b) {
        this.editMode = true;
        this.brand = { id: b.id, name: b.name, logo_path: b.logo_path };
        this.showModal = true;
    }
}">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight">Thương hiệu</h1>
            <p class="text-zinc-500 text-sm mt-1">Quản lý các hãng sản xuất linh kiện PC.</p>
        </div>
        <button @click="openCreate()" class="px-5 py-3 bg-zinc-900 text-white rounded-md text-sm font-bold hover:bg-zinc-800 shadow-md shadow-zinc-900/20 flex items-center gap-2">
            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M12 4v16m8-8H4" />
            </svg>
            THÊM THƯƠNG HIỆU
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($brands as $brand)
        <div class="bg-white rounded-md border border-zinc-100 p-6 shadow-sm hover:shadow-md group flex flex-col items-center text-center">
            <h3 class="text-lg font-black text-zinc-800 mb-1">{{ $brand->name }}</h3>
            <p class="text-[11px] font-bold text-zinc-400 uppercase mb-4 inline-flex items-center gap-1.5">
                {{ $brand->products_count }} SẢN PHẨM
            </p>

            <div class="flex items-center gap-2 mt-auto pt-4 border-t border-zinc-50 w-full justify-center">
                <button @click="openEdit({{ $brand }})" class="p-2 text-zinc-400 hover:text-primary hover:bg-primary/5 rounded-md">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </button>
                <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" onsubmit="return confirm('Xóa thương hiệu này?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="p-2 text-zinc-400 hover:text-red-600 hover:bg-red-50 rounded-md">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center bg-zinc-50/50 rounded-md border border-dashed border-zinc-200">
            <p class="text-zinc-400 italic font-medium">Bạn chưa đăng ký thương hiệu nào.</p>
        </div>
        @endforelse
    </div>

    
    <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-zinc-900/60 backdrop-blur-md" x-cloak>
        <div class="bg-white rounded-md shadow-2xl w-full max-w-sm overflow-hidden" @click.away="showModal = false">
            <div class="p-8 border-b border-zinc-50 bg-zinc-50/50 flex items-center justify-between">
                <h3 class="text-xl font-bold text-zinc-900" x-text="editMode ? 'Sửa thương hiệu' : 'Thêm thương hiệu mới'"></h3>
                <button @click="showModal = false" class="text-zinc-400 hover:text-zinc-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form :action="editMode ? '{{ url('admin/brands') }}/' + brand.id : '{{ route('admin.brands.store') }}'" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf
                <template x-if="editMode"><input type="hidden" name="_method" value="PUT"></template>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-zinc-700">Tên thương hiệu <span class="text-red-500">*</span></label>
                    <input type="text" name="name" x-model="brand.name" required class="w-full bg-zinc-50 border border-zinc-200 rounded-md p-4 text-sm focus:ring-primary focus:border-primary">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-zinc-700">Logo thương hiệu</label>
                    <div class="mt-1 flex flex-col items-center">
                        <template x-if="brand.logo_path && !editMode">
                            <img :src="brand.logo_path" class="w-20 h-20 object-contain mb-4 rounded-md border border-zinc-100">
                        </template>
                        <input type="file" name="logo" class="block w-full text-xs text-zinc-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                    </div>
                </div>

                <div class="pt-4 flex flex-col gap-3">
                    <button type="submit" class="w-full px-5 py-4 bg-primary text-white font-black rounded-md hover:bg-primary-hover shadow-xl shadow-primary/20 uppercase text-xs">Xác nhận Lưu</button>
                    <button type="button" @click="showModal = false" class="w-full px-5 py-4 bg-white border border-zinc-200 text-zinc-400 font-bold rounded-md hover:bg-zinc-50 text-xs uppercase">Hủy bỏ</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection