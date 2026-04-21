<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount('products')->latest()->get();
        return view('admin.brands.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:1024'
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $filePath = $request->file('logo')->getRealPath();
            $uploadResult = app('App\Services\CloudinaryService')->upload($filePath);
            $logoPath = $uploadResult['secure_url'];
        }

        Brand::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . uniqid(),
            'logo_path' => $logoPath
        ]);

        return back()->with('success', 'Đã thêm thương hiệu mới!');
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:1024'
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . uniqid(),
        ];

        if ($request->hasFile('logo')) {
            $filePath = $request->file('logo')->getRealPath();
            $uploadResult = app('App\Services\CloudinaryService')->upload($filePath);
            $data['logo_path'] = $uploadResult['secure_url'];
        }

        $brand->update($data);

        return back()->with('success', 'Đã cập nhật thương hiệu!');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        
        if ($brand->products()->count() > 0) {
            return back()->with('error', 'Không thể xóa thương hiệu đang có sản phẩm!');
        }

        $brand->delete();
        return back()->with('success', 'Đã xóa thương hiệu!');
    }
}
