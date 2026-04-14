<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

protected $fillable = [
    'name', 'category_id', 'description', 'price', 
    'video_url', 'platform_link', 'pdf_file', 'voice_file', 
    'notes', 'is_active'
];

public function category()
{
    return $this->belongsTo(Category::class);
}
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_skills')
                    ->withPivot('is_approved', 'approved_at')
                    ->withTimestamps();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}