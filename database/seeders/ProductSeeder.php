<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    // Seeder 1 vài seed product để test
    public function run(): void
    {
        $cpu = Category::create(['name' => 'CPU - Bộ vi xử lý', 'slug' => 'cpu-bo-vi-xu-ly']);
        $vga = Category::create(['name' => 'VGA - Card màn hình', 'slug' => 'vga-card-man-hinh']);
        $ram = Category::create(['name' => 'RAM - Bộ nhớ trong', 'slug' => 'ram-bo-nho-trong']);

        $intel = Brand::create(['name' => 'Intel', 'slug' => 'intel', 'logo_path' => 'intel.png']);
        $asus = Brand::create(['name' => 'ASUS', 'slug' => 'asus', 'logo_path' => 'asus.png']);
        $nvidia = Brand::create(['name' => 'NVIDIA', 'slug' => 'nvidia', 'logo_path' => 'nvidia.png']);

        Product::create([
            'category_id' => $cpu->id,
            'brand_id' => $intel->id,
            'name' => 'Intel Core i9-14900K',
            'slug' => Str::slug('Intel Core i9-14900K'),
            'price' => 15500000,
            'sale_price' => 14900000,
            'stock' => 10,
            'description' => 'CPU đầu bảng của Intel thế hệ 14',
            'is_active' => true
        ]);

        Product::create([
            'category_id' => $vga->id,
            'brand_id' => $asus->id,
            'name' => 'ASUS ROG Strix RTX 4090',
            'slug' => Str::slug('ASUS ROG Strix RTX 4090'),
            'price' => 55000000,
            'stock' => 5,
            'description' => 'Quái vật đồ họa từ nhà ASUS',
            'is_active' => true
        ]);

        $p1 = Product::where('slug', 'intel-core-i9-14900k')->first();
        if ($p1) {
            $p1->attributes()->createMany([
                ['name' => 'Số nhân', 'value' => '24'],
                ['name' => 'Số luồng', 'value' => '32'],
                ['name' => 'Xung nhịp', 'value' => '5.8 GHz'],
            ]);
        }

        $user = \App\Models\User::first();
        if ($user) {
            $order = \App\Models\Order::create([
                'user_id' => $user->id,
                'total_price' => 15500000,
                'status' => 'pending',
                'payment_method' => 'cod',
                'shipping_address' => 'Hà Nội, Việt Nam',
            ]);

            $order->items()->create([
                'product_id' => $p1->id,
                'quantity' => 1,
                'price' => 15500000,
            ]);
        }

        echo "--- Add seeder successfully! ---\n";
    }
}
