<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Withdrawal;
use App\Models\User;
use Carbon\Carbon;

class WithdrawalSeeder extends Seeder
{
    public function run(): void
    {
        $agents = User::where('role', 'agent')->get();

        if ($agents->isEmpty()) {
            return;
        }

        $statuses = ['pending', 'approved', 'rejected'];

        for ($i = 0; $i < 10; $i++) {
            Withdrawal::create([
                'agent_id' => $agents->random()->id,
                'amount' => rand(10, 100) * 10000,
                'bank_name' => 'Vietcombank',
                'account_number' => '0123456789',
                'account_name' => 'NGUYEN VAN A',
                'note' => 'Rut tien ban nick',
                'status' => $statuses[array_rand($statuses)],
                'created_at' => Carbon::now()->subDays(rand(0, 15)),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
