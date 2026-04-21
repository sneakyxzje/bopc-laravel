@extends('layouts.admin')

@section('title', 'Quản lý danh mục')
@section('page_title', 'Danh mục Sản phẩm')

@section('content')
<div class="mx-auto pb-20 px-4 sm:px-0" x-data="{ 
    showModal: false, 
    editMode: false, 
    category: { id: '', name: '', parent_id: '' },
    openCreate() {
        this.editMode = false;
        this.category = { id: '', name: '', parent_id: '' };
        this.showModal = true;
    },
    openEdit(cat) {
        this.editMode = true;
        this.category = { id: cat.id, name: cat.name, parent_id: cat.parent_id };
        this.showModal = true;
    }
}">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight">Danh mục</h1>
            <p class="text-zinc-500 text-sm mt-1">Quản lý cách phân loại sản phẩm trên website.</p>
        </div>
        <button @click="openCreate()" class="px-5 py-3 bg-primary text-white rounded-md text-sm font-bold hover:bg-primary-hover shadow-md shadow-primary/20 flex items-center gap-2">
            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M12 4v16m8-8H4" />
            </svg>
            THÊM DANH MỤC
        </button>
    </div>

    <div class="bg-white rounded-md shadow-sm border border-zinc-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-zinc-50/80 border-b border-zinc-100">
                    <th class="px-6 py-4 text-[11px] font-black uppercase text-zinc-400">ID</th>
                    <th class="px-6 py-4 text-[11px] font-black uppercase text-zinc-400">Danh mục</th>
                    <th class="px-6 py-4 text-[11px] font-black uppercase text-zinc-400">Cấp trên</th>
                    <th class="px-6 py-4 text-[11px] font-black uppercase text-zinc-400 text-center">Số sản phẩm</th>
                    <th class="px-6 py-4 text-[11px] font-black uppercase text-zinc-400 text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-50">
                @forelse($categories as $category)
                <tr class="hover:bg-zinc-50/50 group">
                    <td class="px-6 py-5">
                        <span class="text-sm font-black text-zinc-400">#{{ $category->id }}</span>
                    </td>
                    <td class="px-6 py-5">
                        <p class="text-sm font-bold text-zinc-800">{{ $category->name }}</p>
                        <p class="text-[11px] text-zinc-400">{{ $category->slug }}</p>
                    </td>
                    <td class="px-6 py-5">
                        @if($category->parent)
                            <span class="text-xs font-bold text-primary bg-primary/5 px-2 py-1 rounded-md">{{ $category->parent->name }}</span>
                        @else
                            <span class="text-xs font-medium text-zinc-300 italic">Gốc</span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-center">
                        <span class="px-2.5 py-1 bg-zinc-100 text-zinc-600 rounded-md text-xs font-bold">{{ $category->products_count }} SP</span>
                    </td>
                    <td class="px-6 py-5 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button @click="openEdit({{ $category }})" class="p-2 text-zinc-400 hover:text-primary hover:bg-primary/10 rounded-md">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            </button>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Xóa danh mục này?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-zinc-400 hover:text-red-600 hover:bg-red-50 rounded-md">
                                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-10 text-center text-zinc-400 italic">Chưa có danh mục nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    
    <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-zinc-900/40 backdrop-blur-sm" x-cloak>
        <div class="bg-white rounded-md shadow-2xl w-full max-w-md overflow-hidden" @click.away="showModal = false">
            <div class="p-6 border-b border-zinc-100 flex items-center justify-between">
                <h3 class="text-lg font-black text-zinc-900" x-text="editMode ? 'Sửa danh mục' : 'Thêm danh mục mới'"></h3>
                <button @click="showModal = false" class="text-zinc-400 hover:text-zinc-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form :action="editMode ? '{{ url('admin/categories') }}/' + category.id : '{{ route('admin.categories.store') }}'" method="POST" class="p-6 space-y-5">
                @csrf
                <template x-if="editMode"><input type="hidden" name="_method" value="PUT"></template>
                
                <div>
                    <label class="block text-sm font-bold text-zinc-700 mb-2">Tên danh mục</label>
                    <input type="text" name="name" x-model="category.name" required class="w-full bg-zinc-50 border border-zinc-200 rounded-md p-3 text-sm focus:ring-primary focus:border-primary">
                </div>

                <div>
                    <label class="block text-sm font-bold text-zinc-700 mb-2">Danh mục cha (Tùy chọn)</label>
                    <select name="parent_id" x-model="category.parent_id" class="w-full bg-zinc-50 border border-zinc-200 rounded-md p-3 text-sm focus:ring-primary">
                        <option value="">-- Không có --</option>
                        @foreach($categories as $cat)
                            <template x-if="cat.id != category.id">
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            </template>
                        @endforeach
                    </select>
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="button" @click="showModal = false" class="flex-1 px-5 py-3 bg-zinc-100 text-zinc-600 font-bold rounded-md hover:bg-zinc-200">Hủy</button>
                    <button type="submit" class="flex-1 px-5 py-3 bg-primary text-white font-bold rounded-md hover:bg-primary-hover shadow-lg shadow-primary/20">Lưu lại</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
