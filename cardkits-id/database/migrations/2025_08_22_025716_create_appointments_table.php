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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('digital_card_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Card owner
            
            // Appointment Details
            $table->string('title'); // Appointment title
            $table->text('description')->nullable(); // Appointment description
            $table->string('type')->default('meeting'); // meeting, call, consultation, etc.
            $table->integer('duration')->default(30); // Duration in minutes
            
            // Scheduling
            $table->dateTime('start_time'); // Start time
            $table->dateTime('end_time'); // End time
            $table->string('timezone')->default('UTC'); // Timezone
            $table->string('location')->nullable(); // Physical location
            $table->string('meeting_url')->nullable(); // Virtual meeting URL
            
            // Client Information
            $table->string('client_name'); // Client name
            $table->string('client_email'); // Client email
            $table->string('client_phone')->nullable(); // Client phone
            $table->text('client_notes')->nullable(); // Client notes
            
            // Status Management
            $table->enum('status', [
                'pending', 'confirmed', 'rescheduled', 'cancelled', 'completed', 'no_show'
            ])->default('pending');
            $table->string('status_notes')->nullable(); // Status change notes
            
            // Calendar Integration
            $table->string('calendar_event_id')->nullable(); // External calendar ID
            $table->string('calendar_provider')->nullable(); // Google, Outlook, etc.
            $table->json('calendar_data')->nullable(); // Calendar-specific data
            
            // Reminders & Notifications
            $table->json('reminders')->nullable(); // Reminder settings
            $table->boolean('send_reminders')->default(true); // Enable reminders
            $table->timestamp('last_reminder_sent_at')->nullable(); // Last reminder time
            
            // Payment & Pricing
            $table->decimal('price', 10, 2)->nullable(); // Appointment price
            $table->string('currency')->default('USD'); // Currency
            $table->string('payment_status')->default('pending'); // paid, pending, failed
            $table->string('payment_method')->nullable(); // Payment method used
            
            // Booking Settings
            $table->boolean('requires_confirmation')->default(false); // Manual confirmation needed
            $table->boolean('allow_rescheduling')->default(true); // Allow rescheduling
            $table->boolean('allow_cancellation')->default(true); // Allow cancellation
            $table->integer('cancellation_hours')->default(24); // Hours before appointment for cancellation
            
            // Analytics
            $table->integer('view_count')->default(0); // Times viewed
            $table->timestamp('last_viewed_at')->nullable(); // Last view time
            
            $table->timestamps();
            $table->softDeletes(); // Soft delete support
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
