<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Services\CloudinaryService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * ProductSeeder - Tự động upload ảnh local lên Cloudinary
 *
 * Cách dùng:
 *   1. Tạo thư mục: storage/app/seed-images/
 *   2. Đặt ảnh vào thư mục đó, tên file tương ứng với 'image_file' bên dưới
 *      VD: pc-gaming-1.jpg, laptop-1.jpg, monitor-1.jpg, ...
 *   3. Chạy: php artisan db:seed --class=ProductSeeder
 */
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $cloudinary = app(CloudinaryService::class);

        // Xóa data cũ để tránh trùng slug
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\ProductImage::truncate();
        \App\Models\ProductVariant::truncate();
        \App\Models\Product::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // =====================================================
        // 1. CATEGORIES
        // =====================================================
        $categories = [
            'PC GAMING'          => 'pc-gaming',
            'PC WORKSTATION'     => 'workstation',
            'PC AMD GAMING'      => 'amd-gaming',
            'PC MINI'            => 'pc-mini',
            'PC OFFICE'          => 'office',
            'Laptop Gaming'      => 'laptop-gaming',
            'Màn hình'           => 'monitors',
            'Linh kiện máy tính' => 'parts',
        ];
        $catModels = [];
        foreach ($categories as $name => $slug) {
            $catModels[$slug] = Category::updateOrCreate(['slug' => $slug], ['name' => $name]);
        }

        // =====================================================
        // 2. BRANDS
        // =====================================================
        $brands = [
            'Intel'    => 'intel',
            'AMD'      => 'amd',
            'NVIDIA'   => 'nvidia',
            'ASUS'     => 'asus',
            'MSI'      => 'msi',
            'Gigabyte' => 'gigabyte',
            'Corsair'  => 'corsair',
            'Kingston' => 'kingston',
            'Samsung'  => 'samsung',
            'LG'       => 'lg',
            'Dell'     => 'dell',
        ];
        $brandModels = [];
        foreach ($brands as $name => $slug) {
            $brandModels[$slug] = Brand::updateOrCreate(['slug' => $slug], ['name' => $name]);
        }

        // =====================================================
        // 3. PRODUCTS
        // 'image_file' = tên file ảnh trong storage/app/seed-images/
        // Nếu file không tồn tại, sản phẩm vẫn được tạo, chỉ bỏ qua ảnh.
        // =====================================================
        $products = [
            // ---------- PC GAMING ----------
            [
                'name'       => 'PC Gaming i9 14900K | RTX 4090 | 64GB DDR5',
                'category'   => 'pc-gaming',
                'brand'      => 'asus',
                'image_file' => 'pc-gaming-1.jpg',
                'desc'       => 'Cấu hình tối thượng cho game thủ chuyên nghiệp. Tản nhiệt nước AIO 360mm, RAM DDR5 6000MHz XMP, SSD Gen4 PCIe 2TB.',
                'variants'   => [
                    ['sku' => 'ASUS-4090-AIR', 'name' => 'Air Cooling Edition',      'price' => 125000000, 'sale_price' => 119900000, 'stock' => 5],
                    ['sku' => 'ASUS-4090-360', 'name' => 'AIO 360mm Liquid Cooling', 'price' => 135000000, 'sale_price' => 129000000, 'stock' => 2],
                    ['sku' => 'ASUS-4090-4TB', 'name' => 'Ultimate 4TB SSD Upgrade', 'price' => 145000000, 'sale_price' => 139000000, 'stock' => 1],
                ],
            ],
            [
                'name'       => 'PC Gaming i5 13400F | RTX 3060 | 16GB RAM',
                'category'   => 'pc-gaming',
                'brand'      => 'msi',
                'image_file' => 'pc-gaming-2.jpg',
                'desc'       => 'PC Gaming quốc dân tầm trung, cân mọi game eSports 1080p ultra. Tản nhiệt khí cao cấp, PSU 80+ Bronze 650W.',
                'variants'   => [
                    ['sku' => 'MSI-3060-16G', 'name' => 'Build 16GB RAM',   'price' => 18500000, 'sale_price' => 16900000, 'stock' => 15],
                    ['sku' => 'MSI-3060-32G', 'name' => 'Upgrade 32GB RAM', 'price' => 19500000, 'sale_price' => 17900000, 'stock' => 10],
                ],
            ],
            [
                'name'       => 'PC Gaming RTX 4070 Super | i7-14700F | 32GB',
                'category'   => 'pc-gaming',
                'brand'      => 'gigabyte',
                'image_file' => 'pc-gaming-3.jpg',
                'desc'       => 'Cân 2K/4K cực mượt với RTX 4070 Super và bộ nhớ GDDR6X 12GB. Hiệu năng gaming đỉnh cao trong tầm tiền.',
                'variants'   => [
                    ['sku' => 'GBT-4070S-32', 'name' => 'Standard 32GB',  'price' => 45000000, 'sale_price' => 42000000, 'stock' => 8],
                    ['sku' => 'GBT-4070S-64', 'name' => 'Pro 64GB DDR5',  'price' => 50000000, 'sale_price' => 47500000, 'stock' => 4],
                ],
            ],

            // ---------- AMD GAMING ----------
            [
                'name'       => 'PC AMD Gaming R7 7800X3D | RX 7900 XTX',
                'category'   => 'amd-gaming',
                'brand'      => 'amd',
                'image_file' => 'amd-gaming-1.jpg',
                'desc'       => 'Sự kết hợp hoàn hảo từ Team Red. R7 7800X3D với công nghệ 3D V-Cache đột phá, RX 7900 XTX 24GB GDDR6.',
                'variants'   => [
                    ['sku' => 'AMD-7900X-XTX', 'name' => 'Ultimate Red (RX 7900 XTX)', 'price' => 85000000, 'sale_price' => 82000000, 'stock' => 3],
                    ['sku' => 'AMD-7900X-XT',  'name' => 'Mid-tier Red (RX 7900 XT)',  'price' => 75000000, 'sale_price' => 71000000, 'stock' => 5],
                ],
            ],
            [
                'name'       => 'PC AMD Gaming Ryzen 5 7600X | RX 7700 XT',
                'category'   => 'amd-gaming',
                'brand'      => 'amd',
                'image_file' => 'amd-gaming-2.jpg',
                'desc'       => 'Combo AMD Zen 4 tầm trung hoàn hảo. Chơi mượt 1440p với chi phí hợp lý nhất thị trường.',
                'variants'   => [
                    ['sku' => 'AMD-76X-7700B', 'name' => '16GB DDR5 Base', 'price' => 25000000, 'sale_price' => 23500000, 'stock' => 12],
                    ['sku' => 'AMD-76X-7700P', 'name' => '32GB DDR5 Pro',  'price' => 27000000, 'sale_price' => 25500000, 'stock' => 7],
                ],
            ],

            // ---------- PC WORKSTATION ----------
            [
                'name'       => 'PC Workstation Dual Xeon | 128GB ECC RAM | Quadro RTX',
                'category'   => 'workstation',
                'brand'      => 'intel',
                'image_file' => 'workstation-1.jpg',
                'desc'       => 'Chuyên dụng cho render 3D, AI, Data Science. Hỗ trợ ECC RAM, bộ nhớ khủng và ổn định tuyệt đối 24/7.',
                'variants'   => [
                    ['sku' => 'WS-XEON-128', 'name' => 'Base Config 128GB ECC', 'price' => 45000000, 'sale_price' => 42000000, 'stock' => 8],
                    ['sku' => 'WS-XEON-256', 'name' => 'Max Config 256GB ECC',  'price' => 55000000, 'sale_price' => 49900000, 'stock' => 3],
                ],
            ],

            // ---------- PC MINI ----------
            [
                'name'       => 'ASUS ROG NUC | i9-14900KF | RTX 4070',
                'category'   => 'pc-mini',
                'brand'      => 'asus',
                'image_file' => 'pc-mini-1.jpg',
                'desc'       => 'Sức mạnh khổng lồ trong thân xác nhỏ bé. PC Mini gaming nhỏ gọn nhưng cực kỳ mạnh mẽ.',
                'variants'   => [
                    ['sku' => 'ROG-NUC-4070', 'name' => 'Phantom Canyon RTX 4070', 'price' => 55000000, 'sale_price' => 53000000, 'stock' => 10],
                ],
            ],

            // ---------- PC OFFICE ----------
            [
                'name'       => 'PC Văn Phòng Intel i3 12100 | 8GB | 256GB SSD',
                'category'   => 'office',
                'brand'      => 'intel',
                'image_file' => 'pc-office-1.jpg',
                'desc'       => 'Mạnh mẽ, bền bỉ và tiết kiệm điện cho các tác vụ văn phòng, kế toán, học tập hàng ngày.',
                'variants'   => [
                    ['sku' => 'OFF-I3-8G256',  'name' => 'Standard 8GB/256GB', 'price' => 7500000, 'sale_price' => 6900000, 'stock' => 50],
                    ['sku' => 'OFF-I3-16G512', 'name' => 'Pro 16GB/512GB',     'price' => 8900000, 'sale_price' => 8200000, 'stock' => 30],
                ],
            ],
            [
                'name'       => 'PC Văn Phòng AMD Ryzen 3 4300G | 8GB | 512GB',
                'category'   => 'office',
                'brand'      => 'amd',
                'image_file' => 'pc-office-2.jpg',
                'desc'       => 'Tích hợp đồ họa AMD Radeon, không cần VGA rời. Lý tưởng cho văn phòng và học sinh sinh viên.',
                'variants'   => [
                    ['sku' => 'OFF-R3-8G512',  'name' => 'Standard 8GB/512GB', 'price' => 7000000, 'sale_price' => 6500000, 'stock' => 40],
                    ['sku' => 'OFF-R3-16G1TB', 'name' => 'Pro 16GB/1TB',       'price' => 8500000, 'sale_price' => 7800000, 'stock' => 20],
                ],
            ],

            // ---------- LAPTOP GAMING ----------
            [
                'name'       => 'Laptop Gaming ASUS ROG Strix G16 | RTX 4060 | i7 13650HX',
                'category'   => 'laptop-gaming',
                'brand'      => 'asus',
                'image_file' => 'laptop-1.jpg',
                'desc'       => 'Màn hình 165Hz QHD, tản nhiệt Tri-Fan, bàn phím RGB per-key. Đỉnh cao laptop gaming tầm trung.',
                'variants'   => [
                    ['sku' => 'ROG-G16-4060-16G', 'name' => '16GB RAM / 512GB SSD', 'price' => 32000000, 'sale_price' => 29900000, 'stock' => 10],
                    ['sku' => 'ROG-G16-4060-32G', 'name' => '32GB RAM / 1TB SSD',   'price' => 36000000, 'sale_price' => 33500000, 'stock' => 5],
                ],
            ],
            [
                'name'       => 'Laptop Gaming MSI Katana 15 | RTX 4070 | i7 13620H',
                'category'   => 'laptop-gaming',
                'brand'      => 'msi',
                'image_file' => 'laptop-2.jpg',
                'desc'       => 'Mỏng nhẹ, hiệu năng mạnh mẽ. Tấm nền 144Hz FHD, Cooler Boost 5, bàn phím per-key RGB.',
                'variants'   => [
                    ['sku' => 'MSI-KAT-4070-16', 'name' => '16GB DDR5 / 1TB NVMe', 'price' => 38000000, 'sale_price' => 35500000, 'stock' => 8],
                    ['sku' => 'MSI-KAT-4070-32', 'name' => '32GB DDR5 / 2TB NVMe', 'price' => 43000000, 'sale_price' => 40000000, 'stock' => 3],
                ],
            ],

            // ---------- MONITORS ----------
            [
                'name'       => 'Màn hình LG UltraGear 27" | 2K QHD 165Hz | IPS',
                'category'   => 'monitors',
                'brand'      => 'lg',
                'image_file' => 'monitor-1.jpg',
                'desc'       => 'Tấm nền IPS 1ms (GtG), AMD FreeSync Premium, NVIDIA G-Sync Compatible. Màu sắc chính xác, đẹp mắt.',
                'variants'   => [
                    ['sku' => 'LG-27QHD-165', 'name' => '27" 2K 165Hz IPS', 'price' => 7500000, 'sale_price' => 6900000, 'stock' => 25],
                ],
            ],
            [
                'name'       => 'Màn hình Samsung Odyssey G7 32" | 4K 144Hz | VA',
                'category'   => 'monitors',
                'brand'      => 'samsung',
                'image_file' => 'monitor-2.jpg',
                'desc'       => 'Màn hình cong 1000R, HDR600, tái tạo màu đen sâu thẳm với tấm nền VA. Lý tưởng cho gaming và multimedia.',
                'variants'   => [
                    ['sku' => 'SAM-G7-32-4K', 'name' => '32" 4K 144Hz VA Curved', 'price' => 15000000, 'sale_price' => 13500000, 'stock' => 12],
                ],
            ],

            // ---------- LINH KIỆN ----------
            [
                'name'       => 'CPU Intel Core i7-14700K',
                'category'   => 'parts',
                'brand'      => 'intel',
                'image_file' => 'cpu-1.jpg',
                'desc'       => '20 nhân (8P + 12E), Boost 5.6GHz. Hiệu năng đỉnh cao cho cả Gaming và Workload đa luồng.',
                'variants'   => [
                    ['sku' => 'CPU-I714K-BOX',  'name' => 'Box Chính Hãng (VSPC)', 'price' => 11500000, 'sale_price' => 10900000, 'stock' => 30],
                    ['sku' => 'CPU-I714K-TRAY', 'name' => 'Tray (Tiết kiệm)',      'price' => 10500000, 'sale_price' => 9990000,  'stock' => 20],
                ],
            ],
            [
                'name'       => 'VGA MSI RTX 4070 Ti GAMING X SLIM 12GB',
                'category'   => 'parts',
                'brand'      => 'msi',
                'image_file' => 'vga-1.jpg',
                'desc'       => 'Card đồ họa mỏng nhẹ 2.5 slot, hiệu năng cực đỉnh. Lý tưởng cho case ITX hoặc Mid-Tower nhỏ gọn.',
                'variants'   => [
                    ['sku' => 'VGA-4070TI-BLK', 'name' => '12GB GDDR6X Black Edition', 'price' => 24500000, 'sale_price' => 23500000, 'stock' => 12],
                    ['sku' => 'VGA-4070TI-WHT', 'name' => '12GB GDDR6X White Edition', 'price' => 25500000, 'sale_price' => 24500000, 'stock' => 5],
                ],
            ],
            [
                'name'       => 'RAM Corsair Vengeance DDR5 32GB (2x16GB) 6000MHz',
                'category'   => 'parts',
                'brand'      => 'corsair',
                'image_file' => 'ram-1.jpg',
                'desc'       => 'Kit RAM DDR5 hiệu năng cao với tản nhiệt nhôm cao cấp. Hỗ trợ XMP 3.0, tương thích Intel 13th/14th Gen.',
                'variants'   => [
                    ['sku' => 'RAM-COR-32-6K', 'name' => '32GB DDR5 6000MHz Black', 'price' => 3800000, 'sale_price' => 3500000, 'stock' => 50],
                    ['sku' => 'RAM-COR-64-6K', 'name' => '64GB DDR5 6000MHz Black', 'price' => 7200000, 'sale_price' => 6800000, 'stock' => 20],
                ],
            ],
            [
                'name'       => 'SSD Samsung 990 Pro NVMe Gen4 1TB/2TB',
                'category'   => 'parts',
                'brand'      => 'samsung',
                'image_file' => 'ssd-1.jpg',
                'desc'       => 'Tốc độ đọc 7,450 MB/s, ghi 6,900 MB/s. SSD PCIe 4.0 nhanh nhất của Samsung dành cho gaming.',
                'variants'   => [
                    ['sku' => 'SSD-990PRO-1T', 'name' => '1TB PCIe 4.0 NVMe', 'price' => 2800000, 'sale_price' => 2500000, 'stock' => 60],
                    ['sku' => 'SSD-990PRO-2T', 'name' => '2TB PCIe 4.0 NVMe', 'price' => 5200000, 'sale_price' => 4800000, 'stock' => 35],
                ],
            ],
        ];

        // =====================================================
        // 4. SEED PRODUCTS + AUTO UPLOAD ẢNH LÊN CLOUDINARY
        // =====================================================
        $seedImageDir = storage_path('app/seed-images');

        foreach ($products as $index => $pData) {
            $this->command->info("[{$index}] Đang seed: {$pData['name']}");

            $product = Product::create([
                'slug'        => Str::slug($pData['name']),
                'category_id' => $catModels[$pData['category']]->id,
                'brand_id'    => $brandModels[$pData['brand']]->id,
                'name'        => $pData['name'],
                'description' => $pData['desc'],
                'is_active'   => true,
            ]);

            // Upload ảnh từ thư mục local lên Cloudinary
            $imageFile = $pData['image_file'] ?? null;
            $imagePath = $imageFile ? $seedImageDir . DIRECTORY_SEPARATOR . $imageFile : null;

            if ($imagePath && file_exists($imagePath)) {
                try {
                    $uploadResult = $cloudinary->upload($imagePath);
                    $imageUrl     = $uploadResult['secure_url'];

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $imageUrl,
                        'is_primary' => true,
                    ]);

                    $this->command->info("   ✓ Upload thành công: {$imageFile}");
                } catch (\Exception $e) {
                    $this->command->warn("   ✗ Upload thất bại ({$imageFile}): " . $e->getMessage());
                }
            } else {
                $this->command->warn("   ⚠ Không tìm thấy file: storage/app/seed-images/{$imageFile}");
                $this->command->warn("     → Sản phẩm vẫn được tạo, chỉ bỏ qua ảnh.");
            }

            // Seed các variants
            foreach ($pData['variants'] as $vData) {
                ProductVariant::create([
                    'product_id'   => $product->id,
                    'sku'          => $vData['sku'],
                    'variant_name' => $vData['name'],
                    'price'        => $vData['price'],
                    'sale_price'   => $vData['sale_price'],
                    'stock'        => $vData['stock'],
                ]);
            }

            $this->command->line('');
        }

        $this->command->info('✅ Seeded ' . count($products) . ' sản phẩm thành công!');
        $this->command->info("📁 Thư mục ảnh: {$seedImageDir}");
    }
}
