<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Support\Facades\Auth;

class LearningController extends Controller
{
    public function show(Skill $skill)
    {
        $user = Auth::user();
        
        $enrollment = $user->skills()
            ->where('skill_id', $skill->id)
            ->withPivot('is_approved')
            ->first();
            
        if (!$enrollment) {
            return redirect()->route('user.skills')->with('error', 'Tafadhali jisajili kwanza kwenye skill hii.');
        }
        
        if (!$enrollment->pivot->is_approved) {
            return redirect()->route('user.skills')->with('error', 'Unasubiri admin kuthibitisha ufikiaji wako.');
        }
        
        return view('user.learn', compact('skill'));
    }
}