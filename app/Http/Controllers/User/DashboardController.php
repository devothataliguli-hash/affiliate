<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get enrolled skills with pivot data
        $enrolledSkills = $user->skills()->withPivot('is_approved', 'approved_at')->get();
        
        // Separate approved and pending skills
        $approvedSkills = $enrolledSkills->where('pivot.is_approved', true);
        $pendingSkills = $enrolledSkills->where('pivot.is_approved', false);
        
        // For progress tracking (you can add a progress field later)
        // For now, we'll use placeholder progress values or calculate from a lessons table
        
        $stats = [
            'total_enrolled' => $enrolledSkills->count(),
            'approved' => $approvedSkills->count(),
            'pending' => $pendingSkills->count(),
        ];

        return view('dashboard', compact('user', 'enrolledSkills', 'approvedSkills', 'pendingSkills', 'stats'));
    }
}