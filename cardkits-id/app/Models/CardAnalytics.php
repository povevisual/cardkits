<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jenssegers\Agent\Agent;

class CardAnalytics extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'digital_card_id',
        'card_component_id',
        'session_id',
        'visitor_id',
        'ip_address',
        'user_agent',
        'referrer',
        'country',
        'region',
        'city',
        'timezone',
        'latitude',
        'longitude',
        'device_type',
        'device_brand',
        'device_model',
        'browser',
        'browser_version',
        'os',
        'os_version',
        'action',
        'action_data',
        'page_url',
        'page_title',
        'scroll_depth',
        'time_on_page',
        'bounce_rate',
        'conversion_rate',
        'engagement_score',
        'load_time',
        'performance_score',
        'campaign_source',
        'campaign_medium',
        'campaign_name',
        'campaign_term',
        'campaign_content',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
        'clicks_count',
        'shares_count',
        'downloads_count',
        'form_submissions',
        'appointment_bookings',
        'payment_conversions',
        'revenue_generated',
        'currency',
        'business_insights',
        'metadata'
    ];

    protected $casts = [
        'action_data' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'scroll_depth' => 'integer',
        'time_on_page' => 'integer',
        'bounce_rate' => 'decimal:2',
        'conversion_rate' => 'decimal:2',
        'engagement_score' => 'decimal:2',
        'load_time' => 'decimal:3',
        'performance_score' => 'decimal:2',
        'clicks_count' => 'integer',
        'shares_count' => 'integer',
        'downloads_count' => 'integer',
        'form_submissions' => 'integer',
        'appointment_bookings' => 'integer',
        'payment_conversions' => 'integer',
        'revenue_generated' => 'decimal:2',
        'business_insights' => 'array',
        'metadata' => 'array'
    ];

    /**
     * Action types
     */
    const ACTIONS = [
        'view' => 'Page View',
        'click' => 'Link Click',
        'scroll' => 'Scroll',
        'form_submit' => 'Form Submission',
        'appointment_book' => 'Appointment Booking',
        'payment' => 'Payment',
        'download' => 'Download',
        'share' => 'Share',
        'video_play' => 'Video Play',
        'map_interaction' => 'Map Interaction',
        'qr_scan' => 'QR Code Scan',
        'pwa_install' => 'PWA Install',
        'bounce' => 'Bounce',
        'exit' => 'Exit'
    ];

    /**
     * Device types
     */
    const DEVICE_TYPES = [
        'desktop' => 'Desktop',
        'tablet' => 'Tablet',
        'mobile' => 'Mobile',
        'tv' => 'Smart TV',
        'console' => 'Gaming Console',
        'other' => 'Other'
    ];

    /**
     * Get the digital card for this analytics record
     */
    public function digitalCard()
    {
        return $this->belongsTo(DigitalCard::class);
    }

    /**
     * Get the card component for this analytics record
     */
    public function cardComponent()
    {
        return $this->belongsTo(CardComponent::class);
    }

    /**
     * Scope for analytics by action
     */
    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope for analytics by device type
     */
    public function scopeByDeviceType($query, $deviceType)
    {
        return $query->where('device_type', $deviceType);
    }

    /**
     * Scope for analytics by browser
     */
    public function scopeByBrowser($query, $browser)
    {
        return $query->where('browser', $browser);
    }

    /**
     * Scope for analytics by operating system
     */
    public function scopeByOs($query, $os)
    {
        return $query->where('os', $os);
    }

    /**
     * Scope for analytics by country
     */
    public function scopeByCountry($query, $country)
    {
        return $query->where('country', $country);
    }

    /**
     * Scope for analytics by date range
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope for analytics today
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Scope for analytics this week
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    /**
     * Scope for analytics this month
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);
    }

    /**
     * Scope for analytics this year
     */
    public function scopeThisYear($query)
    {
        return $query->whereYear('created_at', now()->year);
    }

    /**
     * Scope for analytics by campaign
     */
    public function scopeByCampaign($query, $campaign)
    {
        return $query->where('campaign_name', $campaign);
    }

    /**
     * Scope for analytics by UTM source
     */
    public function scopeByUtmSource($query, $source)
    {
        return $query->where('utm_source', $source);
    }

    /**
     * Get action label attribute
     */
    public function getActionLabelAttribute()
    {
        return self::ACTIONS[$this->action] ?? ucfirst($this->action);
    }

    /**
     * Get device type label attribute
     */
    public function getDeviceTypeLabelAttribute()
    {
        return self::DEVICE_TYPES[$this->device_type] ?? ucfirst($this->device_type);
    }

    /**
     * Get formatted time on page
     */
    public function getFormattedTimeOnPageAttribute()
    {
        if (!$this->time_on_page) {
            return 'N/A';
        }

        $seconds = $this->time_on_page;
        
        if ($seconds < 60) {
            return $seconds . 's';
        }
        
        $minutes = floor($seconds / 60);
        $remainingSeconds = $seconds % 60;
        
        if ($minutes < 60) {
            return $minutes . 'm ' . $remainingSeconds . 's';
        }
        
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        
        return $hours . 'h ' . $remainingMinutes . 'm';
    }

    /**
     * Get formatted load time
     */
    public function getFormattedLoadTimeAttribute()
    {
        if (!$this->load_time) {
            return 'N/A';
        }

        $time = $this->load_time;
        
        if ($time < 1) {
            return round($time * 1000) . 'ms';
        }
        
        return round($time, 2) . 's';
    }

    /**
     * Get formatted revenue
     */
    public function getFormattedRevenueAttribute()
    {
        if (!$this->revenue_generated) {
            return 'N/A';
        }

        $currency = $this->currency ?? 'USD';
        return $currency . ' ' . number_format($this->revenue_generated, 2);
    }

    /**
     * Get location coordinates
     */
    public function getCoordinatesAttribute()
    {
        if ($this->latitude && $this->longitude) {
            return [
                'lat' => (float) $this->latitude,
                'lng' => (float) $this->longitude
            ];
        }
        
        return null;
    }

    /**
     * Get full location string
     */
    public function getFullLocationAttribute()
    {
        $parts = array_filter([
            $this->city,
            $this->region,
            $this->country
        ]);
        
        return implode(', ', $parts) ?: 'Unknown';
    }

    /**
     * Get device information
     */
    public function getDeviceInfoAttribute()
    {
        $info = [];
        
        if ($this->device_type) {
            $info[] = $this->device_type_label;
        }
        
        if ($this->device_brand) {
            $info[] = $this->device_brand;
        }
        
        if ($this->device_model) {
            $info[] = $this->device_model;
        }
        
        return implode(' ', $info) ?: 'Unknown Device';
    }

    /**
     * Get browser information
     */
    public function getBrowserInfoAttribute()
    {
        $info = [];
        
        if ($this->browser) {
            $info[] = $this->browser;
        }
        
        if ($this->browser_version) {
            $info[] = 'v' . $this->browser_version;
        }
        
        return implode(' ', $info) ?: 'Unknown Browser';
    }

    /**
     * Get operating system information
     */
    public function getOsInfoAttribute()
    {
        $info = [];
        
        if ($this->os) {
            $info[] = $this->os;
        }
        
        if ($this->os_version) {
            $info[] = $this->os_version;
        }
        
        return implode(' ', $info) ?: 'Unknown OS';
    }

    /**
     * Get campaign information
     */
    public function getCampaignInfoAttribute()
    {
        $info = [];
        
        if ($this->campaign_source) {
            $info[] = 'Source: ' . $this->campaign_source;
        }
        
        if ($this->campaign_medium) {
            $info[] = 'Medium: ' . $this->campaign_medium;
        }
        
        if ($this->campaign_name) {
            $info[] = 'Campaign: ' . $this->campaign_name;
        }
        
        return implode(' | ', $info) ?: 'Direct Traffic';
    }

    /**
     * Get UTM parameters
     */
    public function getUtmParamsAttribute()
    {
        $params = [];
        
        if ($this->utm_source) {
            $params['utm_source'] = $this->utm_source;
        }
        
        if ($this->utm_medium) {
            $params['utm_medium'] = $this->utm_medium;
        }
        
        if ($this->utm_campaign) {
            $params['utm_campaign'] = $this->utm_campaign;
        }
        
        if ($this->utm_term) {
            $params['utm_term'] = $this->utm_term;
        }
        
        if ($this->utm_content) {
            $params['utm_content'] = $this->utm_content;
        }
        
        return $params;
    }

    /**
     * Check if analytics has location data
     */
    public function hasLocationData()
    {
        return $this->country || $this->city || $this->latitude || $this->longitude;
    }

    /**
     * Check if analytics has device data
     */
    public function hasDeviceData()
    {
        return $this->device_type || $this->browser || $this->os;
    }

    /**
     * Check if analytics has campaign data
     */
    public function hasCampaignData()
    {
        return $this->campaign_source || $this->utm_source;
    }

    /**
     * Check if analytics has performance data
     */
    public function hasPerformanceData()
    {
        return $this->load_time || $this->performance_score;
    }

    /**
     * Check if analytics has business data
     */
    public function hasBusinessData()
    {
        return $this->revenue_generated || $this->conversion_rate || $this->engagement_score;
    }

    /**
     * Get action data for specific key
     */
    public function getActionData($key, $default = null)
    {
        $data = $this->action_data ?? [];
        return data_get($data, $key, $default);
    }

    /**
     * Set action data for specific key
     */
    public function setActionData($key, $value)
    {
        $data = $this->action_data ?? [];
        data_set($data, $key, $value);
        $this->action_data = $data;
        $this->save();
    }

    /**
     * Get business insights for specific key
     */
    public function getBusinessInsight($key, $default = null)
    {
        $insights = $this->business_insights ?? [];
        return data_get($insights, $key, $default);
    }

    /**
     * Set business insight for specific key
     */
    public function setBusinessInsight($key, $value)
    {
        $insights = $this->business_insights ?? [];
        data_set($insights, $key, $value);
        $this->business_insights = $insights;
        $this->save();
    }

    /**
     * Get metadata for specific key
     */
    public function getMetadata($key, $default = null)
    {
        $metadata = $this->metadata ?? [];
        return data_get($metadata, $key, $default);
    }

    /**
     * Set metadata for specific key
     */
    public function setMetadata($key, $value)
    {
        $metadata = $this->metadata ?? [];
        data_set($metadata, $key, $value);
        $this->metadata = $metadata;
        $this->save();
    }

    /**
     * Parse user agent and extract device information
     */
    public static function parseUserAgent($userAgent)
    {
        $agent = new Agent();
        $agent->setUserAgent($userAgent);
        
        return [
            'device_type' => $agent->isDesktop() ? 'desktop' : ($agent->isTablet() ? 'tablet' : 'mobile'),
            'device_brand' => $agent->device(),
            'device_model' => $agent->device(),
            'browser' => $agent->browser(),
            'browser_version' => $agent->version($agent->browser()),
            'os' => $agent->platform(),
            'os_version' => $agent->version($agent->platform())
        ];
    }

    /**
     * Calculate engagement score based on various metrics
     */
    public function calculateEngagementScore()
    {
        $score = 0;
        
        // Time on page (max 5 points)
        if ($this->time_on_page) {
            $timeScore = min(5, $this->time_on_page / 60); // 1 point per minute, max 5
            $score += $timeScore;
        }
        
        // Scroll depth (max 3 points)
        if ($this->scroll_depth) {
            $scrollScore = min(3, $this->scroll_depth / 33); // 1 point per 33% scroll, max 3
            $score += $scrollScore;
        }
        
        // Interactions (max 2 points)
        $interactions = ($this->clicks_count ?? 0) + ($this->shares_count ?? 0) + ($this->downloads_count ?? 0);
        $interactionScore = min(2, $interactions * 0.5); // 0.5 points per interaction, max 2
        $score += $interactionScore;
        
        // Form submissions (max 2 points)
        if ($this->form_submissions) {
            $formScore = min(2, $this->form_submissions * 2); // 2 points per form submission, max 2
            $score += $formScore;
        }
        
        // Appointment bookings (max 3 points)
        if ($this->appointment_bookings) {
            $bookingScore = min(3, $this->appointment_bookings * 3); // 3 points per booking, max 3
            $score += $bookingScore;
        }
        
        // Payment conversions (max 5 points)
        if ($this->payment_conversions) {
            $paymentScore = min(5, $this->payment_conversions * 5); // 5 points per conversion, max 5
            $score += $paymentScore;
        }
        
        return round($score, 2);
    }

    /**
     * Calculate conversion rate
     */
    public function calculateConversionRate()
    {
        $totalViews = $this->digitalCard->analytics()->where('action', 'view')->count();
        
        if ($totalViews === 0) {
            return 0;
        }
        
        $conversions = ($this->form_submissions ?? 0) + 
                      ($this->appointment_bookings ?? 0) + 
                      ($this->payment_conversions ?? 0);
        
        return round(($conversions / $totalViews) * 100, 2);
    }

    /**
     * Get performance rating
     */
    public function getPerformanceRating()
    {
        if (!$this->load_time) {
            return 'N/A';
        }
        
        if ($this->load_time < 1) {
            return 'Excellent';
        } elseif ($this->load_time < 2) {
            return 'Good';
        } elseif ($this->load_time < 3) {
            return 'Fair';
        } else {
            return 'Poor';
        }
    }

    /**
     * Get engagement rating
     */
    public function getEngagementRating()
    {
        if (!$this->engagement_score) {
            return 'N/A';
        }
        
        if ($this->engagement_score >= 15) {
            return 'Excellent';
        } elseif ($this->engagement_score >= 10) {
            return 'Good';
        } elseif ($this->engagement_score >= 5) {
            return 'Fair';
        } else {
            return 'Poor';
        }
    }
}
