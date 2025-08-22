<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'native_name',
        'flag',
        'is_active',
        'is_default',
        'is_rtl',
        'date_format',
        'time_format',
        'number_format',
        'timezone',
        'currency',
        'currency_format',
        'translation_file',
        'is_translated',
        'translation_percentage',
        'sort_order',
        'show_in_picker'
    ];

    protected $casts = [
        'currency_format' => 'array',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'is_rtl' => 'boolean',
        'is_translated' => 'boolean',
        'translation_percentage' => 'integer',
        'sort_order' => 'integer',
        'show_in_picker' => 'boolean'
    ];

    /**
     * Common languages
     */
    const COMMON_LANGUAGES = [
        'en' => [
            'name' => 'English',
            'native_name' => 'English',
            'flag' => '🇺🇸',
            'date_format' => 'Y-m-d',
            'time_format' => 'H:i',
            'number_format' => '1,234.56',
            'timezone' => 'UTC',
            'currency' => 'USD',
            'is_rtl' => false
        ],
        'id' => [
            'name' => 'Indonesian',
            'native_name' => 'Bahasa Indonesia',
            'flag' => '🇮🇩',
            'date_format' => 'd/m/Y',
            'time_format' => 'H:i',
            'number_format' => '1.234,56',
            'timezone' => 'Asia/Jakarta',
            'currency' => 'IDR',
            'is_rtl' => false
        ],
        'ar' => [
            'name' => 'Arabic',
            'native_name' => 'العربية',
            'flag' => '🇸🇦',
            'date_format' => 'Y-m-d',
            'time_format' => 'H:i',
            'number_format' => '١٬٢٣٤٫٥٦',
            'timezone' => 'Asia/Riyadh',
            'currency' => 'SAR',
            'is_rtl' => true
        ],
        'zh' => [
            'name' => 'Chinese',
            'native_name' => '中文',
            'flag' => '🇨🇳',
            'date_format' => 'Y-m-d',
            'time_format' => 'H:i',
            'number_format' => '1,234.56',
            'timezone' => 'Asia/Shanghai',
            'currency' => 'CNY',
            'is_rtl' => false
        ],
        'es' => [
            'name' => 'Spanish',
            'native_name' => 'Español',
            'flag' => '🇪🇸',
            'date_format' => 'd/m/Y',
            'time_format' => 'H:i',
            'number_format' => '1.234,56',
            'timezone' => 'Europe/Madrid',
            'currency' => 'EUR',
            'is_rtl' => false
        ],
        'fr' => [
            'name' => 'French',
            'native_name' => 'Français',
            'flag' => '🇫🇷',
            'date_format' => 'd/m/Y',
            'time_format' => 'H:i',
            'number_format' => '1 234,56',
            'timezone' => 'Europe/Paris',
            'currency' => 'EUR',
            'is_rtl' => false
        ],
        'de' => [
            'name' => 'German',
            'native_name' => 'Deutsch',
            'flag' => '🇩🇪',
            'date_format' => 'd.m.Y',
            'time_format' => 'H:i',
            'number_format' => '1.234,56',
            'timezone' => 'Europe/Berlin',
            'currency' => 'EUR',
            'is_rtl' => false
        ],
        'ja' => [
            'name' => 'Japanese',
            'native_name' => '日本語',
            'flag' => '🇯🇵',
            'date_format' => 'Y-m-d',
            'time_format' => 'H:i',
            'number_format' => '1,234.56',
            'timezone' => 'Asia/Tokyo',
            'currency' => 'JPY',
            'is_rtl' => false
        ],
        'ko' => [
            'name' => 'Korean',
            'native_name' => '한국어',
            'flag' => '🇰🇷',
            'date_format' => 'Y-m-d',
            'time_format' => 'H:i',
            'number_format' => '1,234.56',
            'timezone' => 'Asia/Seoul',
            'currency' => 'KRW',
            'is_rtl' => false
        ],
        'pt' => [
            'name' => 'Portuguese',
            'native_name' => 'Português',
            'flag' => '🇵🇹',
            'date_format' => 'd/m/Y',
            'time_format' => 'H:i',
            'number_format' => '1.234,56',
            'timezone' => 'Europe/Lisbon',
            'currency' => 'EUR',
            'is_rtl' => false
        ],
        'ru' => [
            'name' => 'Russian',
            'native_name' => 'Русский',
            'flag' => '🇷🇺',
            'date_format' => 'd.m.Y',
            'time_format' => 'H:i',
            'number_format' => '1 234,56',
            'timezone' => 'Europe/Moscow',
            'currency' => 'RUB',
            'is_rtl' => false
        ],
        'hi' => [
            'name' => 'Hindi',
            'native_name' => 'हिन्दी',
            'flag' => '🇮🇳',
            'date_format' => 'd/m/Y',
            'time_format' => 'H:i',
            'number_format' => '1,234.56',
            'timezone' => 'Asia/Kolkata',
            'currency' => 'INR',
            'is_rtl' => false
        ]
    ];

    /**
     * Date formats
     */
    const DATE_FORMATS = [
        'Y-m-d' => '2024-01-15',
        'd/m/Y' => '15/01/2024',
        'm/d/Y' => '01/15/2024',
        'd.m.Y' => '15.01.2024',
        'd-m-Y' => '15-01-2024',
        'F j, Y' => 'January 15, 2024',
        'j F Y' => '15 January 2024'
    ];

    /**
     * Time formats
     */
    const TIME_FORMATS = [
        'H:i' => '14:30',
        'h:i A' => '2:30 PM',
        'H:i:s' => '14:30:00',
        'h:i:s A' => '2:30:00 PM'
    ];

    /**
     * Number formats
     */
    const NUMBER_FORMATS = [
        '1,234.56' => '1,234.56',
        '1.234,56' => '1.234,56',
        '1 234,56' => '1 234,56',
        '١٬٢٣٤٫٥٦' => '١٬٢٣٤٫٥٦'
    ];

    /**
     * Get the digital cards using this language
     */
    public function digitalCards()
    {
        return $this->hasMany(DigitalCard::class);
    }

    /**
     * Scope for active languages
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for default language
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Scope for RTL languages
     */
    public function scopeRtl($query)
    {
        return $query->where('is_rtl', true);
    }

    /**
     * Scope for LTR languages
     */
    public function scopeLtr($query)
    {
        return $query->where('is_rtl', false);
    }

    /**
     * Scope for languages shown in picker
     */
    public function scopeShowInPicker($query)
    {
        return $query->where('show_in_picker', true);
    }

    /**
     * Scope for languages by translation status
     */
    public function scopeTranslated($query, $percentage = 100)
    {
        return $query->where('translation_percentage', '>=', $percentage);
    }

    /**
     * Scope for languages ordered by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Check if language is RTL
     */
    public function isRtl()
    {
        return $this->is_rtl;
    }

    /**
     * Check if language is LTR
     */
    public function isLtr()
    {
        return !$this->is_rtl;
    }

    /**
     * Check if language is default
     */
    public function isDefault()
    {
        return $this->is_default;
    }

    /**
     * Check if language is active
     */
    public function isActive()
    {
        return $this->is_active;
    }

    /**
     * Check if language is fully translated
     */
    public function isFullyTranslated()
    {
        return $this->translation_percentage >= 100;
    }

    /**
     * Check if language is partially translated
     */
    public function isPartiallyTranslated()
    {
        return $this->translation_percentage > 0 && $this->translation_percentage < 100;
    }

    /**
     * Check if language is not translated
     */
    public function isNotTranslated()
    {
        return $this->translation_percentage == 0;
    }

    /**
     * Get language direction
     */
    public function getDirectionAttribute()
    {
        return $this->is_rtl ? 'rtl' : 'ltr';
    }

    /**
     * Get language direction class
     */
    public function getDirectionClassAttribute()
    {
        return $this->is_rtl ? 'rtl' : 'ltr';
    }

    /**
     * Get flag emoji or image
     */
    public function getFlagAttribute($value)
    {
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }
        
        return $value ?: '🌐';
    }

    /**
     * Get formatted date example
     */
    public function getFormattedDateExampleAttribute()
    {
        $format = $this->date_format ?: 'Y-m-d';
        return date($format);
    }

    /**
     * Get formatted time example
     */
    public function getFormattedTimeExampleAttribute()
    {
        $format = $this->time_format ?: 'H:i';
        return date($format);
    }

    /**
     * Get formatted number example
     */
    public function getFormattedNumberExampleAttribute()
    {
        $format = $this->number_format ?: '1,234.56';
        return $format;
    }

    /**
     * Get currency symbol
     */
    public function getCurrencySymbolAttribute()
    {
        $currency = $this->currency ?: 'USD';
        
        $symbols = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'JPY' => '¥',
            'CNY' => '¥',
            'KRW' => '₩',
            'INR' => '₹',
            'IDR' => 'Rp',
            'SAR' => 'ر.س',
            'RUB' => '₽'
        ];
        
        return $symbols[$currency] ?? $currency;
    }

    /**
     * Get translation status label
     */
    public function getTranslationStatusLabelAttribute()
    {
        if ($this->isFullyTranslated()) {
            return 'Fully Translated';
        }
        
        if ($this->isPartiallyTranslated()) {
            return 'Partially Translated (' . $this->translation_percentage . '%)';
        }
        
        return 'Not Translated';
    }

    /**
     * Get translation status class
     */
    public function getTranslationStatusClassAttribute()
    {
        if ($this->isFullyTranslated()) {
            return 'success';
        }
        
        if ($this->isPartiallyTranslated()) {
            return 'warning';
        }
        
        return 'danger';
    }

    /**
     * Get language name with native name
     */
    public function getFullNameAttribute()
    {
        if ($this->name === $this->native_name) {
            return $this->name;
        }
        
        return $this->name . ' (' . $this->native_name . ')';
    }

    /**
     * Get language code with name
     */
    public function getCodeWithNameAttribute()
    {
        return strtoupper($this->code) . ' - ' . $this->name;
    }

    /**
     * Format date according to language settings
     */
    public function formatDate($date, $format = null)
    {
        if (!$date) {
            return '';
        }
        
        $dateFormat = $format ?: $this->date_format ?: 'Y-m-d';
        
        if ($date instanceof \Carbon\Carbon) {
            return $date->format($dateFormat);
        }
        
        return date($dateFormat, strtotime($date));
    }

    /**
     * Format time according to language settings
     */
    public function formatTime($time, $format = null)
    {
        if (!$time) {
            return '';
        }
        
        $timeFormat = $format ?: $this->time_format ?: 'H:i';
        
        if ($time instanceof \Carbon\Carbon) {
            return $time->format($timeFormat);
        }
        
        return date($timeFormat, strtotime($time));
    }

    /**
     * Format number according to language settings
     */
    public function formatNumber($number, $decimals = 2)
    {
        if ($this->is_rtl) {
            // For RTL languages, use Arabic numerals if available
            return number_format($number, $decimals);
        }
        
        return number_format($number, $decimals);
    }

    /**
     * Format currency according to language settings
     */
    public function formatCurrency($amount, $currency = null)
    {
        $currency = $currency ?: $this->currency ?: 'USD';
        $amount = number_format($amount, 2);
        
        if ($this->is_rtl) {
            return $amount . ' ' . $currency;
        }
        
        return $currency . ' ' . $amount;
    }

    /**
     * Get available date formats
     */
    public static function getAvailableDateFormats()
    {
        return self::DATE_FORMATS;
    }

    /**
     * Get available time formats
     */
    public static function getAvailableTimeFormats()
    {
        return self::TIME_FORMATS;
    }

    /**
     * Get available number formats
     */
    public static function getAvailableNumberFormats()
    {
        return self::NUMBER_FORMATS;
    }

    /**
     * Get common languages data
     */
    public static function getCommonLanguages()
    {
        return self::COMMON_LANGUAGES;
    }

    /**
     * Create language from common language data
     */
    public static function createFromCommon($code, $additionalData = [])
    {
        if (!isset(self::COMMON_LANGUAGES[$code])) {
            throw new \InvalidArgumentException("Unknown language code: {$code}");
        }
        
        $data = array_merge(self::COMMON_LANGUAGES[$code], $additionalData);
        $data['code'] = $code;
        
        return self::create($data);
    }

    /**
     * Set as default language
     */
    public function setAsDefault()
    {
        // Remove default from other languages
        self::where('is_default', true)->update(['is_default' => false]);
        
        // Set this language as default
        $this->update(['is_default' => true]);
    }

    /**
     * Update translation percentage
     */
    public function updateTranslationPercentage($percentage)
    {
        $this->update([
            'translation_percentage' => max(0, min(100, $percentage)),
            'is_translated' => $percentage >= 100
        ]);
    }

    /**
     * Get translation file path
     */
    public function getTranslationFilePath()
    {
        return $this->translation_file ?: "lang/{$this->code}.json";
    }

    /**
     * Check if translation file exists
     */
    public function hasTranslationFile()
    {
        $path = $this->getTranslationFilePath();
        return file_exists(resource_path($path));
    }

    /**
     * Load translations from file
     */
    public function loadTranslations()
    {
        if (!$this->hasTranslationFile()) {
            return [];
        }
        
        $path = $this->getTranslationFilePath();
        $content = file_get_contents(resource_path($path));
        
        return json_decode($content, true) ?: [];
    }

    /**
     * Save translations to file
     */
    public function saveTranslations($translations)
    {
        $path = $this->getTranslationFilePath();
        $dir = dirname(resource_path($path));
        
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        file_put_contents(resource_path($path), json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
