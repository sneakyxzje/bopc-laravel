<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('--- Starting Demo Data Seeding ---');

        // 1. Tạo 5 User khách hàng
        $users = [];
        $userNames = ['Nguyễn Văn A', 'Trần Thị B', 'Lê Văn C', 'Phạm Minh D', 'Hoàng Thị E'];
        
        foreach ($userNames as $index => $name) {
            $email = 'khachhang' . ($index + 1) . '@example.com';
            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'is_active' => true,
                ]
            );
            $users[] = $user;
            $this->command->info("Created user: {$email}");
        }

        // 2. Lấy danh sách sản phẩm hiện có
        $products = Product::with('variants')->get();
        if ($products->isEmpty()) {
            $this->command->error('No products found in database. Please run ProductSeeder first.');
            return;
        }

        $reviews_pool = [
            'Sản phẩm rất tốt, đóng gói kỹ càng, giao hàng nhanh.',
            'Máy chạy cực nhanh, chơi game rất mượt, rất hài lòng!',
            'Đáng đồng tiền bát gạo, đội ngũ kỹ thuật hỗ trợ nhiệt tình.',
            'Cấu hình mạnh trong tầm giá, build PC rất chắc chắn.',
            'Màn hình hiển thị đẹp, màu sắc trung thực chuẩn gaming.',
            'Linh kiện chính hãng, bảo hành đầy đủ, yên tâm khi mua hàng.',
            'Tư vấn viên nhiệt tình, giải đáp mọi thắc mắc của mình.',
            'Sẽ tiếp tục ủng hộ shop trong tương lai.',
        ];

        // 3. Với mỗi User, tạo 1-2 đơn hàng COD đã hoàn thành
        foreach ($users as $user) {
            $numOrders = rand(1, 2);
            
            for ($i = 0; $i < $numOrders; $i++) {
                $orderProducts = $products->random(rand(1, 2));
                $shippingFee = rand(30000, 100000);
                $subtotal = 0;

                // Tạo Order trước để lấy ID
                $order = Order::create([
                    'user_id' => $user->id,
                    'full_name' => $user->name,
                    'phone' => '09' . rand(10000000, 99999999),
                    'province' => 'Hà Nội',
                    'district' => 'Quận Cầu Giấy',
                    'ward' => 'Phường Dịch Vọng',
                    'address' => rand(1, 200) . ' Đường Xuân Thủy',
                    'shipping_fee' => $shippingFee,
                    'note' => 'Giao hàng giờ hành chính',
                    'total_price' => 0, // Sẽ update sau
                    'payment_method' => 'cod',
                    'payment_status' => Order::PAYMENT_PAID, // COD hoàn thành nên coi như đã trả
                    'status' => Order::STATUS_COMPLETED,
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);

                foreach ($orderProducts as $product) {
                    $variant = $product->variants->first(); // Lấy variant đầu tiên cho đơn giản
                    if (!$variant) continue;

                    $qty = rand(1, 2);
                    $price = $variant->sale_price ?? $variant->price;
                    
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'variant_id' => $variant->id,
                        'quantity' => $qty,
                        'price' => $price,
                    ]);

                    $subtotal += ($price * $qty);

                    // 4. Tạo đánh giá cho sản phẩm này từ user này
                    ProductReview::updateOrCreate(
                        ['user_id' => $user->id, 'product_id' => $product->id],
                        [
                            'rating' => rand(4, 5),
                            'comment' => $reviews_pool[array_rand($reviews_pool)],
                            'status' => 'active',
                            'created_at' => $order->created_at->addDays(rand(1, 5)),
                        ]
                    );
                }

                $order->update(['total_price' => $subtotal + $shippingFee]);
                $this->command->info("Created completed COD order #{$order->id} for user {$user->name}");
            }
        }

        $this->command->info('--- Demo Data Seeding Completed Successfully ---');
    }
}
