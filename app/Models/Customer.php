<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'company',
        'notes',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function discountLinks()
    {
        return $this->hasMany(CustomerDiscountLink::class);
    }

    public function latestDiscountLink()
    {
        return $this->hasOne(CustomerDiscountLink::class)->latestOfMany();
    }

    public function hasDeliveredOrder(): bool
    {
        return $this->orders()->where('status', 'delivered')->exists();
    }

    public function getFirstOrder()
    {
        return $this->orders()->whereNotNull('agent_id')->orderBy('created_at', 'asc')->first();
    }

    public function getFirstAgent()
    {
        return $this->getFirstOrder()?->agent;
    }

    public function getPastLogoPath(): ?string
    {
        // 1. Check order_items from past orders
        $item = OrderItem::whereHas('order', function ($q) {
            $q->where('customer_id', $this->id);
        })->whereNotNull('logo_path')->latest('id')->first();
        if ($item && $item->logo_path) {
            return $item->logo_path;
        }

        // 2. Check orders logo_path
        $order = $this->orders()->whereNotNull('logo_path')->latest('id')->first();
        if ($order && $order->logo_path) {
            return $order->logo_path;
        }

        return null;
    }

    public function getPastLogoUrlAttribute(): ?string
    {
        $path = $this->getPastLogoPath();
        return $path ? asset('public-storage/' . $path) : null;
    }
}
