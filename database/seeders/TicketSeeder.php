<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;
use Carbon\Carbon;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::whereIn('role', ['member', 'agent'])->get();
        $admins = User::where('role', 'admin')->get();

        if ($users->isEmpty() || $admins->isEmpty()) {
            return;
        }

        $statuses = ['open', 'processing', 'resolved', 'closed'];

        for ($i = 0; $i < 10; $i++) {
            $ticket = Ticket::create([
                'user_id' => $users->random()->id,
                'subject' => 'Hỗ trợ nạp tiền lỗi ' . $i,
                'content' => 'Tôi nạp tiền nhưng chưa thấy cộng vào tài khoản.',
                'status' => $statuses[array_rand($statuses)],
                'assigned_to' => rand(0, 1) ? $admins->random()->id : null,
                'created_at' => Carbon::now()->subDays(rand(0, 10)),
                'updated_at' => Carbon::now(),
            ]);

            if ($ticket->status !== 'open') {
                TicketReply::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $admins->random()->id,
                    'message' => 'Chúng tôi đang kiểm tra giao dịch của bạn. Vui lòng đợi nhé!',
                    'created_at' => Carbon::now()->subDays(rand(0, 10))->addHours(1),
                    'updated_at' => Carbon::now()->subDays(rand(0, 10))->addHours(1),
                ]);
            }
        }
    }
}
