<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\Skill;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Enrolled skills with pivot data
        $enrolledSkills = $user->skills()->withPivot('is_approved', 'approved_at')->get();
        
        $stats = [
            'total_enrolled' => $enrolledSkills->count(),
            'approved'       => $enrolledSkills->where('pivot.is_approved', true)->count(),
            'pending'        => $enrolledSkills->where('pivot.is_approved', false)->count(),
        ];
        
        // All active skills with their category relationship loaded (if available)
        $allSkills = Skill::with('category')->where('is_active', true)->get();
        
        // Categorize skills based on category name
        $categorizedSkills = [
            'affiliate'        => collect(),
            'entrepreneurship' => collect(),
            'team_management'  => collect(),
        ];
        
        // Check if the old 'category' column still exists (string column)
        $oldColumnExists = Schema::hasColumn('skills', 'category');
        
        foreach ($allSkills as $skill) {
            if ($oldColumnExists) {
                // Old column exists – use string value directly
                $catName = Str::lower($skill->category ?? '');
            } else {
                // New relationship – use category name
                $catName = $skill->category ? Str::lower($skill->category->name) : '';
            }
            
            if (Str::contains($catName, ['affiliate', 'digital', 'marketing'])) {
                $categorizedSkills['affiliate']->push($skill);
            } 
            elseif (Str::contains($catName, ['entrepreneur', 'biashara', 'startup', 'business'])) {
                $categorizedSkills['entrepreneurship']->push($skill);
            }
            elseif (Str::contains($catName, ['team', 'management', 'leadership', 'uongozi'])) {
                $categorizedSkills['team_management']->push($skill);
            }
            else {
                // Fallback: uncategorized skills go to 'affiliate'
                $categorizedSkills['affiliate']->push($skill);
            }
        }
        
        $enrolledIds = $enrolledSkills->pluck('id')->toArray();
        
        return view('dashboard', compact(
            'user', 
            'enrolledSkills', 
            'stats',
            'categorizedSkills',
            'enrolledIds'
        ));
    }
}