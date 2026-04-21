<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand', 'variants', 'primaryImage']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('variants', function ($v) use ($search) {
                        $v->where('sku', 'like', "%{$search}%");
                    });
            });
        }

        $products = $query->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function edit($id)
    {
        $product = Product::with(['variants', 'images'])->findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'variants' => 'required|array|min:1',
            'variants.*.variant_name' => 'required|string',
            'variants.*.sku' => 'required|string|unique:product_variants,sku,' . $id . ',product_id',
            'variants.*.price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'gallery.*' => 'nullable|image|max:2048'
        ]);

        DB::transaction(function () use ($request, $product) {
            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'weight' => $request->weight ?? 500,
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'status' => $request->status,
                'is_active' => $request->has('is_active') ? 1 : 0,
            ]);

            if ($request->hasFile('image')) {
                $product->images()->where('is_primary', true)->delete();

                $filePath = $request->file('image')->getRealPath();
                $uploadResult = app('App\Services\CloudinaryService')->upload($filePath);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $uploadResult['secure_url'],
                    'is_primary' => true
                ]);
            }

            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $galleryFile) {
                    $gFilePath = $galleryFile->getRealPath();
                    $gUploadResult = app('App\Services\CloudinaryService')->upload($gFilePath);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $gUploadResult['secure_url'],
                        'is_primary' => false
                    ]);
                }
            }

            $product->variants()->delete();
            foreach ($request->variants as $variant) {
                $product->variants()->create([
                    'variant_name' => $variant['variant_name'],
                    'sku' => $variant['sku'],
                    'price' => $variant['price'],
                    'sale_price' => $variant['sale_price'] ?? null,
                    'stock' => $variant['stock'] ?? 0,
                ]);
            }
        });

        return redirect()->route('admin.products.index')->with('success', 'Đã cập nhật sản phẩm thành công!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Đã xóa sản phẩm! Bạn có thể khôi phục trong mục Thùng rác.');
    }

    public function trash(Request $request)
    {
        $query = Product::onlyTrashed()->with(['category', 'brand', 'primaryImage']);

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $products = $query->latest('deleted_at')->paginate(10);
        return view('admin.products.trash', compact('products'));
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('admin.products.trash')->with('success', "Đã khôi phục sản phẩm '{$product->name}' thành công!");
    }

    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);
        $image->delete();
        return back()->with('success', 'Đã xóa ảnh khỏi gallery!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'variants' => 'required|array|min:1',
            'variants.*.variant_name' => 'required|string',
            'variants.*.sku' => 'required|string|unique:product_variants,sku',
            'variants.*.price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'gallery.*' => 'nullable|image|max:2048'
        ]);
        DB::transaction(function () use ($request) {
            $product = Product::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name) . '-' . uniqid(),
                'description' => $request->description,
                'weight' => $request->weight ?? 500,
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'status' => $request->status ?? 1,
                'is_active' => true,
            ]);
            if ($request->hasFile('image')) {
                $filePath = $request->file('image')->getRealPath();
                $uploadResult = app('App\Services\CloudinaryService')->upload($filePath);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $uploadResult['secure_url'],
                    'is_primary' => true
                ]);
            }

            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $galleryFile) {
                    $gFilePath = $galleryFile->getRealPath();
                    $gUploadResult = app('App\Services\CloudinaryService')->upload($gFilePath);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $gUploadResult['secure_url'],
                        'is_primary' => false
                    ]);
                }
            }
            foreach ($request->variants as $variant) {
                $product->variants()->create([
                    'variant_name' => $variant['variant_name'],
                    'sku' => $variant['sku'],
                    'price' => $variant['price'],
                    'sale_price' => $variant['sale_price'] ?? null,
                    'stock' => $variant['stock'] ?? 0,
                ]);
            }
        });
        return redirect()->route('admin.products.index')->with('success', 'Tạo sản phẩm thành công!');
    }
}
