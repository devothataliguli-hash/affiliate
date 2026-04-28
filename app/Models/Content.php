<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'title', 'type', 'file_path', 'text_content',
        'video_url', 'audio_url', 'pdf_url', 'duration', 'order', 'is_free_preview'
    ];

    protected $casts = [
        'is_free_preview' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getContentUrlAttribute()
    {
        switch ($this->type) {
            case 'video':
                return $this->video_url ?: ($this->file_path ? asset('storage/' . $this->file_path) : null);
            case 'audio':
                return $this->audio_url ?: ($this->file_path ? asset('storage/' . $this->file_path) : null);
            case 'pdf':
                return $this->pdf_url ?: ($this->file_path ? asset('storage/' . $this->file_path) : null);
            default:
                return null;
        }
    }
}