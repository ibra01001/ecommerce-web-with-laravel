<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create the themes table
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('primary_color', 7)->default('#3b82f6');
            $table->string('secondary_color', 7)->default('#8b5cf6');
            $table->string('background_color', 7)->default('#ffffff');
            $table->string('text_color', 7)->default('#000000');
            $table->string('font_family', 100)->default('Inter');
            $table->enum('mode', ['light', 'dark'])->default('light');
            
            // Separate active flags for light & dark modes
            $table->boolean('is_active_light')->default(false);
            $table->boolean('is_active_dark')->default(false);
            
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index('mode');
            $table->index('is_active_light');
            $table->index('is_active_dark');
        });

        // Insert default light theme (active for light mode)
        DB::table('themes')->insert([
            'name' => 'Default Light',
            'primary_color' => '#3b82f6',
            'secondary_color' => '#8b5cf6',
            'background_color' => '#ffffff',
            'text_color' => '#000000',
            'font_family' => 'Inter',
            'mode' => 'light',
            'is_active_light' => true,
            'is_active_dark' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert default dark theme (active for dark mode)
        DB::table('themes')->insert([
            'name' => 'Default Dark',
            'primary_color' => '#60a5fa',
            'secondary_color' => '#a78bfa',
            'background_color' => '#0f172a',
            'text_color' => '#ffffff',
            'font_family' => 'Inter',
            'mode' => 'dark',
            'is_active_light' => false,
            'is_active_dark' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert additional light theme (Ocean Blue - inactive)
        DB::table('themes')->insert([
            'name' => 'Ocean Blue',
            'primary_color' => '#0891b2',
            'secondary_color' => '#06b6d4',
            'background_color' => '#f0f9ff',
            'text_color' => '#0c4a6e',
            'font_family' => 'Inter',
            'mode' => 'light',
            'is_active_light' => false,
            'is_active_dark' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert additional dark theme (Midnight Blue - inactive)
        DB::table('themes')->insert([
            'name' => 'Midnight Blue',
            'primary_color' => '#3b82f6',
            'secondary_color' => '#60a5fa',
            'background_color' => '#1e293b',
            'text_color' => '#e2e8f0',
            'font_family' => 'Inter',
            'mode' => 'dark',
            'is_active_light' => false,
            'is_active_dark' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};