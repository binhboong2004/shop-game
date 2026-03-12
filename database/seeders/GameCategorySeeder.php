<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GameCategory;
use App\Models\Game;
use Illuminate\Support\Str;

class GameCategorySeeder extends Seeder
{
    public function run(): void
    {
        $games = Game::all();
        if ($games->isEmpty()) return;

        $categories = [
            'Nick Rank Thách Đấu',
            'Nick Nhiều Skin Súng',
            'Nick Trắng Thông Tin',
            'Thử Vận May VIP',
            'Nick Random 50K',
            'Acc VIP Có Sẵn Tướng',
            'Nick Giá Rẻ Cho Học Sinh',
        ];

        foreach ($categories as $index => $name) {
            GameCategory::create([
                'game_id' => $games->random()->id,
                'name' => $name,
                'slug' => Str::slug($name) . '-' . $index,
                'description' => 'Danh mục ' . $name,
                'status' => 1,
            ]);
        }
    }
}
