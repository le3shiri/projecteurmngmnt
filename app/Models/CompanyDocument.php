<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'description',
        'file_path',
        'file_type',
        'file_size',
        'user_id',
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFormattedSizeAttribute()
    {
        if (!$this->file_size) return 'Inconnu';
        $bytes = $this->file_size;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' B';
        }
    }

    public function getIconAttribute()
    {
        $ext = strtolower(pathinfo($this->file_path, PATHINFO_EXTENSION));
        switch ($ext) {
            case 'pdf':
                return 'fa-file-pdf';
            case 'doc':
            case 'docx':
                return 'fa-file-word';
            case 'xls':
            case 'xlsx':
            case 'csv':
                return 'fa-file-excel';
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'webp':
            case 'svg':
                return 'fa-file-image';
            case 'zip':
            case 'rar':
            case '7z':
                return 'fa-file-zipper';
            default:
                return 'fa-file-lines';
        }
    }

    public function getIconColorAttribute()
    {
        $ext = strtolower(pathinfo($this->file_path, PATHINFO_EXTENSION));
        switch ($ext) {
            case 'pdf':
                return '#ef4444';
            case 'doc':
            case 'docx':
                return '#3b82f6';
            case 'xls':
            case 'xlsx':
            case 'csv':
                return '#10b981';
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'webp':
            case 'svg':
                return '#f59e0b';
            case 'zip':
            case 'rar':
            case '7z':
                return '#8b5cf6';
            default:
                return '#64748b';
        }
    }
}
