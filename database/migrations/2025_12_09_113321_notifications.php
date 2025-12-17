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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'low_stock', 'out_of_stock', 'new_order', 'order_status_change'
            $table->string('title');
            $table->text('message');
            $table->string('link')->nullable(); // URL to relevant page
            $table->enum('priority', ['high', 'medium', 'low'])->default('medium');
            $table->boolean('is_read')->default(false);
            $table->foreignId('related_id')->nullable(); // product_id, order_id, etc.
            $table->string('related_type')->nullable(); // 'product', 'order'
            $table->timestamps();
            
            $table->index(['is_read', 'created_at']);
            $table->index('type');
        });

        // Add low_stock_threshold to products table
        Schema::table('products', function (Blueprint $table) {
            $table->integer('low_stock_threshold')->default(5)->after('stock_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
        
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('low_stock_threshold');
        });
    }
};