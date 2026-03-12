<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WheelPrize;
use App\Models\WheelHistory;
use App\Models\User;
use Carbon\Carbon;

class WheelSeeder extends Seeder
{
    public function run(): void
    {
        $prizes = [
            ['name' => '10.000 VNĐ', 'type' => 'coin', 'value' => 10000, 'probability' => 30.0],
            ['name' => '50.000 VNĐ', 'type' => 'coin', 'value' => 50000, 'probability' => 10.0],
            ['name' => 'Nick Random CQ', 'type' => 'item', 'value' => 0, 'probability' => 5.0],
            ['name' => 'Chúc bạn may mắn', 'type' => 'empty', 'value' => 0, 'probability' => 55.0],
        ];

        foreach ($prizes as $prize) {
            WheelPrize::create($prize);
        }

        $users = User::where('role', 'member')->get();
        $createdPrizes = WheelPrize::all();

        if ($users->isNotEmpty() && $createdPrizes->isNotEmpty()) {
            for ($i = 0; $i < 20; $i++) {
                WheelHistory::create([
                    'user_id' => $users->random()->id,
                    'prize_id' => $createdPrizes->random()->id,
                    'spin_cost' => 10000,
                    'created_at' => Carbon::now()->subDays(rand(0, 5)),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
