<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function store(Request $request, Skill $skill)
    {
        $user = Auth::user();
        
        // Check if already enrolled
        if ($user->skills()->where('skill_id', $skill->id)->exists()) {
            return back()->with('error', 'Tayari umejisajili kwenye skill hii.');
        }
        
        // Enroll user (free skills auto-approved, paid require payment first)
        $isApproved = $skill->price == 0;
        
        $user->skills()->attach($skill->id, [
            'is_approved' => $isApproved,
            'approved_at' => $isApproved ? now() : null,
        ]);
        
        if ($isApproved) {
            return redirect()->route('dashboard')->with('success', 'Umefanikiwa kujisajili! Anza kujifunza sasa.');
        } else {
            return redirect()->route('user.payment.create', $skill)->with('info', 'Tafadhali lipia ili kupata ufikiaji.');
        }
    }
}