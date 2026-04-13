<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['user', 'skill'])->latest()->paginate(15);
        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        return view('admin.payments.show', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,completed,failed',
            'notes' => 'nullable|string',
        ]);

        $payment->update($validated);
        return back()->with('success', 'Payment status updated.');
    }

    public function markCompleted(Payment $payment)
    {
        $payment->update(['status' => 'completed']);
        
        // If payment is for a skill, automatically approve user access
        if ($payment->skill_id) {
            DB::table('user_skills')->updateOrInsert(
                ['user_id' => $payment->user_id, 'skill_id' => $payment->skill_id],
                ['is_approved' => true, 'approved_at' => now(), 'created_at' => now(), 'updated_at' => now()]
            );
        }

        return back()->with('success', 'Payment marked as completed and user approved for skill.');
    }
}