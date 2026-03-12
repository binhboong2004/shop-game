<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attribute;
use App\Models\Game;

class AttributeSeeder extends Seeder
{
    public function run(): void
    {


        $gameLQ = Game::where('slug', 'lien-quan-mobile')->first();
        $gameFF = Game::where('slug', 'free-fire')->first();

        if ($gameLQ) {
            Attribute::create(['game_id' => $gameLQ->id, 'name' => 'Rank', 'type' => 'select', 'options' => ['Đồng', 'Bạc', 'Vàng', 'Bạch Kim', 'Kim Cương', 'Tinh Anh', 'Cao Thủ', 'Thách Đấu']]);
            Attribute::create(['game_id' => $gameLQ->id, 'name' => 'Số Lượng Tướng', 'type' => 'number', 'options' => null]);
            Attribute::create(['game_id' => $gameLQ->id, 'name' => 'Số Lượng Skin', 'type' => 'number', 'options' => null]);
            Attribute::create(['game_id' => $gameLQ->id, 'name' => 'Skin VIP', 'type' => 'text', 'options' => null]);
        }

        if ($gameFF) {
            Attribute::create(['game_id' => $gameFF->id, 'name' => 'Level VIP', 'type' => 'number', 'options' => null]);
            Attribute::create(['game_id' => $gameFF->id, 'name' => 'Pet', 'type' => 'select', 'options' => ['Có', 'Không']]);
            Attribute::create(['game_id' => $gameFF->id, 'name' => 'Skin Súng Tím', 'type' => 'number', 'options' => null]);
        }
    }
}
