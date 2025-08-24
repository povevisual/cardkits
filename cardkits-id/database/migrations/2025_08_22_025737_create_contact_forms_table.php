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
        Schema::create('contact_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('digital_card_id')->constrained()->onDelete('cascade');
            
            // Form Configuration
            $table->string('name'); // Form name
            $table->string('type')->default('contact'); // contact, payment, lead, etc.
            $table->json('fields')->nullable(); // Form field configuration
            $table->json('validation_rules')->nullable(); // Validation rules
            $table->json('styling')->nullable(); // Form styling
            
            // Form Settings
            $table->boolean('is_active')->default(true); // Form visibility
            $table->boolean('require_captcha')->default(false); // CAPTCHA protection
            $table->boolean('email_notifications')->default(true); // Email notifications
            $table->string('notification_email')->nullable(); // Notification email
            $table->json('auto_responder')->nullable(); // Auto-responder settings
            
            // Payment Integration
            $table->boolean('enable_payments')->default(false); // Enable payments
            $table->decimal('payment_amount', 10, 2)->nullable(); // Payment amount
            $table->string('payment_currency')->default('USD'); // Payment currency
            $table->json('payment_gateways')->nullable(); // Enabled payment gateways
            $table->string('payment_success_url')->nullable(); // Success redirect
            $table->string('payment_cancel_url')->nullable(); // Cancel redirect
            
            // Stripe Configuration
            $table->string('stripe_public_key')->nullable(); // Stripe public key
            $table->string('stripe_secret_key')->nullable(); // Stripe secret key
            $table->string('stripe_webhook_secret')->nullable(); // Webhook secret
            
            // PayPal Configuration
            $table->string('paypal_client_id')->nullable(); // PayPal client ID
            $table->string('paypal_secret')->nullable(); // PayPal secret
            $table->string('paypal_mode')->default('sandbox'); // sandbox or live
            
            // Razorpay Configuration
            $table->string('razorpay_key_id')->nullable(); // Razorpay key ID
            $table->string('razorpay_key_secret')->nullable(); // Razorpay secret
            $table->string('razorpay_webhook_secret')->nullable(); // Webhook secret
            
            // Form Processing
            $table->string('form_action')->nullable(); // Custom form action
            $table->string('form_method')->default('POST'); // Form method
            $table->json('integrations')->nullable(); // Third-party integrations
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_forms');
    }
};
