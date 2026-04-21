<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    protected $cloudinaryService;

    public function __construct(CloudinaryService $cloudinaryService)
    {
        $this->cloudinaryService = $cloudinaryService;
    }

    public function index()
    {
        $banners = Banner::orderBy('order')->orderBy('id', 'desc')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'type' => 'required|in:slider,static',
            'link' => 'nullable|url',
            'order' => 'integer',
        ]);

        $banner = new Banner();
        $banner->type = $request->type;
        $banner->link = $request->link;
        $banner->order = $request->order ?? 0;
        $banner->is_active = $request->has('is_active');

        if ($request->hasFile('image_path')) {
            $uploadedImage = $this->cloudinaryService->upload($request->file('image_path')->getRealPath());
            $banner->image_path = $uploadedImage['secure_url'];
        }

        $banner->save();

        return redirect()->route('admin.banners.index')->with('success', 'Banner đã được thêm mới thành công.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'type' => 'required|in:slider,static',
            'link' => 'nullable|url',
            'order' => 'integer',
        ]);

        $banner->type = $request->type;
        $banner->link = $request->link;
        $banner->order = $request->order ?? 0;
        $banner->is_active = $request->has('is_active');

        if ($request->hasFile('image_path')) {
            $uploadedImage = $this->cloudinaryService->upload($request->file('image_path')->getRealPath());
            $banner->image_path = $uploadedImage['secure_url'];
        }

        $banner->save();

        return redirect()->route('admin.banners.index')->with('success', 'Banner đã được cập nhật thành công.');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner đã được xoá thành công.');
    }
}
