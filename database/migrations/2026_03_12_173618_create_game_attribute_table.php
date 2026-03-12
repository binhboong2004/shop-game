<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('game_attribute', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade');
            $table->foreignId('attribute_id')->constrained('attributes')->onDelete('cascade');
            $table->timestamps();
        });

        // Di chuyển dữ liệu cũ từ bảng attributes sang game_attribute
        $attributes = \DB::table('attributes')->get();
        foreach ($attributes as $attribute) {
            if ($attribute->game_id) {
                \DB::table('game_attribute')->insert([
                    'game_id' => $attribute->game_id,
                    'attribute_id' => $attribute->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Xóa cột game_id ở bảng attributes sau khi đã di chuyển dữ liệu
        Schema::table('attributes', function (Blueprint $table) {
            $table->dropForeign(['game_id']);
            $table->dropColumn('game_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Khôi phục cột game_id ở bảng attributes
        Schema::table('attributes', function (Blueprint $table) {
            $table->foreignId('game_id')->nullable()->constrained('games')->onDelete('cascade');
        });

        // Di chuyển ngược lại (chỉ lấy 1 game đầu tiên)
        $relations = \DB::table('game_attribute')->get();
        foreach ($relations as $rel) {
            \DB::table('attributes')
                ->where('id', $rel->attribute_id)
                ->update(['game_id' => $rel->game_id]);
        }

        Schema::dropIfExists('game_attribute');
    }
};
