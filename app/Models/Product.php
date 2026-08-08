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
        'fiche_technique',
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

    public function agentCommissions()
    {
        return $this->hasMany(AgentProductCommission::class);
    }

    public function getCommissionForAgent($agentId)
    {
        if (!$agentId) {
            return (float) ($this->commission_agent ?? 0);
        }

        $specific = $this->agentCommissions->firstWhere('agent_id', $agentId);
        if ($specific && $specific->commission !== null) {
            return (float) $specific->commission;
        }

        return (float) ($this->commission_agent ?? 0);
    }
}
