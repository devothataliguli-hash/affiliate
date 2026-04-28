<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'skill_id', 'name', 'slug', 'description', 'order'
    ];

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function contents()
    {
        return $this->hasMany(Content::class)->orderBy('order');
    }
}