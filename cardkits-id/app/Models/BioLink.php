<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BioLink extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'profile_photo',
        'background_photo',
        'theme_color',
        'text_color',
        'button_color',
        'button_text_color',
        'font_family',
        'show_social_icons',
        'show_analytics',
        'custom_domain',
        'slug',
        'is_active',
        'view_count'
    ];

    protected $casts = [
        'show_social_icons' => 'boolean',
        'show_analytics' => 'boolean',
        'is_active' => 'boolean',
        'view_count' => 'integer',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(BioLinkItem::class)->orderBy('order');
    }

    public function socialMedia(): HasMany
    {
        return $this->hasMany(BioLinkSocialMedia::class)->orderBy('order');
    }

    public function analytics(): HasMany
    {
        return $this->hasMany(BioLinkAnalytics::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Methods
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    public function getFullUrlAttribute()
    {
        if ($this->custom_domain) {
            return 'https://' . $this->custom_domain;
        }
        return url('/bio/' . $this->slug);
    }
}
