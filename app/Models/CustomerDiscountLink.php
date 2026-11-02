<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CustomerDiscountLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'token',
        'created_by',
        'admin_id',
        'first_agent_id',
        'discount_initial',
        'discount_permanent',
        'initial_duration_days',
    ];

    protected $casts = [
        'discount_initial' => 'decimal:2',
        'discount_permanent' => 'decimal:2',
        'initial_duration_days' => 'integer',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function firstAgent()
    {
        return $this->belongsTo(User::class, 'first_agent_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_discount_link_id');
    }

    public function getInitialExpiresAtAttribute(): Carbon
    {
        return $this->created_at->copy()->addDays($this->initial_duration_days ?? 10);
    }

    public function isInitialPeriodActive(): bool
    {
        return now()->lt($this->initial_expires_at);
    }

    public function getCurrentDiscountRate(): float
    {
        return $this->isInitialPeriodActive()
            ? (float) ($this->discount_initial ?? 11.00)
            : (float) ($this->discount_permanent ?? 5.00);
    }

    public function getRemainingSeconds(): int
    {
        return max(0, now()->diffInSeconds($this->initial_expires_at, false));
    }

    public function getRemainingDays(): int
    {
        return (int) ceil($this->getRemainingSeconds() / 86400);
    }

    public function getRemainingHours(): int
    {
        return (int) ceil($this->getRemainingSeconds() / 3600);
    }

    public function getUrl(): string
    {
        return route('catalog.special', ['token' => $this->token]);
    }
}

