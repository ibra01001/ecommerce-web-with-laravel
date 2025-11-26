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
            $table->decimal('price', 8, 2);
            $table->integer('quantity')->default(0); // Total quantity
            $table->integer('taille_S')->default(0);
            $table->integer('taille_M')->default(0);
            $table->integer('taille_L')->default(0);
            $table->integer('taille_XL')->default(0);
            $table->integer('taille_XXL')->default(0);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('category_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};