<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'customer_id',
        'agent_id',
        'status',
        'total',
        'advance_cash',
        'advance_transfer',
        'remaining',
        'logo_path',
        'shipping_ticket_path',
        'notes',
        'delivery_date',
        'source',
        'discount_rate',
        'discount_amount',
        'customer_discount_link_id',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'advance_cash' => 'decimal:2',
        'advance_transfer' => 'decimal:2',
        'remaining' => 'decimal:2',
        'delivery_date' => 'date',
        'discount_rate' => 'decimal:2',
        'discount_amount' => 'decimal:2',
    ];

    public function discountLink()
    {
        return $this->belongsTo(CustomerDiscountLink::class, 'customer_discount_link_id');
    }

    public function isCustomerVip(): bool
    {
        return $this->source === 'customer_vip';
    }

    public function isPendingVip(): bool
    {
        return $this->source === 'customer_vip' && $this->status === 'pending';
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function commission()
    {
        return $this->hasOne(Commission::class);
    }

    public function supplierOrder()
    {
        return $this->hasOne(SupplierOrder::class);
    }

    public function getTotalHtAttribute()
    {
        return (float) $this->total;
    }

    public function getTvaAttribute()
    {
        return 0.00;
    }

    public function getTotalTtcAttribute()
    {
        return (float) $this->total;
    }

    public function getTotalAdvancesAttribute()
    {
        return (float) ($this->advance_cash + $this->advance_transfer);
    }
}
