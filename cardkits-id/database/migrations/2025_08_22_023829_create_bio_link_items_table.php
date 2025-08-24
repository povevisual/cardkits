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
        Schema::create('bio_link_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bio_link_id')->constrained()->onDelete('cascade');
            $table->string('title'); // Link title
            $table->text('url'); // Link URL
            $table->string('icon')->nullable(); // Icon (font awesome or custom)
            $table->string('thumbnail')->nullable(); // Thumbnail image
            $table->enum('type', ['link', 'social', 'email', 'phone', 'text', 'file'])->default('link');
            $table->text('description')->nullable(); // Link description
            $table->boolean('is_active')->default(true); // Active status
            $table->integer('order')->default(0); // Display order
            $table->boolean('open_in_new_tab')->default(true); // Open in new tab
            $table->boolean('track_clicks')->default(true); // Track click analytics
            $table->integer('click_count')->default(0); // Click counter
            $table->json('metadata')->nullable(); // Additional metadata
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bio_link_items');
    }
};
