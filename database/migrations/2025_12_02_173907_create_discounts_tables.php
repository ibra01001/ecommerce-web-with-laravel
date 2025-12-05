<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            
            // Discount type and value
            $table->enum('type', ['percentage', 'fixed']);
            $table->decimal('value', 10, 2);
            
            // Conditions
            $table->decimal('min_purchase', 10, 2)->nullable();
            $table->decimal('max_discount', 10, 2)->nullable();
            
            // Usage limits
            $table->integer('usage_limit')->nullable();
            $table->integer('usage_count')->default(0);
            $table->integer('per_user_limit')->nullable();
            
            // Validity
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            
            // Applicability
            $table->boolean('applies_to_all')->default(true);
            $table->json('category_ids')->nullable();
            $table->json('product_ids')->nullable();
            
            // Status
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });

        // Track discount usage per user
        Schema::create('discount_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discount_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('session_id')->nullable();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->decimal('discount_amount', 10, 2);
            $table->timestamp('used_at');
            
            $table->index(['discount_id', 'user_id']);
            $table->index(['discount_id', 'session_id']);
        });

        // Add discount columns to orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('discount_id')->nullable()->after('total')->constrained()->onDelete('set null');
            $table->string('discount_code')->nullable()->after('discount_id');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('discount_code');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['discount_id']);
            $table->dropColumn(['discount_id', 'discount_code', 'discount_amount']);
        });
        
        Schema::dropIfExists('discount_user');
        Schema::dropIfExists('discounts');
    }
};