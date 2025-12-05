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
        Schema::table('products', function (Blueprint $table) {
            // Add stock_type_id column if it doesn't exist
            if (!Schema::hasColumn('products', 'stock_type_id')) {
                $table->foreignId('stock_type_id')
                    ->nullable()
                    ->after('category_id')
                    ->constrained('stock_types')
                    ->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'stock_type_id')) {
                $table->dropForeign(['stock_type_id']);
                $table->dropColumn('stock_type_id');
            }
        });
    }
};