@extends('layouts.admin')

@section('title', 'Chỉnh sửa sản phẩm')
@section('page_title', 'Chỉnh sửa sản phẩm')

@section('content')
<div class="mx-auto pb-20 px-4 sm:px-0">
    
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" x-data="productForm()">
        @csrf
        @method('PUT')

        
        <div class="flex items-center justify-between mb-8">
            <div>
                <a href="{{ route('admin.products.index') }}" class="text-zinc-400 hover:text-primary text-sm flex items-center gap-1 mb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Quay lại danh sách
                </a>
                <h1 class="text-3xl font-black text-zinc-900 text-wrap max-w-2xl">Chỉnh sửa: {{ $product->name }}</h1>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 bg-white border border-zinc-200 text-zinc-700 font-bold rounded-md hover:bg-zinc-50 shadow-sm text-sm">
                    Hủy bỏ
                </a>
                <button type="submit" class="px-5 py-2.5 bg-zinc-900 hover:bg-zinc-800 text-white font-bold rounded-md shadow-md text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7" />
                    </svg>
                    Cập nhật sản phẩm
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-8 space-y-8">

                
                <section class="bg-white p-8 rounded-md border border-zinc-100 shadow-sm">
                    <h2 class="text-[13px] font-black text-zinc-400 uppercase mb-6">Thông tin chung</h2>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-bold text-zinc-700 mb-1.5">Tên sản phẩm <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" required placeholder="VD: PC Gaming MSI Core i7..." class="w-full bg-zinc-50 border border-zinc-200 text-zinc-900 text-sm rounded-md focus:ring-primary focus:border-primary block p-3">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-zinc-700 mb-1.5">Cân nặng (Gram) <span class="text-zinc-400 font-medium text-xs">(Dùng tính phí GHTK)</span></label>
                            <input type="number" name="weight" value="{{ old('weight', $product->weight) }}" placeholder="500" class="w-full bg-zinc-50 border border-zinc-200 text-zinc-900 text-sm rounded-md focus:ring-primary focus:border-primary block p-3">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-zinc-700 mb-1.5">Mô tả sản phẩm</label>
                            <textarea name="description" rows="5" placeholder="Viết một bài giới thiệu thật thu hút về bộ PC của bạn..." class="w-full bg-zinc-50 border border-zinc-200 text-zinc-900 text-sm rounded-md focus:ring-primary focus:border-primary block p-3">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>
                </section>

                
                <section class="bg-white p-8 rounded-md border border-zinc-100 shadow-sm space-y-6">
                    <h2 class="text-[13px] font-black text-zinc-400 uppercase">Media (Cloudinary)</h2>

                    
                    <div>
                        <label class="block text-sm font-bold text-zinc-700 mb-2">Ảnh đại diện chính <span class="text-xs text-zinc-400 font-medium">(Tải lên để thay đổi)</span></label>
                        <div class="flex items-center gap-6 p-4 bg-zinc-50 rounded-md border border-zinc-200">
                            <div class="w-24 h-24 bg-white rounded-md border border-zinc-200 overflow-hidden flex items-center justify-center shrink-0">
                                @if($product->primaryImage)
                                <img src="{{ $product->primaryImage->image_path }}" class="w-full h-full object-contain" alt="Current Primary">
                                @else
                                <svg class="w-8 h-8 text-zinc-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <input type="file" name="image" class="block w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" accept="image/*">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-zinc-700 mb-2">Ảnh Gallery <span class="text-xs text-zinc-400 font-medium">(Tải lên để thêm mới)</span></label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-3 mb-4">
                            @foreach($product->images->where('is_primary', false) as $img)
                            <div class="relative aspect-square rounded-md border border-zinc-200 overflow-hidden bg-white">
                                <img src="{{ $img->image_path }}" class="w-full h-full object-cover" alt="Gallery">

                                <button
                                    type="button"
                                    onclick="deleteImage({{ $img->id }}, this)"
                                    title="Xóa ảnh"
                                    class="absolute top-1 right-1 w-7 h-7 bg-red-500 text-white rounded-md flex items-center justify-center shadow-lg hover:bg-red-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            @endforeach
                        </div>
                        <div class="border-2 border-dashed border-zinc-200 bg-zinc-50/50 rounded-md p-6 text-center hover:bg-zinc-100 cursor-pointer">
                            <input type="file" name="gallery[]" multiple class="block w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-zinc-200 file:text-zinc-700 hover:file:bg-zinc-300 mx-auto max-w-[250px]" accept="image/*">
                        </div>
                    </div>
                </section>

                <section class="bg-white p-8 rounded-md border border-zinc-100 shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-[13px] font-black text-zinc-400 uppercase">Các cấu hình máy (Variants)</h2>
                        <button type="button" @click="addVariant()" class="text-sm font-bold text-primary bg-primary/10 hover:bg-primary/20 px-3 py-1.5 rounded-md flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 4v16m8-8H4" />
                            </svg>
                            Thêm cấu hình
                        </button>
                    </div>

                    <div class="space-y-4">
                        <template x-for="(variant, index) in variants" :key="index">
                            <div class="p-5 bg-zinc-50 border border-zinc-200 rounded-md relative group pb-8">
                                <div class="flex justify-between items-center mb-3">
                                    <h4 class="text-sm font-bold text-zinc-800" x-text="'Cấu hình #' + (index + 1)"></h4>
                                    <button type="button" @click="removeVariant(index)" x-show="variants.length > 1" class="w-8 h-8 bg-white text-red-500 border border-zinc-200 rounded-md flex items-center justify-center shadow-sm hover:bg-red-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                                    <div class="md:col-span-12">
                                        <label class="block text-xs font-bold text-zinc-500 mb-1">Tên phiên bản</label>
                                        <input type="text" :name="'variants['+index+'][variant_name]'" x-model="variant.variant_name" placeholder="Bắt buộc" required class="w-full bg-white border border-zinc-200 text-zinc-900 text-sm rounded-md block p-2 focus:ring-primary focus:border-primary">
                                    </div>
                                    <div class="md:col-span-3">
                                        <label class="block text-xs font-bold text-zinc-500 mb-1">Mã SKU</label>
                                        <input type="text" :name="'variants['+index+'][sku]'" x-model="variant.sku" placeholder="MSI-I7" required class="w-full bg-white border border-zinc-200 text-zinc-900 text-sm rounded-md block p-2 uppercase focus:ring-primary focus:border-primary">
                                    </div>
                                    <div class="md:col-span-3">
                                        <label class="block text-xs font-bold text-zinc-500 mb-1">Giá bán</label>
                                        <input type="number" :name="'variants['+index+'][price]'" x-model="variant.price" placeholder="10.000.000" required class="w-full bg-white border border-zinc-200 text-zinc-900 text-sm rounded-md block p-2 focus:ring-primary focus:border-primary">
                                    </div>
                                    <div class="md:col-span-3">
                                        <label class="block text-xs font-bold text-zinc-500 mb-1">Giá KM</label>
                                        <input type="number" :name="'variants['+index+'][sale_price]'" x-model="variant.sale_price" placeholder="Tùy chọn" class="w-full bg-white border border-zinc-200 text-zinc-900 text-sm rounded-md block p-2 focus:ring-primary focus:border-primary">
                                    </div>
                                    <div class="md:col-span-3">
                                        <label class="block text-xs font-bold text-zinc-500 mb-1">Tồn kho</label>
                                        <input type="number" :name="'variants['+index+'][stock]'" x-model="variant.stock" placeholder="10" required class="w-full bg-white border border-zinc-200 text-zinc-900 text-sm rounded-md block p-2 focus:ring-primary focus:border-primary">
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </section>
            </div>

            
            <div class="lg:col-span-4 space-y-8">

                
                <section class="bg-zinc-50/50 p-6 rounded-md border border-zinc-100 h-fit">
                    <h3 class="text-[13px] font-black text-zinc-400 uppercase mb-6">Phân loại</h3>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-bold text-zinc-700 mb-1.5">Danh mục</label>
                            <select name="category_id" required class="w-full bg-white border border-zinc-200 text-zinc-900 text-sm rounded-md focus:ring-primary block p-3">
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-zinc-700 mb-1.5">Thương hiệu</label>
                            <select name="brand_id" required class="w-full bg-white border border-zinc-200 text-zinc-900 text-sm rounded-md focus:ring-primary block p-3">
                                <option value="">-- Chọn thương hiệu --</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </section>

                
                <section class="bg-zinc-50/50 p-6 rounded-md border border-zinc-100 h-fit">
                    <h3 class="text-[13px] font-black text-zinc-400 uppercase mb-6">Hiển thị</h3>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-white border border-zinc-200 rounded-md">
                            <div>
                                <p class="text-sm font-bold text-zinc-800">Hiển thị website</p>
                                <p class="text-xs font-medium text-zinc-400">Khách có thể nhìn thấy</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-11 h-6 bg-zinc-200 peer-focus:outline-none rounded-md peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-zinc-300 after:border after:rounded-md after:h-5 after:w-5 peer-checked:bg-emerald-500"></div>
                            </label>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-zinc-700">Tình trạng máy</label>
                            <select name="status" class="w-full bg-white border border-zinc-200 text-zinc-900 text-sm rounded-md focus:ring-primary block p-3">
                                <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Trạng thái: Hoạt động (Còn hàng)</option>
                                <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Trạng thái: Tạm ẩn</option>
                            </select>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </form>
</div>
<div id="variants-data" data-variants="{{ json_encode($product->variants->map(fn($v) => [
    'variant_name' => $v->variant_name,
    'sku'          => $v->sku,
    'price'        => $v->price,
    'sale_price'   => $v->sale_price,
    'stock'        => $v->stock,
])) }}"></div>
<script>
    function productForm() {
        return {
            // prettier-ignore
            variants: JSON.parse(document.getElementById('variants-data').dataset.variants),
            addVariant() {
                this.variants.push({
                    variant_name: '',
                    sku: '',
                    price: '',
                    sale_price: '',
                    stock: 0
                });
            },
            removeVariant(index) {
                if (this.variants.length > 1) {
                    this.variants.splice(index, 1);
                }
            }
        }
    }

    // Lấy CSRF token từ meta tag (cần có trong layout)
    function deleteImage(id) {
        if (!confirm('Xóa ảnh này khỏi gallery?')) return;

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/products/images/${id}`;

        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = document.querySelector('meta[name="csrf-token"]').content;

        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';

        form.appendChild(csrf);
        form.appendChild(method);
        document.body.appendChild(form);
        form.submit();
    }
</script>
@endsection