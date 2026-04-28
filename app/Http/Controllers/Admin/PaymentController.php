<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['user', 'skill'])->latest()->paginate(20);
        $pendingCount = Payment::where('status', 'pending')->count();
        
        return view('admin.payments.index', compact('payments', 'pendingCount'));
    }
    
public function approve(Payment $payment)
{
    $payment->update([
        'status' => 'approved',
        'approved_at' => now(),
        'approved_by' => auth()->id(),
    ]);

    $payment->user->skills()->updateExistingPivot(
        $payment->skill_id,
        [
            'status' => 'approved',
            'approved_at' => now(),
        ]
    );

    return back()->with('success', 'Payment approved successfully.');
}
    
    public function reject(Payment $payment)
    {
        $payment->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
        ]);
        
        // Remove the pending skill from user
       $payment->user->skills()->updateExistingPivot(
    $payment->skill_id,
    ['status' => 'rejected']
);
        return redirect()->back()->with('success', 'Payment rejected and skill access removed.');
    }
}