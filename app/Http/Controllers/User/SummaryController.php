<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class SummaryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get enrolled skills with pivot
        $enrolledSkills = $user->skills()->withPivot('is_approved')->get();
        $approvedCount = $enrolledSkills->where('pivot.is_approved', true)->count();
        
        // Calculate total spent on paid skills
        $totalSpent = Payment::where('user_id', $user->id)
            ->where('status', 'completed')
            ->sum('amount');
        
        // For goals - using enrolled count as progress
        $skillsGoal = 3;
        $skillsProgress = min($approvedCount, $skillsGoal);
        $skillsPercent = $skillsGoal > 0 ? ($skillsProgress / $skillsGoal) * 100 : 0;
        
        // Referral goal (static for now)
        $referralGoal = 5;
        $referralProgress = 0; // You can add referrals later
        $referralPercent = 0;
        
        // Income goal
        $incomeGoal = 50000;
        $incomeProgress = min($totalSpent, $incomeGoal); // Or use earnings if needed
        $incomePercent = $incomeGoal > 0 ? ($incomeProgress / $incomeGoal) * 100 : 0;
        
        return view('user.bonus', compact(
            'user',
            'enrolledSkills',
            'approvedCount',
            'totalSpent',
            'skillsGoal',
            'skillsProgress',
            'skillsPercent',
            'referralGoal',
            'referralProgress',
            'referralPercent',
            'incomeGoal',
            'incomeProgress',
            'incomePercent'
        ));
    }
}