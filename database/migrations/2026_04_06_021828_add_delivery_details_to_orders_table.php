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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('delivery_person_name')->nullable()->after('payment_status');
            $table->string('delivery_person_phone')->nullable()->after('delivery_person_name');
            $table->timestamp('shipped_at')->nullable()->after('delivery_person_phone');
            $table->string('estimated_delivery_time')->nullable()->after('shipped_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['delivery_person_name', 'delivery_person_phone', 'shipped_at', 'estimated_delivery_time']);
        });
    }
};
