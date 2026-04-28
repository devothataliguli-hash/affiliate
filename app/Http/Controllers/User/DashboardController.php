<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $skills = Skill::where('is_active', true)->orderBy('order')->get();
        $mySkills = $user->skills()->wherePivot('status', 'approved')->get();
        $pendingSkills = $user->skills()->wherePivot('status', 'pending')->get();
        $testimonials = Testimonial::where('is_active', true)->orderBy('order')->take(6)->get();
        
        return view('user.dashboard', compact('skills', 'mySkills', 'pendingSkills', 'testimonials'));
    }
}