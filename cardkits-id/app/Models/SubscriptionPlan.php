<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'type',
        'price',
        'currency',
        'billing_cycle',
        'trial_days',
        'is_popular',
        'max_cards',
        'max_components',
        'max_storage_mb',
        'custom_domain',
        'white_label',
        'advanced_analytics',
        'priority_support',
        'template_access',
        'premium_templates',
        'custom_css',
        'integrations',
        'payment_gateways',
        'calendar_integration',
        'api_access',
        'is_active',
        'is_featured',
        'sort_order'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'trial_days' => 'integer',
        'is_popular' => 'boolean',
        'max_cards' => 'integer',
        'max_components' => 'integer',
        'max_storage_mb' => 'integer',
        'custom_domain' => 'boolean',
        'white_label' => 'boolean',
        'advanced_analytics' => 'boolean',
        'priority_support' => 'boolean',
        'template_access' => 'array',
        'premium_templates' => 'boolean',
        'custom_css' => 'boolean',
        'integrations' => 'array',
        'payment_gateways' => 'array',
        'calendar_integration' => 'boolean',
        'api_access' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Plan types
     */
    const TYPES = [
        'free' => 'Free',
        'basic' => 'Basic',
        'pro' => 'Professional',
        'enterprise' => 'Enterprise',
        'custom' => 'Custom'
    ];

    /**
     * Billing cycles
     */
    const BILLING_CYCLES = [
        'monthly' => 'Monthly',
        'quarterly' => 'Quarterly',
        'yearly' => 'Yearly',
        'lifetime' => 'Lifetime'
    ];

    /**
     * Get the user subscriptions for this plan
     */
    public function userSubscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

    /**
     * Get the digital cards using this plan
     */
    public function digitalCards()
    {
        return $this->hasMany(DigitalCard::class, 'subscription_plan_id');
    }

    /**
     * Scope for active plans
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for featured plans
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for popular plans
     */
    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    /**
     * Scope for plans by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope for plans by billing cycle
     */
    public function scopeByBillingCycle($query, $cycle)
    {
        return $query->where('billing_cycle', $cycle);
    }

    /**
     * Scope for free plans
     */
    public function scopeFree($query)
    {
        return $query->where('price', 0);
    }

    /**
     * Scope for paid plans
     */
    public function scopePaid($query)
    {
        return $query->where('price', '>', 0);
    }

    /**
     * Get type label attribute
     */
    public function getTypeLabelAttribute()
    {
        return self::TYPES[$this->type] ?? ucfirst($this->type);
    }

    /**
     * Get billing cycle label attribute
     */
    public function getBillingCycleLabelAttribute()
    {
        return self::BILLING_CYCLES[$this->billing_cycle] ?? ucfirst($this->billing_cycle);
    }

    /**
     * Get formatted price attribute
     */
    public function getFormattedPriceAttribute()
    {
        if ($this->price == 0) {
            return 'Free';
        }

        $currency = $this->currency ?? 'USD';
        $price = number_format($this->price, 2);
        
        if ($this->billing_cycle === 'lifetime') {
            return $currency . ' ' . $price . ' (One-time)';
        }
        
        return $currency . ' ' . $price . '/' . substr($this->billing_cycle, 0, 1);
    }

    /**
     * Get yearly price attribute
     */
    public function getYearlyPriceAttribute()
    {
        if ($this->billing_cycle === 'lifetime') {
            return $this->price;
        }
        
        if ($this->billing_cycle === 'yearly') {
            return $this->price;
        }
        
        if ($this->billing_cycle === 'quarterly') {
            return $this->price * 4;
        }
        
        if ($this->billing_cycle === 'monthly') {
            return $this->price * 12;
        }
        
        return $this->price;
    }

    /**
     * Get monthly price attribute
     */
    public function getMonthlyPriceAttribute()
    {
        if ($this->billing_cycle === 'lifetime') {
            return $this->price / 12; // Divide by 12 for monthly equivalent
        }
        
        if ($this->billing_cycle === 'monthly') {
            return $this->price;
        }
        
        if ($this->billing_cycle === 'quarterly') {
            return $this->price / 3;
        }
        
        if ($this->billing_cycle === 'yearly') {
            return $this->price / 12;
        }
        
        return $this->price;
    }

    /**
     * Get savings percentage for yearly billing
     */
    public function getYearlySavingsAttribute()
    {
        if ($this->billing_cycle === 'yearly') {
            $monthlyPrice = $this->price / 12;
            $yearlyPrice = $this->price;
            $savings = (($monthlyPrice * 12) - $yearlyPrice) / ($monthlyPrice * 12) * 100;
            return round($savings);
        }
        
        return 0;
    }

    /**
     * Check if plan has unlimited cards
     */
    public function hasUnlimitedCards()
    {
        return $this->max_cards === -1 || $this->max_cards === null;
    }

    /**
     * Check if plan has unlimited components
     */
    public function hasUnlimitedComponents()
    {
        return $this->max_components === -1 || $this->max_components === null;
    }

    /**
     * Check if plan has unlimited storage
     */
    public function hasUnlimitedStorage()
    {
        return $this->max_storage_mb === -1 || $this->max_storage_mb === null;
    }

    /**
     * Get formatted storage limit
     */
    public function getFormattedStorageLimitAttribute()
    {
        if ($this->hasUnlimitedStorage()) {
            return 'Unlimited';
        }
        
        if ($this->max_storage_mb >= 1024) {
            return round($this->max_storage_mb / 1024, 1) . ' GB';
        }
        
        return $this->max_storage_mb . ' MB';
    }

    /**
     * Check if plan supports custom domains
     */
    public function supportsCustomDomains()
    {
        return $this->custom_domain;
    }

    /**
     * Check if plan supports white labeling
     */
    public function supportsWhiteLabel()
    {
        return $this->white_label;
    }

    /**
     * Check if plan has advanced analytics
     */
    public function hasAdvancedAnalytics()
    {
        return $this->advanced_analytics;
    }

    /**
     * Check if plan has priority support
     */
    public function hasPrioritySupport()
    {
        return $this->priority_support;
    }

    /**
     * Check if plan has premium templates
     */
    public function hasPremiumTemplates()
    {
        return $this->premium_templates;
    }

    /**
     * Check if plan supports custom CSS
     */
    public function supportsCustomCss()
    {
        return $this->custom_css;
    }

    /**
     * Check if plan has calendar integration
     */
    public function hasCalendarIntegration()
    {
        return $this->calendar_integration;
    }

    /**
     * Check if plan has API access
     */
    public function hasApiAccess()
    {
        return $this->api_access;
    }

    /**
     * Get available integrations
     */
    public function getAvailableIntegrations()
    {
        return $this->integrations ?? [];
    }

    /**
     * Check if plan has specific integration
     */
    public function hasIntegration($integration)
    {
        $integrations = $this->getAvailableIntegrations();
        return in_array($integration, $integrations);
    }

    /**
     * Get available payment gateways
     */
    public function getAvailablePaymentGateways()
    {
        return $this->payment_gateways ?? [];
    }

    /**
     * Check if plan supports specific payment gateway
     */
    public function supportsPaymentGateway($gateway)
    {
        $gateways = $this->getAvailablePaymentGateways();
        return in_array($gateway, $gateways);
    }

    /**
     * Get template access configuration
     */
    public function getTemplateAccess()
    {
        return $this->template_access ?? [];
    }

    /**
     * Check if plan has access to specific template category
     */
    public function hasTemplateAccess($category)
    {
        $access = $this->getTemplateAccess();
        return in_array($category, $access);
    }

    /**
     * Check if plan is free
     */
    public function isFree()
    {
        return $this->price == 0;
    }

    /**
     * Check if plan is paid
     */
    public function isPaid()
    {
        return $this->price > 0;
    }

    /**
     * Check if plan has trial
     */
    public function hasTrial()
    {
        return $this->trial_days > 0;
    }

    /**
     * Get trial duration in days
     */
    public function getTrialDays()
    {
        return $this->trial_days;
    }

    /**
     * Get active subscribers count
     */
    public function getActiveSubscribersCount()
    {
        return $this->userSubscriptions()
            ->where('status', 'active')
            ->count();
    }

    /**
     * Get total revenue
     */
    public function getTotalRevenue()
    {
        return $this->userSubscriptions()
            ->where('status', 'active')
            ->sum('amount');
    }

    /**
     * Compare with another plan
     */
    public function compareWith($otherPlan)
    {
        $comparison = [
            'price' => [
                'current' => $this->price,
                'other' => $otherPlan->price,
                'difference' => $otherPlan->price - $this->price
            ],
            'max_cards' => [
                'current' => $this->max_cards,
                'other' => $otherPlan->max_cards,
                'difference' => $otherPlan->max_cards - $this->max_cards
            ],
            'max_components' => [
                'current' => $this->max_components,
                'other' => $otherPlan->max_components,
                'difference' => $otherPlan->max_components - $this->max_components
            ],
            'features' => [
                'custom_domain' => $otherPlan->custom_domain - $this->custom_domain,
                'white_label' => $otherPlan->white_label - $this->white_label,
                'advanced_analytics' => $otherPlan->advanced_analytics - $this->advanced_analytics,
                'priority_support' => $otherPlan->priority_support - $this->priority_support,
                'premium_templates' => $otherPlan->premium_templates - $this->premium_templates,
                'custom_css' => $otherPlan->custom_css - $this->custom_css,
                'calendar_integration' => $otherPlan->calendar_integration - $this->calendar_integration,
                'api_access' => $otherPlan->api_access - $this->api_access
            ]
        ];

        return $comparison;
    }
}
