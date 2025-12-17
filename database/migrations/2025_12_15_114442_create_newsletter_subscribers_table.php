<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{


public function up(): void
{
    Schema::create('newsletter_subscribers', function (Blueprint $table) {
        $table->id();
        $table->string('email')->unique();
        $table->timestamps();
    });
}
public function down(): void
{
    Schema::dropIfExists('newsletter_subscribers');
}   
};