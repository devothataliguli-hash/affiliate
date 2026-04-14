<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Show the payment form for a skill.
     * Route: GET /payment/{skill}
     */
    public function create(Skill $skill)
    {
        // Check if user is already enrolled
        $user = Auth::user();
        $enrolled = $user->skills()->where('skill_id', $skill->id)->exists();
        
        if ($enrolled) {
            return redirect()->route('dashboard')->with('info', 'You are already enrolled in this skill.');
        }
        
        return view('user.payment', compact('skill'));
    }

    /**
     * Process the payment (store payment record).
     * Route: POST /payment/{skill}
     */
    public function store(Request $request, Skill $skill)
    {
        $user = Auth::user();
        
        // Validate payment details (customize as needed)
        $validated = $request->validate([
            'payment_method' => 'required|string|in:mpesa,airtel_tigo,card',
            'transaction_id' => 'nullable|string|max:100',
            'phone'          => 'nullable|string',
        ]);
        
        // Create payment record (status = pending)
        $payment = Payment::create([
            'user_id'        => $user->id,
            'skill_id'       => $skill->id,
            'amount'         => $skill->price,
            'payment_method' => $validated['payment_method'],
            'transaction_id' => $validated['transaction_id'] ?? null,
            'status'         => 'pending',
            'notes'          => 'Payment initiated by user',
        ]);
        
        // Optionally: enroll the user but set is_approved = false (waiting for payment confirmation)
        $user->skills()->attach($skill->id, [
            'is_approved' => false,
            'approved_at' => null,
        ]);
        
        return redirect()->route('dashboard')->with('success', 'Payment request submitted. Admin will approve after confirmation.');
    }
}