<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_type_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_type_id')->constrained()->onDelete('cascade');
            $table->string('label'); // e.g., "S", "M", "L", "1kg", "2kg", "Red", "Blue"
            $table->string('value')->nullable(); // Optional value field for colors (#FF0000) or other data
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_type_options');
    }
};