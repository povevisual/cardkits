<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardComponent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'digital_card_id',
        'name',
        'type',
        'content',
        'icon',
        'media_url',
        'media_alt',
        'config',
        'styling',
        'animation',
        'order',
        'position',
        'layout',
        'social_media_platform',
        'social_media_username',
        'social_media_url',
        'map_address',
        'map_coordinates',
        'map_zoom',
        'video_url',
        'video_provider',
        'video_autoplay',
        'video_controls',
        'html_content',
        'button_text',
        'button_url',
        'button_style',
        'contact_form_fields',
        'contact_form_validation',
        'status_text',
        'status_type',
        'status_icon',
        'visibility_rules',
        'click_count',
        'last_clicked_at',
        'is_active',
        'is_required',
        'metadata'
    ];

    protected $casts = [
        'config' => 'array',
        'styling' => 'array',
        'animation' => 'array',
        'layout' => 'array',
        'map_coordinates' => 'array',
        'contact_form_fields' => 'array',
        'contact_form_validation' => 'array',
        'visibility_rules' => 'array',
        'metadata' => 'array',
        'video_autoplay' => 'boolean',
        'video_controls' => 'boolean',
        'is_active' => 'boolean',
        'is_required' => 'boolean',
        'click_count' => 'integer',
        'last_clicked_at' => 'datetime',
        'order' => 'integer',
        'map_zoom' => 'integer'
    ];

    /**
     * Component types
     */
    const TYPES = [
        'profile' => 'Profile Information',
        'contact' => 'Contact Details',
        'social' => 'Social Media',
        'map' => 'Location Map',
        'video' => 'Video Embed',
        'html' => 'Custom HTML',
        'button' => 'Call-to-Action Button',
        'form' => 'Contact Form',
        'status' => 'Status/Status',
        'gallery' => 'Image Gallery',
        'appointment' => 'Appointment Booking',
        'payment' => 'Payment Button',
        'qr_code' => 'QR Code',
        'analytics' => 'Analytics Widget'
    ];

    /**
     * Get the digital card that owns this component
     */
    public function digitalCard()
    {
        return $this->belongsTo(DigitalCard::class);
    }

    /**
     * Get the analytics for this component
     */
    public function analytics()
    {
        return $this->hasMany(CardAnalytics::class);
    }

    /**
     * Scope for active components
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for components by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope for ordered components
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Scope for components by position
     */
    public function scopeByPosition($query, $position)
    {
        return $query->where('position', $position);
    }

    /**
     * Get component type label
     */
    public function getTypeLabelAttribute()
    {
        return self::TYPES[$this->type] ?? ucfirst($this->type);
    }

    /**
     * Get media URL attribute
     */
    public function getMediaUrlAttribute($value)
    {
        if ($value && !filter_var($value, FILTER_VALIDATE_URL)) {
            return asset('storage/' . $value);
        }
        
        return $value;
    }

    /**
     * Get icon URL attribute
     */
    public function getIconUrlAttribute()
    {
        if ($this->icon && !filter_var($this->icon, FILTER_VALIDATE_URL)) {
            return asset('storage/' . $this->icon);
        }
        
        return $this->icon;
    }

    /**
     * Get component styling as CSS
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
     * Get component animation classes
     */
    public function getAnimationClassesAttribute()
    {
        if (!$this->animation || !isset($this->animation['type'])) {
            return '';
        }

        $classes = [];
        
        if (isset($this->animation['type'])) {
            $classes[] = 'animate-' . $this->animation['type'];
        }
        
        if (isset($this->animation['delay'])) {
            $classes[] = 'delay-' . $this->animation['delay'];
        }
        
        if (isset($this->animation['duration'])) {
            $classes[] = 'duration-' . $this->animation['duration'];
        }

        return implode(' ', $classes);
    }

    /**
     * Check if component is visible based on rules
     */
    public function isVisible($context = [])
    {
        if (!$this->visibility_rules) {
            return true;
        }

        foreach ($this->visibility_rules as $rule) {
            if (!$this->evaluateVisibilityRule($rule, $context)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Evaluate a single visibility rule
     */
    protected function evaluateVisibilityRule($rule, $context)
    {
        $field = $rule['field'] ?? '';
        $operator = $rule['operator'] ?? 'equals';
        $value = $rule['value'] ?? '';

        if (!isset($context[$field])) {
            return true; // Field not present, assume visible
        }

        $contextValue = $context[$field];

        switch ($operator) {
            case 'equals':
                return $contextValue == $value;
            case 'not_equals':
                return $contextValue != $value;
            case 'contains':
                return str_contains($contextValue, $value);
            case 'greater_than':
                return $contextValue > $value;
            case 'less_than':
                return $contextValue < $value;
            case 'in':
                return in_array($contextValue, (array) $value);
            case 'not_in':
                return !in_array($contextValue, (array) $value);
            default:
                return true;
        }
    }

    /**
     * Increment click count
     */
    public function incrementClickCount()
    {
        $this->increment('click_count');
        $this->update(['last_clicked_at' => now()]);
    }

    /**
     * Get component configuration value
     */
    public function getConfig($key, $default = null)
    {
        return data_get($this->config, $key, $default);
    }

    /**
     * Set component configuration value
     */
    public function setConfig($key, $value)
    {
        $config = $this->config ?? [];
        data_set($config, $key, $value);
        $this->config = $config;
    }

    /**
     * Get component styling value
     */
    public function getStyling($key, $default = null)
    {
        return data_get($this->styling, $key, $default);
    }

    /**
     * Set component styling value
     */
    public function setStyling($key, $value)
    {
        $styling = $this->styling ?? [];
        data_set($styling, $key, $value);
        $this->styling = $styling;
    }
}
