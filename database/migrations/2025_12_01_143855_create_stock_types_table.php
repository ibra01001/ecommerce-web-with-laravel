<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('display_type', ['grid', 'dropdown', 'color-swatch', 'none'])->default('grid');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_types');
    }
};