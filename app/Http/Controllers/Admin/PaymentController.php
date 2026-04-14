<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
public function index(Request $request)
{
    $query = Payment::with(['user', 'skill'])->latest();

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"))
              ->orWhereHas('skill', fn($s) => $s->where('name', 'like', "%{$search}%"));
        });
    }

    if ($request->filled('status') && $request->status != '') {
        $query->where('status', $request->status);
    }

    $payments = $query->paginate(15);

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
public function updateStatus(Request $request, Payment $payment)
{
    $request->validate([
        'status' => 'required|in:pending,completed,failed'
    ]);

    $oldStatus = $payment->status;
    $payment->status = $request->status;
    $payment->save();

    // If changed to 'completed' and has a skill, approve user access
    if ($payment->status === 'completed' && $payment->skill_id && $oldStatus !== 'completed') {
        \DB::table('user_skills')->updateOrInsert(
            ['user_id' => $payment->user_id, 'skill_id' => $payment->skill_id],
            ['is_approved' => true, 'approved_at' => now(), 'created_at' => now(), 'updated_at' => now()]
        );
    }

    if ($request->ajax()) {
        return response()->json(['success' => true, 'status' => $payment->status]);
    }

    return redirect()->back()->with('success', 'Payment status updated.');
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