<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('type')->default('subscription');
            $table->decimal('price', 10, 2);
            $table->string('currency')->default('USD');
            $table->string('billing_cycle')->default('monthly');
            $table->integer('trial_days')->default(0);
            $table->boolean('is_popular')->default(false);
            $table->integer('max_cards')->default(1);
            $table->integer('max_components')->default(10);
            $table->integer('max_storage_mb')->default(100);
            $table->boolean('custom_domain')->default(false);
            $table->boolean('white_label')->default(false);
            $table->boolean('advanced_analytics')->default(false);
            $table->boolean('priority_support')->default(false);
            $table->json('template_access')->nullable();
            $table->boolean('premium_templates')->default(false);
            $table->boolean('custom_css')->default(false);
            $table->json('integrations')->nullable();
            $table->json('payment_gateways')->nullable();
            $table->boolean('calendar_integration')->default(false);
            $table->boolean('api_access')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
