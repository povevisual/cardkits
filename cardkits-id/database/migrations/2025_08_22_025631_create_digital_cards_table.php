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
        Schema::create('digital_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('card_template_id')->constrained()->onDelete('cascade');
            
            // Basic Information
            $table->string('title'); // Card title
            $table->string('slug')->unique(); // URL slug
            $table->text('description')->nullable(); // Card description
            
            // Personal Information
            $table->string('first_name');
            $table->string('last_name');
            $table->string('job_title')->nullable();
            $table->string('company')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->text('bio')->nullable();
            
            // Address Information
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            
            // Media & Assets
            $table->string('profile_photo')->nullable(); // Profile image
            $table->string('cover_photo')->nullable(); // Cover image
            $table->string('logo')->nullable(); // Company logo
            
            // Design & Customization
            $table->json('color_scheme'); // Selected color scheme
            $table->json('layout_config'); // Layout configuration
            $table->json('component_config'); // Component settings
            $table->string('custom_css')->nullable(); // Custom CSS
            
            // Settings & Features
            $table->boolean('is_active')->default(true); // Card visibility
            $table->boolean('is_public')->default(true); // Public access
            $table->string('password')->nullable(); // Password protection
            $table->boolean('show_analytics')->default(true); // Analytics display
            $table->boolean('show_qr_code')->default(true); // QR code display
            $table->boolean('enable_vcard')->default(true); // vCard download
            $table->boolean('enable_pwa')->default(true); // PWA support
            
            // Domain & Branding
            $table->string('custom_domain')->nullable(); // Custom domain
            $table->boolean('white_label')->default(false); // Remove branding
            $table->string('custom_branding')->nullable(); // Custom branding
            
            // SEO & Meta
            $table->string('meta_title')->nullable(); // SEO title
            $table->text('meta_description')->nullable(); // SEO description
            $table->json('meta_keywords')->nullable(); // SEO keywords
            $table->json('og_data')->nullable(); // Open Graph data
            $table->json('structured_data')->nullable(); // JSON-LD data
            
            // Analytics
            $table->integer('view_count')->default(0); // Total views
            $table->integer('download_count')->default(0); // vCard downloads
            $table->timestamp('last_viewed_at')->nullable(); // Last view time
            
            // Subscription & Billing
            $table->string('subscription_plan')->nullable(); // Current plan
            $table->timestamp('subscription_expires_at')->nullable(); // Plan expiry
            
            $table->timestamps();
            $table->softDeletes(); // Soft delete support
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digital_cards');
    }
};
