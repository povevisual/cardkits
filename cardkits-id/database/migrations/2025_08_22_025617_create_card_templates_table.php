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
        Schema::create('card_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Template name
            $table->string('slug')->unique(); // Template identifier
            $table->text('description')->nullable(); // Template description
            $table->string('category'); // business, creative, minimal, modern, etc.
            $table->json('color_schemes'); // Array of 4-5 color schemes
            $table->json('layout_config'); // Layout configuration
            $table->json('component_config'); // Component configuration
            $table->string('preview_image')->nullable(); // Template preview image
            $table->boolean('is_active')->default(true); // Template availability
            $table->boolean('is_premium')->default(false); // Premium template
            $table->integer('sort_order')->default(0); // Display order
            $table->json('metadata')->nullable(); // Additional template data
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_templates');
    }
};
