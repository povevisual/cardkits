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
        Schema::create('bio_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title')->nullable(); // Profile title
            $table->text('description')->nullable(); // Bio description
            $table->string('profile_photo')->nullable(); // Profile photo URL
            $table->string('background_photo')->nullable(); // Background photo URL
            $table->string('theme_color')->default('#000000'); // Theme color
            $table->string('text_color')->default('#ffffff'); // Text color
            $table->string('button_color')->default('#007bff'); // Button color
            $table->string('button_text_color')->default('#ffffff'); // Button text color
            $table->string('font_family')->default('Inter'); // Font family
            $table->boolean('show_social_icons')->default(true); // Show social icons
            $table->boolean('show_analytics')->default(false); // Show analytics
            $table->string('custom_domain')->nullable(); // Custom domain
            $table->string('slug')->unique(); // URL slug
            $table->boolean('is_active')->default(true); // Active status
            $table->integer('view_count')->default(0); // View counter
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bio_links');
    }
};
