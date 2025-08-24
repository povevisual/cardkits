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
        // Create roles table
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Role name
            $table->string('slug')->unique(); // Role identifier
            $table->text('description')->nullable(); // Role description
            $table->string('type')->default('user'); // user, admin, super_admin
            $table->boolean('is_active')->default(true); // Role availability
            $table->integer('sort_order')->default(0); // Display order
            $table->json('permissions')->nullable(); // Default permissions
            $table->timestamps();
        });

        // Create permissions table
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Permission name
            $table->string('slug')->unique(); // Permission identifier
            $table->string('module'); // Module name (cards, analytics, billing, etc.)
            $table->text('description')->nullable(); // Permission description
            $table->string('action'); // create, read, update, delete, manage
            $table->boolean('is_active')->default(true); // Permission availability
            $table->timestamps();
        });

        // Create user_roles pivot table
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->dateTime('assigned_at'); // When role was assigned
            $table->dateTime('expires_at')->nullable(); // Role expiration
            $table->string('assigned_by')->nullable(); // Who assigned the role
            $table->text('notes')->nullable(); // Assignment notes
            $table->timestamps();
            
            $table->unique(['user_id', 'role_id']);
        });

        // Create role_permissions pivot table
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->foreignId('permission_id')->constrained()->onDelete('cascade');
            $table->boolean('is_granted')->default(true); // Grant or deny permission
            $table->json('constraints')->nullable(); // Permission constraints
            $table->timestamps();
            
            $table->unique(['role_id', 'permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
        Schema::dropIfExists('user_roles');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};
