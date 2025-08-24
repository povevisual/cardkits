<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BioLinkItem extends Model
{
    protected $fillable = [
        'bio_link_id',
        'title',
        'url',
        'icon',
        'thumbnail',
        'type',
        'description',
        'is_active',
        'order',
        'open_in_new_tab',
        'track_clicks',
        'click_count',
        'metadata'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'open_in_new_tab' => 'boolean',
        'track_clicks' => 'boolean',
        'click_count' => 'integer',
        'metadata' => 'array'
    ];

    // Relationships
    public function bioLink(): BelongsTo
    {
        return $this->belongsTo(BioLink::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    // Methods
    public function incrementClickCount()
    {
        $this->increment('click_count');
    }

    public function getFormattedUrlAttribute()
    {
        if ($this->type === 'email') {
            return 'mailto:' . $this->url;
        }
        if ($this->type === 'phone') {
            return 'tel:' . $this->url;
        }
        return $this->url;
    }
}
