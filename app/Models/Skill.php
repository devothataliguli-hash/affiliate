<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'price', 'icon', 'color', 'is_active', 'order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function categories()
    {
        return $this->hasMany(Category::class)->orderBy('order');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('status', 'approved_at');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function isPurchasedBy(User $user)
    {
        return $this->users()
            ->where('user_id', $user->id)
            ->wherePivot('status', 'approved')
            ->exists();
    }

    public function isPendingFor(User $user)
    {
        return $this->users()
            ->where('user_id', $user->id)
            ->wherePivot('status', 'pending')
            ->exists();
    }
}