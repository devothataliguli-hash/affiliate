<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'video_url', 'notes', 'is_active'];

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