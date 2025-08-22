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
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('subscription_plan_id')->constrained()->onDelete('cascade');
            
            // Subscription Details
            $table->string('status')->default('active'); // active, cancelled, expired, suspended
            $table->dateTime('start_date'); // Subscription start date
            $table->dateTime('end_date'); // Subscription end date
            $table->dateTime('trial_ends_at')->nullable(); // Trial end date
            $table->dateTime('cancelled_at')->nullable(); // Cancellation date
            
            // Billing Information
            $table->decimal('amount', 10, 2); // Billing amount
            $table->string('currency')->default('USD'); // Billing currency
            $table->string('billing_cycle')->default('monthly'); // Billing frequency
            $table->dateTime('next_billing_date')->nullable(); // Next billing date
            $table->integer('billing_attempts')->default(0); // Failed billing attempts
            
            // Payment Gateway
            $table->string('gateway')->nullable(); // Stripe, PayPal, Razorpay
            $table->string('gateway_subscription_id')->nullable(); // External subscription ID
            $table->string('gateway_customer_id')->nullable(); // External customer ID
            $table->json('gateway_data')->nullable(); // Gateway-specific data
            
            // Usage Tracking
            $table->integer('cards_used')->default(0); // Number of cards created
            $table->integer('storage_used_mb')->default(0); // Storage used in MB
            $table->json('feature_usage')->nullable(); // Feature usage tracking
            
            // Auto-renewal
            $table->boolean('auto_renew')->default(true); // Auto-renewal enabled
            $table->boolean('cancel_at_period_end')->default(false); // Cancel at period end
            
            // Admin Notes
            $table->text('admin_notes')->nullable(); // Admin notes
            $table->string('cancellation_reason')->nullable(); // Cancellation reason
            
            $table->timestamps();
            $table->softDeletes(); // Soft delete support
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_subscriptions');
    }
};
