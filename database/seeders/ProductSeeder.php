<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'PC GAMING' => 'pc-gaming',
            'PC WORKSTATION' => 'workstation',
            'PC AMD GAMING' => 'amd-gaming',
            'PC MINI' => 'pc-mini',
            'PC OFFICE' => 'office',
            'Linh kiện máy tính' => 'parts',
        ];

        $catModels = [];
        foreach ($categories as $name => $slug) {
            $catModels[$slug] = Category::updateOrCreate(['slug' => $slug], ['name' => $name]);
        }

        $brands = [
            'Intel' => 'intel',
            'AMD' => 'amd',
            'NVIDIA' => 'nvidia',
            'ASUS' => 'asus',
            'MSI' => 'msi',
            'Gigabyte' => 'gigabyte',
            'Corsair' => 'corsair',
            'Kingston' => 'kingston',
            'Samsung' => 'samsung',
        ];

        $brandModels = [];
        foreach ($brands as $name => $slug) {
            $brandModels[$slug] = Brand::updateOrCreate(['slug' => $slug], ['name' => $name]);
        }

        $products = [
            [
                'name' => 'PC Gaming i9 14900K | RTX 4090 | 64GB DDR5',
                'category' => 'pc-gaming',
                'brand' => 'asus',
                'desc' => 'Cấu hình tối thượng cho game thủ chuyên nghiệp với các tùy chọn tản nhiệt và lưu trữ.',
                'variants' => [
                    ['name' => 'Standard Edition (Air Cool)', 'price' => 125000000, 'sale_price' => 119900000, 'stock' => 5],
                    ['name' => 'Liquid Cooling Special Edition', 'price' => 135000000, 'sale_price' => 129000000, 'stock' => 2],
                    ['name' => 'Ultimate 4TB SSD Upgrade', 'price' => 145000000, 'sale_price' => 139000000, 'stock' => 1],
                ]
            ],
            [
                'name' => 'PC Gaming i5 13400F | RTX 3060 | 16GB RAM',
                'category' => 'pc-gaming',
                'brand' => 'msi',
                'desc' => 'PC Gaming quốc dân tầm trung, cân mọi game eSports. Lựa chọn dung lượng RAM.',
                'variants' => [
                    ['name' => 'Build 16GB RAM', 'price' => 18500000, 'sale_price' => 16900000, 'stock' => 15],
                    ['name' => 'Upgrade 32GB RAM', 'price' => 19500000, 'sale_price' => 17900000, 'stock' => 10],
                ]
            ],
            [
                'name' => 'PC AMD Gaming R7 7800X3D | RX 7900 XTX',
                'category' => 'amd-gaming',
                'brand' => 'amd',
                'desc' => 'Sự kết hợp hoàn hảo từ đội đỏ AMD cho hiệu năng chơi game 4K.',
                'variants' => [
                    ['name' => 'Ultimate Red (RX 7900 XTX)', 'price' => 85000000, 'sale_price' => 82000000, 'stock' => 3],
                    ['name' => 'Mid-tier Red (RX 7900 XT)', 'price' => 75000000, 'sale_price' => 71000000, 'stock' => 5],
                ]
            ],
            [
                'name' => 'PC Workstation Dual Xeon E5-2696 v4 | 128GB RAM',
                'category' => 'workstation',
                'brand' => 'intel',
                'desc' => 'Chuyên dụng cho render 3D, giả lập và cắm nhiều NoxPlayer.',
                'variants' => [
                    ['name' => 'Base Config (128GB RAM)', 'price' => 45000000, 'sale_price' => 42000000, 'stock' => 8],
                    ['name' => 'Max Config (256GB RAM)', 'price' => 55000000, 'sale_price' => 49900000, 'stock' => 3],
                ]
            ],
            [
                'name' => 'ASUS ROG NUC | i9-14900KF | RTX 4070',
                'category' => 'pc-mini',
                'brand' => 'asus',
                'desc' => 'Sức mạnh khổng lồ trong thân xác nhỏ bé.',
                'variants' => [
                    ['name' => 'Phantom Canyon (RTX 4070)', 'price' => 55000000, 'sale_price' => 53000000, 'stock' => 10],
                ]
            ],
            [
                'name' => 'PC Văn Phòng i3 12100 | 8GB RAM | 256GB SSD',
                'category' => 'office',
                'brand' => 'intel',
                'desc' => 'Mượt mà cho các tác vụ Office, kế toán.',
                'variants' => [
                    ['name' => 'Standard (8GB/256GB)', 'price' => 7500000, 'sale_price' => 6900000, 'stock' => 50],
                    ['name' => 'Pro (16GB/512GB)', 'price' => 8900000, 'sale_price' => 8200000, 'stock' => 30],
                ]
            ],
            [
                'name' => 'CPU Intel Core i7-14700K',
                'category' => 'parts',
                'brand' => 'intel',
                'desc' => 'CPU hiệu năng cao cho Gaming và làm việc đời mới nhất.',
                'variants' => [
                    ['name' => 'Box Chính Hãng (VSPC)', 'price' => 11500000, 'sale_price' => 10900000, 'stock' => 30],
                    ['name' => 'Tray (Tiết kiệm)', 'price' => 10500000, 'sale_price' => 9990000, 'stock' => 20],
                ]
            ],
            [
                'name' => 'VGA MSI RTX 4070 Ti GAMING X SLIM',
                'category' => 'parts',
                'brand' => 'msi',
                'desc' => 'Card đồ họa mỏng nhẹ, hiệu năng cực đỉnh cho case nhỏ.',
                'variants' => [
                    ['name' => '12GB GDDR6X Black', 'price' => 24500000, 'sale_price' => 23500000, 'stock' => 12],
                    ['name' => '12GB GDDR6X White Edition', 'price' => 25500000, 'sale_price' => 24500000, 'stock' => 5],
                ]
            ],
        ];

        foreach ($products as $pData) {
            $product = Product::updateOrCreate(
                ['slug' => Str::slug($pData['name'])],
                [
                    'category_id' => $catModels[$pData['category']]->id,
                    'brand_id'    => $brandModels[$pData['brand']]->id,
                    'name'        => $pData['name'],
                    'description' => $pData['desc'],
                    'is_active'   => true
                ]
            );

            foreach ($pData['variants'] as $vData) {
                ProductVariant::updateOrCreate(
                    ['product_id' => $product->id, 'variant_name' => $vData['name']],
                    [
                        'sku' => strtoupper(substr($pData['brand'], 0, 3)) . '-' . rand(10000, 99999),
                        'price' => $vData['price'],
                        'sale_price' => $vData['sale_price'],
                        'stock' => $vData['stock'],
                    ]
                );
            }
        }



        echo "--- Seeded Diverse Products & Variants Successfully! ---\n";
    }
}
