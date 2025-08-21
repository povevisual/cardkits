<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'title',
        'company',
        'email',
        'phone',
        'website',
        'address',
        'bio',
        'photo',
        'template',
        'color_scheme',
        'is_public',
        'views',
        'shares',
        'downloads',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'views' => 'integer',
        'shares' => 'integer',
        'downloads' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return $this->photo; // For base64 encoded images
        }
        return null;
    }

    public function getShareUrlAttribute()
    {
        return url("/preview/{$this->id}");
    }

    public function getQrCodeUrlAttribute()
    {
        // In a real app, you'd generate a QR code
        return "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($this->share_url);
    }
}