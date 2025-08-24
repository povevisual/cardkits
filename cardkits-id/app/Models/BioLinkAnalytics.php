<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BioLinkAnalytics extends Model
{
    protected $fillable = [
        'bio_link_id',
        'bio_link_item_id',
        'ip_address',
        'user_agent',
        'referrer',
        'country',
        'city',
        'device_type',
        'browser',
        'os',
        'action',
        'clicked_at'
    ];

    protected $casts = [
        'clicked_at' => 'datetime'
    ];

    // Relationships
    public function bioLink(): BelongsTo
    {
        return $this->belongsTo(BioLink::class);
    }

    public function bioLinkItem(): BelongsTo
    {
        return $this->belongsTo(BioLinkItem::class);
    }

    // Scopes
    public function scopeViews($query)
    {
        return $query->where('action', 'view');
    }

    public function scopeClicks($query)
    {
        return $query->where('action', 'click');
    }

    public function scopeShares($query)
    {
        return $query->where('action', 'share');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month);
    }
}
