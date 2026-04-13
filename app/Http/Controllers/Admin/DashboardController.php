<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Skill;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalSkills = Skill::count();
        $totalPayments = Payment::where('status', 'completed')->sum('amount');
        $pendingApprovals = \DB::table('user_skills')->where('is_approved', false)->count();
        $recentUsers = User::latest()->take(5)->get();
        $recentPayments = Payment::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalSkills', 'totalPayments', 
            'pendingApprovals', 'recentUsers', 'recentPayments'
        ));
    }
}