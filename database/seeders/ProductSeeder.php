<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $cpu = Category::create(['name' => 'CPU - Bộ vi xử lý', 'slug' => 'cpu-bo-vi-xu-ly']);
        $vga = Category::create(['name' => 'VGA - Card màn hình', 'slug' => 'vga-card-man-hinh']);

        $intel = Brand::create(['name' => 'Intel', 'slug' => 'intel', 'logo_path' => 'intel.png']);
        $asus = Brand::create(['name' => 'ASUS', 'slug' => 'asus', 'logo_path' => 'asus.png']);

        $p1 = Product::create([
            'category_id' => $cpu->id,
            'brand_id'    => $intel->id,
            'name'        => 'Intel Core i9-14900K',
            'slug'        => Str::slug('Intel Core i9-14900K'),
            'description' => 'CPU đầu bảng của Intel thế hệ 14',
            'is_active'   => true
        ]);

        ProductVariant::create([
            'product_id'   => $p1->id,
            'variant_name' => 'Box Chính Hãng',
            'sku'          => 'I9-14900K-BOX',
            'price'        => 15500000,
            'sale_price'   => 14900000,
            'stock'        => 10,
        ]);

        $p2 = Product::create([
            'category_id' => $vga->id,
            'brand_id'    => $asus->id,
            'name'        => 'ASUS ROG Strix RTX 4090',
            'slug'        => Str::slug('ASUS ROG Strix RTX 4090'),
            'description' => 'Quái vật đồ họa từ nhà ASUS',
            'is_active'   => true
        ]);

        ProductVariant::create([
            'product_id'   => $p2->id,
            'variant_name' => 'OC Edition 24GB',
            'sku'          => 'RTX4090-OC-24G',
            'price'        => 55000000,
            'sale_price'   => 53500000,
            'stock'        => 5,
        ]);

        $user = User::first() ?? User::create([
            'name'     => 'User Test',
            'email'    => 'test@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        if ($user) {
            $order = Order::create([
                'user_id'         => $user->id,
                'total_price'     => 14900000,
                'status'          => Order::STATUS_PENDING,
                'payment_method'  => 'vnpay',
                'payment_status'  => Order::PAYMENT_UNPAID,
                'full_name'       => 'Ngô Tuấn Đạt',
                'phone'           => '0987654321',
                'note' => 'Giao cho tôi vào giờ hành chính, hỗ trợ tôi lắp đặt',
                'address'         => 'Hà Nội, Việt Nam',
            ]);

            echo "--- Created Order #{$order->id} for testing ---\n";
        }

        echo "--- Seeded Products & Variants Successfully! ---\n";
    }
}
