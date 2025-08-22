<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DigitalCard extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'card_template_id',
        'title',
        'slug',
        'first_name',
        'last_name',
        'company_name',
        'job_title',
        'email',
        'phone',
        'website',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'profile_photo',
        'cover_photo',
        'logo',
        'bio',
        'theme_color',
        'text_color',
        'button_color',
        'button_text_color',
        'font_family',
        'background_type',
        'background_image',
        'background_color',
        'gradient_colors',
        'custom_css',
        'custom_domain',
        'is_public',
        'password_protected',
        'password',
        'show_analytics',
        'enable_qr_code',
        'qr_code_image',
        'pwa_enabled',
        'pwa_icon',
        'pwa_theme_color',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'og_image',
        'structured_data',
        'meta_tags',
        'is_active',
        'is_featured',
        'view_count',
        'last_viewed_at',
        'subscription_plan_id',
        'storage_used_mb',
        'feature_usage',
        'settings',
        'metadata'
    ];

    protected $casts = [
        'gradient_colors' => 'array',
        'custom_css' => 'array',
        'structured_data' => 'array',
        'meta_tags' => 'array',
        'feature_usage' => 'array',
        'settings' => 'array',
        'metadata' => 'array',
        'is_public' => 'boolean',
        'password_protected' => 'boolean',
        'show_analytics' => 'boolean',
        'enable_qr_code' => 'boolean',
        'pwa_enabled' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'view_count' => 'integer',
        'last_viewed_at' => 'datetime',
        'storage_used_mb' => 'decimal:2'
    ];

    protected $hidden = [
        'password'
    ];

    /**
     * Get the user that owns the card
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the template used for this card
     */
    public function template()
    {
        return $this->belongsTo(CardTemplate::class, 'card_template_id');
    }

    /**
     * Get the components of this card
     */
    public function components()
    {
        return $this->hasMany(CardComponent::class)->orderBy('order');
    }

    /**
     * Get the appointments for this card
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get the contact forms for this card
     */
    public function contactForms()
    {
        return $this->hasMany(ContactForm::class);
    }

    /**
     * Get the analytics for this card
     */
    public function analytics()
    {
        return $this->hasMany(CardAnalytics::class);
    }

    /**
     * Get the subscription plan for this card
     */
    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    /**
     * Get the user subscription
     */
    public function userSubscription()
    {
        return $this->belongsTo(UserSubscription::class, 'subscription_plan_id');
    }

    /**
     * Scope for active cards
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for public cards
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope for featured cards
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for cards by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Get full name attribute
     */
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    /**
     * Get full address attribute
     */
    public function getFullAddressAttribute()
    {
        $parts = array_filter([
            $this->address,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->country
        ]);
        
        return implode(', ', $parts);
    }

    /**
     * Get public URL attribute
     */
    public function getPublicUrlAttribute()
    {
        if ($this->custom_domain) {
            return 'https://' . $this->custom_domain;
        }
        
        return route('cards.public', $this->slug);
    }

    /**
     * Get QR code URL attribute
     */
    public function getQrCodeUrlAttribute()
    {
        return $this->qr_code_image ? asset('storage/' . $this->qr_code_image) : null;
    }

    /**
     * Get profile photo URL attribute
     */
    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo ? asset('storage/' . $this->profile_photo) : null;
    }

    /**
     * Get cover photo URL attribute
     */
    public function getCoverPhotoUrlAttribute()
    {
        return $this->cover_photo ? asset('storage/' . $this->cover_photo) : null;
    }

    /**
     * Get logo URL attribute
     */
    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }

    /**
     * Increment view count
     */
    public function incrementViewCount()
    {
        $this->increment('view_count');
        $this->update(['last_viewed_at' => now()]);
    }

    /**
     * Check if card is password protected
     */
    public function isPasswordProtected()
    {
        return $this->password_protected && !empty($this->password);
    }

    /**
     * Check if card can be viewed by user
     */
    public function canBeViewedBy($user = null)
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->is_public) {
            return true;
        }

        if ($user && $user->id === $this->user_id) {
            return true;
        }

        return false;
    }

    /**
     * Generate slug from title
     */
    public static function generateSlug($title)
    {
        $slug = Str::slug($title);
        $count = static::where('slug', 'LIKE', $slug . '%')->count();
        
        return $count ? $slug . '-' . ($count + 1) : $slug;
    }
}
