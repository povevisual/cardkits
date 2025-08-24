<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CardTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'category',
        'color_schemes',
        'layout_config',
        'component_config',
        'preview_image',
        'is_active',
        'is_premium',
        'sort_order',
        'metadata'
    ];

    protected $casts = [
        'color_schemes' => 'array',
        'layout_config' => 'array',
        'component_config' => 'array',
        'metadata' => 'array',
        'is_active' => 'boolean',
        'is_premium' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Get the digital cards using this template
     */
    public function digitalCards()
    {
        return $this->hasMany(DigitalCard::class);
    }

    /**
     * Scope for active templates
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for premium templates
     */
    public function scopePremium($query)
    {
        return $query->where('is_premium', true);
    }

    /**
     * Scope for free templates
     */
    public function scopeFree($query)
    {
        return $query->where('is_premium', false);
    }

    /**
     * Scope for templates by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get template preview URL
     */
    public function getPreviewUrlAttribute()
    {
        return $this->preview_image ? asset('storage/' . $this->preview_image) : null;
    }

    /**
     * Get available color schemes
     */
    public function getAvailableColorSchemesAttribute()
    {
        return $this->color_schemes ?? [];
    }

    /**
     * Get default layout configuration
     */
    public function getDefaultLayoutAttribute()
    {
        return $this->layout_config ?? [];
    }

    /**
     * Get default component configuration
     */
    public function getDefaultComponentsAttribute()
    {
        return $this->component_config ?? [];
    }
}
