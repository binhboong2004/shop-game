<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            UserSeeder::class,
            GameSeeder::class,
            GameCategorySeeder::class,
            AttributeSeeder::class,
            AccountSeeder::class,
            AccountAttributeSeeder::class,
            SettingSeeder::class,
            OrderSeeder::class,
            DepositCategorySeeder::class,
            DepositSeeder::class,
            WithdrawalSeeder::class,
            DiscountCodeSeeder::class,
            TicketSeeder::class,
            WheelSeeder::class,
            ArticleSeeder::class,
            LuckyWheelSeeder::class,
        ]);
    }
}
