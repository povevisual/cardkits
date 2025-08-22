<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactForm extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'digital_card_id',
        'name',
        'type',
        'fields',
        'validation_rules',
        'styling',
        'is_active',
        'require_captcha',
        'email_notifications',
        'notification_email',
        'auto_responder',
        'enable_payments',
        'payment_amount',
        'payment_currency',
        'payment_gateways',
        'payment_success_url',
        'payment_cancel_url',
        'stripe_public_key',
        'stripe_secret_key',
        'stripe_webhook_secret',
        'stripe_product_id',
        'stripe_price_id',
        'paypal_client_id',
        'paypal_secret',
        'paypal_mode',
        'paypal_webhook_id',
        'razorpay_key_id',
        'razorpay_key_secret',
        'razorpay_webhook_secret',
        'razorpay_plan_id'
    ];

    protected $casts = [
        'fields' => 'array',
        'validation_rules' => 'array',
        'styling' => 'array',
        'auto_responder' => 'array',
        'payment_gateways' => 'array',
        'is_active' => 'boolean',
        'require_captcha' => 'boolean',
        'email_notifications' => 'boolean',
        'enable_payments' => 'boolean',
        'payment_amount' => 'decimal:2'
    ];

    /**
     * Form types
     */
    const TYPES = [
        'contact' => 'Contact Form',
        'lead_generation' => 'Lead Generation',
        'support' => 'Support Request',
        'feedback' => 'Feedback Form',
        'appointment' => 'Appointment Request',
        'quote' => 'Quote Request',
        'custom' => 'Custom Form'
    ];

    /**
     * Payment gateways
     */
    const PAYMENT_GATEWAYS = [
        'stripe' => 'Stripe',
        'paypal' => 'PayPal',
        'razorpay' => 'Razorpay'
    ];

    /**
     * Get the digital card for this form
     */
    public function digitalCard()
    {
        return $this->belongsTo(DigitalCard::class);
    }

    /**
     * Get form submissions
     */
    public function submissions()
    {
        return $this->hasMany(ContactFormSubmission::class);
    }

    /**
     * Scope for active forms
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for forms by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope for forms with payments enabled
     */
    public function scopeWithPayments($query)
    {
        return $query->where('enable_payments', true);
    }

    /**
     * Get type label attribute
     */
    public function getTypeLabelAttribute()
    {
        return self::TYPES[$this->type] ?? ucfirst($this->type);
    }

    /**
     * Get available payment gateways
     */
    public function getAvailablePaymentGatewaysAttribute()
    {
        if (!$this->payment_gateways) {
            return [];
        }

        $available = [];
        foreach ($this->payment_gateways as $gateway) {
            if (isset(self::PAYMENT_GATEWAYS[$gateway])) {
                $available[$gateway] = self::PAYMENT_GATEWAYS[$gateway];
            }
        }

        return $available;
    }

    /**
     * Check if form has payment gateway configured
     */
    public function hasPaymentGateway($gateway)
    {
        if (!$this->payment_gateways) {
            return false;
        }

        return in_array($gateway, $this->payment_gateways);
    }

    /**
     * Check if Stripe is configured
     */
    public function isStripeConfigured()
    {
        return $this->hasPaymentGateway('stripe') && 
               $this->stripe_public_key && 
               $this->stripe_secret_key;
    }

    /**
     * Check if PayPal is configured
     */
    public function isPayPalConfigured()
    {
        return $this->hasPaymentGateway('paypal') && 
               $this->paypal_client_id && 
               $this->paypal_secret;
    }

    /**
     * Check if Razorpay is configured
     */
    public function isRazorpayConfigured()
    {
        return $this->hasPaymentGateway('razorpay') && 
               $this->razorpay_key_id && 
               $this->razorpay_key_secret;
    }

    /**
     * Get form fields configuration
     */
    public function getFormFields()
    {
        return $this->fields ?? [];
    }

    /**
     * Get validation rules for form fields
     */
    public function getValidationRules()
    {
        return $this->validation_rules ?? [];
    }

    /**
     * Get form styling configuration
     */
    public function getFormStyling()
    {
        return $this->styling ?? [];
    }

    /**
     * Get auto-responder configuration
     */
    public function getAutoResponderConfig()
    {
        return $this->auto_responder ?? [];
    }

    /**
     * Check if auto-responder is enabled
     */
    public function hasAutoResponder()
    {
        $config = $this->getAutoResponderConfig();
        return !empty($config) && ($config['enabled'] ?? false);
    }

    /**
     * Get auto-responder email template
     */
    public function getAutoResponderTemplate()
    {
        $config = $this->getAutoResponderConfig();
        return $config['template'] ?? 'default';
    }

    /**
     * Get auto-responder subject
     */
    public function getAutoResponderSubject()
    {
        $config = $this->getAutoResponderConfig();
        return $config['subject'] ?? 'Thank you for your message';
    }

    /**
     * Get auto-responder message
     */
    public function getAutoResponderMessage()
    {
        $config = $this->getAutoResponderConfig();
        return $config['message'] ?? 'We have received your message and will get back to you soon.';
    }

    /**
     * Check if form requires captcha
     */
    public function requiresCaptcha()
    {
        return $this->require_captcha;
    }

    /**
     * Check if email notifications are enabled
     */
    public function hasEmailNotifications()
    {
        return $this->email_notifications && $this->notification_email;
    }

    /**
     * Get notification email address
     */
    public function getNotificationEmail()
    {
        return $this->notification_email;
    }

    /**
     * Check if payments are enabled
     */
    public function hasPayments()
    {
        return $this->enable_payments && $this->payment_amount > 0;
    }

    /**
     * Get formatted payment amount
     */
    public function getFormattedPaymentAmount()
    {
        if (!$this->hasPayments()) {
            return 'Free';
        }

        $currency = $this->payment_currency ?? 'USD';
        return $currency . ' ' . number_format($this->payment_amount, 2);
    }

    /**
     * Get payment success URL
     */
    public function getPaymentSuccessUrl()
    {
        return $this->payment_success_url ?? route('forms.payment.success');
    }

    /**
     * Get payment cancel URL
     */
    public function getPaymentCancelUrl()
    {
        return $this->payment_cancel_url ?? route('forms.payment.cancel');
    }

    /**
     * Get form styling as CSS
     */
    public function getCssStylesAttribute()
    {
        if (!$this->styling) {
            return '';
        }

        $css = '';
        foreach ($this->styling as $property => $value) {
            if ($value !== null && $value !== '') {
                $css .= "{$property}: {$value}; ";
            }
        }

        return trim($css);
    }

    /**
     * Get form field by name
     */
    public function getFieldByName($name)
    {
        $fields = $this->getFormFields();
        
        foreach ($fields as $field) {
            if (($field['name'] ?? '') === $name) {
                return $field;
            }
        }

        return null;
    }

    /**
     * Check if field is required
     */
    public function isFieldRequired($fieldName)
    {
        $field = $this->getFieldByName($fieldName);
        return $field && ($field['required'] ?? false);
    }

    /**
     * Get field validation rules
     */
    public function getFieldValidationRules($fieldName)
    {
        $rules = $this->getValidationRules();
        return $rules[$fieldName] ?? [];
    }

    /**
     * Get form submission count
     */
    public function getSubmissionCount()
    {
        return $this->submissions()->count();
    }

    /**
     * Get recent submissions
     */
    public function getRecentSubmissions($limit = 10)
    {
        return $this->submissions()->latest()->limit($limit)->get();
    }
}
