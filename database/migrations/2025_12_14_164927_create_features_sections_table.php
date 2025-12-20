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
        // Main features section configuration
        Schema::create('features_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_title')->default('Why Choose Us');
            $table->text('section_description')->nullable();
            $table->enum('layout_style', ['grid', 'carousel', 'list'])->default('grid');
            $table->enum('columns', ['2', '3', '4'])->default('4');
            $table->string('background_color')->default('#f8fafc'); // Tailwind slate-50
            $table->boolean('show_section_title')->default(false);
            $table->boolean('show_section_description')->default(false);
            $table->integer('display_order')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Individual feature items
        Schema::create('feature_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('features_section_id')->constrained()->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            
            // Icon options
            $table->enum('icon_type', ['svg', 'svg_upload', 'image', 'emoji'])->default('svg');
            $table->text('icon_svg')->nullable(); // Store SVG code
            $table->string('icon_svg_path')->nullable(); // Store SVG file path
            $table->string('icon_image_path')->nullable(); // Store uploaded icon image
            $table->string('icon_emoji')->nullable(); // Store emoji
            $table->string('icon_color')->default('#0f172a'); // Tailwind slate-900
            
            // Visual customization
            $table->string('title_color')->default('#0f172a');
            $table->string('description_color')->default('#475569');
            $table->enum('alignment', ['left', 'center', 'right'])->default('center');
            
            // Link (optional)
            $table->string('link_url')->nullable();
            $table->string('link_text')->nullable();
            $table->boolean('open_in_new_tab')->default(false);
            
            // Ordering and visibility
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Brand story section (the bottom section)
        Schema::create('brand_story_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Crafted with Purpose');
            $table->text('description');
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->string('background_color')->default('#ffffff');
            $table->string('title_color')->default('#0f172a');
            $table->string('description_color')->default('#475569');
            $table->boolean('show_button')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feature_items');
        Schema::dropIfExists('features_sections');
        Schema::dropIfExists('brand_story_sections');
    }
};