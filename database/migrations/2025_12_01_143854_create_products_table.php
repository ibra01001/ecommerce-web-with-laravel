<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('image')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            
            // Old stock columns (for backward compatibility)
            $table->enum('stock_type', ['size-based', 'total'])->default('total');
            $table->integer('total_quantity')->default(0);
            $table->integer('taille_S')->default(0);
            $table->integer('taille_M')->default(0);
            $table->integer('taille_L')->default(0);
            $table->integer('taille_XL')->default(0);
            $table->integer('taille_XXL')->default(0);
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};