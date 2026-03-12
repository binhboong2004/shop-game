<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $games = [
            ['name' => 'Liên Quân Mobile', 'slug' => 'lien-quan-mobile', 'description' => 'Game MOBA trên nền tảng di động', 'status' => 1],
            ['name' => 'Free Fire', 'slug' => 'free-fire', 'description' => 'Game Battle Royale mobile', 'status' => 1],
            ['name' => 'PUBG Mobile', 'slug' => 'pubg-mobile', 'description' => 'Game bắn súng sinh tồn', 'status' => 1],
            ['name' => 'Valorant', 'slug' => 'valorant', 'description' => 'Game FPS chiến thuật PC', 'status' => 1],
            ['name' => 'Genshin Impact', 'slug' => 'genshin-impact', 'description' => 'Game thế giới nhập vai', 'status' => 1],
            ['name' => 'Tốc Chiến', 'slug' => 'toc-chien', 'description' => 'Game MOBA mobile 2', 'status' => 1],
            ['name' => 'Roblox', 'slug' => 'roblox', 'description' => 'Game sáng tạo thế giới', 'status' => 1],
        ];

        foreach ($games as $game) {
            Game::create($game);
        }
    }
}
