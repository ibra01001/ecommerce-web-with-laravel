<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->longText('content');
            $table->string('image')->nullable();
            $table->string('mission_title')->nullable();
            $table->text('mission_content')->nullable();
            $table->string('vision_title')->nullable();
            $table->text('vision_content')->nullable();
            $table->json('team_members')->nullable(); // Will store name, position, bio, and photo path
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('about_us');
    }
};