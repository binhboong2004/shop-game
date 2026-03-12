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
        Schema::table('deposits', function (Blueprint $table) {
            $table->foreignId('deposit_category_id')->nullable()->after('user_id')->constrained('deposit_categories')->onDelete('set null');
            $table->decimal('received_amount', 15, 2)->nullable()->after('amount');
            if (Schema::hasColumn('deposits', 'method')) {
                $table->dropColumn('method');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropForeign(['deposit_category_id']);
            $table->dropColumn(['deposit_category_id', 'received_amount']);
            $table->enum('method', ['bank', 'card', 'momo'])->after('amount')->nullable();
        });
    }
};
