<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Skill;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isAdmin()) {
                abort(403, 'Unauthorized access.');
            }
            return $next($request);
        });
    }
    
    public function index()
    {
        $totalUsers = User::count();
        $totalSkills = Skill::count();
        $totalPayments = Payment::count();
        $pendingPayments = Payment::where('status', 'pending')->count();
        $recentPayments = Payment::with(['user', 'skill'])->latest()->take(10)->get();
        $recentUsers = User::latest()->take(5)->get();
        
$paymentsByMonth = Payment::selectRaw('EXTRACT(MONTH FROM created_at) as month, COUNT(*) as count')
    ->whereYear('created_at', date('Y'))
    ->groupBy('month')
    ->get();
        
        return view('admin.dashboard', compact(
            'totalUsers', 'totalSkills', 'totalPayments', 'pendingPayments',
            'recentPayments', 'recentUsers', 'paymentsByMonth'
        ));
    }
}