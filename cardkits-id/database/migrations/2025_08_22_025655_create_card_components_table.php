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
        Schema::create('card_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('digital_card_id')->constrained()->onDelete('cascade');
            
            // Component Information
            $table->string('name'); // Component name
            $table->string('type'); // text, image, video, html, map, social, button, divider, etc.
            $table->text('content')->nullable(); // Component content
            $table->string('icon')->nullable(); // Font Awesome icon
            $table->string('media_url')->nullable(); // Media file URL
            $table->string('media_alt')->nullable(); // Media alt text
            
            // Component Configuration
            $table->json('config')->nullable(); // Component-specific configuration
            $table->json('styling')->nullable(); // CSS styling options
            $table->json('animation')->nullable(); // Animation settings
            
            // Layout & Positioning
            $table->integer('order')->default(0); // Display order
            $table->string('position')->default('main'); // main, sidebar, footer
            $table->json('layout')->nullable(); // Layout constraints
            
            // Social Media (for social type)
            $table->string('social_platform')->nullable(); // Platform name
            $table->string('social_url')->nullable(); // Social media URL
            $table->string('social_username')->nullable(); // Username
            
            // Map Component (for map type)
            $table->string('map_address')->nullable(); // Address for map
            $table->decimal('map_latitude', 10, 8)->nullable(); // Latitude
            $table->decimal('map_longitude', 11, 8)->nullable(); // Longitude
            $table->string('map_zoom')->nullable(); // Map zoom level
            
            // Video Component (for video type)
            $table->string('video_provider')->nullable(); // YouTube, Vimeo, etc.
            $table->string('video_id')->nullable(); // Video ID
            $table->string('video_thumbnail')->nullable(); // Thumbnail image
            $table->boolean('video_autoplay')->default(false); // Autoplay setting
            
            // HTML Component (for html type)
            $table->text('html_content')->nullable(); // Raw HTML content
            $table->boolean('html_sanitized')->default(true); // Sanitized HTML
            
            // Button Component (for button type)
            $table->string('button_text')->nullable(); // Button text
            $table->string('button_url')->nullable(); // Button URL
            $table->string('button_style')->default('primary'); // Button style
            $table->boolean('button_new_tab')->default(false); // Open in new tab
            
            // Contact Form (for form type)
            $table->json('form_fields')->nullable(); // Form field configuration
            $table->string('form_action')->nullable(); // Form submission URL
            $table->string('form_method')->default('POST'); // Form method
            
            // Status & Visibility
            $table->boolean('is_active')->default(true); // Component visibility
            $table->boolean('is_required')->default(false); // Required component
            $table->json('visibility_rules')->nullable(); // Conditional visibility
            
            // Analytics
            $table->integer('click_count')->default(0); // Click tracking
            $table->timestamp('last_clicked_at')->nullable(); // Last click time
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_components');
    }
};
