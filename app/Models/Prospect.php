<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prospect extends Model
{
    use HasFactory;

    protected $fillable = [
        'prospect_file_id',
        'name',
        'phone',
        'status',
        'notes',
        'called_at',
    ];

    protected $casts = [
        'called_at' => 'datetime',
    ];

    public function file()
    {
        return $this->belongsTo(ProspectFile::class, 'prospect_file_id');
    }
}
