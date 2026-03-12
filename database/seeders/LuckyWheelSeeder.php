<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LuckyWheelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lienQuan = \App\Models\Game::where('slug', 'lien-quan-mobile')->first();
        $roblox = \App\Models\Game::where('slug', 'roblox')->first();

        $wheels = [
            [
                'game_id' => $lienQuan->id ?? 1,
                'name' => 'Vòng Quay Quân Huy Đặc Biệt',
                'image' => 'https://ui-avatars.com/api/?name=VQ+1&background=random&size=200',
                'price' => 20000,
                'status' => true,
                'description' => 'Cơ hội nhận hàng ngàn quân huy miễn phí mỗi ngày.',
            ],
            [
                'game_id' => $lienQuan->id ?? 1,
                'name' => 'Vòng Quay Nick VIP Liên Quân',
                'image' => 'https://ui-avatars.com/api/?name=VQ+2&background=random&size=200',
                'price' => 50000,
                'status' => true,
                'description' => 'Sở hữu ngay nick VIP full set trang phục cực hiếm.',
            ],
            [
                'game_id' => $roblox->id ?? 7,
                'name' => 'Vòng Quay Robux Trúng Đậm',
                'image' => 'https://ui-avatars.com/api/?name=VQ+3&background=random&size=200',
                'price' => 10000,
                'status' => true,
                'description' => 'Nạp Robux siêu tốc, uy tín 100%.',
            ]
        ];

        foreach ($wheels as $wheel) {
            \App\Models\LuckyWheel::create($wheel);
        }
    }
}
