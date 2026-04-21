@extends('layouts.admin')

@section('title', 'Thêm sản phẩm mới')
@section('page_title', 'Thêm sản phẩm mới')

@section('content')
<div class="mx-auto pb-20 px-4 sm:px-0">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" x-data="productForm()">
        @csrf
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-black text-zinc-900">Thêm sản phẩm mới</h1>
            </div>

            <div class="flex items-center gap-3">
                <button type="button" class="px-5 py-2.5 bg-white border border-zinc-200 text-zinc-700 font-bold rounded-md hover:bg-zinc-50 shadow-sm text-sm">
                    Hủy bỏ
                </button>
                <button type="submit" class="px-5 py-2.5 bg-zinc-900 hover:bg-zinc-800 text-white font-bold rounded-md shadow-md text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7" />
                    </svg>
                    Lưu sản phẩm
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
                            <input type="text" name="name" required placeholder="VD: PC Gaming MSI Core i7..." class="w-full bg-zinc-50 border border-zinc-200 text-zinc-900 text-sm rounded-md focus:ring-primary focus:border-primary block p-3">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-zinc-700 mb-1.5">Cân nặng (Gram) <span class="text-zinc-400 font-medium text-xs">(Dùng tính phí GHTK)</span></label>
                            <input type="number" name="weight" value="500" placeholder="500" class="w-full bg-zinc-50 border border-zinc-200 text-zinc-900 text-sm rounded-md focus:ring-primary focus:border-primary block p-3">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-zinc-700 mb-1.5">Mô tả sản phẩm</label>
                            <textarea name="description" rows="5" placeholder="Viết một bài giới thiệu thật thu hút về bộ PC của bạn..." class="w-full bg-zinc-50 border border-zinc-200 text-zinc-900 text-sm rounded-md focus:ring-primary focus:border-primary block p-3"></textarea>
                        </div>
                    </div>
                </section>

                <section class="bg-white p-8 rounded-md border border-zinc-100 shadow-sm space-y-6">
                    <h2 class="text-[13px] font-black text-zinc-400 uppercase">Media (Cloudinary)</h2>

                    <div>
                        <label class="block text-sm font-bold text-zinc-700 mb-2">Ảnh đại diện chính <span class="text-red-500">*</span></label>
                        <div class="border-2 border-dashed border-zinc-200 bg-zinc-50 rounded-md p-6 text-center hover:bg-zinc-100 cursor-pointer group">
                            <input type="file" name="image" class="block w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 mx-auto max-w-[250px]" accept="image/*" required>
                        </div>
                    </div>

                    
                    <div>
                        <label class="block text-sm font-bold text-zinc-700 mb-2">Ảnh Gallery (Nhiều ảnh)</label>
                        <div class="border-2 border-dashed border-zinc-200 bg-zinc-50/50 rounded-md p-6 text-center hover:bg-zinc-100 cursor-pointer group">
                            <p class="text-xs text-zinc-400 font-medium mb-3">Có thể chọn nhiều bức ảnh cùng lúc để làm Slider cho Detail Page.</p>
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
                                        <label class="block text-xs font-bold text-zinc-500 mb-1">Tên phiên bản (VD: RAM 16GB, SSD 512GB)</label>
                                        <input type="text" :name="'variants['+index+'][variant_name]'" x-model="variant.name" placeholder="Bắt buộc" required class="w-full bg-white border border-zinc-200 text-zinc-900 text-sm rounded-md block p-2 focus:ring-primary focus:border-primary">
                                    </div>
                                    <div class="md:col-span-3">
                                        <label class="block text-xs font-bold text-zinc-500 mb-1">Mã SKU</label>
                                        <input type="text" :name="'variants['+index+'][sku]'" x-model="variant.sku" placeholder="MSI-I7" required class="w-full bg-white border border-zinc-200 text-zinc-900 text-sm rounded-md block p-2 uppercase focus:ring-primary focus:border-primary">
                                    </div>
                                    <div class="md:col-span-3">
                                        <label class="block text-xs font-bold text-zinc-500 mb-1">Giá bán (đ)</label>
                                        <input type="number" :name="'variants['+index+'][price]'" x-model="variant.price" placeholder="10.000.000" required class="w-full bg-white border border-zinc-200 text-zinc-900 text-sm rounded-md block p-2 focus:ring-primary focus:border-primary">
                                    </div>
                                    <div class="md:col-span-3">
                                        <label class="block text-xs font-bold text-zinc-500 mb-1">Giá KM (đ)</label>
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
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-zinc-700 mb-1.5">Thương hiệu</label>
                            <select name="brand_id" required class="w-full bg-white border border-zinc-200 text-zinc-900 text-sm rounded-md focus:ring-primary block p-3">
                                <option value="">-- Chọn thương hiệu --</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </form>
</div>

<script>
    function productForm() {
        return {
            variants: [{
                name: '',
                sku: '',
                price: '',
                sale_price: '',
                stock: ''
            }],
            addVariant() {
                this.variants.push({
                    name: '',
                    sku: '',
                    price: '',
                    sale_price: '',
                    stock: ''
                });
            },
            removeVariant(index) {
                if (this.variants.length > 1) {
                    this.variants.splice(index, 1);
                }
            }
        }
    }
</script>
@endsection