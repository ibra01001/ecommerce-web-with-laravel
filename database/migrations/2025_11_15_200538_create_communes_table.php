<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('communes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('wilaya_id')->constrained()->onDelete('cascade');
            $table->string('code', 2)->nullable();
            $table->timestamps();
            
            $table->index('wilaya_id');
            $table->index('code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('communes');
    }
};