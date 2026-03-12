<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('users')->insert([
            [
                'name' => 'Administrator',
                'email' => 'admin@admin.com',
                'password' => Hash::make('123456'),
                'phone' => '0123456789',
                'role' => 'admin',
                'balance' => 9999999,
                'status' => 'active',
                'is_verified' => true,
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Đại lý ABC',
                'email' => 'agent@shop.com',
                'password' => Hash::make('123456'),
                'phone' => '0987654321',
                'role' => 'agent',
                'balance' => 5000000,
                'status' => 'active',
                'is_verified' => true,
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Thành viên 1',
                'email' => 'member1@gmail.com',
                'password' => Hash::make('123456'),
                'phone' => '0333444555',
                'role' => 'member',
                'balance' => 100000,
                'status' => 'active',
                'is_verified' => true,
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
