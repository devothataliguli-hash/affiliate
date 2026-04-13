<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Support\Facades\Auth;

class SkillController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get all active skills
        $skills = Skill::where('is_active', true)->get();
        
        // Get user's enrolled skill IDs with approval status
        $enrolledSkills = $user->skills()->withPivot('is_approved')->get();
        $enrolledSkillIds = $enrolledSkills->pluck('id')->toArray();
        $approvedSkillIds = $enrolledSkills->where('pivot.is_approved', true)->pluck('id')->toArray();
        $pendingSkillIds = $enrolledSkills->where('pivot.is_approved', false)->pluck('id')->toArray();
        
        return view('user.skills', compact('skills', 'enrolledSkillIds', 'approvedSkillIds', 'pendingSkillIds'));
    }
}