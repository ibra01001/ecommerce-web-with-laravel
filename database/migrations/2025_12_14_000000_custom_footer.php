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
        Schema::create('footers', function (Blueprint $table) {
            $table->id();
            
            // About Section
            $table->string('business_name')->nullable();
            $table->text('about_text')->nullable();
            
            // Contact Information
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            
            // Social Media Links
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('tiktok_url')->nullable();
            $table->string('whatsapp_number')->nullable();
            
            // Working Hours
            $table->string('working_hours')->nullable();
            $table->string('working_days')->nullable();
            
            // Copyright & Legal
            $table->string('copyright_text')->nullable();
            $table->text('terms_url')->nullable();
            $table->text('privacy_url')->nullable();
            $table->text('refund_policy_url')->nullable();
            
            // Newsletter
            $table->boolean('show_newsletter')->default(true);
            $table->string('newsletter_title')->nullable();
            $table->text('newsletter_description')->nullable();
            
            // Display Options
            $table->boolean('show_social_media')->default(true);
            $table->boolean('show_contact_info')->default(true);
            $table->boolean('show_quick_links')->default(true);
            
            // Custom Links (stored as JSON)
            $table->json('custom_links')->nullable();
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footers');
    }
};