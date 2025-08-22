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
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            
            // Language Information
            $table->string('name'); // Language name (English, Arabic, etc.)
            $table->string('code', 5)->unique(); // Language code (en, ar, etc.)
            $table->string('native_name')->nullable(); // Native language name
            $table->string('flag')->nullable(); // Flag emoji or image
            
            // Language Settings
            $table->boolean('is_active')->default(true); // Language availability
            $table->boolean('is_default')->default(false); // Default language
            $table->boolean('is_rtl')->default(false); // Right-to-left support
            $table->string('date_format')->default('Y-m-d'); // Date format
            $table->string('time_format')->default('H:i'); // Time format
            $table->string('number_format')->default('1,234.56'); // Number format
            
            // Localization
            $table->string('timezone')->default('UTC'); // Default timezone
            $table->string('currency')->default('USD'); // Default currency
            $table->json('currency_format')->nullable(); // Currency formatting
            
            // Translation Files
            $table->string('translation_file')->nullable(); // Translation file path
            $table->boolean('is_translated')->default(false); // Translation status
            $table->decimal('translation_percentage', 5, 2)->default(0); // Translation completeness
            
            // Display Settings
            $table->integer('sort_order')->default(0); // Display order
            $table->boolean('show_in_picker')->default(true); // Show in language picker
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
