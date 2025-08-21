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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('title');
            $table->string('company');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->text('address')->nullable();
            $table->text('bio')->nullable();
            $table->text('photo')->nullable(); // Base64 encoded image
            $table->enum('template', ['modern', 'classic', 'creative', 'minimal'])->default('modern');
            $table->enum('color_scheme', ['blue', 'green', 'purple', 'orange', 'red'])->default('blue');
            $table->boolean('is_public')->default(true);
            $table->integer('views')->default(0);
            $table->integer('shares')->default(0);
            $table->integer('downloads')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};