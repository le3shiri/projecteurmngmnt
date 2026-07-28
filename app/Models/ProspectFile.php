<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProspectFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'file_path',
        'agent_id',
        'uploaded_by',
    ];

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function prospects()
    {
        return $this->hasMany(Prospect::class);
    }

    public function getProgressAttribute()
    {
        $total = $this->prospects()->count();
        if ($total === 0) return 0;
        $called = $this->prospects()->where('status', '!=', 'pending')->count();
        return round(($called / $total) * 100);
    }
}
