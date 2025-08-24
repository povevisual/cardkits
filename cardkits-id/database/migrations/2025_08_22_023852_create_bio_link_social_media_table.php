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
        Schema::create('bio_link_social_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bio_link_id')->constrained()->onDelete('cascade');
            $table->enum('platform', [
                'instagram', 'facebook', 'twitter', 'youtube', 'tiktok', 
                'linkedin', 'github', 'spotify', 'twitch', 'discord',
                'telegram', 'whatsapp', 'snapchat', 'pinterest', 'reddit'
            ]);
            $table->string('username'); // Social media username
            $table->string('url'); // Full social media URL
            $table->string('icon')->nullable(); // Platform icon
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bio_link_social_media');
    }
};
