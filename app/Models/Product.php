<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'category',
        'category_id',
        'price',
        'prix_fournisseur',
        'commission_agent',
        'stock',
        'image',
        'is_active',
    ];

    protected $casts = [
        'category_id' => 'integer',
        'price' => 'decimal:2',
        'prix_fournisseur' => 'decimal:2',
        'commission_agent' => 'decimal:2',
        'stock' => 'integer',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
