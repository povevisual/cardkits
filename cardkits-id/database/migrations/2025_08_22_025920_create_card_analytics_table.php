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
        Schema::create('card_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('digital_card_id')->constrained()->onDelete('cascade');
            $table->foreignId('card_component_id')->nullable()->constrained()->onDelete('cascade');
            
            // Visitor Information
            $table->string('session_id')->nullable(); // Session identifier
            $table->string('visitor_id')->nullable(); // Unique visitor ID
            $table->string('ip_address')->nullable(); // Visitor IP address
            $table->string('user_agent')->nullable(); // Browser user agent
            $table->string('referrer')->nullable(); // Traffic source
            
            // Geographic Data
            $table->string('country')->nullable(); // Visitor country
            $table->string('region')->nullable(); // Visitor region/state
            $table->string('city')->nullable(); // Visitor city
            $table->string('timezone')->nullable(); // Visitor timezone
            
            // Device & Browser
            $table->string('device_type')->nullable(); // mobile, tablet, desktop
            $table->string('device_brand')->nullable(); // Apple, Samsung, etc.
            $table->string('device_model')->nullable(); // iPhone 12, Galaxy S21, etc.
            $table->string('browser')->nullable(); // Chrome, Firefox, Safari, etc.
            $table->string('browser_version')->nullable(); // Browser version
            $table->string('os')->nullable(); // Operating system
            $table->string('os_version')->nullable(); // OS version
            
            // Action Tracking
            $table->enum('action', [
                'view', 'click', 'download', 'share', 'book_appointment', 'submit_form', 'payment'
            ])->default('view');
            $table->string('action_target')->nullable(); // What was clicked/viewed
            $table->json('action_data')->nullable(); // Additional action data
            
            // Engagement Metrics
            $table->integer('time_on_page')->nullable(); // Time spent on page (seconds)
            $table->integer('scroll_depth')->nullable(); // Scroll depth percentage
            $table->json('interactions')->nullable(); // User interactions
            $table->boolean('converted')->default(false); // Conversion tracking
            
            // Performance Metrics
            $table->integer('page_load_time')->nullable(); // Page load time (ms)
            $table->string('connection_type')->nullable(); // 4G, WiFi, etc.
            $table->string('screen_resolution')->nullable(); // Screen resolution
            
            // Campaign & Marketing
            $table->string('utm_source')->nullable(); // UTM source
            $table->string('utm_medium')->nullable(); // UTM medium
            $table->string('utm_campaign')->nullable(); // UTM campaign
            $table->string('utm_term')->nullable(); // UTM term
            $table->string('utm_content')->nullable(); // UTM content
            
            // Business Intelligence
            $table->string('lead_score')->nullable(); // Lead scoring
            $table->string('customer_stage')->nullable(); // Customer journey stage
            $table->json('custom_attributes')->nullable(); // Custom tracking attributes
            
            // Timestamps
            $table->timestamp('action_at'); // When action occurred
            $table->timestamp('session_started_at')->nullable(); // Session start time
            $table->timestamp('session_ended_at')->nullable(); // Session end time
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['digital_card_id', 'action_at']);
            $table->index(['visitor_id', 'action_at']);
            $table->index(['action', 'action_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_analytics');
    }
};
