<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\User;
use Carbon\Carbon;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $admins = User::where('role', 'admin')->get();

        if ($admins->isEmpty()) {
            return;
        }

        for ($i = 1; $i <= 5; $i++) {
            Article::create([
                'title' => 'Tin tức nóng hổi số ' . $i,
                'slug' => 'tin-tuc-nong-hoi-so-' . $i,
                'content' => 'Nội dung chi tiết của bài viết tin tức số ' . $i . '. Cập nhật các tính năng và sự kiện mới nhất trên Shop.',
                'type' => rand(0, 1) ? 'news' : 'event',
                'status' => 'published',
                'author_id' => $admins->random()->id,
                'created_at' => Carbon::now()->subDays(rand(0, 30)),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
