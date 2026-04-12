<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Upgrade reviews table when an older "empty" create_reviews migration already ran.
     */
    public function up(): void
    {
        if (! Schema::hasTable('reviews') || Schema::hasColumn('reviews', 'product_id')) {
            return;
        }

        Schema::table('reviews', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('rating');
            $table->text('body')->nullable();
            $table->boolean('is_approved')->default(false);

            $table->unique(['user_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('reviews') || ! Schema::hasColumn('reviews', 'product_id')) {
            return;
        }

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['user_id']);
            $table->dropUnique(['user_id', 'product_id']);
            $table->dropColumn(['product_id', 'user_id', 'rating', 'body', 'is_approved']);
        });
    }
};
