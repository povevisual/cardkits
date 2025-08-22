<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'digital_card_id',
        'user_id',
        'title',
        'description',
        'type',
        'duration',
        'start_time',
        'end_time',
        'timezone',
        'location',
        'meeting_url',
        'client_name',
        'client_email',
        'client_phone',
        'client_notes',
        'status',
        'status_notes',
        'calendar_event_id',
        'calendar_provider',
        'calendar_data',
        'reminders',
        'send_reminders',
        'last_reminder_sent_at',
        'price',
        'currency',
        'payment_status',
        'payment_method',
        'requires_confirmation',
        'allow_rescheduling',
        'allow_cancellation',
        'cancellation_hours',
        'view_count',
        'last_viewed_at'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'calendar_data' => 'array',
        'reminders' => 'array',
        'send_reminders' => 'boolean',
        'last_reminder_sent_at' => 'datetime',
        'price' => 'decimal:2',
        'requires_confirmation' => 'boolean',
        'allow_rescheduling' => 'boolean',
        'allow_cancellation' => 'boolean',
        'view_count' => 'integer',
        'last_viewed_at' => 'datetime'
    ];

    /**
     * Appointment statuses
     */
    const STATUSES = [
        'pending' => 'Pending',
        'confirmed' => 'Confirmed',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
        'rescheduled' => 'Rescheduled',
        'no_show' => 'No Show'
    ];

    /**
     * Appointment types
     */
    const TYPES = [
        'consultation' => 'Consultation',
        'meeting' => 'Meeting',
        'call' => 'Phone Call',
        'video_call' => 'Video Call',
        'in_person' => 'In Person',
        'other' => 'Other'
    ];

    /**
     * Payment statuses
     */
    const PAYMENT_STATUSES = [
        'pending' => 'Pending',
        'paid' => 'Paid',
        'failed' => 'Failed',
        'refunded' => 'Refunded',
        'cancelled' => 'Cancelled'
    ];

    /**
     * Get the digital card for this appointment
     */
    public function digitalCard()
    {
        return $this->belongsTo(DigitalCard::class);
    }

    /**
     * Get the user who created this appointment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the analytics for this appointment
     */
    public function analytics()
    {
        return $this->hasMany(CardAnalytics::class, 'card_component_id')
            ->where('action', 'appointment_view');
    }

    /**
     * Scope for appointments by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for upcoming appointments
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_time', '>', now());
    }

    /**
     * Scope for past appointments
     */
    public function scopePast($query)
    {
        return $query->where('start_time', '<', now());
    }

    /**
     * Scope for today's appointments
     */
    public function scopeToday($query)
    {
        return $query->whereDate('start_time', today());
    }

    /**
     * Scope for this week's appointments
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('start_time', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    /**
     * Scope for this month's appointments
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('start_time', now()->month)
            ->whereYear('start_time', now()->year);
    }

    /**
     * Scope for appointments by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for appointments by digital card
     */
    public function scopeByDigitalCard($query, $cardId)
    {
        return $query->where('digital_card_id', $cardId);
    }

    /**
     * Get status label attribute
     */
    public function getStatusLabelAttribute()
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }

    /**
     * Get type label attribute
     */
    public function getTypeLabelAttribute()
    {
        return self::TYPES[$this->type] ?? ucfirst($this->type);
    }

    /**
     * Get payment status label attribute
     */
    public function getPaymentStatusLabelAttribute()
    {
        return self::PAYMENT_STATUSES[$this->payment_status] ?? ucfirst($this->payment_status);
    }

    /**
     * Get formatted duration attribute
     */
    public function getFormattedDurationAttribute()
    {
        if (!$this->duration) {
            return 'N/A';
        }

        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;

        if ($hours > 0 && $minutes > 0) {
            return "{$hours}h {$minutes}m";
        } elseif ($hours > 0) {
            return "{$hours}h";
        } else {
            return "{$minutes}m";
        }
    }

    /**
     * Get formatted price attribute
     */
    public function getFormattedPriceAttribute()
    {
        if (!$this->price) {
            return 'Free';
        }

        $currency = $this->currency ?? 'USD';
        return $currency . ' ' . number_format($this->price, 2);
    }

    /**
     * Get is upcoming attribute
     */
    public function getIsUpcomingAttribute()
    {
        return $this->start_time && $this->start_time->isFuture();
    }

    /**
     * Get is past attribute
     */
    public function getIsPastAttribute()
    {
        return $this->start_time && $this->start_time->isPast();
    }

    /**
     * Get is today attribute
     */
    public function getIsTodayAttribute()
    {
        return $this->start_time && $this->start_time->isToday();
    }

    /**
     * Get can be cancelled attribute
     */
    public function getCanBeCancelledAttribute()
    {
        if (!$this->allow_cancellation) {
            return false;
        }

        if ($this->cancellation_hours && $this->start_time) {
            $cancellationDeadline = $this->start_time->subHours($this->cancellation_hours);
            return now()->isBefore($cancellationDeadline);
        }

        return $this->isUpcoming;
    }

    /**
     * Get can be rescheduled attribute
     */
    public function getCanBeRescheduledAttribute()
    {
        return $this->allow_rescheduling && $this->isUpcoming;
    }

    /**
     * Check if appointment requires confirmation
     */
    public function requiresConfirmation()
    {
        return $this->requires_confirmation && $this->status === 'pending';
    }

    /**
     * Confirm appointment
     */
    public function confirm()
    {
        $this->update([
            'status' => 'confirmed',
            'status_notes' => 'Appointment confirmed'
        ]);
    }

    /**
     * Cancel appointment
     */
    public function cancel($reason = null)
    {
        $this->update([
            'status' => 'cancelled',
            'status_notes' => $reason ?? 'Appointment cancelled'
        ]);
    }

    /**
     * Complete appointment
     */
    public function complete()
    {
        $this->update([
            'status' => 'completed',
            'status_notes' => 'Appointment completed'
        ]);
    }

    /**
     * Reschedule appointment
     */
    public function reschedule($newStartTime, $newEndTime = null)
    {
        $this->update([
            'start_time' => $newStartTime,
            'end_time' => $newEndTime ?? $newStartTime->addMinutes($this->duration),
            'status' => 'rescheduled',
            'status_notes' => 'Appointment rescheduled'
        ]);
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
     * Get calendar event data
     */
    public function getCalendarEventData()
    {
        return $this->calendar_data ?? [];
    }

    /**
     * Set calendar event data
     */
    public function setCalendarEventData($data)
    {
        $this->calendar_data = $data;
        $this->save();
    }

    /**
     * Get reminder settings
     */
    public function getReminderSettings()
    {
        return $this->reminders ?? [];
    }

    /**
     * Set reminder settings
     */
    public function setReminderSettings($settings)
    {
        $this->reminders = $settings;
        $this->save();
    }

    /**
     * Check if reminders should be sent
     */
    public function shouldSendReminders()
    {
        return $this->send_reminders && !empty($this->reminders);
    }

    /**
     * Get next reminder time
     */
    public function getNextReminderTime()
    {
        if (!$this->shouldSendReminders() || !$this->start_time) {
            return null;
        }

        $reminders = $this->reminders;
        $nextReminder = null;

        foreach ($reminders as $reminder) {
            $reminderTime = $this->start_time->copy()->subMinutes($reminder['minutes'] ?? 0);
            
            if ($reminderTime->isFuture() && (!$nextReminder || $reminderTime->isAfter($nextReminder))) {
                $nextReminder = $reminderTime;
            }
        }

        return $nextReminder;
    }
}
