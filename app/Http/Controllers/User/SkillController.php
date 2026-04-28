<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\Content;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * Display user's purchased skills
     */
    public function mySkills()
    {
        $user = auth()->user();
        $mySkills = $user->skills()->wherePivot('status', 'approved')->with('categories')->get();
        $pendingSkills = $user->skills()->wherePivot('status', 'pending')->with('categories')->get();
        
        return view('user.my-skills', compact('mySkills', 'pendingSkills'));
    }
    
    /**
     * Show a specific skill details
     */
    public function show($slug)
    {
        $skill = Skill::where('slug', $slug)->with(['categories.contents'])->firstOrFail();
        $user = auth()->user();
        
        $isPurchased = $skill->isPurchasedBy($user);
        $isPending = $skill->isPendingFor($user);
        
        return view('user.skill-show', compact('skill', 'isPurchased', 'isPending'));
    }
    
    /**
     * View specific content inside a skill
     */
    public function content($skillSlug, $categorySlug, $contentId)
    {
        $skill = Skill::where('slug', $skillSlug)->firstOrFail();
        $content = Content::with('category.skill')->findOrFail($contentId);
        
        // Verify content belongs to the skill
        if ($content->category->skill_id !== $skill->id) {
            abort(404);
        }
        
        $user = auth()->user();
        $isPurchased = $skill->isPurchasedBy($user);
        
        // Check if content is free preview or user purchased the skill
        if (!$content->is_free_preview && !$isPurchased) {
            return redirect()->route('user.skill.show', $skill->slug)
                ->with('error', 'You need to purchase this skill to access all content.');
        }
        
        return view('user.content-view', compact('skill', 'content', 'isPurchased'));
    }
}