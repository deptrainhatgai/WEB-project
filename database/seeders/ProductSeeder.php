<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Bánh sinh nhật K1',
                'price' => 123000,
                'image_path' => 'img/anh1.png',
                // 'category' => 'Bánh Sinh Nhật',
                'sold_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Bánh sinh nhật K2',
                'price' => 223000,
                'image_path' => 'img/anh2.png',
                // 'category' => 'Bánh Sinh Nhật',
                'sold_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Bánh Sinh Nhật K3',
                'price' => 423000,
                'image_path' => 'img/anh3.png',
                // 'category' => 'Bánh Sinh Nhật',
                'sold_count' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Bánh sinh nhật K4',
                'price' => 0,
                'image_path' => 'img/anh4.png',
                // 'category' => 'Bánh Sinh Nhật',
                'sold_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Bánh Sự Kiện
            [
                'name' => 'Bánh Cưới Mẫu 1',
                'price' => 123000,
                'image_path' => 'img/anh5.png',
                // 'category' => 'Bánh Sự Kiện',
                'sold_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Bánh Cưới Mẫu 2',
                'price' => 223000,
                'image_path' => 'img/anh6.png',
                // 'category' => 'Bánh Sự Kiện',
                'sold_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Bánh Cưới Mẫu 3',
                'price' => 123000,
                'image_path' => 'img/anh7.png',
                // 'category' => 'Bánh Sự Kiện',
                'sold_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Bánh Cưới Mẫu 4',
                'price' => 223000,
                'image_path' => 'img/anh8.png',
                // 'category' => 'Bánh Sự Kiện',
                'sold_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Thêm các sản phẩm khác tương tự
        ];

        DB::table('products')->insert($products);
    }
}
