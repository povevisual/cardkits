<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BioLinkSocialMedia extends Model
{
    protected $fillable = [
        'bio_link_id',
        'platform',
        'username',
        'url',
        'icon',
        'is_active',
        'order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
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
    public function getPlatformIconAttribute()
    {
        $icons = [
            'instagram' => 'fab fa-instagram',
            'facebook' => 'fab fa-facebook',
            'twitter' => 'fab fa-twitter',
            'youtube' => 'fab fa-youtube',
            'tiktok' => 'fab fa-tiktok',
            'linkedin' => 'fab fa-linkedin',
            'github' => 'fab fa-github',
            'spotify' => 'fab fa-spotify',
            'twitch' => 'fab fa-twitch',
            'discord' => 'fab fa-discord',
            'telegram' => 'fab fa-telegram',
            'whatsapp' => 'fab fa-whatsapp',
            'snapchat' => 'fab fa-snapchat',
            'pinterest' => 'fab fa-pinterest',
            'reddit' => 'fab fa-reddit'
        ];

        return $icons[$this->platform] ?? 'fas fa-link';
    }

    public function getPlatformColorAttribute()
    {
        $colors = [
            'instagram' => '#E4405F',
            'facebook' => '#1877F2',
            'twitter' => '#1DA1F2',
            'youtube' => '#FF0000',
            'tiktok' => '#000000',
            'linkedin' => '#0A66C2',
            'github' => '#181717',
            'spotify' => '#1DB954',
            'twitch' => '#9146FF',
            'discord' => '#5865F2',
            'telegram' => '#0088CC',
            'whatsapp' => '#25D366',
            'snapchat' => '#FFFC00',
            'pinterest' => '#BD081C',
            'reddit' => '#FF4500'
        ];

        return $colors[$this->platform] ?? '#000000';
    }
}
