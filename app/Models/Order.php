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
        'notes',
        'delivery_date',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'advance_cash' => 'decimal:2',
        'advance_transfer' => 'decimal:2',
        'remaining' => 'decimal:2',
        'delivery_date' => 'date',
    ];

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
