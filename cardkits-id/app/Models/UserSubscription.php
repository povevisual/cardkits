<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class UserSubscription extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'subscription_plan_id',
        'status',
        'start_date',
        'end_date',
        'trial_ends_at',
        'cancelled_at',
        'amount',
        'currency',
        'billing_cycle',
        'next_billing_date',
        'billing_attempts',
        'gateway',
        'gateway_subscription_id',
        'gateway_customer_id',
        'gateway_data',
        'cards_used',
        'storage_used_mb',
        'feature_usage',
        'auto_renew',
        'cancel_at_period_end',
        'admin_notes',
        'cancellation_reason'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'trial_ends_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'next_billing_date' => 'datetime',
        'gateway_data' => 'array',
        'feature_usage' => 'array',
        'auto_renew' => 'boolean',
        'cancel_at_period_end' => 'boolean',
        'amount' => 'decimal:2',
        'cards_used' => 'integer',
        'storage_used_mb' => 'decimal:2',
        'billing_attempts' => 'integer'
    ];

    /**
     * Subscription statuses
     */
    const STATUSES = [
        'active' => 'Active',
        'trialing' => 'Trialing',
        'past_due' => 'Past Due',
        'cancelled' => 'Cancelled',
        'unpaid' => 'Unpaid',
        'incomplete' => 'Incomplete',
        'incomplete_expired' => 'Incomplete Expired',
        'paused' => 'Paused'
    ];

    /**
     * Payment gateways
     */
    const GATEWAYS = [
        'stripe' => 'Stripe',
        'paypal' => 'PayPal',
        'razorpay' => 'Razorpay',
        'manual' => 'Manual'
    ];

    /**
     * Get the user for this subscription
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subscription plan
     */
    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    /**
     * Get the digital cards using this subscription
     */
    public function digitalCards()
    {
        return $this->hasMany(DigitalCard::class, 'subscription_plan_id');
    }

    /**
     * Scope for active subscriptions
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for trialing subscriptions
     */
    public function scopeTrialing($query)
    {
        return $query->where('status', 'trialing');
    }

    /**
     * Scope for cancelled subscriptions
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Scope for past due subscriptions
     */
    public function scopePastDue($query)
    {
        return $query->where('status', 'past_due');
    }

    /**
     * Scope for subscriptions by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for subscriptions by gateway
     */
    public function scopeByGateway($query, $gateway)
    {
        return $query->where('gateway', $gateway);
    }

    /**
     * Scope for subscriptions expiring soon
     */
    public function scopeExpiringSoon($query, $days = 7)
    {
        return $query->where('end_date', '<=', now()->addDays($days))
            ->where('status', 'active');
    }

    /**
     * Get status label attribute
     */
    public function getStatusLabelAttribute()
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }

    /**
     * Get gateway label attribute
     */
    public function getGatewayLabelAttribute()
    {
        return self::GATEWAYS[$this->gateway] ?? ucfirst($this->gateway);
    }

    /**
     * Get formatted amount attribute
     */
    public function getFormattedAmountAttribute()
    {
        $currency = $this->currency ?? 'USD';
        return $currency . ' ' . number_format($this->amount, 2);
    }

    /**
     * Get formatted storage usage attribute
     */
    public function getFormattedStorageUsageAttribute()
    {
        if ($this->storage_used_mb >= 1024) {
            return round($this->storage_used_mb / 1024, 1) . ' GB';
        }
        
        return $this->storage_used_mb . ' MB';
    }

    /**
     * Check if subscription is active
     */
    public function isActive()
    {
        return in_array($this->status, ['active', 'trialing']);
    }

    /**
     * Check if subscription is trialing
     */
    public function isTrialing()
    {
        return $this->status === 'trialing';
    }

    /**
     * Check if subscription is cancelled
     */
    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    /**
     * Check if subscription is past due
     */
    public function isPastDue()
    {
        return $this->status === 'past_due';
    }

    /**
     * Check if subscription has trial
     */
    public function hasTrial()
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    /**
     * Check if subscription is in trial period
     */
    public function isInTrial()
    {
        return $this->hasTrial() && $this->status === 'trialing';
    }

    /**
     * Get trial days remaining
     */
    public function getTrialDaysRemaining()
    {
        if (!$this->hasTrial()) {
            return 0;
        }

        return max(0, now()->diffInDays($this->trial_ends_at, false));
    }

    /**
     * Check if subscription is expiring soon
     */
    public function isExpiringSoon($days = 7)
    {
        if (!$this->end_date || !$this->isActive()) {
            return false;
        }

        return $this->end_date->diffInDays(now(), false) <= $days;
    }

    /**
     * Check if subscription can be cancelled
     */
    public function canBeCancelled()
    {
        return $this->isActive() && !$this->cancel_at_period_end;
    }

    /**
     * Check if subscription can be renewed
     */
    public function canBeRenewed()
    {
        return $this->isActive() && $this->auto_renew;
    }

    /**
     * Check if subscription supports auto-renewal
     */
    public function supportsAutoRenewal()
    {
        return $this->auto_renew;
    }

    /**
     * Cancel subscription
     */
    public function cancel($reason = null, $atPeriodEnd = true)
    {
        if ($atPeriodEnd) {
            $this->update([
                'cancel_at_period_end' => true,
                'cancellation_reason' => $reason
            ]);
        } else {
            $this->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancellation_reason' => $reason
            ]);
        }
    }

    /**
     * Reactivate subscription
     */
    public function reactivate()
    {
        $this->update([
            'cancel_at_period_end' => false,
            'cancellation_reason' => null
        ]);
    }

    /**
     * Pause subscription
     */
    public function pause()
    {
        $this->update(['status' => 'paused']);
    }

    /**
     * Resume subscription
     */
    public function resume()
    {
        $this->update(['status' => 'active']);
    }

    /**
     * Update billing information
     */
    public function updateBilling($amount, $currency, $billingCycle)
    {
        $this->update([
            'amount' => $amount,
            'currency' => $currency,
            'billing_cycle' => $billingCycle
        ]);
    }

    /**
     * Update next billing date
     */
    public function updateNextBillingDate()
    {
        if (!$this->end_date) {
            return;
        }

        $nextBilling = $this->end_date->copy();
        
        switch ($this->billing_cycle) {
            case 'monthly':
                $nextBilling->addMonth();
                break;
            case 'quarterly':
                $nextBilling->addMonths(3);
                break;
            case 'yearly':
                $nextBilling->addYear();
                break;
            case 'lifetime':
                return; // No next billing for lifetime
        }

        $this->update(['next_billing_date' => $nextBilling]);
    }

    /**
     * Check if user can create more cards
     */
    public function canCreateMoreCards()
    {
        $plan = $this->subscriptionPlan;
        if (!$plan) {
            return false;
        }

        if ($plan->hasUnlimitedCards()) {
            return true;
        }

        return $this->cards_used < $plan->max_cards;
    }

    /**
     * Check if user can add more components
     */
    public function canAddMoreComponents($componentCount)
    {
        $plan = $this->subscriptionPlan;
        if (!$plan) {
            return false;
        }

        if ($plan->hasUnlimitedComponents()) {
            return true;
        }

        return $componentCount <= $plan->max_components;
    }

    /**
     * Check if user can use more storage
     */
    public function canUseMoreStorage($additionalStorageMb)
    {
        $plan = $this->subscriptionPlan;
        if (!$plan) {
            return false;
        }

        if ($plan->hasUnlimitedStorage()) {
            return true;
        }

        return ($this->storage_used_mb + $additionalStorageMb) <= $plan->max_storage_mb;
    }

    /**
     * Get feature usage for specific feature
     */
    public function getFeatureUsage($feature)
    {
        $usage = $this->feature_usage ?? [];
        return $usage[$feature] ?? 0;
    }

    /**
     * Update feature usage
     */
    public function updateFeatureUsage($feature, $value)
    {
        $usage = $this->feature_usage ?? [];
        $usage[$feature] = $value;
        $this->feature_usage = $usage;
        $this->save();
    }

    /**
     * Increment feature usage
     */
    public function incrementFeatureUsage($feature, $amount = 1)
    {
        $currentUsage = $this->getFeatureUsage($feature);
        $this->updateFeatureUsage($feature, $currentUsage + $amount);
    }

    /**
     * Get gateway data for specific key
     */
    public function getGatewayData($key, $default = null)
    {
        $data = $this->gateway_data ?? [];
        return data_get($data, $key, $default);
    }

    /**
     * Set gateway data for specific key
     */
    public function setGatewayData($key, $value)
    {
        $data = $this->gateway_data ?? [];
        data_set($data, $key, $value);
        $this->gateway_data = $data;
        $this->save();
    }

    /**
     * Get subscription duration in days
     */
    public function getDurationInDays()
    {
        if (!$this->start_date || !$this->end_date) {
            return 0;
        }

        return $this->start_date->diffInDays($this->end_date);
    }

    /**
     * Get days until expiration
     */
    public function getDaysUntilExpiration()
    {
        if (!$this->end_date) {
            return 0;
        }

        return max(0, now()->diffInDays($this->end_date, false));
    }

    /**
     * Check if subscription needs renewal
     */
    public function needsRenewal()
    {
        if (!$this->isActive() || $this->cancel_at_period_end) {
            return false;
        }

        return $this->isExpiringSoon(30); // 30 days before expiration
    }

    /**
     * Get renewal amount
     */
    public function getRenewalAmount()
    {
        return $this->amount;
    }

    /**
     * Process successful payment
     */
    public function processSuccessfulPayment()
    {
        $this->update([
            'status' => 'active',
            'billing_attempts' => 0
        ]);

        $this->updateNextBillingDate();
    }

    /**
     * Process failed payment
     */
    public function processFailedPayment()
    {
        $this->increment('billing_attempts');
        
        if ($this->billing_attempts >= 3) {
            $this->update(['status' => 'past_due']);
        }
    }
}
